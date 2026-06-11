<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambahkan kolom tenant (unit_id, role, google_id) ke tabel users yang sudah ada.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('unit_id')
                ->nullable()
                ->after('id')
                ->constrained('units')
                ->nullOnDelete();

            $table->enum('role', ['superadmin', 'admin'])
                ->default('admin')
                ->after('unit_id');

            $table->string('google_id')
                ->nullable()
                ->unique()
                ->after('remember_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('unit_id');
            $table->dropColumn(['role', 'google_id']);
        });
    }
};
