<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TenantController extends Controller
{
    //
    public function index()
    {
        $cacheKey = 'super_admin:tenants:main';
        $ttl = now()->addHours(2);

        $source = Cache::has($cacheKey) ? 'cache' : 'db';

        if ($source === 'cache') {
            $tenants = Cache::get($cacheKey);
        } else {
            $tenants = Tenant::query()
                ->select('id', 'name', 'npsn', 'level', 'status')
                ->orderBy('name')
                ->get();
            Cache::put($cacheKey, $tenants, $ttl);
        }
        $data = [
            'tenants' => $tenants,
            'page' => 'Tenants',
        ];
        return view('super_admin.tenant.index', $data);
    }
}
