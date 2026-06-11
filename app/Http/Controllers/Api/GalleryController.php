<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GalleryResource;
use App\Models\Unit;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Galleries
 *
 * API for querying school activity galleries and multimedia banner content.
 */
class GalleryController extends Controller
{
    use ApiResponse;

    /**
     * Get galleries.
     *
     * Returns a list of galleries for the specified school unit.
     *
     * @urlParam slug string required The slug of the school unit. Example: smk-mandiri
     * @queryParam opsi_tampilan string Filter galleries by display option: `hero_section`, `gambar_pembuka`, `galeri_dokumentasi`, or `galeri_program`. Example: galeri_dokumentasi
     *
     * @response {
     *   "success": true,
     *   "message": "Daftar galeri berhasil diambil.",
     *   "data": [
     *     {
     *       "id": 1,
     *       "nama_kegiatan": "LDKS OSIS 2026",
     *       "opsi_tampilan": "galeri_dokumentasi",
     *       "major_id": null,
     *       "photos": [
     *         {
     *           "id": 1,
     *           "file_foto": "http://localhost/storage/1/ldks.png",
     *           "urutan": 1
     *         }
     *       ]
     *     }
     *   ]
     * }
     */
    public function index(Request $request, string $slug): JsonResponse
    {
        $unit = Unit::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $query = $unit->galleries()->with('photos');

        if ($request->filled('opsi_tampilan')) {
            $query->where('opsi_tampilan', $request->query('opsi_tampilan'));
        }

        $galleries = $query->orderBy('created_at', 'desc')->get();

        return $this->successResponse(GalleryResource::collection($galleries), 'Daftar galeri berhasil diambil.');
    }

    /**
     * Get gallery details.
     *
     * Returns a specific gallery details along with all associated photos.
     *
     * @urlParam slug string required The slug of the school unit. Example: smk-mandiri
     * @urlParam id integer required The ID of the gallery. Example: 1
     *
     * @response {
     *   "success": true,
     *   "message": "Detail galeri berhasil diambil.",
     *   "data": {
     *     "id": 1,
     *     "nama_kegiatan": "LDKS OSIS 2026",
     *     "opsi_tampilan": "galeri_dokumentasi",
     *     "major_id": null,
     *     "photos": [
     *       {
     *         "id": 1,
     *         "file_foto": "http://localhost/storage/1/ldks.png",
     *         "urutan": 1
     *       }
     *     ]
     *   }
     * }
     */
    public function show(string $slug, int $id): JsonResponse
    {
        $unit = Unit::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $gallery = $unit->galleries()
            ->where('id', $id)
            ->with('photos')
            ->firstOrFail();

        return $this->successResponse(new GalleryResource($gallery), 'Detail galeri berhasil diambil.');
    }
}
