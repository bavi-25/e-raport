<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\AcademicYear;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcademicYearSeeder extends Seeder
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
                $academicYears = [
                    [
                        'code' => '2025/2026-Ganjil',
                        'term' => 'Ganjil',
                        'start_date' => '2025-07-01',
                        'end_date' => '2025-12-31',
                        'status' => 'Inactive',
                    ],
                    [
                        'code' => '2025/2026-Genap',
                        'term' => 'Genap',
                        'start_date' => '2026-01-04',
                        'end_date' => '2026-06-30',
                        'status' => 'Active',
                    ],
                ];

                foreach ($academicYears as $ay) {
                    AcademicYear::updateOrCreate(
                        [
                            'tenant_id' => $tenant->id,
                            'code'      => $ay['code'],
                        ],
                        [
                            'term'       => $ay['term'],
                            'start_date' => $ay['start_date'],
                            'end_date'   => $ay['end_date'],
                            'status'     => $ay['status'],
                        ]
                    );
                }
            }
        });
    }
}
