<?php

namespace App\Http\Resources;

use App\Helpers\AssetHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GalleryPhotoResource extends JsonResource
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
            'file_foto' => AssetHelper::getUrl($this->file_foto),
            'urutan' => (int) $this->urutan,
        ];
    }
}
