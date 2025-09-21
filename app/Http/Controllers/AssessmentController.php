<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Enrollment;
use App\Models\ClassSubject;
use App\Models\AssessmentComponent;
use App\Models\AssessmentItem;
use App\Models\GradeEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AssessmentController extends Controller
{
    /* ===== Helpers ===== */
   

    public function index()
    {
        $tenantId = $this->tenantId();

        $assessments = Cache::remember(
            $this->keyMain($tenantId),
            $this->ttl(),
            function () use ($tenantId) {
                $ids = Assessment::query()
                    ->where('tenant_id', $tenantId)
                    ->selectRaw('MIN(id) AS id')
                    ->groupBy('class_subject_id', 'title', 'date', 'tenant_id')
                    ->pluck('id');

                return Assessment::query()
                    ->whereIn('id', $ids)
                    ->select('id', 'title', 'date', 'class_subject_id', 'tenant_id')
                    ->with([
                        'classSubject:id,subject_id,class_id,teacher_id,tenant_id',
                        'classSubject.class:id,name',
                        'classSubject.teacher:id,name',
                        'classSubject.subject:id,code,name'
                    ])
                    ->orderByDesc('date')->orderByDesc('id')
                    ->get();
            }
        );

        return view('school.assessment.index', [
            'page' => 'Assessments',
            'assessments' => $assessments,
        ]);
    }

    /* ===== Create (tanpa Enrollment dropdown) ===== */
    public function create()
    {
        $tenantId = $this->tenantId();

        $classSubjects = Cache::remember($this->keyClassSubjects($tenantId), $this->ttl(), function () use ($tenantId) {
            return ClassSubject::with([
                'subject:id,code,name',
                'class:id,name,academic_year_id',
                'teacher:id,user_id,name',
            ])
                ->select('id', 'class_id', 'subject_id', 'teacher_id', 'tenant_id')
                ->where('tenant_id', $tenantId)
                ->latest('id')
                ->get();
        });

        $components = Cache::remember($this->keyComponents($tenantId), $this->ttl(), function () use ($tenantId) {
            return AssessmentComponent::select('id', 'name', 'weight', 'tenant_id')
                ->where('tenant_id', $tenantId)
                ->orderBy('name')
                ->get();
        });

        return view('school.assessment.create', [
            'page' => 'Create Assessment',
            'classSubjects' => $classSubjects,
            'components' => $components,
            'today' => now()->toDateString(),
        ]);
    }


    public function store(Request $request)
    {
        $tenantId = $this->tenantId();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'class_subject_id' => 'required|exists:class_subjects,id',
            'assessment_component_id' => 'required|exists:assessment_components,id',
            'items' => 'required|array|min:1',
            'items.*.competency_code' => 'required|string|max:100',
            'items.*.max_score' => 'required|numeric|min:0|max:100',
        ]);

        $classSubject = ClassSubject::query()
            ->with('class:id,academic_year_id')
            ->where('tenant_id', $tenantId)
            ->where('id', $validated['class_subject_id'])
            ->first(['id', 'class_id', 'tenant_id']);

        if (!$classSubject || !$classSubject->class) {
            return back()
                ->withErrors(['class_subject_id' => 'Class Subject tidak valid atau tidak memiliki relasi Class/Academic Year.'])
                ->withInput();
        }

        $enrollmentIds = Enrollment::query()
            ->where('tenant_id', $tenantId)
            ->where('class_id', $classSubject->class_id)
            ->where('academic_year_id', $classSubject->class->academic_year_id)
            ->pluck('id')
            ->all();

        if (empty($enrollmentIds)) {
            return back()
                ->withErrors(['class_subject_id' => 'Belum ada siswa yang ter-enroll pada kelas & tahun ajaran ini.'])
                ->withInput();
        }

        $createdCount = 0;
        $lastAssessmentTitle = $validated['title'];

        DB::transaction(function () use ($validated, $tenantId, $enrollmentIds, $classSubject, &$createdCount, &$lastAssessmentTitle) {

            $itemTemplates = collect($validated['items'])->map(function ($it) use ($tenantId) {
                return [
                    'tenant_id' => $tenantId,
                    'competency_code' => $it['competency_code'],
                    'max_score' => $it['max_score'],
                ];
            });

            collect($enrollmentIds)->chunk(100)->each(
                function ($chunk) use ($validated, $tenantId, $classSubject, $itemTemplates, &$createdCount) {

                    foreach ($chunk as $enrollmentId) {
                        $assessment = Assessment::create([
                            'title' => $validated['title'],
                            'date' => $validated['date'],
                            'enrollment_id' => $enrollmentId,
                            'class_subject_id' => $classSubject->id,
                            'assessment_component_id' => $validated['assessment_component_id'],
                            'tenant_id' => $tenantId,
                        ]);

                        $items = $itemTemplates->map(function ($tpl) use ($assessment) {
                            return $tpl + ['assessment_id' => $assessment->id];
                        })->all();

                        AssessmentItem::insert($items);
                        $createdCount++;
                    }
                }
            );
        });

        $this->forgetCaches($tenantId);

        return redirect()
            ->route('school.assessments.index')
            ->with('success', "Assessment \"{$lastAssessmentTitle}\" dibuat untuk {$createdCount} enrollment dan item berhasil digenerate.");
    }

    public function edit(string $id)
    {
        $tenantId = $this->tenantId();

        $assessment = Cache::remember(
            $this->keyItem($tenantId, $id),
            $this->ttl(),
            function () use ($tenantId, $id) {
                return Assessment::query()
                    ->select('id', 'title', 'date', 'class_subject_id', 'assessment_component_id', 'tenant_id')
                    ->where('tenant_id', $tenantId)
                    ->where('id', $id)
                    ->with([
                        // untuk menampilkan ringkasannya di header form (kelas & guru)
                        'classSubject:id,class_id,teacher_id,tenant_id',
                        'classSubject.class:id,name',
                        'classSubject.teacher:id,name',
                        'assessmentComponent:id,name,weight',
                        'items' => function ($q) {
                            $q->select('id', 'assessment_id', 'competency_code', 'max_score', 'tenant_id')
                                ->orderBy('id');
                        },
                    ])
                    ->firstOrFail();
            }
        );

        $classSubjects = Cache::remember(
            $this->keyClassSubjects($tenantId),
            $this->ttl(),
            function () use ($tenantId) {
                return ClassSubject::query()
                    ->with([
                        'subject:id,code,name',
                        'class:id,name,academic_year_id',
                        'teacher:id,user_id,name',
                    ])
                    ->select('id', 'class_id', 'subject_id', 'teacher_id', 'tenant_id')
                    ->where('tenant_id', $tenantId)
                    ->latest('id')
                    ->get();
            }
        );
        
        $components = Cache::remember(
            $this->keyComponents($tenantId),
            $this->ttl(),
            function () use ($tenantId) {
                return AssessmentComponent::query()
                    ->select('id', 'name', 'weight', 'tenant_id')
                    ->where('tenant_id', $tenantId)
                    ->orderBy('name')
                    ->get();
            }
        );

        return view('school.assessment.edit', [
            'page' => 'Edit Assessment',
            'assessment' => $assessment,
            'classSubjects' => $classSubjects,
            'components' => $components,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $tenantId = $this->tenantId();

        $assessment = Assessment::where('tenant_id', $tenantId)
            ->where('id', $id)
            ->firstOrFail();

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'class_subject_id' => ['required', 'uuid'],
            'assessment_component_id' => ['required', 'uuid'],

            'items' => ['nullable', 'array'],
            'items.*.id' => ['nullable', 'uuid'],
            'items.*.competency_code' => ['required_with:items.*.max_score', 'string', 'max:100'],
            'items.*.max_score' => ['required_with:items.*.competency_code', 'numeric', 'min:0', 'max:100'],
        ]);

        $classSubject = ClassSubject::with('class:id,academic_year_id')
            ->where('tenant_id', $tenantId)
            ->where('id', $data['class_subject_id'])
            ->first();

        if (!$classSubject) {
            return back()->withErrors(['class_subject_id' => 'Class Subject tidak valid.'])->withInput();
        }

        $component = AssessmentComponent::where('tenant_id', $tenantId)
            ->where('id', $data['assessment_component_id'])
            ->first();

        if (!$component) {
            return back()->withErrors(['assessment_component_id' => 'Component tidak valid.'])->withInput();
        }

        DB::transaction(function () use ($assessment, $data, $tenantId, $classSubject) {
            $classSubjectChanged = $assessment->class_subject_id !== $data['class_subject_id'];

            $assessment->update([
                'title' => $data['title'],
                'date' => $data['date'],
                'class_subject_id' => $data['class_subject_id'],
                'assessment_component_id' => $data['assessment_component_id'],
            ]);

            $existingItems = AssessmentItem::where('tenant_id', $tenantId)
                ->where('assessment_id', $assessment->id)
                ->get(['id']);

            $existingIds = $existingItems->pluck('id')->map(fn($v) => (string) $v)->all();

            $payloadItems = collect($data['items'] ?? [])
                // Buang baris kosong total bila ada
                ->filter(function ($row) {
                    $cc = trim((string) ($row['competency_code'] ?? ''));
                    return $cc !== '';
                })
                ->values();

            $sentIds = $payloadItems->pluck('id')->filter()->map(fn($v) => (string) $v)->all();

            $payloadItems->filter(fn($row) => !empty($row['id']))->each(function ($row) use ($tenantId, $assessment) {
                AssessmentItem::where('tenant_id', $tenantId)
                    ->where('assessment_id', $assessment->id)
                    ->where('id', $row['id'])
                    ->update([
                        'competency_code' => $row['competency_code'],
                        'max_score' => $row['max_score'],
                    ]);
            });

            $newRows = $payloadItems->filter(fn($row) => empty($row['id']))->map(function ($row) use ($tenantId, $assessment) {
                return [
                    'id' => DB::raw('gen_random_uuid()'),
                    'tenant_id' => $tenantId,
                    'assessment_id' => $assessment->id,
                    'competency_code' => $row['competency_code'],
                    'max_score' => $row['max_score'],
                ];
            })->values()->all();

            if (!empty($newRows)) {
                AssessmentItem::insert($newRows);
            }

            $toDelete = array_diff($existingIds, $sentIds);
            if (!empty($toDelete)) {
                AssessmentItem::where('tenant_id', $tenantId)
                    ->where('assessment_id', $assessment->id)
                    ->whereIn('id', $toDelete)
                    ->delete();
            }

            // 3) (OPSIONAL) Jika class_subject berubah, reseed grade_entries yang belum ada
            /*
            if ($classSubjectChanged) {
                $classId = $classSubject->class_id;
                $yearId  = optional($classSubject->class)->academic_year_id;

                $studentIds = Enrollment::query()
                    ->where('tenant_id', $tenantId)
                    ->where('class_id',  $classId)
                    ->when($yearId, fn($q) => $q->where('academic_year_id', $yearId))
                    ->pluck('student_id');

                $itemIds = $assessment->items()->pluck('id');
                $now = now();
                $rows = [];

                foreach ($itemIds as $itemId) {
                    foreach ($studentIds as $sid) {
                        $exists = GradeEntry::where([
                            'tenant_id'          => $tenantId,
                            'assessment_item_id' => $itemId,
                            'student_id'         => $sid,
                        ])->exists();
                        if (!$exists) {
                            $rows[] = [
                                'id'                 => DB::raw('gen_random_uuid()'),
                                'tenant_id'          => $tenantId,
                                'assessment_item_id' => $itemId,
                                'student_id'         => $sid,
                                'score'              => null,
                                'graded_at'          => $now,
                            ];
                        }
                    }
                }
                if (!empty($rows)) {
                    DB::table('grade_entries')->insert($rows);
                }
            }
            */
        });

        $this->forgetCaches($tenantId, $id);

        return redirect()
            ->route('school.assessments.index')
            ->with('success', 'Assessment updated.');
    }


    /* ===== Destroy ===== */
    public function destroy(string $id)
    {
        $tenantId = $this->tenantId();

        $assessment = Assessment::where('tenant_id', $tenantId)->where('id', $id)->firstOrFail();
        $assessment->delete();

        $this->forgetCaches($tenantId, $id);

        return redirect()->route('school.assessments.index')->with('success', 'Assessment deleted.');
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
        return "{$tenantId}:assessments:main";
    }
    private function keyItem(string $tenantId, string $id): string
    {
        return "{$tenantId}:assessments:item:{$id}";
    }
    private function keyClassSubjects(string $tenantId): string
    {
        return "{$tenantId}:class_subjects:for_assess";
    }
    private function keyComponents(string $tenantId): string
    {
        return "{$tenantId}:assessment_components:for_assess";
    }
    private function forgetCaches(string $tenantId, ?string $id = null): void
    {
        Cache::forget($this->keyMain($tenantId));
        if ($id)
            Cache::forget($this->keyItem($tenantId, $id));
    }
  
}