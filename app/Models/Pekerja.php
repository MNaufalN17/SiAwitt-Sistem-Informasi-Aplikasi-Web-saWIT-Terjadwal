<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Pekerja extends Model {
    protected $fillable = ['user_id', 'nama_pekerja', 'no_hp', 'alamat', 'status'];
    
    // Relasi ke tabel users (Akun Login)
    public function user() {
        return $this->belongsTo(User::class);
    }
}
