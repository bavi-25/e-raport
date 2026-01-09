<?php

namespace Database\Seeders;



use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\TenantSeeder;

use Database\Seeders\ClassRoomSeed;
use Database\Seeders\SubjectSeeder;
use Database\Seeders\GradeLevelSeeder;
use Database\Seeders\AcademicYearSeeder;
use Database\Seeders\AssessmentComponentSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            TenantSeeder::class,
            UserSeeder::class,
            AcademicYearSeeder::class,
            GradeLevelSeeder::class,
            SubjectSeeder::class,
            ClassRoomSeed::class,
            AssessmentComponentSeeder::class,
        ]);
    }
}
