<?php

namespace App\Http\Controllers\Student;


use App\Models\Enrollment;
use App\Models\ClassSubject;
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
    public function generateRaport($siswaId)
    {
        $data = [
            'sekolah' => [
                'nama' => 'SMA NEGERI 1 BALIKPAPAN',
                'alamat' => 'Jl. Jenderal Sudirman No. 123, Balikpapan Kota',
                'telepon' => '0542-123456',
                'email' => 'info@sman1-bpp.sch.id'
            ],
            'siswa' => (object) [
                'nama' => 'Ahmad Rizki Pratama',
                'nis' => '202401',
                'nisn' => '0123456789'
            ],
            'kelas' => (object) ['nama' => 'X IPA 1'],
            'semester' => 'Ganjil',
            'tahun_ajaran' => '2024/2025',
            'nilai' => [
                ['mata_pelajaran' => 'Pendidikan Agama dan Budi Pekerti', 'kkm' => 75, 'pengetahuan' => 85, 'keterampilan' => 88, 'nilai_akhir' => 86, 'predikat' => 'B'],
                ['mata_pelajaran' => 'Pendidikan Pancasila dan Kewarganegaraan', 'kkm' => 75, 'pengetahuan' => 82, 'keterampilan' => 85, 'nilai_akhir' => 83, 'predikat' => 'B'],
                ['mata_pelajaran' => 'Bahasa Indonesia', 'kkm' => 75, 'pengetahuan' => 88, 'keterampilan' => 90, 'nilai_akhir' => 89, 'predikat' => 'A'],
                ['mata_pelajaran' => 'Matematika', 'kkm' => 75, 'pengetahuan' => 78, 'keterampilan' => 80, 'nilai_akhir' => 79, 'predikat' => 'B'],
                ['mata_pelajaran' => 'Sejarah Indonesia', 'kkm' => 75, 'pengetahuan' => 84, 'keterampilan' => 86, 'nilai_akhir' => 85, 'predikat' => 'B'],
                ['mata_pelajaran' => 'Bahasa Inggris', 'kkm' => 75, 'pengetahuan' => 87, 'keterampilan' => 89, 'nilai_akhir' => 88, 'predikat' => 'A'],
                ['mata_pelajaran' => 'Seni Budaya', 'kkm' => 75, 'pengetahuan' => 90, 'keterampilan' => 92, 'nilai_akhir' => 91, 'predikat' => 'A'],
                ['mata_pelajaran' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'kkm' => 75, 'pengetahuan' => 85, 'keterampilan' => 88, 'nilai_akhir' => 86, 'predikat' => 'B'],
                ['mata_pelajaran' => 'Fisika', 'kkm' => 75, 'pengetahuan' => 80, 'keterampilan' => 82, 'nilai_akhir' => 81, 'predikat' => 'B'],
                ['mata_pelajaran' => 'Kimia', 'kkm' => 75, 'pengetahuan' => 83, 'keterampilan' => 85, 'nilai_akhir' => 84, 'predikat' => 'B'],
                ['mata_pelajaran' => 'Biologi', 'kkm' => 75, 'pengetahuan' => 86, 'keterampilan' => 88, 'nilai_akhir' => 87, 'predikat' => 'B'],
            ],
            'rata_rata' => 85,
            'predikat_rata' => 'B',
            'kehadiran' => (object) ['sakit' => 2, 'izin' => 1, 'alpha' => 0],
            'catatan' => 'Ahmad menunjukkan perkembangan yang sangat baik dalam proses pembelajaran. Siswa aktif dalam kegiatan kelas dan memiliki motivasi belajar yang tinggi. Pertahankan prestasi dan tingkatkan kemampuan dalam mata pelajaran Matematika.',
            'wali_kelas' => (object) ['nama' => 'Dra. Siti Aminah, M.Pd', 'nip' => '196705051990032001'],
            'kota' => 'Balikpapan',
            'tanggal' => now()->translatedFormat('d F Y'),
        ];

        $pdf = Pdf::loadView('student.report.index', $data)
            ->setPaper('a4', 'portrait');
        // return $pdf->download('raport-'.$siswaId.'.pdf');
        return $pdf->stream('raport-' . $siswaId . '.pdf'); // preview di browser
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
