<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeResource;
use App\Models\Unit;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

/**
 * @group Employees
 *
 * API for retrieving employee (teacher and staff) data for a school unit.
 */
class EmployeeController extends Controller
{
    use ApiResponse;

    /**
     * Get employees list.
     *
     * Returns a list of teachers and staff for the specified school unit,
     * ordered by `order_number` ascending (lower number = higher rank).
     *
     * @urlParam slug string required The slug of the school unit. Example: smk-mandiri
     *
     * @response {
     *   "success": true,
     *   "message": "Daftar pegawai berhasil diambil.",
     *   "data": [
     *     {
     *       "id": 1,
     *       "nama": "Drs. Ahmad Fauzi, M.Pd.",
     *       "jabatan": "Kepala Sekolah",
     *       "order_number": 1,
     *       "photo": "http://localhost/storage/1/employees/photo.jpg",
     *       "created_at": "2026-06-22T00:00:00+00:00",
     *       "updated_at": "2026-06-22T00:00:00+00:00"
     *     }
     *   ]
     * }
     */
    public function index(string $slug): JsonResponse
    {
        $unit = Unit::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $employees = $unit->employees()
            ->orderBy('order_number')
            ->orderBy('nama')
            ->get();

        return $this->successResponse(
            EmployeeResource::collection($employees),
            'Daftar pegawai berhasil diambil.'
        );
    }

    /**
     * Get employee details.
     *
     * Returns detailed information for a specific employee/staff member.
     *
     * @urlParam slug string required The slug of the school unit. Example: smk-mandiri
     * @urlParam id integer required The ID of the employee. Example: 1
     *
     * @response {
     *   "success": true,
     *   "message": "Detail pegawai berhasil diambil.",
     *   "data": {
     *     "id": 1,
     *     "nama": "Drs. Ahmad Fauzi, M.Pd.",
     *     "jabatan": "Kepala Sekolah",
     *     "order_number": 1,
     *     "photo": "http://localhost/storage/1/employees/photo.jpg",
     *     "created_at": "2026-06-22T00:00:00+00:00",
     *     "updated_at": "2026-06-22T00:00:00+00:00"
     *   }
     * }
     */
    public function show(string $slug, int $id): JsonResponse
    {
        $unit = Unit::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $employee = $unit->employees()
            ->where('id', $id)
            ->firstOrFail();

        return $this->successResponse(
            new EmployeeResource($employee),
            'Detail pegawai berhasil diambil.'
        );
    }
}
