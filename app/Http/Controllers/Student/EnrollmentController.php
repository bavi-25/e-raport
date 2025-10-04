<?php

namespace App\Http\Controllers\Student;


use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    //
    public function index()
    {

        $enrollments = Enrollment::with("student", "class", "academicYear")
            ->where('tenant_id', $this->tenantId())
            ->where('student_id', $this->studentId())
            ->get();
        $data = [
            'page' => 'Enrollment Student',
            'enrollments' => $enrollments,
        ];
        return view('student.enrollment.index', $data);
    }

    public function show($id)
    {
        $enrollment = Enrollment::query()
            ->where('tenant_id', $this->tenantId())
            ->where('student_id', $this->studentId())
            ->with([
                'student:id,name',
                'academicYear:id,code,term,status',
                'class:id,name,academic_year_id,tenant_id',
                'class.classSubjects:id,class_id,subject_id,teacher_id',
                'class.classSubjects.subject:id,code,name',
                'class.classSubjects.teacher:id,name',
            ])
            ->findOrFail($id);

        return view('student.enrollment.show', [
            'page' => 'Enrollment Detail',
            'enrollment' => $enrollment,
        ]);
    }

    public function subject_detail($enrollmentId, $subjectId)
    {
        $tenantId = $this->tenantId();
        $studentId = $this->studentId();

        $enrollment = Enrollment::query()
            ->where('tenant_id', $tenantId)
            ->where('student_id', $studentId)
            ->with([
                'student:id,name',
                'academicYear:id,code,term,status',
                'class:id,name,tenant_id',
            ])
            ->findOrFail($enrollmentId);

        $classId = optional($enrollment->class)->id;
        if (!$classId) {
            abort(404, 'Kelas untuk enrollment ini tidak ditemukan.');
        }

        $classSubject = \App\Models\ClassSubject::query()
            ->where('tenant_id', $tenantId)
            ->where('class_id', $classId)
            ->where('subject_id', $subjectId)
            ->with([
                'subject:id,code,name',
                'teacher:id,name',

                'assessments' => function ($q) use ($enrollmentId, $tenantId) {
                    $q->select('id', 'class_subject_id', 'enrollment_id', 'title', 'date', 'tenant_id')
                        ->where('tenant_id', $tenantId)
                        ->where('enrollment_id', $enrollmentId)
                        ->orderByDesc('date')->orderByDesc('id');
                },

                'assessments.items' => function ($q) use ($tenantId) {
                    $q->select('id', 'assessment_id', 'max_score', 'tenant_id')
                        ->where('tenant_id', $tenantId)
                        ->orderBy('id');
                },

                'assessments.items.gradeEntries' => function ($q) use ($tenantId, $studentId) {
                    $q->select('id', 'assessment_item_id', 'student_id', 'final_score', 'tenant_id')
                        ->where('tenant_id', $tenantId)
                        ->where('student_id', $studentId);
                },

                'finalGrades' => function ($q) use ($tenantId, $studentId) {
                    $q->select('id', 'class_subject_id', 'student_id', 'final_score', 'tenant_id')
                        ->where('tenant_id', $tenantId)
                        ->where('student_id', $studentId);
                },
            ])
            ->first();

        if (!$classSubject) {
            abort(404, 'Subject tidak ditemukan pada kelas dari enrollment ini.');
        }

        $assessmentSummaries = [];
        foreach ($classSubject->assessments as $ass) {
            $itemsCount = $ass->items->count();
            $scoredItems = 0;
            $scoreSum = 0.0;
            $maxSum = 0.0;

            foreach ($ass->items as $item) {
                $maxSum += (float) ($item->max_score ?? 0);
                $entry = $item->gradeEntries->first();

                if ($entry) {
                    $scoredItems++;
                    $scoreSum += (float) ($entry->final_score ?? 0);
                }
            }

            $percent = ($maxSum > 0) ? round(($scoreSum / $maxSum) * 100, 2) : null;

            $assessmentSummaries[] = [
                'id' => $ass->id,
                'title' => $ass->title,
                'date' => $ass->date,
                'items_count' => $itemsCount,
                'scored_items' => $scoredItems,
                'score_sum' => $scoreSum,
                'max_sum' => $maxSum,
                'percent' => $percent,
            ];
        }

        return view('student.enrollment.subject_detail', [
            'page' => 'Subject Detail',
            'enrollment' => $enrollment,
            'classSubject' => $classSubject,
            'assessments' => $classSubject->assessments,
            'assessmentSummaries' => $assessmentSummaries,
        ]);
    }


    private function tenantId(): string
    {
        return (string) Auth::user()->tenant_id;
    }

    private function studentId(): string
    {
        return (string) Auth::user()->profile->id;
    }
}
