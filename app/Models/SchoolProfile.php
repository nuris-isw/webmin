<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        // Tab A
        'logo_sekolah',
        'email',
        'telepon',
        'alamat',
        'google_map_embed_url',
        'media_sosial',
        // Tab B
        'nama_kepala_sekolah',
        'foto_kepala_sekolah',
        'sambutan_kepala_sekolah',
        'sejarah_singkat_sekolah',
        // Tab C
        'visi',
        'misi',
        'deskripsi_kurikulum',
        'pdf_kalender_akademik',
    ];

    protected $casts = [
        'media_sosial' => 'array',
    ];

    // ---------------------------------------------------------------
    // Relasi
    // ---------------------------------------------------------------

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
