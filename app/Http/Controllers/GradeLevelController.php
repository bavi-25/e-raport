<?php

namespace App\Http\Controllers;

use App\Models\GradeLevel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class GradeLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = Auth::user();
        $tenantKey = $user->tenant_id;
        $cacheKey = "$tenantKey:grade_level:main";
        $ttl = now()->addHours(2);

        $source = Cache::has($cacheKey) ? 'cache' : 'db';

        if ($source === 'cache') {
            $grade_levels = Cache::get($cacheKey);
        } else {
            $grade_levels = GradeLevel::query()
                ->select('id', 'name', 'level', 'tenant_id')
                ->where('tenant_id', $tenantKey)
                ->orderBy('name')
                ->get();
            Cache::put($cacheKey, $grade_levels, $ttl);
        }
        $data = [
            'page' => 'Grade Levels',
            'grade_levels' => $grade_levels,
        ];
        return view('school.grade_level.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
