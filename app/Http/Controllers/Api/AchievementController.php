<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AchievementResource;
use App\Models\Unit;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Achievements
 *
 * API for querying school achievements.
 */
class AchievementController extends Controller
{
    use ApiResponse;

    /**
     * Get achievements.
     *
     * Returns a list of achievements for the specified school unit.
     *
     * @urlParam slug string required The slug of the school unit. Example: smk-mandiri
     * @queryParam peraih string Filter achievements by recipient role: `siswa`, `guru`, `tendik`, or `sekolah`. Example: siswa
     *
     * @response {
     *   "success": true,
     *   "message": "Daftar prestasi berhasil diambil.",
     *   "data": [
     *     {
     *       "id": 1,
     *       "judul_prestasi": "Juara 1 Lomba LKS SMK",
     *       "tahun_prestasi": 2026,
     *       "peraih_prestasi": "siswa",
     *       "deskripsi_prestasi": "Juara 1 Bidang IT Network Systems Administration.",
     *       "foto_penghargaan": "http://localhost/storage/1/ach.png"
     *     }
     *   ]
     * }
     */
    public function index(Request $request, string $slug): JsonResponse
    {
        $unit = Unit::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $query = $unit->achievements();

        if ($request->filled('peraih')) {
            $query->where('peraih_prestasi', $request->query('peraih'));
        }

        $achievements = $query->orderBy('tahun_prestasi', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return $this->successResponse(AchievementResource::collection($achievements), 'Daftar prestasi berhasil diambil.');
    }
}
