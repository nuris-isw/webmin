<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GalleryPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'gallery_id',
        'file_foto',
        'urutan',
    ];

    protected $casts = [
        'urutan' => 'integer',
    ];

    // ---------------------------------------------------------------
    // Relasi
    // ---------------------------------------------------------------

    public function gallery(): BelongsTo
    {
        return $this->belongsTo(Gallery::class);
    }
}
