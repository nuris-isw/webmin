<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'nama_kegiatan',
        'opsi_tampilan',
        'major_id',
    ];

    // ---------------------------------------------------------------
    // Scopes — filter berdasarkan opsi tampilan
    // ---------------------------------------------------------------

    public function scopeHeroSection($query)
    {
        return $query->where('opsi_tampilan', 'hero_section');
    }

    public function scopeGambarPembuka($query)
    {
        return $query->where('opsi_tampilan', 'gambar_pembuka');
    }

    public function scopeGaleriDokumentasi($query)
    {
        return $query->where('opsi_tampilan', 'galeri_dokumentasi');
    }

    public function scopeGaleriProgram($query)
    {
        return $query->where('opsi_tampilan', 'galeri_program');
    }

    public function scopeByOpsi($query, string $opsi)
    {
        return $query->where('opsi_tampilan', $opsi);
    }

    // ---------------------------------------------------------------
    // Relasi
    // ---------------------------------------------------------------

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(GalleryPhoto::class)->orderBy('urutan');
    }
}
