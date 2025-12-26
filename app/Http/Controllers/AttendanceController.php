<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Enrollment;
use App\Models\ClassSubject;
use Illuminate\Http\Request;
use App\Models\AttendanceEntry;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    //
    public function index()
    {
        $teacherId = auth()->user()->profile->id;
        $classSubjects = ClassSubject::with(['class.gradeLevel', 'subject', 'class.academicYear'])
            ->where('teacher_id', $teacherId)
            ->whereHas('class.academicYear', function ($q) {
                $q->where('status', 'active');
            })
            ->get();
        return view('school.attendance.index', [
            'page' => 'Attendance Records',
            'class_subjects' => $classSubjects,
        ]);
    }

    public function create()
    {
        return view('school.attendance.create');
    }

    public function store(Request $request)
    {
        $teacherId = auth()->user()->profile->id;
        $tenantId = auth()->user()->tenant_id;

        $request->validate([
            'class_subject_id' => 'required|exists:class_subjects,id',
            'notes' => 'nullable|string|max:1000',
            'entries' => 'required|array',
            'entries.*.status' => 'required|in:present,absent,excused,sick',
            'entries.*.remarks' => 'nullable|string|max:255',
        ]);

        $classSubject = ClassSubject::findOrFail($request->class_subject_id);

        if ($classSubject->teacher_id !== $teacherId) {
            return redirect()->back()->with('error', 'Unauthorized access to attendance submission.');
        }

        $today = today();


        return DB::transaction(function () use ($request, $classSubject, $teacherId, $tenantId, $today) {


            $attendance = Attendance::where('class_subject_id', $classSubject->id)
                ->where('date', $today)
                ->first();

            if ($attendance) {
                $attendance->update([
                    'notes' => $request->notes,
                ]);
            } else {
                $attendance = Attendance::create([
                    'date' => $today,
                    'class_subject_id' => $classSubject->id,
                    'teacher_id' => $teacherId,
                    'notes' => $request->notes,
                    'tenant_id' => $tenantId,
                ]);
            }

            AttendanceEntry::where('attendance_id', $attendance->id)->delete();

            foreach ($request->entries as $studentId => $data) {
                AttendanceEntry::create([
                    'attendance_id' => $attendance->id,
                    'student_id' => $studentId,
                    'status' => $data['status'],
                    'remarks' => $data['remarks'] ?? null,
                    'tenant_id' => $tenantId,
                ]);
            }

            return redirect()->route('school.attendance.index')
                ->with('success', 'Absensi dan jurnal mengajar berhasil disimpan!');
        });
    }

    public function show($id)
    {
        $teacherId = auth()->user()->profile->id;

        // Ambil data attendance beserta class_subject dan entries (dengan student)
        $attendance = Attendance::with(['classSubject', 'entries.student'])
            ->findOrFail($id);

        // Cek apakah kelas ini memang diajar oleh guru yang login
        if ($attendance->classSubject->teacher_id !== $teacherId) {
            return redirect()->back()->with('error', 'Unauthorized access to attendance detail.');
        }

        // Hitung summary (opsional, bisa ditampilkan di atas tabel)
        $summary = [
            'present' => $attendance->entries->where('status', 'present')->count(),
            'sick' => $attendance->entries->where('status', 'sick')->count(),
            'excused' => $attendance->entries->where('status', 'excused')->count(),
            'absent' => $attendance->entries->where('status', 'absent')->count(),
            'total' => $attendance->entries->count(),
        ];

        return view('school.attendance.show', [
            'page' => 'Detail Absensi',
            'attendance' => $attendance,
            'summary' => $summary,
        ]);
    }
    public function edit($id)
    {
        return view('school.attendance.edit');
    }
    public function update(Request $request, $id)
    {
    }
    public function destroy($id)
    {
    }

    public function start($id)
    {
        $status = ['Present', 'Excused', 'Sick', 'Absent'];

        $teacherId = auth()->user()->profile->id;
        $classSubject = ClassSubject::findOrFail($id);

        if ($classSubject->teacher_id !== $teacherId) {
            return redirect()->back()->with('error', 'Unauthorized access to attendance history.');
        }

        $today = today();

        $attendance = Attendance::with('entries')
            ->where('class_subject_id', $classSubject->id)
            ->whereDate('date', $today)
            ->first();

        $attendanceEntries = $attendance
            ? $attendance->entries->keyBy('student_id')
            : collect();

        $enrollments = Enrollment::with('student')
            ->where('class_id', $classSubject->class_id)
            ->where('academic_year_id', $classSubject->class->academic_year_id)
            ->get();

        return view('school.attendance.create', [
            'page' => 'Attendance and Teaching Journal',
            'classSubject' => $classSubject,
            'attendance' => $attendance,
            'attendanceEntries' => $attendanceEntries,
            'enrollments' => $enrollments,
            'today' => $today,
            'status' => $status,
        ]);
    }

    public function history($id)
    {
        $teacherId = auth()->user()->profile->id;
        $classSubject = ClassSubject::findOrFail($id);

        if ($classSubject->teacher_id !== $teacherId) {
            return redirect()->back()->with('error', 'Unauthorized access to attendance history.');
        }

        $attendances = Attendance::with('entries')
            ->where('class_subject_id', $classSubject->id)
            ->orderByDesc('date')
            ->get();


        foreach ($attendances as $attendance) {
            $attendance->present_count = $attendance->entries->where('status', 'present')->count();
            $attendance->sick_count = $attendance->entries->where('status', 'sick')->count();
            $attendance->excused_count = $attendance->entries->where('status', 'excused')->count();
            $attendance->absent_count = $attendance->entries->where('status', 'absent')->count();
        }

        return view('school.attendance.history', [
            'page' => 'Riwayat Absensi',
            'classSubject' => $classSubject,
            'attendances' => $attendances,
        ]);
    }
}
