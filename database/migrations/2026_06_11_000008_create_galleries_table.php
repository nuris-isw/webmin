<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Galeri kegiatan dengan opsi tampilan (Display Placement Routing).
     * major_id nullable — wajib diisi hanya jika unit SMK + opsi_tampilan = galeri_program.
     */
    public function up(): void
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')
                ->constrained('units')
                ->cascadeOnDelete();

            $table->string('nama_kegiatan');
            $table->enum('opsi_tampilan', [
                'hero_section',
                'gambar_pembuka',
                'galeri_dokumentasi',
                'galeri_program',
            ])->comment('Routing display placement untuk frontend');

            // Nullable — hanya wajib untuk unit SMK dengan opsi galeri_program
            $table->foreignId('major_id')
                ->nullable()
                ->constrained('majors')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
