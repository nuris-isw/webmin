<?php

namespace App\Http\Resources;

use App\Helpers\AssetHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitResource extends JsonResource
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
            'nama_sekolah' => $this->nama_sekolah,
            'slug' => $this->slug,
            'jenjang' => $this->jenjang,
            'is_active' => (bool) $this->is_active,
            'logo_sekolah' => $this->schoolProfile ? AssetHelper::getUrl($this->schoolProfile->logo_sekolah) : null,
            'profile' => new SchoolProfileResource($this->whenLoaded('schoolProfile')),
        ];
    }
}
