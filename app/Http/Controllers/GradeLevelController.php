<?php

namespace App\Http\Controllers;

use App\Http\Requests\GradeLevelRequest;
use App\Models\GradeLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class GradeLevelController extends Controller
{
    public function index()
    {
        $tenantId = $this->tenantId();
        $cacheKey = $this->keyMain($tenantId);
        $gradeLevels = Cache::remember($cacheKey, $this->ttl(), function () use ($tenantId) {
            return GradeLevel::query()
                ->select('id', 'name', 'level', 'tenant_id')
                ->where('tenant_id', $tenantId)
                ->orderBy('name')
                ->get();
        });

        return view('school.grade_level.index', [
            'page' => 'Grade Levels',
            'grade_levels' => $gradeLevels,
        ]);
    }

    public function create()
    {
        return view('school.grade_level.create', ['page' => 'Grade Levels']);
    }

    public function store(GradeLevelRequest $request)
    {
        $tenantId = $this->tenantId();

        GradeLevel::create([
            'name' => $request->name,
            'level' => $request->level,
            'tenant_id' => $tenantId,
        ]);

        $this->forgetAllGradeLevelCache($tenantId);

        return redirect()
            ->route('school.grade_levels.index')
            ->with('success', 'Grade level created successfully!');
    }

    public function edit(string $id)
    {
        $tenantId = $this->tenantId();
        $cacheKey = $this->keyItem($tenantId, $id);

        $gradeLevel = Cache::remember($cacheKey, $this->ttl(), function () use ($tenantId, $id) {
            return GradeLevel::where('tenant_id', $tenantId)
                ->where('id', $id)
                ->firstOrFail();
        });

        return view('school.grade_level.edit', [
            'page' => 'Grade Levels',
            'gradeLevel' => $gradeLevel,
        ]);
    }

    public function update(GradeLevelRequest $request, string $id)
    {
        $tenantId = $this->tenantId();

        $gradeLevel = GradeLevel::where('tenant_id', $tenantId)
            ->where('id', $id)
            ->firstOrFail();

        $gradeLevel->update([
            'name' => $request->name,
            'level' => $request->level,
        ]);

        Cache::forget($this->keyItem($tenantId, $id));
        $this->forgetAllGradeLevelCache($tenantId);

        return redirect()
            ->route('school.grade_levels.index')
            ->with('success', 'Grade level updated successfully!');
    }

    public function destroy(string $id)
    {
        $tenantId = $this->tenantId();

        $gradeLevel = GradeLevel::where('tenant_id', $tenantId)
            ->where('id', $id)
            ->firstOrFail();

        $gradeLevel->delete();

        Cache::forget($this->keyItem($tenantId, $id));
        $this->forgetAllGradeLevelCache($tenantId);

        return redirect()
            ->route('school.grade_levels.index')
            ->with('success', 'Grade level deleted successfully!');
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
        return "{$tenantId}:grade_level:main";
    }

    private function keyItem(string $tenantId, string $id): string
    {
        return "{$tenantId}:grade_level:item:{$id}";
    }

    private function forgetAllGradeLevelCache(string $tenantId): void
    {
        Cache::forget($this->keyMain($tenantId));
    }
}