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
        Schema::create('laporan_pekerjaans', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel jadwal dan pekerja
            $table->unsignedBigInteger('jadwal_kegiatan_id');
            $table->unsignedBigInteger('pekerja_id');
            
            // Data laporan utama
            $table->text('catatan_pekerja');
            
            // 👇 INI KUNCINYA: Tambahan ->nullable() agar MySQL menerima nilai kosong
            $table->string('foto_bukti')->nullable(); 
            
            $table->date('tanggal_lapor');
            $table->timestamps();

            // Definisi Foreign Key (Opsional tapi disarankan agar rapi)
            $table->foreign('jadwal_kegiatan_id')->references('id')->on('jadwal_kegiatans')->onDelete('cascade');
            // Catatan: Jika relasi pekerja_id error saat migrate, baris foreign pekerja ini bisa dihapus/disesuaikan
            // $table->foreign('pekerja_id')->references('id')->on('pekerjas')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_pekerjaans');
    }
};