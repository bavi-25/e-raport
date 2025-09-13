<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tenant;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\AcademicYearRequest;

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
        $data = [
            'page' => 'Create Academic Year',
        ];
        return view('school.academic_year.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AcademicYearRequest $request)
    {
        $user = Auth::user();
        $tenantKey = $user->tenant_id;
        $data = $request->validated();

        $startYear = Carbon::parse($data['start_date'])->year;
        $endYear = $startYear + 1;
        $code = $startYear . '/' . $endYear . '-' . $data['term'];

        DB::transaction(callback: function () use ($tenantKey, $data, $code) {
            if ($data['status'] === 'Active') {
                AcademicYear::where('tenant_id', $tenantKey)
                    ->where('status', 'Active')
                    ->update(['status' => 'Inactive']);
            }

            AcademicYear::updateOrCreate(
                ['tenant_id' => $tenantKey, 'code' => $code],
                [
                    'term' => $data['term'],
                    'start_date' => $data['start_date'],
                    'end_date' => $data['end_date'],
                    'status' => $data['status'],
                ]
            );
        });

        return redirect()->route('school.academic_year.index')->with('success', 'Academic year saved.');
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
