<?php

namespace App\Http\Controllers;


use App\Models\ClassRoom;
use App\Models\FinalGrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $tenantId = $this->tenantId();
        $profileId = Auth::user()->profile->id;

        $academicYears = DB::table('academic_years')
            ->where('tenant_id', $tenantId)
            ->orderByDesc('status')
            ->orderByDesc('start_date')
            ->get(['id', 'code', 'term', 'status']);

        $classes = ClassRoom::with(['classSubjects.subject:id,code,name'])
            ->where('tenant_id', $tenantId)
            ->where('homeroom_teacher_id', $profileId)
            ->get(['id', 'name', 'section', 'tenant_id', 'homeroom_teacher_id']);

        $academic_year_id = (int) $request->query('academic_year_id', 0);
        $class_id = (int) $request->query('class_id', 0);
        $class_subject_id = (int) $request->query('class_subject_id', 0);

        $classSubjects = collect();
        if ($class_id) {
            $classObj = $classes->firstWhere('id', $class_id);
            if ($classObj) {
                $classSubjects = $classObj->classSubjects->map(function ($cs) {
                    return [
                        'id' => $cs->id,
                        'subject_code' => $cs->subject->code ?? 'SUB',
                        'subject_name' => $cs->subject->name ?? 'Subject',
                    ];
                })->values();
            }
        }

        $finalRows = collect();
        if ($academic_year_id && $class_id && $class_subject_id) {
            $finalRows = FinalGrade::query()
                ->where('final_grades.tenant_id', $tenantId)
                ->where('final_grades.class_subject_id', $class_subject_id)
                ->join('enrollments as e', function ($j) use ($tenantId, $academic_year_id, $class_id) {
                    $j->on('e.student_id', '=', 'final_grades.student_id')
                        ->where('e.tenant_id', '=', $tenantId)
                        ->where('e.academic_year_id', '=', $academic_year_id)
                        ->where('e.class_id', '=', $class_id);
                })
                ->join('profiles as p', 'p.id', '=', 'e.student_id')
                ->orderBy('p.name')
                ->get([
                    'p.name as student_name',
                    'final_grades.student_id',
                    'final_grades.final_score',
                ]);
        }

        return view('school.report.index', [
            'page' => 'Student Report',
            'tenantId' => $tenantId,
            'academicYears' => $academicYears,
            'classes' => $classes,
            'classSubjects' => $classSubjects,
            'academic_year_id' => $academic_year_id,
            'class_id' => $class_id,
            'class_subject_id' => $class_subject_id,
            'finalRows' => $finalRows,
        ]);
    }
    public function calculateFinalGrades(Request $request)
    {
        $data = $request->validate([
            'tenant_id' => 'required|integer',
            'academic_year_id' => 'required|integer',
            'class_id' => 'required|integer',
            'class_subject_id' => 'required|integer',
        ]);
        $tenantId = (int) $data['tenant_id'];
        $academicYearId = (int) $data['academic_year_id'];
        $classId = (int) $data['class_id'];
        $classSubjectId = (int) $data['class_subject_id'];

        // $sql = "
        //     WITH enrolled AS (
        //         SELECT DISTINCT e.student_id
        //         FROM enrollments e
        //         WHERE e.class_id = :class_id
        //         AND e.academic_year_id = :academic_year_id
        //         AND e.tenant_id = :tenant_id
        //     ),
        //     items AS (
        //         SELECT ai.id AS item_id,
        //             ac.id AS component_id,
        //             ac.weight
        //         FROM assessments a
        //         JOIN assessment_items ai ON ai.assessment_id = a.id
        //         JOIN assessment_components ac ON a.assessment_component_id = ac.id
        //         WHERE a.class_subject_id = :class_subject_id
        //         AND a.tenant_id = :tenant_id
        //     ),
        //     scores AS (
        //         SELECT ge.student_id,
        //             i.component_id,
        //             AVG(ge.final_score) AS avg_score
        //         FROM grade_entries ge
        //         JOIN items i ON i.item_id = ge.assessment_item_id
        //         JOIN enrolled e ON e.student_id = ge.student_id
        //         WHERE ge.tenant_id = :tenant_id
        //         GROUP BY ge.student_id, i.component_id
        //     ),
        //     weighted AS (
        //         SELECT s.student_id,
        //             ROUND(
        //                 SUM(s.avg_score * i.weight) / NULLIF(SUM(i.weight), 0)
        //             , 2) AS final_score
        //         FROM scores s
        //         JOIN items i ON i.component_id = s.component_id
        //         GROUP BY s.student_id
        //     )
        //     SELECT student_id, final_score
        //     FROM weighted
        //     ORDER BY student_id
        // ";
        $sql = "
           SELECT
            t.student_id,
            ROUND(SUM(t.avg_score * t.weight) / 100.0, 2) AS final_score
            FROM (
            SELECT
                ge.student_id,
                ac.id AS component_id,
                SUM(ge.final_score) AS avg_score,
                ac.weight
            FROM enrollments e
            JOIN grade_entries ge
                ON ge.student_id = e.student_id
            AND ge.tenant_id = ?
            JOIN assessment_items ai
                ON ai.id = ge.assessment_item_id
            AND ai.tenant_id = ?
            JOIN assessments a
                ON a.id = ai.assessment_id
            AND a.tenant_id = ?
            AND a.class_subject_id = ?
            JOIN assessment_components ac
                ON ac.id = a.assessment_component_id
            AND ac.tenant_id = ?
            WHERE e.tenant_id = ?
                AND e.class_id = ?
                AND e.academic_year_id = ?
            GROUP BY ge.student_id, ac.id, ac.weight
            ) AS t
            GROUP BY t.student_id
            ORDER BY t.student_id;
        ";


        // $rows = collect(DB::select($sql, [
        //     'tenant_id' => $tenantId,
        //     'academic_year_id' => $academicYearId,
        //     'class_id' => $classId,
        //     'class_subject_id' => $classSubjectId,
        // ]));
        $rows = collect(DB::select($sql, [
            $tenantId,        // ge.tenant_id
            $tenantId,        // ai.tenant_id
            $tenantId,        // a.tenant_id
            $classSubjectId,  // a.class_subject_id
            $tenantId,        // ac.tenant_id
            $tenantId,        // e.tenant_id
            $classId,         // e.class_id
            $academicYearId,  // e.academic_year_id
        ]));

        if ($rows->isEmpty()) {
            return response()->json([
                'status' => 'ok',
                'data' => [],
                'message' => 'Tidak ada nilai yang bisa dihitung untuk parameter ini.',
            ]);
        }

        $now = now();
        $payload = $rows->map(fn($r) => [
            'tenant_id' => $tenantId,
            'student_id' => (int) $r->student_id,
            'class_subject_id' => $classSubjectId,
            'final_score' => (float) $r->final_score,
            'created_at' => $now,
            'updated_at' => $now,
        ])->all();

        FinalGrade::upsert(
            $payload,
            ['tenant_id', 'student_id', 'class_subject_id'],
            ['final_score', 'updated_at']
        );

        return response()->json([
            'status' => 'ok',
            'data' => $rows,
            'saved' => count($payload),
        ]);
    }
    private function tenantId(): string
    {
        return (string) Auth::user()->tenant_id;
    }

}
