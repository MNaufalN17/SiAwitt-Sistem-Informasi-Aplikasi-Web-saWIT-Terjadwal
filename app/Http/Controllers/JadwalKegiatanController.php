<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalKegiatan;
use App\Models\BlokKebun;
use App\Models\Pekerja;

class JadwalKegiatanController extends Controller
{
    /**
     * Menampilkan daftar jadwal untuk sisi Admin.
     */
    public function index()
    {
        // Mengambil semua jadwal diurutkan dari tanggal terbaru beserta relasinya
        $jadwals = JadwalKegiatan::with(['blokKebun', 'pekerja'])->orderBy('tanggal_kegiatan', 'desc')->get();
        
        // Mengambil data pendukung untuk modal input jadwal baru milik admin
        $bloks = BlokKebun::all();
        $pekerjas = Pekerja::where('status', 'Aktif')->get();

        return view('admin.jadwal.index', compact('jadwals', 'bloks', 'pekerjas'));
    }

    /**
     * Menyimpan jadwal baru yang dirilis oleh Admin.
     */
    public function store(Request $request)
    {
        $request->validate([
            'blok_kebun_id' => 'required',
            'pekerja_id' => 'required',
            'jenis_kegiatan' => 'required',
            'tanggal_kegiatan' => 'required|date',
        ]);

        JadwalKegiatan::create([
            'blok_kebun_id' => $request->blok_kebun_id,
            'pekerja_id' => $request->pekerja_id,
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
            'status' => 'Belum Dikerjakan', // Status awal ketika jadwal baru dibuat
        ]);

        return redirect()->route('jadwal-kegiatan.index')->with('success', 'Jadwal kegiatan baru berhasil dirilis!');
    }

    /**
     * Memproses Verifikasi dari Mandor ATAU Update dari Admin.
     */
    public function update(Request $request, $id)
    {
        $jadwal = JadwalKegiatan::findOrFail($id);

        // LOGIKAL UTAMA MANDOR: Jika request mengandung data 'status' dari form Mandor
        if ($request->has('status')) {
            $jadwal->update([
                'status' => $request->status, // Mengubah status menjadi 'Selesai'
                'metode_verifikasi' => $request->metode_verifikasi ?? 'Diverifikasi Mandor',
            ]);

            // Mengembalikan Mandor ke halaman dashboard-nya dengan pesan sukses
            return redirect()->route('dashboard')->with('success', 'Laporan pekerjaan berhasil diverifikasi dan dinyatakan SAH!');
        }

        // Logika update data standar jika dilakukan oleh Admin
        $jadwal->update($request->all());
        return redirect()->route('jadwal-kegiatan.index')->with('success', 'Data jadwal berhasil diperbarui!');
    }

    /**
     * Menghapus jadwal kegiatan (Akses Admin).
     */
    public function destroy($id)
    {
        $jadwal = JadwalKegiatan::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('jadwal-kegiatan.index')->with('success', 'Jadwal kegiatan berhasil dihapus dari sistem!');
    }

    // Method resource bawaan Laravel di bawah ini sengaja dibuat kosong / aman agar route::resource tidak error
    public function create() { return abort(404); }
    public function show($id) { return abort(404); }
    public function edit($id) { return abort(404); }
}