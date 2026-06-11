<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Data ekstrakurikuler per unit sekolah.
     */
    public function up(): void
    {
        Schema::create('extracurriculars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')
                ->constrained('units')
                ->cascadeOnDelete();

            $table->string('logo_ekskul')->nullable();
            $table->string('nama_ekskul');
            $table->string('pembina_ekskul')->nullable();
            $table->text('jadwal_kegiatan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extracurriculars');
    }
};
