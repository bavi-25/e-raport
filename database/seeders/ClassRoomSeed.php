<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\User;
use App\Models\Tenant;
use App\Models\GradeLevel;
use App\Models\AcademicYear;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassRoomSeed extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $tenants = Tenant::all();

            $this->command->info("Total tenants: " . $tenants->count());

            foreach ($tenants as $tenant) {
                $this->command->info("Processing tenant: {$tenant->id}");

                $homeroomTeacherIds = User::query()
                    ->where('tenant_id', $tenant->id)
                    ->whereHas('roles', function ($query) {
                        $query->where('name', 'Wali Kelas');
                    })
                    ->pluck('id')
                    ->values()
                    ->toArray();

                if (count($homeroomTeacherIds) === 0) {
                    $this->command->warn("Tenant {$tenant->id}: No homeroom teachers found");
                    continue;
                }

                //$this->command->info("Found " . count($homeroomTeacherIds) . " homeroom teachers");

                $activeAcademicYear = AcademicYear::query()
                    ->where('tenant_id', $tenant->id)
                    ->where('status', 'Active')
                    ->first();

                if (!$activeAcademicYear) {
                    $this->command->warn("Tenant {$tenant->id}: No active academic year");
                    continue;
                }

                $classes = $this->getClassesByLevel($tenant->level);
                $created = 0;

                foreach ($classes as $i => $classLabel) {
                    [$name, $section] = $this->splitNameSection($classLabel);
                    $levelNumber = $this->resolveGradeLevelNumber($tenant->level, $name);

                    if (!$levelNumber) {
                        $this->command->warn("Could not resolve level for: {$classLabel}");
                        continue;
                    }

                    $gradeLevelId = GradeLevel::query()
                        ->where('tenant_id', $tenant->id)
                        ->where('level', $levelNumber)
                        ->value('id');

                    if (!$gradeLevelId) {
                        $this->command->warn("Grade level not found for level: {$levelNumber}");
                        continue;
                    }

                    $label = trim($name) . trim($section);
                    $homeroomTeacherId = $homeroomTeacherIds[$i % count($homeroomTeacherIds)];

                    ClassRoom::create([
                        'tenant_id' => $tenant->id,
                        'academic_year_id' => $activeAcademicYear->id,
                        'label' => $label,
                        'name' => trim($name),
                        'section' => trim($section),
                        'grade_level_id' => $gradeLevelId,
                        'homeroom_teacher_id' => $homeroomTeacherId,
                    ]);

                    $created++;
                }

                //$this->command->info("Created {$created} classrooms for tenant {$tenant->id}");
            }
        });
    }

    private function getClassesByLevel(string $level): array
    {
        return match ($level) {
            'SMA', 'SMK' => [
                'X IPA 1',
                'X IPA 2',
                'X IPS 1',
                'X IPS 2',
                'XI IPA 1',
                'XI IPA 2',
                'XI IPS 1',
                'XI IPS 2',
                'XII IPA 1',
                'XII IPA 2',
                'XII IPS 1',
                'XII IPS 2',
            ],
            'SMP' => ['VII A', 'VII B', 'VIII A', 'VIII B', 'IX A', 'IX B'],
            default => ['1 A', '1 B', '2 A', '2 B', '3 A', '3 B', '4 A', '4 B', '5 A', '5 B', '6 A', '6 B'],
        };
    }

    private function splitNameSection(string $label): array
    {
        $parts = preg_split('/\s+/', trim($label));

        if (!$parts || count($parts) === 1) {
            return [trim($label), ''];
        }

        $section = array_pop($parts);
        $name = implode(' ', $parts);

        return [trim($name), trim($section)];
    }

    private function resolveGradeLevelNumber(string $tenantLevel, string $name): ?int
    {
        $name = trim($name);

        if ($tenantLevel === 'SD') {
            $n = (int) $name;
            return ($n >= 1 && $n <= 6) ? $n : null;
        }

        if ($tenantLevel === 'SMP') {
            return match ($name) {
                'VII' => 7,
                'VIII' => 8,
                'IX' => 9,
                default => null,
            };
        }

        if (in_array($tenantLevel, ['SMA', 'SMK'], true)) {
            $roman = strtok($name, ' ') ?: $name;

            return match ($roman) {
                'X' => 10,
                'XI' => 11,
                'XII' => 12,
                default => null,
            };
        }

        return null;
    }
}
