<?php
namespace App\Http\Controllers;

use App\Models\JadwalKegiatan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        // Hanya mengambil data kegiatan yang statusnya sudah Selesai
        $laporans = JadwalKegiatan::with(['blokKebun', 'pekerja', 'laporanPekerjaan'])
                    ->where('status', 'Selesai')
                    ->orderBy('updated_at', 'desc')
                    ->get();

        return view('admin.laporan.index', compact('laporans'));
    }
}