<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExtracurricularResource;
use App\Models\Unit;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

/**
 * @group Extracurriculars
 *
 * API for querying school extracurricular organizations and clubs.
 */
class ExtracurricularController extends Controller
{
    use ApiResponse;

    /**
     * Get extracurriculars.
     *
     * Returns a list of extracurriculars for the specified school unit.
     *
     * @urlParam slug string required The slug of the school unit. Example: smk-mandiri
     *
     * @response {
     *   "success": true,
     *   "message": "Daftar ekstrakurikuler berhasil diambil.",
     *   "data": [
     *     {
     *       "id": 1,
     *       "nama_ekskul": "Pramuka",
     *       "pembina_ekskul": "Kak Ahmad",
     *       "jadwal_kegiatan": "Sabtu 08:00 - 11:00",
     *       "logo_ekskul": "http://localhost/storage/1/ekskul.png"
     *     }
     *   ]
     * }
     */
    public function index(string $slug): JsonResponse
    {
        $unit = Unit::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $extracurriculars = $unit->extracurriculars()
            ->orderBy('nama_ekskul')
            ->get();

        return $this->successResponse(ExtracurricularResource::collection($extracurriculars), 'Daftar ekstrakurikuler berhasil diambil.');
    }
}
