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
                // contoh hardcode tahun ajaran sekarang
                $academicYears = [
                    [
                        'code'       => '2024/2025-Ganjil',
                        'term'       => 'Ganjil',
                        'start_date' => '2024-07-15',
                        'end_date'   => '2024-12-20',
                        'status'     => 'Active',
                    ],
                    [
                        'code'       => '2024/2025-Genap',
                        'term'       => 'Genap',
                        'start_date' => '2025-01-06',
                        'end_date'   => '2025-06-20',
                        'status'     => 'Inactive',
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
