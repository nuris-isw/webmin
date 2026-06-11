<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpmbSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'status_spmb',
        'informasi_prosedur',
        'url_eksternal_pendaftaran',
    ];

    protected $casts = [
        'status_spmb' => 'boolean',
    ];

    // ---------------------------------------------------------------
    // Relasi
    // ---------------------------------------------------------------

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
