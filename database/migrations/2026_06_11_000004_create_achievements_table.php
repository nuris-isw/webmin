<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Data prestasi siswa, guru, tendik, atau sekolah per unit.
     */
    public function up(): void
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')
                ->constrained('units')
                ->cascadeOnDelete();

            $table->string('judul_prestasi');
            $table->string('tahun_prestasi');
            $table->enum('peraih_prestasi', ['siswa', 'guru', 'tendik', 'sekolah']);
            $table->text('deskripsi_prestasi')->nullable();
            $table->string('foto_penghargaan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
