<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanPekerjaan;
use App\Models\JadwalKegiatan;

class LaporanPekerjaanController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi: foto_bukti dibuat menjadi 'nullable'
        $request->validate([
            'jadwal_kegiatan_id' => 'required',
            'pekerja_id' => 'required',
            'catatan_pekerja' => 'required', // Catatan jadi wajib sebagai ganti foto
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // Boleh kosong (nullable)
        ]);

        // 2. Proses Upload Foto (Hanya jika gambar diunggah)
        $fotoPath = null;
        if ($request->hasFile('foto_bukti')) {
            $fotoPath = $request->file('foto_bukti')->store('bukti_lapangan', 'public');
        }

        // 3. Simpan ke database Laporan
        LaporanPekerjaan::create([
            'jadwal_kegiatan_id' => $request->jadwal_kegiatan_id,
            'pekerja_id' => $request->pekerja_id,
            'catatan_pekerja' => $request->catatan_pekerja,
            'foto_bukti' => $fotoPath, // Akan bernilai null jika tidak ada foto
            'tanggal_lapor' => now(),
        ]);

        // 4. Ubah status jadwal menjadi 'Menunggu Verifikasi'
        $jadwal = JadwalKegiatan::find($request->jadwal_kegiatan_id);
        if ($jadwal) {
            $jadwal->update(['status' => 'Menunggu Verifikasi']);
        }

        // 5. Kembali ke halaman pekerja
        return redirect()->route('dashboard')->with('success', 'Laporan berhasil dikirim ke Mandor!');
    }
}