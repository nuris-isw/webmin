<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Major extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'nama_jurusan',
        'nomenklatur_istilah',
        'shortname',
        'nama_kaprog',
        'foto_kaprog',
        'deskripsi_jurusan',
    ];

    // ---------------------------------------------------------------
    // Relasi
    // ---------------------------------------------------------------

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Galeri program yang terhubung ke jurusan ini.
     */
    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }
}
