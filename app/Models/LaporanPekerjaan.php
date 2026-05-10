<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LaporanPekerjaan extends Model {
    protected $fillable = ['jadwal_kegiatan_id', 'pekerja_id', 'catatan_pekerja', 'foto_bukti', 'tanggal_lapor'];
}