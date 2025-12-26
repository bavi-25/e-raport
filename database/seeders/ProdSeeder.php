<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tenant;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ProdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create("id_ID");

        $tenant = Tenant::create([
            'uuid' => Str::uuid()->toString(),
            'name' => 'TK Indonesia Emas',
            'npsn' => '12345678',
            'level' => 'TK',
            'status' => 'active',
        ]);

        $students = [
            "ADNAN AL - JAZIRAH",
            "AGUSTINI DEWI KARTIKA",
            "AHMAD ZELLY ISDHIANTO",
            "AMBAR ARUM",
            "AMBAR SARI",
            "BUNGA SARTINO PUTRI",
            "DARYANTO PAMUNGKAS ",
            "DENI FAJAR ADINATA",
            "DWI PUTRI UTAMI",
            "EKA DEVI RAMADANI",
            "ESA YAHYA ARIVIN",
            "F. TARA WILIANTI",
            "GIBSON STEPEN",
            "HERU DIKI SETIAWAN ",
            "JORGIUS GUNTUR PUTRA MANDALA",
            "KHARENISA SUIDA MAMPUK ",
            "KAREN NATASYA ",
            "LUSIKA TIA AMOREMIA",
            "M. ARJUNA ALDI PRATAMA",
            "MARIA REONALDA WEA",
            "MUHAMMAD FARIZ SYAHREZA ",
            "NADFARU SA'ADATA DHARONI",
            "NADIATUN HASANAH",
            "NOVITA TRI MURTI",
            "PUTRI AMANDA",
            "RAMADANI",
            "RICARDO SEBASTIAN HADI",
            "SAMSUL RIZAL FAZRI",
            "SIPRIANA FRENSIA SINAGA",
            "SITI NURASIH",
            "TEGAR ANDRIANSYAH SETIABUDI",
            "TRIANA APRILIA ",
            "YOHANES MARSELUS LUNA",
            "ACHMAD SOBIRIN",
            "AHMAD DWI MUSTAKIM",
            "AIRIN MUTIA",
            "ANDI DHARMAWAN WAHYU ADJI",
            "ARDY FEBRIANSYAH ",
            "BONISIUS",
            "DEO HERDIAN",
            "DESI RATNA PRATIWI",
            "DYAH FATMAWATI ",
            "EKA DEWI KUSUMAWATI",
            "EVA SUMARNINGSIH",
            "FITRI",
            "GRACIA PRECILIA DESI",
            "HIKMAL AL BANIANSYAH SIAHAAN",
            "JULIANI INTAN ",
            "KAROMATUL DZIKRIANI",
            "KESYA NATANIA",
            "LUNA CAREY INDI ",
            "MARIA ALVANI LAVIGNE PUNGUS",
            "MARIO APRIAYANTO RASI",
            "MUHAMMAD DHANI",
            "NAFIDA JANNAH",
            "NIA YUNITA SARI",
            "NUR RAFA ARDIANTO",
            "PUTRI RAMADHANI",
            "RANDI ARYA PANGESTU",
            "SELIAN",
            "SRI NAYA",
            "TANDIKA RASKI",
            "THERESIA INDRI SATIA PRATIWI",
            "WINSON ALBERT",
            "YOHANES JUNIMAN DUFO",
            "YOHANES MARVELIANUS WEWO",
            "AFDIL RIZKIANA",
            "AHMAD RISKY ADITYA ",
            "ALLAN IGNATIUS KEVIN ",
            "ANSELMUS JONPETER",
            "AURA NURHAYATI",
            "CORNILIA VIOLIN",
            "DICKY NUR FADILLAH",
            "DIMAS ALI NUGRAHA",
            "EDHO RISKIA PUTRA",
            "EKA NOFITA SARI",
            "EVAN OKTAVIO DWI NUGROHO ",
            "FRANSISKUS PAKE",
            "HAIKAL MUHAMMAT AKBAR",
            "INTAN AULIA PERMATA ",
            "JHONI ARI SEFUDIN",
            "KALISHA PUTRI AZARI ",
            "KHURIN NUZILA AMAMI",
            "KUSNIAWAN",
            "MARIA KRISTINA WONA",
            "MOCHAMAD DEVIN HARTMAN",
            "MUHAMMAD SASTYO PRAYOGA ",
            "NISA ALVIYANA",
            "NISRINA SALWA SALSABILA ",
            "PETRUS RINDUM ",
            "RAEHAN ANDIKA",
            "RATNA MUTMAINAH",
            "RIZKY FAREL AQIL",
            "SELVIA ",
            "SINDI ARTIKA YANTI ",
            "TIFANI INDI NATASYA ",
            "WINDY FEBRIANTI",
            "YEKTI ANNISA FILOSOFIA ",
            "YUDHITA REGINA ",
            "DESTY SAHARANI",
            "ISTI KOMAHRIATI",
            "RIDWAN BAGAS SAPUTRA",
            "AHMAD DANANG DWI CAHYO",
            "AHMAD AHRIS CHOIRIL WAFA",
            "NAZIRA ARLIANI",
        ];

        foreach ($students as $student) {
            $emailLocal = Str::slug($student, '_');

            $user = User::create([
                'name' => $student,
                'email' => $emailLocal . '@eraport.com',
                'password' => bcrypt('password'),
                'tenant_id' => $tenant->id,
            ]);

            $user->assignRole('Siswa');

            $user->profile()->create([
                'name' => $student,
                'nip_nis' => 'NIS-' . str_pad($faker->unique()->numberBetween(1, 99999), 5, '0', STR_PAD_LEFT),
                'birth_date' => $faker->date('Y-m-d', '2019-12-31'),
                'religion' => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
                'gender' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'phone' => $faker->phoneNumber(),
                'address' => $faker->address(),
                'user_id' => $user->id,
            ]);
        }

        $teachers = [
            "Ayu Melati Sari",
            "Budi Prasetyo",
            "Citra Wulandari",
            "Dedi Kurniawan",
            "Erna Puspitasari",
            "Fajar Pratama",
            "Gita Lestari",
            "Hendra Wijaya",
            "Indah Permata Sari",
            "Joko Santoso",
            "Kurnia Dewi Astuti",
            "Lukman Hakim",
            "Melisa Putri Andini",
            "Nurul Aini",
            "Oki Ramadhan",
            "Putri Maharani",
            "Rahmat Hidayat",
            "Siti Maesaroh",
            "Taufik Firmansyah",
            "Yuni Kartika",
        ];

        foreach ($teachers as $index => $teacher) {
            $emailLocal = Str::slug($teacher, '_');

            $user = User::create([
                'name' => $teacher,
                'email' => $emailLocal . '@eraport.com',
                'password' => bcrypt('password'),
                'tenant_id' => $tenant->id,
            ]);

            $user->assignRole('Guru');

            if ($index === 0) {
                $user->assignRole('Kepala Sekolah');
            }

            $user->profile()->create([
                'name' => $teacher,
                'nip_nis' => 'NIP-' . str_pad($faker->unique()->numberBetween(1, 99999), 5, '0', STR_PAD_LEFT),
                'birth_date' => $faker->date('Y-m-d', '1995-12-31'),
                'religion' => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
                'gender' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'phone' => $faker->phoneNumber(),
                'address' => $faker->address(),
                'user_id' => $user->id,
            ]);
        }
    }
}
