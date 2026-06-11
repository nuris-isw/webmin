<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Berita dan artikel per unit sekolah dengan slug unik per unit.
     */
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')
                ->constrained('units')
                ->cascadeOnDelete();

            $table->string('judul_berita');
            $table->string('slug');
            $table->longText('konten_berita')->nullable();
            $table->string('gambar_utama')->nullable();
            $table->timestamp('published_at')->nullable()
                ->comment('Null berarti masih draft');

            $table->timestamps();

            // Slug unik per unit (bukan global)
            $table->unique(['unit_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
