<?php

namespace Database\Seeders;

use App\Models\GradeEntry;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Contracts\Role;

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

        ]);
    }
}
