<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request; // <- perbaikan: gunakan Request ini
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    public function index()
    {
        $tenantId = $this->tenantId();
        $subjects = Cache::remember(
            $this->keyMain($tenantId),
            $this->ttl(),
            function () use ($tenantId) {
                return Subject::query()
                    ->select('id', 'code', 'name', 'group_name', 'phase', 'tenant_id')
                    ->where('tenant_id', $tenantId)
                    ->orderBy('code')
                    ->get();
            }
        );

        return view('school.subject.index', [
            'page' => 'Subjects',
            'subjects' => $subjects,
        ]);
    }
    public function create()
    {
        return view('school.subject.create', [
            'page' => 'Create Subject',
        ]);
    }
    public function store(Request $request)
    {
        $tenantId = $this->tenantId();

        $data = $request->validate([
            'code' => ['required', 'string', 'max:255', 'unique:subjects,code'],
            'name' => ['required', 'string', 'max:255'],
            'group_name' => ['required', 'string', 'max:255'],
            'phase' => ['required', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($tenantId, $data) {
            Subject::create([
                'code' => $data['code'],
                'name' => $data['name'],
                'group_name' => $data['group_name'],
                'phase' => $data['phase'],
                'tenant_id' => $tenantId,
            ]);
        });

        $this->forgetCaches($tenantId);

        return redirect()
            ->route('school.subjects.index')
            ->with('success', 'Subject created.');
    }
    public function edit(string $id)
    {
        $tenantId = $this->tenantId();

        $subject = Cache::remember(
            $this->keyItem($tenantId, $id),
            $this->ttl(),
            function () use ($tenantId, $id) {
                return Subject::where('tenant_id', $tenantId)
                    ->where('id', $id)
                    ->firstOrFail();
            }
        );

        return view('school.subject.edit', [
            'page' => 'Edit Subject',
            'subject' => $subject,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $tenantId = $this->tenantId();

        $subject = Subject::where('tenant_id', $tenantId)
            ->where('id', $id)
            ->firstOrFail();

        $data = $request->validate([
            'code' => ['required', 'string', 'max:255', 'unique:subjects,code,' . $subject->id],
            'name' => ['required', 'string', 'max:255'],
            'group_name' => ['required', 'string', 'max:255'],
            'phase' => ['required', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($subject, $data) {
            $subject->update([
                'code' => $data['code'],
                'name' => $data['name'],
                'group_name' => $data['group_name'],
                'phase' => $data['phase'],
            ]);
        });

        $this->forgetCaches($tenantId, $id);

        return redirect()
            ->route('school.subjects.index')
            ->with('success', 'Subject updated.');
    }

    public function destroy(string $id)
    {
        $tenantId = $this->tenantId();

        $subject = Subject::where('tenant_id', $tenantId)
            ->where('id', $id)
            ->firstOrFail();

        $subject->delete();

        $this->forgetCaches($tenantId, $id);

        return redirect()
            ->route('school.subjects.index')
            ->with('success', 'Subject deleted.');
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
        return "{$tenantId}:subjects:main";
    }

    private function keyItem(string $tenantId, string $id): string
    {
        return "{$tenantId}:subjects:item:{$id}";
    }

    private function forgetCaches(string $tenantId, ?string $id = null): void
    {
        Cache::forget($this->keyMain($tenantId));
        if ($id) {
            Cache::forget($this->keyItem($tenantId, $id));
        }
    }

}
