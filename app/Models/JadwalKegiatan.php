<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class JadwalKegiatan extends Model {
    protected $fillable = ['blok_kebun_id', 'pekerja_id', 'jenis_kegiatan', 'tanggal_kegiatan', 'status', 'catatan_admin', 'metode_verifikasi'];

    public function blokKebun() { return $this->belongsTo(BlokKebun::class); }
    public function pekerja() { return $this->belongsTo(Pekerja::class); }
    public function laporanPekerjaan() { return $this->hasOne(LaporanPekerjaan::class); }
}
