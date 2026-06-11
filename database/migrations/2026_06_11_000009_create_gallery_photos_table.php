<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Foto-foto individual dalam sebuah galeri kegiatan (mendukung multi-upload).
     */
    public function up(): void
    {
        Schema::create('gallery_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_id')
                ->constrained('galleries')
                ->cascadeOnDelete();

            $table->string('file_foto');
            $table->unsignedSmallInteger('urutan')->default(0)
                ->comment('Urutan tampil foto dalam galeri, asc');

            $table->timestamps();

            $table->index(['gallery_id', 'urutan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_photos');
    }
};
