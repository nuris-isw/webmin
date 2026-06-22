<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_sekolah',
        'slug',
        'jenjang',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ---------------------------------------------------------------
    // Boot — auto-generate slug dari nama_sekolah
    // ---------------------------------------------------------------

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Unit $unit) {
            if (empty($unit->slug)) {
                $unit->slug = Str::slug($unit->nama_sekolah);
            }
        });
    }

    // ---------------------------------------------------------------
    // Helpers
    // ---------------------------------------------------------------

    /** Apakah unit ini berjenjang SMK? */
    public function isSmk(): bool
    {
        return $this->jenjang === 'smk';
    }

    /** Apakah unit ini berjenjang SMP? */
    public function isSmp(): bool
    {
        return $this->jenjang === 'smp';
    }

    /** Apakah unit ini berjenjang TK? */
    public function isTk(): bool
    {
        return $this->jenjang === 'tk';
    }

    /** Dapatkan label nama program/jurusan dinamis berdasarkan jenjang */
    public function getMajorLabel(): string
    {
        if ($this->isSmk()) {
            return 'Jurusan';
        }
        if ($this->isSmp()) {
            return 'Program Unggulan';
        }
        return 'Program Pendidikan'; // tk
    }

    /** Dapatkan label kepala/pimpinan program dinamis berdasarkan jenjang */
    public function getLeaderLabel(): string
    {
        if ($this->isSmk()) {
            return 'Kepala Program (Kaprog)';
        }
        if ($this->isSmp()) {
            return 'Koordinator Program';
        }
        return 'Koordinator Layanan / Guru PJ'; // tk
    }

    // ---------------------------------------------------------------
    // Relasi
    // ---------------------------------------------------------------

    public function schoolProfile(): HasOne
    {
        return $this->hasOne(SchoolProfile::class);
    }

    public function spmbSetting(): HasOne
    {
        return $this->hasOne(SpmbSetting::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function achievements(): HasMany
    {
        return $this->hasMany(Achievement::class);
    }

    public function extracurriculars(): HasMany
    {
        return $this->hasMany(Extracurricular::class);
    }

    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }

    public function majors(): HasMany
    {
        return $this->hasMany(Major::class);
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
