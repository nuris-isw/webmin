<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Pengaturan SPMB (Seleksi Penerimaan Murid Baru) per unit sekolah.
     * Relasi one-to-one dengan unit (unique unit_id).
     */
    public function up(): void
    {
        Schema::create('spmb_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')
                ->unique()
                ->constrained('units')
                ->cascadeOnDelete();

            $table->boolean('status_spmb')->default(false)
                ->comment('true = SPMB sedang dibuka');
            $table->longText('informasi_prosedur')->nullable();
            $table->string('url_eksternal_pendaftaran')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spmb_settings');
    }
};
