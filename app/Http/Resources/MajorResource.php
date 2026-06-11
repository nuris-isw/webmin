<?php

namespace App\Http\Resources;

use App\Helpers\AssetHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MajorResource extends JsonResource
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
            'nama_jurusan' => $this->nama_jurusan,
            'nomenklatur_istilah' => $this->nomenklatur_istilah,
            'shortname' => $this->shortname,
            'nama_kaprog' => $this->nama_kaprog,
            'foto_kaprog' => AssetHelper::getUrl($this->foto_kaprog),
            'deskripsi_jurusan' => $this->deskripsi_jurusan,
            'galeri_program' => GalleryResource::collection($this->whenLoaded('galleries')),
            'created_at' => $this->created_at ? $this->created_at->toIso8601String() : null,
            'updated_at' => $this->updated_at ? $this->updated_at->toIso8601String() : null,
        ];
    }
}
