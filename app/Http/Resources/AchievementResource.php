<?php

namespace App\Http\Resources;

use App\Helpers\AssetHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AchievementResource extends JsonResource
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
            'judul_prestasi' => $this->judul_prestasi,
            'tahun_prestasi' => (int) $this->tahun_prestasi,
            'peraih_prestasi' => $this->peraih_prestasi,
            'deskripsi_prestasi' => $this->deskripsi_prestasi,
            'foto_penghargaan' => AssetHelper::getUrl($this->foto_penghargaan),
            'created_at' => $this->created_at ? $this->created_at->toIso8601String() : null,
            'updated_at' => $this->updated_at ? $this->updated_at->toIso8601String() : null,
        ];
    }
}
