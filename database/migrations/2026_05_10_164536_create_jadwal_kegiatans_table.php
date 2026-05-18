<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jadwal_kegiatans', function (Blueprint $table) {
        $table->id();
        
        // Relasi ke tabel blok_kebuns dan pekerjas
        $table->foreignId('blok_kebun_id')->constrained('blok_kebuns')->onDelete('cascade');
        $table->foreignId('pekerja_id')->constrained('pekerjas')->onDelete('cascade');
        
        // Kolom data kegiatan
        $table->string('jenis_kegiatan'); // Panen atau Pemupukan
        $table->date('tanggal_kegiatan'); // INI KOLOM YANG HILANG TADI
        $table->string('status')->default('Belum Dikerjakan'); // Belum Dikerjakan, Menunggu Verifikasi, Selesai
        
        // Kolom untuk verifikasi admin
        $table->string('metode_verifikasi')->nullable();
        $table->text('catatan_admin')->nullable();
        
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_kegiatans');
    }
};
