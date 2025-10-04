<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\Assessment;
use App\Models\Enrollment;
use App\Models\GradeEntry;
use App\Models\AcademicYear;
use App\Models\ClassSubject;
use App\Models\AssessmentItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GradeEntryController extends Controller
{
    public function index(Request $request)
    {
        $tenantId = $this->tenantId();
        $teacherProfileId = optional(Auth::user()->profile)->id;

        $academicYearId = $request->query('academic_year_id');
        $classId = $request->query('class_id');
        $classSubjectId = $request->query('class_subject_id');
        $enrollmentId = $request->query('enrollment_id');
        $assessmentId = $request->query('assessment_id');

        // Academic years
        $academicYears = AcademicYear::query()
            ->where('tenant_id', $tenantId)
            ->orderByDesc('status')
            ->orderByDesc('id')
            ->get(['id', 'code', 'term', 'status']);

        // Kelas yang diajar guru (jika ada)
        $classIdsTaught = ClassSubject::query()
            ->where('tenant_id', $tenantId)
            ->when($teacherProfileId, fn($q) => $q->where('teacher_id', $teacherProfileId))
            ->pluck('class_id')->unique()->values();

        $classes = ClassRoom::query()
            ->where('tenant_id', $tenantId)
            ->when($classIdsTaught->isNotEmpty(), fn($q) => $q->whereIn('id', $classIdsTaught))
            ->orderBy('name')
            ->get(['id', 'name']);

        // Mata pelajaran dalam kelas yang dipilih
        $classSubjects = collect();
        if ($classId) {
            $classSubjects = ClassSubject::query()
                ->where('tenant_id', $tenantId)
                ->where('class_id', $classId)
                ->when($teacherProfileId, fn($q) => $q->where('teacher_id', $teacherProfileId))
                ->with(['subject:id,code,name'])
                ->orderByDesc('id')
                ->get(['id', 'class_id', 'subject_id', 'teacher_id', 'tenant_id']);
        }

        // Daftar siswa (enrollments) di kelas & tahun ajaran
        $enrollments = collect();
        if ($classId && $academicYearId) {
            $enrollments = Enrollment::query()
                ->where('tenant_id', $tenantId)
                ->where('class_id', $classId)
                ->where('academic_year_id', $academicYearId)
                ->with(['student:id,name'])
                ->orderBy('id', 'asc')
                ->get(['id', 'student_id', 'class_id', 'academic_year_id', 'tenant_id']);
        }

        // Daftar assessment untuk siswa & mapel
        $assessments = collect();
        if ($enrollmentId && $classSubjectId) {
            $assessments = Assessment::query()
                ->where('tenant_id', $tenantId)
                ->where('enrollment_id', $enrollmentId)
                ->where('class_subject_id', $classSubjectId)
                ->with(['assessmentComponent:id,name,weight'])
                ->orderByDesc('date')->orderByDesc('id')
                ->get(['id', 'title', 'date', 'enrollment_id', 'class_subject_id', 'assessment_component_id', 'tenant_id']);
        }

        // Detail assessment terpilih + items + nilai siswa
        $assessment = null;
        $items = collect();
        $gradeByItem = [];

        if ($assessmentId && $enrollmentId && $classSubjectId) {
            $assessment = Assessment::query()
                ->where('tenant_id', $tenantId)
                ->where('id', $assessmentId)
                ->where('enrollment_id', $enrollmentId)
                ->where('class_subject_id', $classSubjectId)
                ->with(['enrollment:id,student_id'])
                ->first();

            if ($assessment) {
                $items = AssessmentItem::query()
                    ->where('tenant_id', $tenantId)
                    ->where('assessment_id', $assessment->id)
                    ->orderBy('id')
                    ->get(['id', 'assessment_id', 'competency_code', 'max_score', 'tenant_id']);

                $studentId = optional($assessment->enrollment)->student_id;

                $grades = GradeEntry::query()
                    ->where('tenant_id', $tenantId)
                    ->where('student_id', $studentId) // ← tanpa schema_has_column: diasumsikan kolom wajib ada
                    ->whereIn('assessment_item_id', $items->pluck('id'))
                    ->get(['id', 'assessment_item_id', 'final_score']);

                $gradeByItem = $grades->keyBy('assessment_item_id')
                    ->map(fn($g) => $g->final_score)
                    ->toArray();
            }
        }

        return view('school.grade_entries.index', [
            'page' => 'Input Nilai Siswa',
            'academicYears' => $academicYears,
            'classes' => $classes,
            'classSubjects' => $classSubjects,
            'enrollments' => $enrollments,
            'assessments' => $assessments,
            'assessment' => $assessment,
            'items' => $items,
            'gradeByItem' => $gradeByItem,
            'academic_year_id' => $academicYearId,
            'class_id' => $classId,
            'class_subject_id' => $classSubjectId,
            'enrollment_id' => $enrollmentId,
            'assessment_id' => $assessmentId,
        ]);
    }

    public function store(Request $request)
    {
        $tenantId = $this->tenantId();

        $validated = $request->validate([
            'academic_year_id' => 'required',
            'class_id' => 'required',
            'class_subject_id' => 'required',
            'enrollment_id' => 'required',
            'assessment_id' => 'nullable',
            'title' => 'required_without:assessment_id|string|max:255',
            'date' => 'required_without:assessment_id|date',
            'assessment_component_id' => 'required_without:assessment_id|uuid',
            'scores' => 'array',
            'scores.*' => 'nullable|numeric|min:0|max:1000',
            'next_student' => 'nullable|boolean',
        ]);

        $assessment = null;

        DB::transaction(function () use ($tenantId, $validated, &$assessment) {

            // Pastikan enrollment sesuai tenant + filter class & year
            $enrollment = Enrollment::query()
                ->where('tenant_id', $tenantId)
                ->where('id', $validated['enrollment_id'])
                ->where('class_id', $validated['class_id'])
                ->where('academic_year_id', $validated['academic_year_id'])
                ->firstOrFail();

            // Pastikan class_subject sesuai tenant & class
            $classSubject = ClassSubject::query()
                ->where('tenant_id', $tenantId)
                ->where('id', $validated['class_subject_id'])
                ->where('class_id', $validated['class_id'])
                ->firstOrFail();

            if (!empty($validated['assessment_id'])) {
                // Pakai assessment existing (tetap dibatasi tenant & konsisten)
                $assessment = Assessment::query()
                    ->where('tenant_id', $tenantId)
                    ->where('id', $validated['assessment_id'])
                    ->where('enrollment_id', $enrollment->id)
                    ->where('class_subject_id', $classSubject->id)
                    ->firstOrFail();
            } else {
                // Buat assessment baru
                $assessment = Assessment::create([
                    'tenant_id' => $tenantId,
                    'enrollment_id' => $enrollment->id,
                    'class_subject_id' => $classSubject->id,
                    'assessment_component_id' => $validated['assessment_component_id'],
                    'title' => $validated['title'],
                    'date' => date('Y-m-d', strtotime($validated['date'])),
                ]);
            }

            // Simpan nilai per item untuk siswa ini
            $scores = $validated['scores'] ?? [];
            $studentId = $enrollment->student_id;

            if (!empty($scores)) {
                // Hanya izinkan item yang memang milik assessment ini
                $validItemIds = AssessmentItem::query()
                    ->where('tenant_id', $tenantId)
                    ->where('assessment_id', $assessment->id)
                    ->pluck('id')
                    ->all();

                foreach ($scores as $itemId => $score) {
                    if ($score === null || $score === '' || !in_array($itemId, $validItemIds, true)) {
                        continue;
                    }

                    GradeEntry::updateOrCreate(
                        [
                            'tenant_id' => $tenantId,
                            'assessment_item_id' => $itemId,
                            'student_id' => $studentId,
                        ],
                        [
                            'final_score' => round((float) $score, 2),
                        ]
                    );
                }
            }
        });

        // Redirect params
        $params = [
            'academic_year_id' => $validated['academic_year_id'],
            'class_id' => $validated['class_id'],
            'class_subject_id' => $validated['class_subject_id'],
        ];

        // Lanjut ke siswa berikutnya?
        if ($request->boolean('next_student')) {
            $list = Enrollment::query()
                ->where('tenant_id', $tenantId)
                ->where('class_id', $validated['class_id'])
                ->where('academic_year_id', $validated['academic_year_id'])
                ->orderBy('id')
                ->pluck('id')
                ->values();

            $pos = $list->search($validated['enrollment_id']);
            $nextEnrollmentId = $pos !== false ? $list->get($pos + 1) : null;

            if ($nextEnrollmentId) {
                $params['enrollment_id'] = $nextEnrollmentId;

                return redirect()
                    ->route('school.grade_entries.index', $params)
                    ->with('success', 'Nilai tersimpan. Beralih ke siswa berikutnya.');
            }
        }

        // Kembali ke siswa saat ini + set assessment_id agar item terload
        $params['enrollment_id'] = $validated['enrollment_id'];
        $params['assessment_id'] = $assessment->id;

        return redirect()
            ->route('school.grade_entries.index', $params)
            ->with('success', 'Nilai tersimpan.');
    }

    private function tenantId(): string
    {
        return (string) Auth::user()->tenant_id;
    }

    private function ttl()
    {
        return now()->addHours(2);
    }
}
