<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use App\Models\Unit;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group News
 *
 * API for querying news and articles from school units.
 */
class NewsController extends Controller
{
    use ApiResponse;

    /**
     * Get news listing.
     *
     * Returns a paginated list of published news articles for the specified unit.
     *
     * @urlParam slug string required The slug of the school unit. Example: smk-mandiri
     * @queryParam per_page integer Number of articles per page. Default: 10. Example: 10
     * @queryParam page integer Page number. Example: 1
     *
     * @response {
     *   "success": true,
     *   "message": "Daftar berita berhasil diambil.",
     *   "data": [
     *     {
     *       "id": 1,
     *       "judul_berita": "Pendaftaran Siswa Baru",
     *       "slug": "pendaftaran-siswa-baru",
     *       "konten_berita": "Pendaftaran...",
     *       "gambar_utama": "http://localhost/storage/1/news.png",
     *       "published_at": "2026-06-11T12:00:00Z"
     *     }
     *   ],
     *   "meta": {
     *     "current_page": 1,
     *     "from": 1,
     *     "last_page": 1,
     *     "per_page": 10,
     *     "to": 1,
     *     "total": 1
     *   },
     *   "links": {
     *     "first": "http://localhost/api/v1/units/smk-mandiri/news?page=1",
     *     "last": "http://localhost/api/v1/units/smk-mandiri/news?page=1",
     *     "prev": null,
     *     "next": null
     *   }
     * }
     */
    public function index(Request $request, string $slug): JsonResponse
    {
        $unit = Unit::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $perPage = $request->query('per_page', 10);
        $news = $unit->news()
            ->whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->paginate($perPage);

        return $this->successResponse(NewsResource::collection($news), 'Daftar berita berhasil diambil.');
    }

    /**
     * Get news detail.
     *
     * Returns a specific published news article by its slug.
     *
     * @urlParam slug string required The slug of the school unit. Example: smk-mandiri
     * @urlParam newsSlug string required The slug of the news article. Example: pendaftaran-siswa-baru
     *
     * @response {
     *   "success": true,
     *   "message": "Detail berita berhasil diambil.",
     *   "data": {
     *     "id": 1,
     *     "judul_berita": "Pendaftaran Siswa Baru",
     *     "slug": "pendaftaran-siswa-baru",
     *     "konten_berita": "Pendaftaran...",
     *     "gambar_utama": "http://localhost/storage/1/news.png",
     *     "published_at": "2026-06-11T12:00:00Z"
     *   }
     * }
     */
    public function show(string $slug, string $newsSlug): JsonResponse
    {
        $unit = Unit::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $article = $unit->news()
            ->where('slug', $newsSlug)
            ->whereNotNull('published_at')
            ->firstOrFail();

        return $this->successResponse(new NewsResource($article), 'Detail berita berhasil diambil.');
    }
}
