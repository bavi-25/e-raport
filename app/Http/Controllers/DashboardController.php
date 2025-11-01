<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $roles = collect($user->roles ?? [])
            ->map(fn($r) => is_string($r) ? $r : ($r->name ?? $r->slug ?? ''))
            ->filter()
            ->map(fn($r) => str_replace(['-', ' '], '_', strtolower($r)))
            ->unique()
            ->values()
            ->toArray();
        $data = $this->getData($roles);

        return view('dashboard.index', $data);
    }

    private function getData(array $roles): array
    {
        // Gunakan namespace per-role agar aman untuk multi-role
        $data = [
            'roles' => $roles,
            'page' => 'Dashboard',
            'stats' => [],   // ringkasan angka global (boleh kosong)
            'widgets' => [],   // data per-role: widgets['guru'], widgets['siswa'], dst.
        ];

        if (in_array('super_admin', $roles)) {
            $data['stats']['tenantCount'] = Tenant::count();
            $data['stats']['userCount'] = User::count();
            $data['widgets']['super_admin'] = [
                // isi jika perlu
            ];
        }

        if (in_array('admin', $roles)) {
            $data['widgets']['admin'] = [
                'pendingApprovals' => 0,
            ];
        }

        if (in_array('kepala_sekolah', $roles)) {
            $data['widgets']['kepala_sekolah'] = [
                'latestScores' => [],
            ];
        }

        if (in_array('wali_kelas', $roles)) {
            $data['widgets']['wali_kelas'] = [
                'myClass' => null,
            ];
        }

        if (in_array('guru', $roles)) {
            $data['widgets']['guru'] = [
                'studentCount' => 3,
                'subjects' => 5,
            ];
        }

        if (in_array('siswa', $roles)) {
            $data['widgets']['siswa'] = [
                'latestScores' => [],
            ];
        }

        return $data;
    }
}
