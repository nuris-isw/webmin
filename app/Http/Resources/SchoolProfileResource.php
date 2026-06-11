<?php

namespace App\Http\Resources;

use App\Helpers\AssetHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolProfileResource extends JsonResource
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
            'unit_id' => $this->unit_id,
            'logo_sekolah' => AssetHelper::getUrl($this->logo_sekolah),
            'email' => $this->email,
            'telepon' => $this->telepon,
            'alamat' => $this->alamat,
            'google_map_embed_url' => $this->google_map_embed_url,
            'media_sosial' => $this->media_sosial,
            'nama_kepala_sekolah' => $this->nama_kepala_sekolah,
            'foto_kepala_sekolah' => AssetHelper::getUrl($this->foto_kepala_sekolah),
            'sambutan_kepala_sekolah' => $this->sambutan_kepala_sekolah,
            'sejarah_singkat_sekolah' => $this->sejarah_singkat_sekolah,
            'visi' => $this->visi,
            'misi' => $this->misi,
            'deskripsi_kurikulum' => $this->deskripsi_kurikulum,
            'pdf_kalender_akademik' => AssetHelper::getUrl($this->pdf_kalender_akademik),
            'created_at' => $this->created_at ? $this->created_at->toIso8601String() : null,
            'updated_at' => $this->updated_at ? $this->updated_at->toIso8601String() : null,
        ];
    }
}
