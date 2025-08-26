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
            $superAdmin = User::updateOrCreate(
                ['email' => 'superadmin@erapor.local'],
                [
                    'name'              => 'Super Admin',
                    'password'          => Hash::make('passwordSuperAdmin!'), // ganti di production
                    'tenant_id'         => 1, // atau pilih salah satu tenant_id jika diinginkan
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

            $schoolRoles = ['Admin', 'Kepala Sekolah', 'Wali Kelas', 'Guru', 'Siswa'];

            foreach ($tenants as $tenant) {
                $slug = Str::slug($tenant->name, '-');
                foreach ($schoolRoles as $roleName) {
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
                            'gender'     => in_array($roleName, ['Siswa', 'Guru', 'Wali Kelas']) ? 'Perempuan' : 'Laki-laki',
                            'phone'      => '081200000000',
                            'address'    => "Sekolah {$tenant->name}",
                        ]
                    );
                }
            }
        });
    }
}
