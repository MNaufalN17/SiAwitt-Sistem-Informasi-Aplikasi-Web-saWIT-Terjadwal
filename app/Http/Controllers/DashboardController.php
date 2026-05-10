<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\JadwalKegiatan;
use App\Models\Pekerja;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'admin') {
            return view('admin.dashboard'); 
        } else {
            // Cari profil pekerja berdasarkan user_id yang login
            $profilPekerja = Pekerja::where('user_id', $user->id)->first();
            
            // Ambil tugas yang belum selesai untuk pekerja ini
            $tugas = [];
            if($profilPekerja) {
                $tugas = JadwalKegiatan::with('blokKebun')
                            ->where('pekerja_id', $profilPekerja->id)
                            ->where('status', '!=', 'Selesai')
                            ->get();
            }

            return view('pekerja.dashboard', compact('tugas', 'profilPekerja'));
        }
    }
}
