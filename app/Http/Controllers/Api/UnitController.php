<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UnitResource;
use App\Models\Unit;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

/**
 * @group Units
 *
 * API for managing and querying school units.
 */
class UnitController extends Controller
{
    use ApiResponse;

    /**
     * Get active units.
     *
     * Returns a list of all active school units.
     *
     * @response {
     *   "success": true,
     *   "message": "Daftar unit sekolah berhasil diambil.",
     *   "data": [
     *     {
     *       "id": 1,
     *       "nama_sekolah": "SMK Mandiri",
     *       "slug": "smk-mandiri",
     *       "jenjang": "smk",
     *       "is_active": true,
     *       "logo_sekolah": "http://localhost/storage/1/logo.png"
     *     }
     *   ]
     * }
     */
    public function index(): JsonResponse
    {
        $units = Unit::where('is_active', true)->with('schoolProfile')->get();

        return $this->successResponse(UnitResource::collection($units), 'Daftar unit sekolah berhasil diambil.');
    }

    /**
     * Get unit details.
     *
     * Returns the full school profile of the specified unit slug.
     *
     * @urlParam slug string required The slug of the school unit. Example: smk-mandiri
     *
     * @response {
     *   "success": true,
     *   "message": "Detail unit sekolah berhasil diambil.",
     *   "data": {
     *     "id": 1,
     *     "nama_sekolah": "SMK Mandiri",
     *     "slug": "smk-mandiri",
     *     "jenjang": "smk",
     *     "is_active": true,
     *     "logo_sekolah": "http://localhost/storage/1/logo.png",
     *     "profile": {
     *       "id": 1,
     *       "unit_id": 1,
     *       "logo_sekolah": "http://localhost/storage/1/logo.png",
     *       "email": "smk@mandiri.sch.id",
     *       "telepon": "021-123456",
     *       "alamat": "Jl. Mandiri No. 1",
     *       "google_map_embed_url": "https://maps...",
     *       "media_sosial": {"facebook": "https://..."}
     *     }
     *   }
     * }
     */
    public function show(string $slug): JsonResponse
    {
        $unit = Unit::where('slug', $slug)
            ->where('is_active', true)
            ->with('schoolProfile')
            ->firstOrFail();

        $unit->load('schoolProfile');

        return $this->successResponse(new UnitResource($unit), 'Detail unit sekolah berhasil diambil.');
    }
}
