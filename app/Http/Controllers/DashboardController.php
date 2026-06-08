<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JadwalKegiatan;
use App\Models\BlokKebun;
use App\Models\Pekerja;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Jika yang login adalah Admin (Pemilik Kebun)
        if ($user->role == 'admin') {
            // Menghitung statistik untuk kotak warna-warni
            $totalBlok = BlokKebun::count();
            $totalPekerja = Pekerja::count();
            $menunggu = JadwalKegiatan::where('status', 'Menunggu Verifikasi')->count();
            $belum = JadwalKegiatan::where('status', 'Belum Dikerjakan')->count();
            
            // Mengambil 5 jadwal terbaru untuk tabel di bawah
            $jadwalTerdekat = JadwalKegiatan::with(['blokKebun', 'pekerja'])
                                ->orderBy('tanggal_kegiatan', 'desc')
                                ->take(5)
                                ->get();
            
            return view('admin.dashboard', compact('totalBlok', 'totalPekerja', 'menunggu', 'belum', 'jadwalTerdekat'));
        } 
        // 2. Jika yang login adalah Mandor
        elseif ($user->role == 'mandor') {
            $jadwals = JadwalKegiatan::with(['blokKebun', 'pekerja', 'laporanPekerjaan'])
                        ->where('status', 'Menunggu Verifikasi')
                        ->get();
                        
            return view('mandor.dashboard', compact('jadwals'));
        } 
        // 3. Jika yang login adalah Pekerja
        else {
            $pekerja = Pekerja::where('user_id', $user->id)->first();
            
            if(!$pekerja) abort(403, 'Profil pekerja Anda belum diatur oleh sistem.');
            
            $tugas = JadwalKegiatan::where('pekerja_id', $pekerja->id)
                        ->where('status', 'Belum Dikerjakan')
                        ->get();
                        
            return view('pekerja.dashboard', compact('tugas'));
        }
    }
}