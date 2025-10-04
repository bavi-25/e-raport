<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ClassRoomController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\GradeLevelController;
use App\Http\Controllers\GradeEntryController;
use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\ClassSubjectController;
use App\Http\Controllers\AssessmentComponentController;

Route::get('/redis-test', function () {
    try {
        // Ping
        $pong = Redis::connection()->ping(); // harusnya "PONG"

        // Set/Get langsung via Redis
        Redis::set('test:key', 'hello');
        $val = Redis::get('test:key');

        // Test via Cache store redis
        Cache::store('redis')->put('cache:key', 'world', 60);
        $cacheVal = Cache::store('redis')->get('cache:key');

        return response()->json([
            'ping' => $pong,
            'redis_get' => $val,
            'cache_get' => $cacheVal,
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'error' => $e->getMessage(),
        ], 500);
    }
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate')->middleware('guest');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');


//SUPER ADMIN
Route::middleware(['auth', 'role:Super-Admin'])->group(function () {
    Route::resource('/super-admin/tenants', TenantController::class)->names('super_admin.tenants');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('/school/academic-years', AcademicYearController::class)->names('school.academic_year');
    Route::resource('/school/grade_levels', GradeLevelController::class)->names('school.grade_levels');
    Route::resource('/school/class_rooms', ClassRoomController::class)->names('school.class_rooms');
    Route::resource('/school/subjects', SubjectController::class)->names('school.subjects');
    Route::resource('/school/assessment_compnents', AssessmentComponentController::class)->names('school.assessment_components');
    Route::resource('/school/students', StudentController::class)->names('school.students');
    Route::resource('/school/class_subjects', ClassSubjectController::class)->names('school.class_subjects');
    Route::resource('/school/enrollments', EnrollmentController::class)->names('school.enrollments');
    Route::resource('/school/assessments', AssessmentController::class)->names('school.assessments');
});

Route::middleware(['auth', 'role:Guru|Wali Kelas'])->group(function () {
    Route::get('/school/grade-entries', [GradeEntryController::class, 'index'])->name('school.grade_entries.index');
    Route::post('/school/grade-entries', [GradeEntryController::class, 'store'])->name('school.grade_entries.store');
});


Route::middleware(['auth', 'role:Siswa'])->group(function () {
    Route::get('/student/enrollments', [\App\Http\Controllers\Student\EnrollmentController::class, 'index'])->name('student.enrollment.index');
    Route::get('/student/enrollments/{id}', [\App\Http\Controllers\Student\EnrollmentController::class, 'show'])->name('student.enrollment.show');
    Route::get('/student/enrollments/{enrollmentId}/subjects/{subjectId}', [\App\Http\Controllers\Student\EnrollmentController::class, 'subject_detail'])->name('student.enrollment.subject_detail');
});