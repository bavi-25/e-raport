<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Tenant::create([
            'uuid'   => Str::uuid(),
            'name'   => 'SD Negeri 00 Dev',
            'npsn'   => '1000000001',
            'level'  => 'SD',
            'status' => 'Active',
        ]);

        Tenant::create([
            'uuid'   => Str::uuid(),
            'name'   => 'SMP Negeri 00 Dev',
            'npsn'   => '1000000002',
            'level'  => 'SMP',
            'status' => 'Active',
        ]);

        Tenant::create([
            'uuid'   => Str::uuid(),
            'name'   => 'SMA Negeri 00 Dev',
            'npsn'   => '1000000003',
            'level'  => 'SMA',
            'status' => 'Active',
        ]);
    }
}
