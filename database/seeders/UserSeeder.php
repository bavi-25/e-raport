<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tenant;
use App\Models\Profile;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::transaction(function () {
            // Super Admin
            $superAdmin = User::updateOrCreate(
                ['email' => 'superadmin@erapor.local'],
                [
                    'name'              => 'Super Admin',
                    'password'          => Hash::make('passwordSuperAdmin!'),
                    'tenant_id'         => 1,
                    'email_verified_at' => now(),
                ]
            );
            $superAdmin->assignRole('Super-Admin');

            Profile::updateOrCreate(
                ['user_id' => $superAdmin->id],
                [
                    'name'       => 'Super Admin',
                    'nip_nis'    => 'SA-000000',
                    'birth_date' => '1990-01-01',
                    'religion'   => 'Islam',
                    'gender'     => 'Laki-laki',
                    'phone'      => '080000000000',
                    'address'    => 'Pusat Sistem',
                ]
            );

            $tenants = Tenant::all();

            foreach ($tenants as $tenant) {
                $slugTenant = Str::slug($tenant->name, '-');

                // --- Single roles (1 per tenant) ---
                $singleRoles = ['Admin', 'Kepala Sekolah'];

                foreach ($singleRoles as $roleName) {
                    $email = Str::slug($roleName, '-') . "+t{$tenant->id}@erapor.local";

                    $user = User::updateOrCreate(
                        ['email' => $email],
                        [
                            'name'              => "{$roleName} {$tenant->name}",
                            'password'          => Hash::make('1234'),
                            'tenant_id'         => $tenant->id,
                            'email_verified_at' => now(),
                        ]
                    );

                    $user->syncRoles([$roleName]);

                    Profile::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'name'       => "{$roleName} {$tenant->name}",
                            'nip_nis'    => strtoupper(substr($roleName, 0, 2)) . '-' . str_pad((string)$tenant->id, 6, '0', STR_PAD_LEFT),
                            'birth_date' => '1995-01-01',
                            'religion'   => 'Islam',
                            'gender'     => 'Laki-laki',
                            'phone'      => '081200000000',
                            'address'    => "Sekolah {$tenant->name}",
                        ]
                    );
                }

                // --- 3 Wali Kelas per tenant ---
                for ($i = 1; $i <= 3; $i++) {
                    $email = "walikelas{$i}+t{$tenant->id}@erapor.local";

                    $user = User::updateOrCreate(
                        ['email' => $email],
                        [
                            'name'              => "Wali Kelas {$i} {$tenant->name}",
                            'password'          => Hash::make('1234'),
                            'tenant_id'         => $tenant->id,
                            'email_verified_at' => now(),
                        ]
                    );

                    // Wali Kelas dapat dua role: Wali Kelas + Guru
                    $user->syncRoles(['Wali Kelas', 'Guru']);

                    Profile::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'name'       => "Wali Kelas {$i} {$tenant->name}",
                            'nip_nis'    => "WK-" . str_pad((string)$tenant->id, 4, '0', STR_PAD_LEFT) . str_pad((string)$i, 3, '0', STR_PAD_LEFT),
                            'birth_date' => '1993-06-01',
                            'religion'   => 'Islam',
                            'gender'     => ($i % 2 === 0) ? 'Perempuan' : 'Laki-laki',
                            'phone'      => '08121000000' . $i,
                            'address'    => "Sekolah {$tenant->name}",
                        ]
                    );
                }

                // --- 3 Guru per tenant ---
                for ($i = 1; $i <= 3; $i++) {
                    $email = "guru{$i}+t{$tenant->id}@erapor.local";

                    $user = User::updateOrCreate(
                        ['email' => $email],
                        [
                            'name'              => "Guru {$i} {$tenant->name}",
                            'password'          => Hash::make('1234'),
                            'tenant_id'         => $tenant->id,
                            'email_verified_at' => now(),
                        ]
                    );

                    // Guru hanya role Guru
                    $user->syncRoles(['Guru']);

                    Profile::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'name'       => "Guru {$i} {$tenant->name}",
                            'nip_nis'    => "GU-" . str_pad((string)$tenant->id, 4, '0', STR_PAD_LEFT) . str_pad((string)$i, 3, '0', STR_PAD_LEFT),
                            'birth_date' => '1990-07-01',
                            'religion'   => 'Islam',
                            'gender'     => ($i % 2 === 0) ? 'Perempuan' : 'Laki-laki',
                            'phone'      => '08130000000' . $i,
                            'address'    => "Sekolah {$tenant->name}",
                        ]
                    );
                }
            }
        });
    }
}
