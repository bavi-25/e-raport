<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{

    public function index()
    {
        $tenantId = $this->tenantId();

        $students = Cache::remember(
            $this->keyMain($tenantId),
            $this->ttl(),
            function () use ($tenantId) {
                return User::role('Siswa')
                    ->with('profile:id,user_id,name,nip_nis')
                    ->select('id', 'name', 'email', 'tenant_id')
                    ->where('tenant_id', $tenantId)
                    ->orderBy('name')
                    ->get();
            }
        );

        return view('school.student.index', [
            'page' => 'Students',
            'students' => $students,
        ]);
    }

    public function create()
    {
        return view('school.student.create', [
            'page' => 'Create Student',
        ]);
    }

    public function store(Request $request)
    {
        $tenantId = $this->tenantId();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'profile_name' => ['nullable', 'string', 'max:255'],
            'nip_nis' => ['nullable', 'string', 'max:50'],
            'birth_date' => ['nullable', 'date'],
            'religion' => ['nullable', 'string', 'max:50'],
            'gender' => ['nullable', 'string', 'max:10'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        DB::transaction(function () use ($tenantId, $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'tenant_id' => $tenantId,
            ]);

            $user->assignRole('Siswa');

            Profile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'name' => $data['profile_name'] ?? $data['name'],
                    'nip_nis' => $data['nip_nis'] ?? null,
                    'birth_date' => $data['birth_date'] ?? null,
                    'religion' => $data['religion'] ?? null,
                    'gender' => $data['gender'] ?? null,
                    'phone' => $data['phone'] ?? null,
                    'address' => $data['address'] ?? null,
                ]
            );
        });

        $this->forgetCaches($tenantId);

        return redirect()->route('school.students.index')->with('success', 'Student created.');
    }

    public function edit(string $id)
    {
        $tenantId = $this->tenantId();

        $student = Cache::remember($this->keyItem($tenantId, $id), $this->ttl(), function () use ($tenantId, $id) {
            return User::role('Siswa')
                ->with('profile')
                ->where('tenant_id', $tenantId)
                ->where('id', $id)
                ->firstOrFail();
        });

        return view('school.student.edit', [
            'page' => 'Edit Student',
            'student' => $student,
        ]);
    }


    public function update(Request $request, string $id)
    {
        $tenantId = $this->tenantId();

        $student = User::role('Siswa')
            ->where('tenant_id', $tenantId)
            ->where('id', $id)
            ->firstOrFail();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($student->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'profile_name' => ['nullable', 'string', 'max:255'],
            'nip_nis' => ['nullable', 'string', 'max:50'],
            'birth_date' => ['nullable', 'date'],
            'religion' => ['nullable', 'string', 'max:50'],
            'gender' => ['nullable', 'string', 'max:10'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        DB::transaction(function () use ($student, $data) {
            $student->update([
                'name' => $data['name'],
                'email' => $data['email'],
                ...(isset($data['password']) && $data['password'] ? ['password' => $data['password']] : []),
            ]);

            Profile::updateOrCreate(
                ['user_id' => $student->id],
                [
                    'name' => $data['profile_name'] ?? $data['name'],
                    'nip_nis' => $data['nip_nis'] ?? null,
                    'birth_date' => $data['birth_date'] ?? null,
                    'religion' => $data['religion'] ?? null,
                    'gender' => $data['gender'] ?? null,
                    'phone' => $data['phone'] ?? null,
                    'address' => $data['address'] ?? null,
                ]
            );
        });

        $this->forgetCaches($tenantId, $id);

        return redirect()->route('school.students.index')->with('success', 'Student updated.');
    }

    public function destroy(string $id)
    {
        $tenantId = $this->tenantId();

        $student = User::role('Siswa')
            ->where('tenant_id', $tenantId)
            ->where('id', $id)
            ->firstOrFail();

        DB::transaction(function () use ($student) {
            optional($student->profile)->delete();
            $student->delete();
        });

        $this->forgetCaches($tenantId, $id);

        return redirect()->route('school.students.index')->with('success', 'Student deleted.');
    }


    public function show(string $id)
    {
        $tenantId = $this->tenantId();

        $student = Cache::remember($this->keyItem($tenantId, $id), $this->ttl(), function () use ($tenantId, $id) {
            return User::role('Siswa')
                ->with('profile')
                ->where('tenant_id', $tenantId)
                ->where('id', $id)
                ->firstOrFail();
        });

        return view('school.student.show', [
            'page' => 'Student Detail',
            'student' => $student,
        ]);
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
        return "{$tenantId}:students:main";
    }

    private function keyItem(string $tenantId, string $id): string
    {
        return "{$tenantId}:students:item:{$id}";
    }
    private function forgetCaches(string $tenantId, ?string $id = null): void
    {
        Cache::forget($this->keyMain($tenantId));
        if ($id)
            Cache::forget($this->keyItem($tenantId, $id));
    }
}
