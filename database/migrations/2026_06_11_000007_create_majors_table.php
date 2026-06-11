<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Jurusan / program keahlian khusus untuk unit berjenjang SMK.
     * Dibuat sebelum galleries agar major_id FK bisa dibuat.
     */
    public function up(): void
    {
        Schema::create('majors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')
                ->constrained('units')
                ->cascadeOnDelete();

            $table->string('nama_jurusan');
            $table->string('nomenklatur_istilah')
                ->comment('Contoh: Program Keahlian, Konsentrasi Keahlian, Program Studi');
            $table->string('shortname')
                ->comment('Contoh: TKJ, RPL, AKL');
            $table->string('nama_kaprog')->nullable()
                ->comment('Nama Kepala Program Keahlian');
            $table->string('foto_kaprog')->nullable();
            $table->longText('deskripsi_jurusan')->nullable()
                ->comment('Kompetensi, materi esensial, dan prospek kerja');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('majors');
    }
};
