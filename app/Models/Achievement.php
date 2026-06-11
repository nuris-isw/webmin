<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'judul_prestasi',
        'tahun_prestasi',
        'peraih_prestasi',
        'deskripsi_prestasi',
        'foto_penghargaan',
    ];

    // ---------------------------------------------------------------
    // Relasi
    // ---------------------------------------------------------------

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
