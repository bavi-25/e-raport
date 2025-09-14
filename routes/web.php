<?php

use App\Http\Controllers\AssessmentComponentController;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GradeLevelController;
use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\ClassRoomController;

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
});