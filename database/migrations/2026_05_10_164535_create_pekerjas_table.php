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
        Schema::create('pekerjas', function (Blueprint $table) {
        $table->id();
        
        // PASTIKAN BARIS INI BENAR-BENAR ADA:
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        
        $table->string('nama_pekerja');
        $table->string('no_hp');
        $table->text('alamat');
        $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pekerjas');
    }
};
