<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponse
{
    /**
     * Return a standardized success JSON response.
     */
    protected function successResponse($data, string $message = null, int $code = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        if ($data instanceof AnonymousResourceCollection && $data->resource instanceof LengthAwarePaginator) {
            $paginated = $data->resource->toArray();
            $response['data'] = $data->resolve();
            $response['meta'] = [
                'current_page' => $paginated['current_page'],
                'from' => $paginated['from'],
                'last_page' => $paginated['last_page'],
                'path' => $paginated['path'],
                'per_page' => $paginated['per_page'],
                'to' => $paginated['to'],
                'total' => $paginated['total'],
            ];
            $response['links'] = [
                'first' => $paginated['first_page_url'],
                'last' => $paginated['last_page_url'],
                'prev' => $paginated['prev_page_url'],
                'next' => $paginated['next_page_url'],
            ];
        } else {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }

    /**
     * Return a standardized error JSON response.
     */
    protected function errorResponse(string $message, int $code): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => null,
        ], $code);
    }
}
