<?php

namespace App\Http\Controllers;

use App\Models\GradeLevel;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClassRoomRequest;
use App\Models\ClassRoom;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ClassRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $classRooms = Cache::remember('class_rooms:all', now()->addMinutes(10), function () {
            return ClassRoom::with(['gradeLevel', 'homeroomTeacher', 'academicYear'])
                ->where('tenant_id', Auth::user()->tenant_id)
                ->orderBy('name')
                ->get();
        });

        $data = [
            'page' => 'Class Rooms',
            'classs_rooms' => $classRooms,
        ];
        return view('school.class_room.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $tenantKey = $user->tenant_id;
        $ttl = now()->addHours(2);

        $grade_levels = Cache::remember(
            "$tenantKey:grade_level:main",
            $ttl,
            function () use ($tenantKey) {
                return GradeLevel::query()
                    ->select('id', 'name', 'tenant_id')
                    ->where('tenant_id', $tenantKey)
                    ->orderBy('name')
                    ->get();
            }
        );

        $teachers = Cache::remember(
            "$tenantKey:teachers:homeroom",
            $ttl,
            function () use ($tenantKey) {
                return User::role('Wali Kelas')
                    ->with(['profile:id,user_id,name'])
                    ->where('tenant_id', $tenantKey)
                    ->select('id', 'name', 'email', 'tenant_id')
                    ->orderBy('name')
                    ->get();
            }
        );

        $data = [
            'page'         => 'Create Class Room',
            'grade_levels' => $grade_levels,
            'teachers'     => $teachers,
        ];

        return view('school.class_room.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClassRoomRequest $request)
    {
        //
        $user = Auth::user();
        $tenantKey = $user->tenant_id;
        $academic_year = AcademicYear::select('id', 'status')
            ->where('tenant_id', $tenantKey)
            ->where('status ', true)
            ->first();

        if (!$academic_year) {
            return redirect()->back()->with('error', 'Tahun Pelajaran aktif tidak ditemukan. Silahkan atur Tahun Pelajaran terlebih dahulu.');
        }
        ClassRoom::create([
            'name' => $request->name,
            'section' => $request->section,
            'label' => $request->label,
            'grade_level_id' => $request->grade_level_id,
            'homeroom_teacher_id' => $request->teacher_id,
            'academic_year_id' => $academic_year->id,
            'tenant_id' => $tenantKey,
        ]);
        return redirect()->route('school.class_rooms.index')->with('success', 'Kelas berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
