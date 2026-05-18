<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BlokKebunController;
use App\Http\Controllers\PekerjaController;
use App\Http\Controllers\JadwalKegiatanController;
use App\Http\Controllers\LaporanPekerjaanController;
use App\Http\Controllers\LaporanController;

// Langsung arahkan halaman utama (root) ke form login
Route::get('/', function () {
    return view('auth.login');
});

// Memuat rute autentikasi bawaan Laravel UI (Login, Logout, Passwords)
Auth::routes();

// Memaksa redirect dari /home ke /dashboard untuk mencegah error 404
Route::redirect('/home', '/dashboard');

// Grup rute yang hanya bisa diakses jika pengguna sudah login
Route::middleware(['auth'])->group(function () {
 
    // Dashboard (Controller akan memisahkan view berdasarkan role)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Data Master: Blok Kebun
    Route::resource('blok-kebun', BlokKebunController::class);
    
    // CRUD Data Master: Pekerja Lapangan (Termasuk pembuatan akun)
    Route::resource('pekerja', PekerjaController::class);
    
    // CRUD & Verifikasi: Jadwal Kegiatan Panen / Pemupukan
    Route::resource('jadwal-kegiatan', JadwalKegiatanController::class);
    
    // Rekapitulasi: Laporan Kegiatan yang sudah selesai
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    
    // ---------------------------------------------------------
    // Rute Khusus Akses Pekerja Lapangan
    // ---------------------------------------------------------
    
    // Proses upload foto dan pengiriman laporan hasil kerja
    Route::resource('laporan-pekerjaan', LaporanPekerjaanController::class)->only(['store']);
    
});