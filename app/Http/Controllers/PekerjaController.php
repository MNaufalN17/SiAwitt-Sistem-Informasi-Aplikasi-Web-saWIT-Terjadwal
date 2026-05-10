<?php

namespace App\Http\Controllers;

use App\Models\Pekerja;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PekerjaController extends Controller
{
    public function index()
    {
        // Menampilkan daftar pekerja dengan mengambil data relasi akun user-nya
        $pekerjas = Pekerja::with('user')->get();
        return view('admin.pekerja.index', compact('pekerjas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pekerja' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'no_hp' => 'required',
            'alamat' => 'required',
        ]);

        // Menggunakan DB Transaction agar jika satu gagal, semuanya dibatalkan
        DB::beginTransaction();
        try {
            // 1. Buat akun login untuk pekerja di tabel users
            $user = User::create([
                'name' => $request->nama_pekerja,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'pekerja', // Otomatis diset sebagai pekerja
            ]);

            // 2. Simpan profil detail pekerja di tabel pekerjas
            Pekerja::create([
                'user_id' => $user->id,
                'nama_pekerja' => $request->nama_pekerja,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'status' => 'Aktif',
            ]);

            DB::commit();
            return redirect()->route('pekerja.index')->with('success', 'Akun dan Data Pekerja berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Pekerja $pekerja)
    {
        // Karena kita set onDelete('cascade') di migrasi, 
        // menghapus User otomatis akan menghapus profil Pekerja juga
        $user = User::find($pekerja->user_id);
        if($user) {
            $user->delete(); 
        }
        
        return redirect()->route('pekerja.index')->with('success', 'Data Pekerja berhasil dihapus!');
    }
}