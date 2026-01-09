<?php

namespace Database\Seeders;


use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\AssessmentComponent;

class AssessmentComponentSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            $tenants = Tenant::all();

            foreach ($tenants as $tenant) {

                $components = $this->componentsByLevel($tenant->level);

                $total = array_sum(array_column($components, 'weight'));
                if ($total !== 100) {
                    continue;
                }

                foreach ($components as $c) {
                    AssessmentComponent::updateOrCreate(
                        [
                            'tenant_id' => $tenant->id,
                            'name' => $c['name'],
                        ],
                        [
                            'tenant_id' => $tenant->id,
                            'name' => $c['name'],
                            'weight' => $c['weight'],
                        ]
                    );
                }
            }
        });
    }

    private function componentsByLevel(string $level): array
    {
        return match ($level) {
            'SD' => [
                ['name' => 'Tugas Harian (PR/LKPD/Latihan)', 'weight' => 40],

                ['name' => 'Asesmen Harian (Kuis/UH)', 'weight' => 30],

                ['name' => 'Sumatif Akhir Semester (UAS/PAS)', 'weight' => 20],

                ['name' => 'Sikap/Keaktifan', 'weight' => 10],
            ],

            'SMP', 'SMA', 'SMK' => [
                ['name' => 'Tugas/Proyek/Praktik', 'weight' => 30],
                ['name' => 'UH/Kuis (Formatif)', 'weight' => 30],
                ['name' => 'PTS/UTS (Sumatif Tengah Semester)', 'weight' => 20],
                ['name' => 'PAS/UAS (Sumatif Akhir Semester)', 'weight' => 20],
            ],

            default => [
                ['name' => 'Tugas', 'weight' => 40],
                ['name' => 'UH/Kuis', 'weight' => 30],
                ['name' => 'UAS', 'weight' => 20],
                ['name' => 'Sikap', 'weight' => 10],
            ],
        };
    }
}
