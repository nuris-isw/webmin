<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Profil lengkap sekolah per unit — Tab A (Kontak & Lokasi),
     * Tab B (Profil & Sejarah), Tab C (Akademik).
     */
    public function up(): void
    {
        Schema::create('school_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')
                ->unique()
                ->constrained('units')
                ->cascadeOnDelete();

            // Tab A: Kontak & Lokasi
            $table->string('logo_sekolah')->nullable();
            $table->string('email')->nullable();
            $table->string('telepon')->nullable();
            $table->text('alamat')->nullable();
            $table->text('google_map_embed_url')->nullable();
            $table->json('media_sosial')->nullable()
                ->comment('Keys: instagram, facebook, youtube, tiktok');

            // Tab B: Profil & Sejarah
            $table->string('nama_kepala_sekolah')->nullable();
            $table->string('foto_kepala_sekolah')->nullable();
            $table->longText('sambutan_kepala_sekolah')->nullable();
            $table->longText('sejarah_singkat_sekolah')->nullable();

            // Tab C: Akademik
            $table->longText('visi')->nullable();
            $table->longText('misi')->nullable();
            $table->longText('deskripsi_kurikulum')->nullable();
            $table->string('pdf_kalender_akademik')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_profiles');
    }
};
