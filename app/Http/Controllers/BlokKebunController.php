<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlokKebun;

class BlokKebunController extends Controller
{
    /**
     * Menampilkan daftar data blok kebun.
     */
    public function index()
    {
        // Variabel $bloks di sini harus sama persis namanya dengan yang di-compact
        $bloks = BlokKebun::orderBy('nama_blok', 'asc')->get();
        
        // compact('bloks') inilah yang mengirimkan variabel ke tampilan
        return view('admin.blok-kebun.index', compact('bloks'));
    }

    /**
     * Menyimpan data blok kebun baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_blok' => 'required|string|max:255',
            'luas_lahan' => 'required|numeric',
            'lokasi' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        BlokKebun::create($request->all());

        return redirect()->route('blok-kebun.index')->with('success', 'Data Blok Kebun baru berhasil ditambahkan!');
    }

    /**
     * Memperbarui/Mengedit data blok kebun yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_blok' => 'required|string|max:255',
            'luas_lahan' => 'required|numeric',
            'lokasi' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $blok = BlokKebun::findOrFail($id);
        $blok->update($request->all());

        return redirect()->route('blok-kebun.index')->with('success', 'Data Blok Kebun berhasil diperbarui!');
    }

    /**
     * Menghapus data blok kebun dari database.
     */
    public function destroy($id)
    {
        $blok = BlokKebun::findOrFail($id);
        $blok->delete();

        return redirect()->route('blok-kebun.index')->with('success', 'Data Blok Kebun berhasil dihapus!');
    }

    // Method kosong agar resource bawaan Laravel tidak error
    public function create() { abort(404); }
    public function show($id) { abort(404); }
    public function edit($id) { abort(404); }
}