<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

       User::create([
            'name' => 'Pemilik Kebun',
            'email' => 'admin@siawitt.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);
        
        // Membuat satu contoh akun Pekerja
        User::create([
            'name' => 'Pekerja Dummy',
            'email' => 'pekerja@siawitt.com',
            'password' => Hash::make('12345678'),
            'role' => 'pekerja',
        ]);
    }
}
