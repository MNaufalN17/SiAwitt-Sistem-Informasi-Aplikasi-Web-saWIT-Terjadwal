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
        Schema::create('blok_kebuns', function (Blueprint $table) {
        $table->id();
        
        // PASTIKAN KOLOM-KOLOM INI ADA:
        $table->string('nama_blok');
        $table->decimal('luas_lahan', 8, 2); // 8 digit total, 2 di belakang koma
        $table->string('lokasi');
        $table->text('keterangan')->nullable();
        
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blok_kebuns');
    }
};
