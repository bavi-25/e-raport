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
            ->map(fn($r) => str_replace('-', '_', strtolower($r)))
            ->unique()
            ->values()
            ->toArray();
        $data = $this->getData($roles);

        return view('dashboard.index', $data);
    }
    private function getData($roles)
    {
        $data = [
            'roles' => $roles,
            'page' => 'Dashboard',
        ];

        if (in_array('super_admin', $roles)) {
            $data['tenantCount'] = Tenant::count();
            $data['userCount']   = User::count();
        } elseif (in_array('teacher', $roles)) {
            $data['studentCount'] = 3;
            $data['subjects']   = 5;
        } elseif (in_array('student', $roles)) {
            // misalnya data khusus siswa
            $data['latestScores'] = []; // atau query nilai siswa
        }

        return $data;
    }
}
