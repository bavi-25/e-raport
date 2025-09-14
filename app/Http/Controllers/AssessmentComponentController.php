<?php

namespace App\Http\Controllers;

use App\Models\AssessmentComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AssessmentComponentController extends Controller
{
    public function index()
    {
        $tenantId = $this->tenantId();

        $components = Cache::remember(
            $this->keyMain($tenantId),
            $this->ttl(),
            function () use ($tenantId) {
                return AssessmentComponent::query()
                    ->select('id', 'name', 'weight', 'tenant_id')
                    ->where('tenant_id', $tenantId)
                    ->orderBy('name')
                    ->get();
            }
        );

        return view('school.assessment_component.index', [
            'page' => 'Assessment Components',
            'assessment_components' => $components,
        ]);
    }

    public function create()
    {
        return view('school.assessment_component.create', [
            'page' => 'Create Assessment Component',
        ]);
    }

    public function store(Request $request)
    {
        $tenantId = $this->tenantId();

        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('assessment_components', 'name')
                    ->where(fn($q) => $q->where('tenant_id', $tenantId)),
            ],
            'weight' => ['required', 'numeric', 'between:0,100'],
        ]);

        DB::transaction(function () use ($tenantId, $data) {
            AssessmentComponent::create([
                'name' => $data['name'],
                'weight' => number_format((float) $data['weight'], 2, '.', ''), // simpan 2 desimal
                'tenant_id' => $tenantId,
            ]);
        });

        $this->forgetCaches($tenantId);

        return redirect()
            ->route('school.assessment_components.index')
            ->with('success', 'Assessment component created.');
    }

    public function edit(string $id)
    {
        $tenantId = $this->tenantId();

        $component = Cache::remember(
            $this->keyItem($tenantId, $id),
            $this->ttl(),
            function () use ($tenantId, $id) {
                return AssessmentComponent::where('tenant_id', $tenantId)
                    ->where('id', $id)
                    ->firstOrFail();
            }
        );

        return view('school.assessment_component.edit', [
            'page' => 'Edit Assessment Component',
            'component' => $component,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $tenantId = $this->tenantId();

        $component = AssessmentComponent::where('tenant_id', $tenantId)
            ->where('id', $id)
            ->firstOrFail();

        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('assessment_components', 'name')
                    ->where(fn($q) => $q->where('tenant_id', $tenantId))
                    ->ignore($component->id),
            ],
            'weight' => ['required', 'numeric', 'between:0,100'],
        ]);

        DB::transaction(function () use ($component, $data) {
            $component->update([
                'name' => $data['name'],
                'weight' => number_format((float) $data['weight'], 2, '.', ''),
            ]);
        });

        $this->forgetCaches($tenantId, $id);

        return redirect()
            ->route('school.assessment_components.index')
            ->with('success', 'Assessment component updated.');
    }

    public function destroy(string $id)
    {
        $tenantId = $this->tenantId();

        $component = AssessmentComponent::where('tenant_id', $tenantId)
            ->where('id', $id)
            ->firstOrFail();

        $component->delete();

        $this->forgetCaches($tenantId, $id);

        return redirect()
            ->route('school.assessment_components.index')
            ->with('success', 'Assessment component deleted.');
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
        return "{$tenantId}:assessment_components:main";
    }

    private function keyItem(string $tenantId, string $id): string
    {
        return "{$tenantId}:assessment_components:item:{$id}";
    }

    private function forgetCaches(string $tenantId, ?string $id = null): void
    {
        Cache::forget($this->keyMain($tenantId));
        if ($id) {
            Cache::forget($this->keyItem($tenantId, $id));
        }
    }
}
