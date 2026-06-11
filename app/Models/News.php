<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';

    protected $fillable = [
        'unit_id',
        'judul_berita',
        'slug',
        'konten_berita',
        'gambar_utama',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    // ---------------------------------------------------------------
    // Boot — auto-generate slug dari judul_berita (unique per unit)
    // ---------------------------------------------------------------

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (News $news) {
            if (empty($news->slug)) {
                $news->slug = static::generateUniqueSlug($news->judul_berita, $news->unit_id);
            }
        });
    }

    /**
     * Generate slug unik dalam konteks unit tertentu.
     */
    public static function generateUniqueSlug(string $title, int $unitId): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $counter = 1;

        while (static::where('unit_id', $unitId)->where('slug', $slug)->exists()) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    // ---------------------------------------------------------------
    // Scopes
    // ---------------------------------------------------------------

    /** Hanya berita yang sudah dipublikasikan. */
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    /** Hanya draft (belum dipublikasikan). */
    public function scopeDraft($query)
    {
        return $query->whereNull('published_at');
    }

    // ---------------------------------------------------------------
    // Relasi
    // ---------------------------------------------------------------

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
