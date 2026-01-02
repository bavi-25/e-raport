<?php

namespace App\Http\Controllers\Student;


use View;
use App\Models\Tenant;
use App\Models\Enrollment;
use App\Models\AttendanceEntry;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
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
    // public function generateRaport($enrollmentId)
    // {
    //     $enrollment = Enrollment::query()
    //         ->where('tenant_id', $this->tenantId())
    //         ->where('student_id', $this->studentId())
    //         ->with([
    //             'student',
    //             'academicYear:id,code,term,status',
    //             'class:id,name,academic_year_id,tenant_id,homeroom_teacher_id',
    //             'class.homeroomTeacher:id,name',
    //             'class.classSubjects:id,class_id,subject_id,teacher_id',
    //             'class.classSubjects.subject:id,code,name',
    //             'class.classSubjects.teacher:id,name',
    //             'class.classSubjects.finalGrades' => function ($q) use ($enrollmentId) {
    //                 $q->where('student_id', function ($sub) use ($enrollmentId) {
    //                     $sub->select('student_id')
    //                         ->from('enrollments')
    //                         ->where('id', $enrollmentId);
    //                 });
    //             },
    //         ])
    //         ->findOrFail($enrollmentId);

    //     $siswa = $enrollment->student;
    //     $kelas = (object) ['nama' => $enrollment->class->name ?? '-'];
    //     $semester = $enrollment->academicYear->term ?? '-';
    //     $tahunAjaran = $enrollment->academicYear->code ?? '-';
    //     $waliKelas = (object) [
    //         'nama' => $enrollment->class->homeroomTeacher->name ?? null,
    //         'nip' => null,
    //     ];

    //     $nilai = [];
    //     foreach ($enrollment->class->classSubjects as $cs) {
    //         $fg = $cs->finalGrades->first();
    //         $final = $fg->final_score ?? null;

    //         $nilai[] = [
    //             'mata_pelajaran' => $cs->subject->name ?? '(Tidak diketahui)',
    //             'nilai_akhir' => $final !== null ? number_format((float) $final, 2) : '-',
    //         ];
    //     }

    //     $angka = [];
    //     foreach ($nilai as $n) {
    //         $v = is_string($n['nilai_akhir']) ? str_replace(',', '.', $n['nilai_akhir']) : $n['nilai_akhir'];
    //         if (is_numeric($v))
    //             $angka[] = (float) $v;
    //     }
    //     $rataRata = count($angka) ? number_format(array_sum($angka) / count($angka), 2) : '-';

    //     $sekolah = Tenant::where('id', $this->tenantId())->first();

    //     $kehadiran = (object) ['sakit' => 0, 'izin' => 0, 'alpha' => 0];
    //     $catatan = null;
    //     $kota = 'Kota';
    //     $tanggal = now()->format('d F Y');

    //     $pdf = Pdf::loadView('student.report.index', [
    //         'sekolah' => $sekolah,
    //         'siswa' => $siswa,
    //         'kelas' => $kelas,
    //         'semester' => $semester,
    //         'tahun_ajaran' => $tahunAjaran,
    //         'nilai' => $nilai,
    //         'rata_rata' => $rataRata,
    //         'kehadiran' => $kehadiran,
    //         'catatan' => $catatan,
    //         'kota' => $kota,
    //         'tanggal' => $tanggal,
    //         'wali_kelas' => $waliKelas,
    //     ])->setPaper('a4', 'portrait');

    //     return $pdf->stream('raport-' . ($siswa->nama ?: 'siswa') . '.pdf');
    // }
    public function generateRaport($enrollmentId)
    {
        $enrollment = Enrollment::query()
            ->where('tenant_id', $this->tenantId())
            ->where('student_id', $this->studentId())
            ->with([
                'student',
                'academicYear:id,code,term,status',
                'class:id,name,academic_year_id,tenant_id,homeroom_teacher_id',
                'class.homeroomTeacher:id,name',
                'class.classSubjects:id,class_id,subject_id,teacher_id',
                'class.classSubjects.subject:id,code,name',
                'class.classSubjects.teacher:id,name',
                'class.classSubjects.finalGrades' => function ($q) use ($enrollmentId) {
                    $q->where('student_id', function ($sub) use ($enrollmentId) {
                        $sub->select('student_id')
                            ->from('enrollments')
                            ->where('id', $enrollmentId);
                    });
                },
            ])
            ->findOrFail($enrollmentId);

        $siswa = $enrollment->student;
        $studentId = $siswa->id;
        $classId = $enrollment->class_id;

        $kelas = (object) ['nama' => $enrollment->class->name ?? '-'];
        $semester = $enrollment->academicYear->term ?? '-';
        $tahunAjaran = $enrollment->academicYear->code ?? '-';
        $waliKelas = (object) [
            'nama' => $enrollment->class->homeroomTeacher->name ?? null,
            'nip' => null,
        ];

        // === Ambil nilai + kehadiran PER MATA PELAJARAN ===
        $nilai = [];
        foreach ($enrollment->class->classSubjects as $cs) {
            $subjectName = $cs->subject->name ?? '(Tidak diketahui)';
            $finalGrade = $cs->finalGrades->first();
            $nilaiAkhir = $finalGrade?->final_score ? number_format((float) $finalGrade->final_score, 2) : '-';

            // Hitung kehadiran untuk mata pelajaran ini
            $kehadiranMapel = AttendanceEntry::query()
                ->where('student_id', $studentId)
                ->whereHas('attendance', function ($q) use ($cs) {
                    $q->where('class_subject_id', $cs->id);
                })
                ->selectRaw("
                SUM(CASE WHEN status IN ('present', 'late') THEN 1 ELSE 0 END) as hadir,
                SUM(CASE WHEN status IN ('absent', 'excused') THEN 1 ELSE 0 END) as tidak_hadir
            ")
                ->first();

            $hadir = $kehadiranMapel?->hadir ?? 0;
            $tidakHadir = $kehadiranMapel?->tidak_hadir ?? 0;

            $nilai[] = [
                'mata_pelajaran' => $subjectName,
                'nilai_akhir' => $nilaiAkhir,
                'hadir' => $hadir,
                'tidak_hadir' => $tidakHadir,
            ];
        }

        // Hitung rata-rata nilai (hanya dari nilai akhir yang valid)
        $angka = array_filter(array_column($nilai, 'nilai_akhir'), fn($v) => is_numeric(str_replace(',', '.', $v)));
        $angka = array_map(fn($v) => (float) str_replace(',', '.', $v), $angka);
        $rataRata = count($angka) ? number_format(array_sum($angka) / count($angka), 2) : '-';

        $sekolah = Tenant::where('id', $this->tenantId())->first();
        $kota = 'Jakarta'; // atau ambil dari tenant
        $tanggal = now()->format('d F Y');

        $pdf = Pdf::loadView('student.report.index', [
            'sekolah' => $sekolah,
            'siswa' => $siswa,
            'kelas' => $kelas,
            'semester' => $semester,
            'tahun_ajaran' => $tahunAjaran,
            'nilai' => $nilai,           // sekarang berisi hadir & tidak_hadir
            'rata_rata' => $rataRata,
            'kota' => $kota,
            'tanggal' => $tanggal,
            'wali_kelas' => $waliKelas,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('raport-' . ($siswa->name ?? 'siswa') . '.pdf');
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
