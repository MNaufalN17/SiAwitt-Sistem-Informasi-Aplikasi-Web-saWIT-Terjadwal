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
        
        // DUA KOLOM INI WAJIB ADA SEBAGAI PENGHUBUNG:
        $table->foreignId('jadwal_kegiatan_id')->constrained('jadwal_kegiatans')->onDelete('cascade');
        $table->foreignId('pekerja_id')->constrained('pekerjas')->onDelete('cascade');
        
        // Kolom isi laporan
        $table->text('catatan_pekerja')->nullable();
        $table->string('foto_bukti');
        $table->date('tanggal_lapor');
        
        $table->timestamps();
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
