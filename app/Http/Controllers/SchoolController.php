<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class SchoolController extends Controller
{
    public function index()
    {
        $tenantId = $this->tenantId();

        $tenant = Cache::remember(
            "tenant_info:{$tenantId}",
            $this->ttl(),
            fn() => Tenant::query()
                ->select([
                    'id',
                    'name',
                    'npsn'
                ])
                ->find($tenantId)
        );

        $principal = Cache::remember(
            "tenant:{$tenantId}:principal",
            $this->ttl(),
            fn() => User::query()
                ->role('Kepala Sekolah')
                ->with(['profile:id,user_id,name,nip_nis,birth_date,phone,address'])
                ->where('tenant_id', $tenantId)
                ->first()
        );

        return view('school.tenant.index', [
            'page' => 'School Information',
            'tenant' => $tenant,
            'principal' => $principal,
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
}
