<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ClassRoom;
use App\Models\GradeLevel;
use App\Models\AcademicYear;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\ClassRoomRequest;

class ClassRoomController extends Controller
{
    public function index()
    {
        $tenantId = $this->tenantId();
        $cacheKey = $this->keyMain($tenantId);

        $classRooms = Cache::remember($cacheKey, $this->ttl(), function () use ($tenantId) {
            return ClassRoom::with(['gradeLevel', 'homeroomTeacher', 'academicYear'])
                ->where('tenant_id', $tenantId)
                ->orderBy('name')
                ->get();
        });

        return view('school.class_room.index', [
            'page' => 'Class Rooms',
            'classs_rooms' => $classRooms,
        ]);
    }

    public function create()
    {
        $tenantId = $this->tenantId();

        $gradeLevels = Cache::remember($this->keyGradeLevels($tenantId), $this->ttl(), function () use ($tenantId) {
            return GradeLevel::query()
                ->select('id', 'name', 'tenant_id')
                ->where('tenant_id', $tenantId)
                ->orderBy('name')
                ->get();
        });

        $teachers = Cache::remember($this->keyHomeroomTeachers($tenantId), $this->ttl(), function () use ($tenantId) {
            return User::role('Wali Kelas')
                ->with(['profile:id,user_id,name'])
                ->where('tenant_id', $tenantId)
                ->select('id', 'email', 'tenant_id')
                ->orderBy('id')
                ->get();
        });

        return view('school.class_room.create', [
            'page' => 'Create Class Room',
            'grade_levels' => $gradeLevels,
            'teachers' => $teachers,
        ]);
    }

    public function store(ClassRoomRequest $request)
    {
        $tenantId = $this->tenantId();

        $academicYear = AcademicYear::select('id', 'status')
            ->where('tenant_id', $tenantId)
            ->where('status', 'Active')
            ->first();

        if (!$academicYear) {
            return back()->withInput()->with(
                'error',
                'Active academic year not found. Please set the Academic Year first.'
            );
        }

        ClassRoom::create([
            'name' => $request->name,
            'section' => $request->section,
            'label' => $request->label,
            'grade_level_id' => $request->grade_level_id,
            'homeroom_teacher_id' => $request->teacher_id,
            'academic_year_id' => $academicYear->id,
            'tenant_id' => $tenantId,
        ]);

        $this->forgetClassRoomCaches($tenantId);

        return redirect()
            ->route('school.class_rooms.index')
            ->with('success', 'Class Room created.');
    }


    public function edit(string $id)
    {
        $tenantId = $this->tenantId();

        $classRoom = Cache::remember($this->keyItem($tenantId, $id), $this->ttl(), function () use ($tenantId, $id) {
            return ClassRoom::with(['gradeLevel', 'homeroomTeacher', 'academicYear'])
                ->where('tenant_id', $tenantId)
                ->where('id', $id)
                ->firstOrFail();
        });

        $gradeLevels = Cache::remember($this->keyGradeLevels($tenantId), $this->ttl(), function () use ($tenantId) {
            return GradeLevel::query()
                ->select('id', 'name', 'tenant_id')
                ->where('tenant_id', $tenantId)
                ->orderBy('name')
                ->get();
        });

        $teachers = Cache::remember($this->keyHomeroomTeachers($tenantId), $this->ttl(), function () use ($tenantId) {
            return User::role('Wali Kelas')
                ->with(['profile:id,user_id,name'])
                ->where('tenant_id', $tenantId)
                ->select('id', 'email', 'tenant_id')
                ->orderBy('id')
                ->get();
        });

        return view('school.class_room.edit', [
            'page' => 'Edit Class Room',
            'class_room' => $classRoom,
            'grade_levels' => $gradeLevels,
            'teachers' => $teachers,
        ]);
    }

    public function update(ClassRoomRequest $request, string $id)
    {
        $tenantId = $this->tenantId();

        $classRoom = ClassRoom::where('tenant_id', $tenantId)
            ->where('id', $id)
            ->firstOrFail();

        $classRoom->update([
            'name' => $request->name,
            'section' => $request->section,
            'label' => $request->label,
            'grade_level_id' => $request->grade_level_id,
            'homeroom_teacher_id' => $request->teacher_id,
        ]);

        $this->forgetClassRoomCaches($tenantId, $id);

        return redirect()
            ->route('school.class_rooms.index')
            ->with('success', 'Class Room updated.');
    }

    public function destroy(string $id)
    {
        $tenantId = $this->tenantId();

        $classRoom = ClassRoom::where('tenant_id', $tenantId)
            ->where('id', $id)
            ->firstOrFail();

        $classRoom->delete();

        $this->forgetClassRoomCaches($tenantId, $id);

        return redirect()
            ->route('school.class_rooms.index')
            ->with('success', 'Class Room deleted.');
    }
    private function tenantId(): string
    {
        return (string) Auth::user()->tenant_id;
    }
    private function ttl()
    {
        return now()->addHours(2);
    }

    private function keyMain(string $tenantId): string
    {
        return "{$tenantId}:class_room:main";
    }

    private function keyItem(string $tenantId, string $id): string
    {
        return "{$tenantId}:class_room:item:{$id}";
    }

    private function keyGradeLevels(string $tenantId): string
    {
        return "{$tenantId}:grade_level:main";
    }

    private function keyHomeroomTeachers(string $tenantId): string
    {
        return "{$tenantId}:teachers:homeroom:main";
    }

    private function forgetClassRoomCaches(string $tenantId, ?string $id = null): void
    {
        Cache::forget($this->keyMain($tenantId));
        if ($id) {
            Cache::forget($this->keyItem($tenantId, $id));
        }
    }
}
