# E-RAPORT

![Laravel](https://img.shields.io/badge/Laravel-11-red?logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2-blue)
![License](https://img.shields.io/badge/license-MIT-green)
![Status](https://img.shields.io/badge/status-Dalam%20Pengembangan-yellow)

**E-RAPORT** adalah aplikasi manajemen rapor digital berbasis web yang dibangun menggunakan **Laravel 12**. Aplikasi ini dirancang untuk membantu sekolah (multi-tenant) dalam mengelola data akademik siswa, mulai dari penilaian, absensi, hingga pembuatan rapor akhir secara otomatis.

Aplikasi ini mendukung sistem multi-tenant, sehingga satu instalasi bisa digunakan oleh banyak sekolah (tenant) secara terpisah dan aman.

## Fitur Utama

- **Multi-Tenant** – Setiap sekolah memiliki data terisolasi (tenant_id)
- **Manajemen Kelas & Tahun Ajaran**
- **Manajemen Mata Pelajaran & Guru Pengajar**
- **Penilaian Berbasis Komponen** (bobot penilaian customizable)
- **Input Nilai Harian, Ulangan, Tugas, dll.**
- **Absensi Per Pertemuan Mata Pelajaran**
- **Perhitungan Nilai Akhir Otomatis**
- **Pembuatan & Penyimpanan Rapor Digital (PDF)**
- **Role & Permission** menggunakan Spatie Laravel Permission
- **Profil Siswa, Guru, dan Wali Kelas**

## Tech Stack

- **Backend**: Laravel 12 (PHP 8.2+)
- **Database**: MySQL
- **Authentication**: Laravel Sanctum / Built-in Auth + Spatie Roles
- **Frontend**: Blade Template (bisa dikembangkan ke Inertia/Vue/Livewire nantinya)

## Model & Relasi Utama

Berikut adalah gambaran relasi utama dalam aplikasi:

- **Tenant** → Sekolah (multi-tenant)
- **AcademicYear** → Tahun Ajaran
- **GradeLevel** → Tingkat Kelas (misal: X, XI, XII)
- **ClassRoom** → Kelas (misal: X IPA 1)
- **Profile** → Data siswa/guru (terhubung ke User)
- **Subject** → Mata Pelajaran
- **ClassSubject** → Penugasan mata pelajaran ke kelas + guru pengajar
- **Enrollment** → Pendaftaran siswa ke kelas pada tahun ajaran tertentu
- **AssessmentComponent** → Komponen penilaian (Tugas 30%, UH 40%, UAS 30%, dll.)
- **Assessment** → Kegiatan penilaian (misal: Ulangan Harian Matematika)
- **AssessmentItem** → Butir soal/item penilaian
- **GradeEntry** → Nilai siswa per item
- **FinalGrade** → Nilai akhir siswa per mata pelajaran
- **Attendance** & **AttendanceEntry** → Absensi per pertemuan
- **ReportCard** → File rapor akhir siswa

## Prasyarat (Prerequisites)

- PHP ≥ 8.2
- Composer
- MySQL atau PostgreSQL
- Web server (Apache/Nginx)
