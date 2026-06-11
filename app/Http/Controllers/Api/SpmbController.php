<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SpmbResource;
use App\Models\Unit;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

/**
 * @group SPMB
 *
 * API for querying school enrollment (SPMB) settings and status.
 */
class SpmbController extends Controller
{
    use ApiResponse;

    /**
     * Get SPMB settings.
     *
     * Returns the SPMB settings of the specified school unit.
     *
     * @urlParam slug string required The slug of the school unit. Example: smk-mandiri
     *
     * @response {
     *   "success": true,
     *   "message": "Pengaturan SPMB berhasil diambil.",
     *   "data": {
     *     "id": 1,
     *     "status_spmb": true,
     *     "informasi_prosedur": "Berikut adalah prosedur pendaftaran...",
     *     "url_eksternal_pendaftaran": "https://ppdb.example.com"
     *   }
     * }
     */
    public function show(string $slug): JsonResponse
    {
        $unit = Unit::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $spmb = $unit->spmbSetting;

        if (!$spmb) {
            $spmb = $unit->spmbSetting()->firstOrCreate([
                'status_spmb' => false,
                'informasi_prosedur' => 'Belum ada informasi prosedur pendaftaran.',
            ]);
        }

        return $this->successResponse(new SpmbResource($spmb), 'Pengaturan SPMB berhasil diambil.');
    }
}
