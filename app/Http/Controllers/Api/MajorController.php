<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MajorResource;
use App\Models\Unit;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

/**
 * @group Majors
 *
 * API for querying SMK majors/competencies. Note: Only available for units of type 'smk'.
 */
class MajorController extends Controller
{
    use ApiResponse;

    /**
     * Get majors list.
     *
     * Returns a list of majors/programs of study for the specified unit. Returns 404 if the unit is not a SMK.
     *
     * @urlParam slug string required The slug of the school unit. Example: smk-mandiri
     *
     * @response {
     *   "success": true,
     *   "message": "Daftar jurusan berhasil diambil.",
     *   "data": [
     *     {
     *       "id": 1,
     *       "nama_jurusan": "Teknik Komputer dan Jaringan",
     *       "nomenklatur_istilah": "Teknik Komputer dan Jaringan",
     *       "shortname": "TKJ",
     *       "nama_kaprog": "Pak Budi",
     *       "foto_kaprog": "http://localhost/storage/1/kaprog.png",
     *       "deskripsi_jurusan": "Deskripsi TKJ...",
     *       "galeri_program": []
     *     }
     *   ]
     * }
     */
    public function index(string $slug): JsonResponse
    {
        $unit = Unit::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        if (!$unit->isSmk()) {
            abort(404, 'Fitur ini hanya tersedia untuk unit SMK.');
        }

        $majors = $unit->majors()
            ->with(['galleries.photos' => function ($query) {
                $query->orderBy('urutan');
            }])
            ->orderBy('nama_jurusan')
            ->get();

        return $this->successResponse(MajorResource::collection($majors), 'Daftar jurusan berhasil diambil.');
    }

    /**
     * Get major details.
     *
     * Returns detailed information for a specific major, including associated galleries and Kaprog data. Returns 404 if the unit is not a SMK.
     *
     * @urlParam slug string required The slug of the school unit. Example: smk-mandiri
     * @urlParam id integer required The ID of the major. Example: 1
     *
     * @response {
     *   "success": true,
     *   "message": "Detail jurusan berhasil diambil.",
     *   "data": {
     *     "id": 1,
     *     "nama_jurusan": "Teknik Komputer dan Jaringan",
     *     "nomenklatur_istilah": "Teknik Komputer dan Jaringan",
     *     "shortname": "TKJ",
     *     "nama_kaprog": "Pak Budi",
     *     "foto_kaprog": "http://localhost/storage/1/kaprog.png",
     *     "deskripsi_jurusan": "Deskripsi TKJ...",
     *     "galeri_program": []
     *   }
     * }
     */
    public function show(string $slug, int $id): JsonResponse
    {
        $unit = Unit::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        if (!$unit->isSmk()) {
            abort(404, 'Fitur ini hanya tersedia untuk unit SMK.');
        }

        $major = $unit->majors()
            ->where('id', $id)
            ->with(['galleries.photos' => function ($query) {
                $query->orderBy('urutan');
            }])
            ->firstOrFail();

        return $this->successResponse(new MajorResource($major), 'Detail jurusan berhasil diambil.');
    }
}
