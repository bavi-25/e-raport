<?php

namespace App\Http\Controllers;

use App\Models\ClassSubject;
use App\Models\ClassRoom;
use App\Models\Subject;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ClassSubjectController extends Controller
{



    /* ========= Index ========= */
    public function index()
    {
        $tenantId = $this->tenantId();

        $assignments = Cache::remember($this->keyMain($tenantId), $this->ttl(), function () use ($tenantId) {
            return ClassSubject::with([
                'class:id,name,tenant_id',
                'subject:id,code,name,tenant_id',
                'teacher:id,name,user_id',
                'teacher.user:id,tenant_id,email'
            ])
                // tenant scoping via relasi
                ->whereHas('class', fn($q) => $q->where('tenant_id', $tenantId))
                ->whereHas('subject', fn($q) => $q->where('tenant_id', $tenantId))
                ->whereHas('teacher.user', fn($q) => $q->where('tenant_id', $tenantId))
                ->orderByDesc('id')
                ->get();
        });

        return view('school.class_subject.index', [
            'page' => 'Class Subjects',
            'assignments' => $assignments,
        ]);
    }

    /* ========= Create ========= */
    public function create()
    {
        $tenantId = $this->tenantId();

        $classes = Cache::remember(
            $this->keyClasses($tenantId),
            $this->ttl(),
            function () use ($tenantId) {
                return ClassRoom::select('id', 'name', 'tenant_id')
                    ->where('tenant_id', $tenantId)
                    ->orderBy('name')->get();
            }
        );

        $subjects = Cache::remember(
            $this->keySubjects($tenantId),
            $this->ttl(),
            function () use ($tenantId) {
                return Subject::select('id', 'code', 'name', 'tenant_id')
                    ->where('tenant_id', $tenantId)
                    ->orderBy('code')->get();
            }
        );

        $teachers = Cache::remember(
            $this->keyTeachers($tenantId),
            $this->ttl(),
            function () use ($tenantId) {
                return User::role('Guru')
                    ->with('profile:id,user_id,name')
                    ->where('tenant_id', $tenantId)
                    ->select('id', 'tenant_id', 'email')
                    ->orderBy('id')
                    ->get()
                    ->map(fn($u) => $u->profile)
                    ->filter();
            }
        );

        return view('school.class_subject.create', [
            'page' => 'Create Assignment',
            'classes' => $classes,
            'subjects' => $subjects,
            'teachers' => $teachers,
        ]);
    }


    public function store(Request $request)
    {
        $tenantId = $this->tenantId();

        $data = $request->validate([
            'class_id' => ['required', 'integer', 'exists:classes,id'],
            'subject_id' => ['required', 'integer', 'exists:subjects,id'],
            'teacher_id' => ['required', 'integer', 'exists:profiles,id'],
        ]);

        $classOk = ClassRoom::where('tenant_id', $tenantId)->where('id', $data['class_id'])->exists();
        $subjectOk = Subject::where('tenant_id', $tenantId)->where('id', $data['subject_id'])->exists();
        $teacherOk = Profile::where('id', $data['teacher_id'])->whereHas('user', fn($q) => $q->where('tenant_id', $tenantId)->role('Guru'))->exists();

        if (!$classOk || !$subjectOk || !$teacherOk) {
            return back()->withInput()->with('error', 'Invalid class/subject/teacher for this tenant.');
        }

        $exists = ClassSubject::where('class_id', $data['class_id'])
            ->where('subject_id', $data['subject_id'])
            ->exists();
        if ($exists) {
            return back()->withInput()->with('error', 'This class already has a main teacher for the selected subject.');
        }
        $data['tenant_id'] = $tenantId;
        DB::transaction(function () use ($data) {
            ClassSubject::create($data);
        });

        $this->forgetCaches($tenantId);

        return redirect()->route('school.class_subjects.index')
            ->with('success', 'Assignment created.');
    }

    public function edit(string $id)
    {
        $tenantId = $this->tenantId();

        $assignment = Cache::remember(
            $this->keyItem($tenantId, $id),
            $this->ttl(),
            function () use ($tenantId, $id) {
                return ClassSubject::with(['class', 'subject', 'teacher', 'teacher.user'])
                    ->where('id', $id)
                    ->whereHas('class', fn($q) => $q->where('tenant_id', $tenantId))
                    ->whereHas('subject', fn($q) => $q->where('tenant_id', $tenantId))
                    ->whereHas('teacher.user', fn($q) => $q->where('tenant_id', $tenantId))
                    ->firstOrFail();
            }
        );

        $classes = Cache::remember(
            $this->keyClasses($tenantId),
            $this->ttl(),
            function () use ($tenantId) {
                return ClassRoom::select('id', 'name', 'tenant_id')
                    ->where('tenant_id', $tenantId)
                    ->orderBy('name')->get();
            }
        );

        $subjects = Cache::remember(
            $this->keySubjects($tenantId),
            $this->ttl(),
            function () use ($tenantId) {
                return Subject::select('id', 'code', 'name', 'tenant_id')
                    ->where('tenant_id', $tenantId)
                    ->orderBy('code')->get();
            }
        );

        $teachers = Cache::remember(
            $this->keyTeachers($tenantId),
            $this->ttl(),
            function () use ($tenantId) {
                return User::role('Guru')
                    ->with('profile:id,user_id,name')
                    ->where('tenant_id', $tenantId)
                    ->select('id', 'tenant_id', 'email')
                    ->orderBy('id')
                    ->get()
                    ->map(fn($u) => $u->profile)
                    ->filter();
            }
        );
        return view('school.class_subject.edit', [
            'page' => 'Edit Assignment',
            'assignment' => $assignment,
            'classes' => $classes,
            'subjects' => $subjects,
            'teachers' => $teachers,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $tenantId = $this->tenantId();

        $data = $request->validate([
            'class_id' => ['required', 'integer', 'exists:classes,id'],
            'subject_id' => ['required', 'integer', 'exists:subjects,id'],
            'teacher_id' => ['required', 'integer', 'exists:profiles,id'],
        ]);
        
        $assignment = ClassSubject::where('id', $id)
            ->whereHas('class', fn($q) => $q->where('tenant_id', $tenantId))
            ->whereHas('subject', fn($q) => $q->where('tenant_id', $tenantId))
            ->whereHas('teacher.user', fn($q) => $q->where('tenant_id', $tenantId))
            ->firstOrFail();


        $classOk = ClassRoom::where('tenant_id', $tenantId)->where('id', $data['class_id'])->exists();
        $subjectOk = Subject::where('tenant_id', $tenantId)->where('id', $data['subject_id'])->exists();
        $teacherOk = Profile::where('id', $data['teacher_id'])->whereHas('user', fn($q) => $q->where('tenant_id', $tenantId)->role('Guru'))->exists();
        if (!$classOk || !$subjectOk || !$teacherOk) {
            return back()->withInput()->with('error', 'Invalid class/subject/teacher for this tenant.');
        }

        $exists = ClassSubject::where('class_id', $data['class_id'])
            ->where('subject_id', $data['subject_id'])
            ->where('id', '!=', $assignment->id)
            ->exists();
        if ($exists) {
            return back()->withInput()->with('error', 'This class already has a main teacher for the selected subject.');
        }

        DB::transaction(function () use ($assignment, $data) {
            $assignment->update($data);
        });

        $this->forgetCaches($tenantId, $id);

        return redirect()->route('school.class_subjects.index')
            ->with('success', 'Assignment updated.');
    }

    public function destroy(string $id)
    {
        $tenantId = $this->tenantId();

        $assignment = ClassSubject::where('id', $id)
            ->whereHas('class', fn($q) => $q->where('tenant_id', $tenantId))
            ->whereHas('subject', fn($q) => $q->where('tenant_id', $tenantId))
            ->whereHas('teacher.user', fn($q) => $q->where('tenant_id', $tenantId))
            ->firstOrFail();

        $assignment->delete();

        $this->forgetCaches($tenantId, $id);

        return redirect()->route('school.class_subjects.index')
            ->with('success', 'Assignment deleted.');
    }

    public function show(string $id)
    {
        $tenantId = $this->tenantId();

        $assignment = Cache::remember($this->keyItem($tenantId, $id), $this->ttl(), function () use ($tenantId, $id) {
            return ClassSubject::with(['class', 'subject', 'teacher', 'teacher.user'])
                ->where('id', $id)
                ->whereHas('class', fn($q) => $q->where('tenant_id', $tenantId))
                ->whereHas('subject', fn($q) => $q->where('tenant_id', $tenantId))
                ->whereHas('teacher.user', fn($q) => $q->where('tenant_id', $tenantId))
                ->firstOrFail();
        });

        return view('school.class_subject.show', [
            'page' => 'Assignment Detail',
            'assignment' => $assignment,
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
    private function keyMain(string $tenantId): string
    {
        return "{$tenantId}:class_subjects:main";
    }
    private function keyItem(string $tenantId, string $id): string
    {
        return "{$tenantId}:class_subjects:item:{$id}";
    }
    private function keyClasses(string $tenantId): string
    {
        return "{$tenantId}:classes:list";
    }
    private function keySubjects(string $tenantId): string
    {
        return "{$tenantId}:subjects:list";
    }
    private function keyTeachers(string $tenantId): string
    {
        return "{$tenantId}:teachers:guru:profiles";
    }
    private function forgetCaches(string $tenantId, ?string $id = null): void
    {
        Cache::forget($this->keyMain($tenantId));
        if ($id)
            Cache::forget($this->keyItem($tenantId, $id));
    }
}
