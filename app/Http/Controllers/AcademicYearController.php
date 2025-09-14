<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\AcademicYear;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\AcademicYearRequest;

class AcademicYearController extends Controller
{
    public function index()
    {
        $tenantId = $this->tenantId();

        $academicYears = Cache::remember($this->keyMain($tenantId), $this->ttl(), function () use ($tenantId) {
            return AcademicYear::query()
                ->select('id', 'code', 'term', 'start_date', 'end_date', 'status')
                ->where('tenant_id', $tenantId)
                ->orderBy('code')
                ->get();
        });

        return view('school.academic_year.index', [
            'page' => 'Academic Year',
            'academic_years' => $academicYears,
        ]);
    }

    public function create()
    {
        return view('school.academic_year.create', [
            'page' => 'Create Academic Year',
        ]);
    }

    public function store(AcademicYearRequest $request)
    {
        $tenantId = $this->tenantId();
        $data = $request->validated();

        $code = $this->buildCode($data['start_date'], $data['term']);

        DB::transaction(function () use ($tenantId, $data, $code) {
            // Pastikan hanya satu 'Active' per tenant
            if ($data['status'] === 'Active') {
                AcademicYear::where('tenant_id', $tenantId)
                    ->where('status', 'Active')
                    ->update(['status' => 'Inactive']);
            }

            AcademicYear::updateOrCreate(
                ['tenant_id' => $tenantId, 'code' => $code],
                [
                    'term' => $data['term'],
                    'start_date' => $data['start_date'],
                    'end_date' => $data['end_date'],
                    'status' => $data['status'],
                ]
            );
        });

        $this->forgetCaches($tenantId);

        return redirect()
            ->route('school.academic_year.index')
            ->with('success', 'Academic year saved.');
    }

    public function edit(string $id)
    {
        $tenantId = $this->tenantId();

        $academicYear = Cache::remember($this->keyItem($tenantId, $id), $this->ttl(), function () use ($tenantId, $id) {
            return AcademicYear::where('tenant_id', $tenantId)
                ->where('id', $id)
                ->firstOrFail();
        });

        return view('school.academic_year.edit', [
            'page' => 'Edit Academic Year',
            'academicYear' => $academicYear,
        ]);
    }

    public function update(AcademicYearRequest $request, string $id)
    {
        $tenantId = $this->tenantId();
        $data = $request->validated();

        $academicYear = AcademicYear::where('tenant_id', $tenantId)
            ->where('id', $id)
            ->firstOrFail();

        $newCode = $this->buildCode($data['start_date'], $data['term']);

        DB::transaction(function () use ($tenantId, $data, $academicYear, $newCode, $id) {
            if ($data['status'] === 'Active') {
                AcademicYear::where('tenant_id', $tenantId)
                    ->where('status', 'Active')
                    ->where('id', '!=', $id)
                    ->update(['status' => 'Inactive']);
            }

            $academicYear->update([
                'code' => $newCode,
                'term' => $data['term'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'status' => $data['status'],
            ]);
        });
        $this->forgetCaches($tenantId, $id);

        return redirect()
            ->route('school.academic_year.index')
            ->with('success', 'Academic year updated.');
    }

    public function destroy(string $id)
    {
        $tenantId = $this->tenantId();

        $academicYear = AcademicYear::where('tenant_id', $tenantId)
            ->where('id', $id)
            ->firstOrFail();

        $academicYear->delete();

        $this->forgetCaches($tenantId, $id);

        return redirect()
            ->route('school.academic_year.index')
            ->with('success', 'Academic year deleted.');
    }
    private function tenantId(): string
    {
        return (string) Auth::user()->tenant_id;
    }

    private function ttl()
    {
        return now()->addHours(2);
    }

    private function keyMain(string $tenantId): string
    {
        return "{$tenantId}:academic_year:main";
    }

    private function keyItem(string $tenantId, string $id): string
    {
        return "{$tenantId}:academic_year:item:{$id}";
    }

    private function forgetCaches(string $tenantId, ?string $id = null): void
    {
        Cache::forget($this->keyMain($tenantId));
        if ($id) {
            Cache::forget($this->keyItem($tenantId, $id));
        }
    }

    private function buildCode(string $startDate, string $term): string
    {
        $startYear = Carbon::parse($startDate)->year;
        $endYear = $startYear + 1;
        return "{$startYear}/{$endYear}-{$term}";
    }
}
