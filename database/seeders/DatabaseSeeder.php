<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pekerja;
use App\Models\BlokKebun;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. BUAT AKUN ADMIN (PEMILIK KEBUN)
        User::create([
            'name' => 'Pemilik Kebun (Admin)',
            'email' => 'admin@siawitt.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);

        // 2. BUAT AKUN MANDOR (SUPERVISOR LAPANGAN)
        User::create([
            'name' => 'Bapak Mandor',
            'email' => 'mandor@siawitt.com',
            'password' => Hash::make('12345678'),
            'role' => 'mandor',
        ]);

        // 3. BUAT AKUN USER UNTUK PEKERJA LAPANGAN
        $userPekerja = User::create([
            'name' => 'Slamet (Pekerja)',
            'email' => 'pekerja@siawitt.com',
            'password' => Hash::make('12345678'),
            'role' => 'pekerja',
        ]);

        // 4. BUAT PROFIL PEKERJA (Terikat dengan user_id di atas)
        // Langkah ini wajib agar saat pekerja login, DashboardController tidak error mencari data profilnya
        Pekerja::create([
            'user_id' => $userPekerja->id,
            'nama_pekerja' => 'Slamet Utomo',
            'no_hp' => '081234567890',
            'alamat' => 'Perumahan Inti Kebun Sawit Blok C',
            'status' => 'Aktif',
        ]);

        // 5. BUAT DATA MASTER BLOK KEBUN AWAL
        // Ini ditambahkan agar Admin tidak perlu repot menginput dari nol saat pertama kali demo program
        BlokKebun::create([
            'nama_blok' => 'Blok A1',
            'luas_lahan' => 5.5,
            'lokasi' => 'Sektor Utara',
            'keterangan' => 'Tanaman menghasilkan tahun ke-4',
        ]);

        BlokKebun::create([
            'nama_blok' => 'Blok B2',
            'luas_lahan' => 4.2,
            'lokasi' => 'Sektor Selatan',
            'keterangan' => 'Area lereng, perlu pemupukan intensif',
        ]);
    }
}