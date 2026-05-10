<?php

namespace App\Http\Controllers;

use App\Models\BlokKebun;
use Illuminate\Http\Request;

class BlokKebunController extends Controller
{
    public function index()
    {
        $blokKebuns = BlokKebun::all();
        return view('admin.blok-kebun.index', compact('blokKebuns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_blok' => 'required',
            'luas_lahan' => 'required|numeric',
            'lokasi' => 'required',
        ]);

        BlokKebun::create($request->all());

        return redirect()->route('blok-kebun.index')->with('success', 'Data Blok Kebun berhasil ditambahkan!');
    }

    public function destroy(BlokKebun $blokKebun)
    {
        $blokKebun->delete();
        return redirect()->route('blok-kebun.index')->with('success', 'Data Blok berhasil dihapus!');
    }
}