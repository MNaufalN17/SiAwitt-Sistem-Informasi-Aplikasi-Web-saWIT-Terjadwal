<?php

namespace App\Http\Controllers;

use App\Models\JadwalKegiatan;
use App\Models\BlokKebun;
use App\Models\Pekerja;
use Illuminate\Http\Request;

class JadwalKegiatanController extends Controller
{
    // Menampilkan halaman jadwal & verifikasi
    public function index()
    {
        $jadwals = JadwalKegiatan::with(['blokKebun', 'pekerja'])->orderBy('tanggal_kegiatan', 'desc')->get();
        $bloks = BlokKebun::all();
        $pekerjas = Pekerja::where('status', 'Aktif')->get();
        
        return view('admin.jadwal.index', compact('jadwals', 'bloks', 'pekerjas'));
    }

    // Admin membuat jadwal baru
    public function store(Request $request)
    {
        JadwalKegiatan::create([
            'blok_kebun_id' => $request->blok_kebun_id,
            'pekerja_id' => $request->pekerja_id,
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
            'status' => 'Belum Dikerjakan'
        ]);

        return redirect()->back()->with('success', 'Jadwal berhasil dibuat!');
    }

    // Admin melakukan verifikasi pekerjaan (Selesai)
    public function update(Request $request, $id)
    {
        $jadwal = JadwalKegiatan::findOrFail($id);
        
        // Jika diverifikasi dari upload sistem
        if($request->metode == 'Upload Sistem'){
            $jadwal->update([
                'status' => 'Selesai',
                'metode_verifikasi' => 'Upload Sistem'
            ]);
        } 
        // Jika pekerja melapor langsung (manual)
        else {
            $jadwal->update([
                'status' => 'Selesai',
                'metode_verifikasi' => 'Laporan Langsung',
                'catatan_admin' => $request->catatan_admin
            ]);
        }

        return redirect()->back()->with('success', 'Pekerjaan berhasil diverifikasi!');
    }
}