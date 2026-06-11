<?php

namespace App\Http\Resources;

use App\Helpers\AssetHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'judul_berita' => $this->judul_berita,
            'slug' => $this->slug,
            'konten_berita' => $this->konten_berita,
            'gambar_utama' => AssetHelper::getUrl($this->gambar_utama),
            'published_at' => $this->published_at ? $this->published_at->toIso8601String() : null,
            'created_at' => $this->created_at ? $this->created_at->toIso8601String() : null,
            'updated_at' => $this->updated_at ? $this->updated_at->toIso8601String() : null,
        ];
    }
}
