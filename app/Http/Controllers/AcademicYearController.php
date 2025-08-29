<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AcademicYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = Auth::user();
        $tenantKey = $user->tenant_id;
        $cacheKey = "$tenantKey:academic_year:main";
        $ttl = now()->addHours(2);
        
        $source = Cache::has($cacheKey) ? 'cache' : 'db';
        
        if ($source === 'cache') {
            $academic_years = Cache::get($cacheKey);
        } else {
            $academic_years = AcademicYear::query()
            ->select('id', 'code', 'term', 'start_date', 'end_date', 'status')
            ->where('tenant_id', $tenantKey)
            ->orderBy('code')
            ->get();
            Cache::put($cacheKey, $academic_years, $ttl);
        }
        $data = [
            'page' => 'Academic Year',
            'academic_years' => $academic_years,
        ];
        return view('school.academic_year.index', $data);
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
