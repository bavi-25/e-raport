<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\ClassRoom;
use App\Models\AcademicYear;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class EnrollmentController extends Controller
{


    public function index(Request $request)
    {
        $tenantId = $this->tenantId();
        $classId = $request->query('class_id');
        $ayId = $request->query('academic_year_id');

        $enrollments = Cache::remember(
            $this->keyList($tenantId, $classId, $ayId),
            $this->ttl(),
            callback: function () use ($tenantId, $classId, $ayId) {
                $q = Enrollment::query()
                    ->with([
                        'student:id,user_id,name,nip_nis',
                        'student.user:id,tenant_id',
                        'class:id,name',
                        'academicYear:id,code,term,status',
                    ])
                    ->select('id', 'student_id', 'class_id', 'academic_year_id', 'tenant_id')
                    ->where('tenant_id', $tenantId);

                if ($classId) {
                    $q->where('class_id', $classId);
                }
                if ($ayId) {
                    $q->where('academic_year_id', $ayId);
                }

                return $q->orderByDesc('id')->get();
            }
        );

        $classRooms = Cache::remember(
            $this->keyClasses($tenantId),
            $this->ttl(),
            function () use ($tenantId) {
                return ClassRoom::select('id', 'name', 'tenant_id')
                    ->where('tenant_id', $tenantId)
                    ->orderBy('name')->get();
            }
        );

        $academicYears = Cache::remember(
            $this->keyYears($tenantId),
            $this->ttl(),
            function () use ($tenantId) {
                return AcademicYear::select('id', 'code', 'term', 'status')
                    ->where('tenant_id', $tenantId)
                    ->orderByDesc('start_date')->get();
            }
        );

        return view('school.enrollment.index', [
            'page' => 'Enrollments',
            'enrollments' => $enrollments,
            'class_rooms' => $classRooms,
            'academic_years' => $academicYears,
            'selected_class' => $classId,
            'selected_year' => $ayId,
        ]);
    }

    public function create()
    {
        $tenantId = $this->tenantId();

        $classRooms = Cache::remember(
            $this->keyClasses($tenantId),
            $this->ttl(),
            function () use ($tenantId) {
                return ClassRoom::select('id', 'name', 'tenant_id')
                    ->where('tenant_id', $tenantId)
                    ->orderBy('name')->get();
            }
        );

        $students = Cache::remember(
            $this->keyStudents($tenantId),
            $this->ttl(),
            function () use ($tenantId) {
                return User::role('Siswa')
                    ->with(['profile:id,user_id,name,nip_nis'])
                    ->where('tenant_id', $tenantId)
                    ->select('id', 'email', 'tenant_id')
                    ->orderBy('id')->get()
                    ->map(fn($u) => $u->profile)
                    ->filter();
            }
        );

        $academicYears = Cache::remember(
            $this->keyYears($tenantId),
            $this->ttl(),
            function () use ($tenantId) {
                return AcademicYear::select('id', 'code', 'term', 'status')
                    ->where('tenant_id', $tenantId)
                    ->orderByDesc('start_date')->get();
            }
        );

        $activeYear = $academicYears->firstWhere('status', 'Active');

        return view('school.enrollment.create', [
            'page' => 'Create Enrollment',
            'class_rooms' => $classRooms,
            'students' => $students,
            'academic_years' => $academicYears,
            'active_year' => $activeYear,
        ]);
    }

    public function store(Request $request)
    {
        $tenantId = $this->tenantId();

        $data = $request->validate([
            'student_id' => ['required', 'integer'],
            'class_id' => ['required', 'integer'],
            'academic_year_id' => ['nullable', 'integer'],
        ]);

        $class = ClassRoom::where('tenant_id', $tenantId)
            ->where('id', $data['class_id'])->first();
        if (!$class) {
            return back()->withErrors(['class_id' => 'Kelas tidak valid.'])->withInput();
        }

        $student = Profile::where('id', $data['student_id'])
            ->whereHas('user', fn($q) => $q->where('tenant_id', $tenantId)->role('Siswa'))
            ->first();
        if (!$student) {
            return back()->withErrors(['student_id' => 'Siswa tidak valid.'])->withInput();
        }

        $ayId = $data['academic_year_id'];
        if (!$ayId) {
            $active = AcademicYear::where('tenant_id', $tenantId)
                ->where('status', 'Active')->first();
            if (!$active) {
                return back()->withErrors(['academic_year_id' => 'Tahun ajaran aktif tidak ditemukan.'])->withInput();
            }
            $ayId = $active->id;
        } else {
            $ayValid = AcademicYear::where('tenant_id', $tenantId)
                ->where('id', $ayId)->exists();
            if (!$ayValid) {
                return back()->withErrors(['academic_year_id' => 'Tahun ajaran tidak valid.'])->withInput();
            }
        }

        $exists = Enrollment::where('tenant_id', $tenantId)
            ->where('student_id', $data['student_id'])
            ->where('academic_year_id', $ayId)
            ->exists();
        if ($exists) {
            return back()->withErrors(['student_id' => 'Siswa sudah terdaftar pada tahun ajaran ini.'])->withInput();
        }

        DB::transaction(function () use ($tenantId, $data, $ayId) {
            Enrollment::create([
                'student_id' => $data['student_id'],
                'class_id' => $data['class_id'],
                'academic_year_id' => $ayId,
                'tenant_id' => $tenantId,
            ]);
        });

        $this->forgetListCaches($tenantId);

        return redirect()->route('school.enrollments.index')
            ->with('success', 'Enrollment created.');
    }

    public function edit(string $id)
    {
        $tenantId = $this->tenantId();

        $enrollment = Cache::remember(
            $this->keyItem($tenantId, $id),
            $this->ttl(),
            function () use ($tenantId, $id) {
                return Enrollment::with(['student:id,user_id,name,nip_nis', 'class:id,name', 'academicYear:id,code,term,status'])
                    ->where('tenant_id', $tenantId)
                    ->where('id', $id)
                    ->firstOrFail();
            }
        );

        $classRooms = Cache::remember(
            $this->keyClasses($tenantId),
            $this->ttl(),
            function () use ($tenantId) {
                return ClassRoom::select('id', 'name', 'tenant_id')
                    ->where('tenant_id', $tenantId)
                    ->orderBy('name')->get();
            }
        );

        $students = Cache::remember(
            $this->keyStudents($tenantId),
            $this->ttl(),
            function () use ($tenantId) {
                return User::role('Siswa')
                    ->with(['profile:id,user_id,name,nip_nis'])
                    ->where('tenant_id', $tenantId)
                    ->select('id', 'email', 'tenant_id')
                    ->orderBy('id')->get()
                    ->map(fn($u) => $u->profile)
                    ->filter();
            }
        );

        $academicYears = Cache::remember(
            $this->keyYears($tenantId),
            $this->ttl(),
            function () use ($tenantId) {
                return AcademicYear::select('id', 'code', 'term', 'status')
                    ->where('tenant_id', $tenantId)
                    ->orderByDesc('start_date')->get();
            }
        );

        return view('school.enrollment.edit', [
            'page' => 'Edit Enrollment',
            'enrollment' => $enrollment,
            'class_rooms' => $classRooms,
            'students' => $students,
            'academic_years' => $academicYears,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $tenantId = $this->tenantId();

        $enrollment = Enrollment::where('tenant_id', $tenantId)
            ->where('id', $id)->firstOrFail();

        $data = $request->validate([
            'student_id' => ['required', 'integer'],
            'class_id' => ['required', 'integer'],
            'academic_year_id' => ['required', 'integer'],
        ]);

        $class = ClassRoom::where('tenant_id', $tenantId)
            ->where('id', $data['class_id'])->first();
        if (!$class) {
            return back()->withErrors(['class_id' => 'Kelas tidak valid.'])->withInput();
        }

        $student = Profile::where('id', $data['student_id'])
            ->whereHas('user', fn($q) => $q->where('tenant_id', $tenantId)->role('Siswa'))
            ->first();
        if (!$student) {
            return back()->withErrors(['student_id' => 'Siswa tidak valid.'])->withInput();
        }

        $ayValid = AcademicYear::where('tenant_id', $tenantId)
            ->where('id', $data['academic_year_id'])->exists();
        if (!$ayValid) {
            return back()->withErrors(['academic_year_id' => 'Tahun ajaran tidak valid.'])->withInput();
        }

        $exists = Enrollment::where('tenant_id', $tenantId)
            ->where('student_id', $data['student_id'])
            ->where('academic_year_id', $data['academic_year_id'])
            ->where('id', '!=', $enrollment->id)
            ->exists();
        if ($exists) {
            return back()->withErrors(['student_id' => 'Siswa sudah terdaftar pada tahun ajaran ini.'])->withInput();
        }

        DB::transaction(function () use ($enrollment, $data) {
            $enrollment->update([
                'student_id' => $data['student_id'],
                'class_id' => $data['class_id'],
                'academic_year_id' => $data['academic_year_id'],
            ]);
        });

        $this->forgetItemCache($tenantId, $id);
        $this->forgetListCaches($tenantId);

        return redirect()->route('school.enrollments.index')
            ->with('success', 'Enrollment updated.');
    }

    public function destroy(string $id)
    {
        $tenantId = $this->tenantId();

        $enrollment = Enrollment::where('tenant_id', $tenantId)
            ->where('id', $id)->firstOrFail();

        $enrollment->delete();

        $this->forgetItemCache($tenantId, $id);
        $this->forgetListCaches($tenantId);

        return redirect()->route('school.enrollments.index')
            ->with('success', 'Enrollment deleted.');
    }

    public function show(string $id)
    {
        $tenantId = $this->tenantId();

        $enrollment = Cache::remember(
            $this->keyItem($tenantId, $id),
            $this->ttl(),
            function () use ($tenantId, $id) {
                return Enrollment::with(['student:id,user_id,name,nip_nis', 'class:id,name', 'academicYear:id,code,term,status'])
                    ->where('tenant_id', $tenantId)
                    ->where('id', $id)
                    ->firstOrFail();
            }
        );

        return view('school.enrollment.show', [
            'page' => 'Enrollment Detail',
            'enrollment' => $enrollment,
        ]);
    }
    private function tenantId(): string
    {
        return (string) Auth::user()->tenant_id;
    }

    private function ttl()
    {
        return now()->addHours(2);
    }

    private function keyList(string $tenantId, $classId = null, $ayId = null): string
    {
        $c = $classId ?: 'all';
        $y = $ayId ?: 'all';
        return "{$tenantId}:enrollments:list:{$c}:{$y}";
    }

    private function keyItem(string $tenantId, string $id): string
    {
        return "{$tenantId}:enrollments:item:{$id}";
    }

    private function keyClasses(string $tenantId): string
    {
        return "{$tenantId}:class_room:main";
    }

    private function keyStudents(string $tenantId): string
    {
        return "{$tenantId}:students:for_enroll";
    }

    private function keyYears(string $tenantId): string
    {
        return "{$tenantId}:academic_year:main";
    }

    private function forgetListCaches(string $tenantId): void
    {
        Cache::forget($this->keyList($tenantId));
        Cache::forget($this->keyYears($tenantId));
    }

    private function forgetItemCache(string $tenantId, string $id): void
    {
        Cache::forget($this->keyItem($tenantId, $id));
    }
}
