<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubjectSeeder extends Seeder
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
                $subjects = match ($tenant->level) {
                    'SD' => [
                        ['code' => 'MTK-SD', 'name' => 'Matematika', 'group' => 'Wajib', 'phase' => 'A'],
                        ['code' => 'BINDO-SD', 'name' => 'Bahasa Indonesia', 'group' => 'Wajib', 'phase' => 'A'],
                        ['code' => 'IPA-SD', 'name' => 'Ilmu Pengetahuan Alam', 'group' => 'Wajib', 'phase' => 'A'],
                        ['code' => 'IPS-SD', 'name' => 'Ilmu Pengetahuan Sosial', 'group' => 'Wajib', 'phase' => 'A'],
                        ['code' => 'AGM-SD', 'name' => 'Pendidikan Agama', 'group' => 'Wajib', 'phase' => 'A'],
                    ],
                    'SMP' => [
                        ['code' => 'MTK-SMP', 'name' => 'Matematika', 'group' => 'Wajib', 'phase' => 'B'],
                        ['code' => 'BINDO-SMP', 'name' => 'Bahasa Indonesia', 'group' => 'Wajib', 'phase' => 'B'],
                        ['code' => 'BING-SMP', 'name' => 'Bahasa Inggris', 'group' => 'Wajib', 'phase' => 'B'],
                        ['code' => 'IPA-SMP', 'name' => 'Ilmu Pengetahuan Alam', 'group' => 'Wajib', 'phase' => 'B'],
                        ['code' => 'IPS-SMP', 'name' => 'Ilmu Pengetahuan Sosial', 'group' => 'Wajib', 'phase' => 'B'],
                    ],
                    'SMA' => [
                        ['code' => 'MTK-SMA', 'name' => 'Matematika', 'group' => 'Wajib', 'phase' => 'C'],
                        ['code' => 'BINDO-SMA', 'name' => 'Bahasa Indonesia', 'group' => 'Wajib', 'phase' => 'C'],
                        ['code' => 'BING-SMA', 'name' => 'Bahasa Inggris', 'group' => 'Wajib', 'phase' => 'C'],
                        ['code' => 'FIS-SMA', 'name' => 'Fisika', 'group' => 'Peminatan', 'phase' => 'C'],
                        ['code' => 'KIM-SMA', 'name' => 'Kimia', 'group' => 'Peminatan', 'phase' => 'C'],
                        ['code' => 'BIO-SMA', 'name' => 'Biologi', 'group' => 'Peminatan', 'phase' => 'C'],
                    ],
                    'SMK' => [
                        ['code' => 'MTK-SMK', 'name' => 'Matematika', 'group' => 'Wajib', 'phase' => 'D'],
                        ['code' => 'BINDO-SMK', 'name' => 'Bahasa Indonesia', 'group' => 'Wajib', 'phase' => 'D'],
                        ['code' => 'BING-SMK', 'name' => 'Bahasa Inggris', 'group' => 'Wajib', 'phase' => 'D'],
                        ['code' => 'PROD-SMK', 'name' => 'Produktif Kejuruan', 'group' => 'Kejuruan', 'phase' => 'D'],
                        ['code' => 'PKK-SMK', 'name' => 'Proyek Kreatif dan Kewirausahaan', 'group' => 'Kejuruan', 'phase' => 'D'],
                    ],
                    default => [],
                };

                foreach ($subjects as $s) {
                    Subject::updateOrCreate(
                        [
                            'tenant_id' => $tenant->id,
                            'code'      => $s['code'],
                        ],
                        [
                            'name'       => $s['name'],
                            'group_name' => $s['group'],
                            'phase'      => $s['phase'],
                        ]
                    );
                }
            }
        });
    }
}
