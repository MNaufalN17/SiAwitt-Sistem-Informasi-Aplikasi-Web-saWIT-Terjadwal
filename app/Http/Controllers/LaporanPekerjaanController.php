<?php

namespace App\Http\Controllers;

use App\Models\LaporanPekerjaan;
use App\Models\JadwalKegiatan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanPekerjaanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'foto_bukti' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Simpan foto ke storage public
        $path = $request->file('foto_bukti')->store('bukti_pekerjaan', 'public');

        // Buat data laporan
        LaporanPekerjaan::create([
            'jadwal_kegiatan_id' => $request->jadwal_kegiatan_id,
            'pekerja_id' => $request->pekerja_id,
            'catatan_pekerja' => $request->catatan_pekerja,
            'foto_bukti' => $path,
            'tanggal_lapor' => Carbon::now()
        ]);

        // Ubah status jadwal menjadi Menunggu Verifikasi
        JadwalKegiatan::where('id', $request->jadwal_kegiatan_id)->update([
            'status' => 'Menunggu Verifikasi'
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil dikirim, menunggu verifikasi Admin.');
    }
}