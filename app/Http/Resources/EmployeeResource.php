<?php

namespace App\Http\Resources;

use App\Helpers\AssetHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'nama'         => $this->nama,
            'jabatan'      => $this->jabatan,
            'order_number' => $this->order_number,
            'photo'        => AssetHelper::getUrl($this->photo),
            'created_at'   => $this->created_at ? $this->created_at->toIso8601String() : null,
            'updated_at'   => $this->updated_at ? $this->updated_at->toIso8601String() : null,
        ];
    }
}
