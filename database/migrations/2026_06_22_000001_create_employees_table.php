<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Data guru dan pegawai sekolah per unit.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')
                ->constrained('units')
                ->cascadeOnDelete();

            $table->string('nama')->comment('Nama lengkap guru/pegawai');
            $table->string('jabatan')->comment('Jabatan atau posisi');
            $table->unsignedSmallInteger('order_number')->default(0)
                ->comment('Urutan tampil: angka kecil = jabatan lebih tinggi');
            $table->string('photo')->nullable()->comment('Path foto profil');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
