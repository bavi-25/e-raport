<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\GradeLevel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradeLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::transaction(function () {
            $tenants = Tenant::all();

            foreach ($tenants as $tenant) {
                $grades = match ($tenant->level) {
                    'SD' => [
                        ['name' => 'Kelas 1', 'level' => 1],
                        ['name' => 'Kelas 2', 'level' => 2],
                        ['name' => 'Kelas 3', 'level' => 3],
                        ['name' => 'Kelas 4', 'level' => 4],
                        ['name' => 'Kelas 5', 'level' => 5],
                        ['name' => 'Kelas 6', 'level' => 6],
                    ],
                    'SMP' => [
                        ['name' => 'Kelas 7', 'level' => 7],
                        ['name' => 'Kelas 8', 'level' => 8],
                        ['name' => 'Kelas 9', 'level' => 9],
                    ],
                    'SMA', 'SMK' => [
                        ['name' => 'Kelas 10', 'level' => 10],
                        ['name' => 'Kelas 11', 'level' => 11],
                        ['name' => 'Kelas 12', 'level' => 12],
                    ],
                    default => [],
                };

                foreach ($grades as $g) {
                    GradeLevel::updateOrCreate(
                        [
                            'tenant_id' => $tenant->id,
                            'level'     => $g['level'],
                        ],
                        [
                            'name'      => $g['name'],
                        ]
                    );
                }
            }
        });
    }
}
