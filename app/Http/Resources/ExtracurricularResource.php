<?php

namespace App\Http\Resources;

use App\Helpers\AssetHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExtracurricularResource extends JsonResource
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
            'nama_ekskul' => $this->nama_ekskul,
            'pembina_ekskul' => $this->pembina_ekskul,
            'jadwal_kegiatan' => $this->jadwal_kegiatan,
            'logo_ekskul' => AssetHelper::getUrl($this->logo_ekskul),
            'created_at' => $this->created_at ? $this->created_at->toIso8601String() : null,
            'updated_at' => $this->updated_at ? $this->updated_at->toIso8601String() : null,
        ];
    }
}
