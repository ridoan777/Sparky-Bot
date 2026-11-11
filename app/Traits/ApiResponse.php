<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait ApiResponse
{
    /**
     * Return a successful response with a message and data.
     */
    public function successResponse($data, $message = "Success", $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Generate an error JSON response.
     */
    public function errorResponse($message = "Something went wrong", $code = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => ''
        ], $code);
    }


    /**
     * Return a paginated response with a message and pagination metadata.
     */
    public function paginateResponse($paginator, $message = "Data fetched successfully", $code = 200)
    {
        $items = $paginator->items();

        if (empty($items)) {
            return response()->json([
                'success' => true,
                'message' => 'No data found',
                'data' => [],
                'meta' => [
                    'current_page' => $paginator->currentPage(),
                    'last_page' => $paginator->lastPage(),
                    'per_page' => $paginator->perPage(),
                    'total' => $paginator->total(),
                ]
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $items,
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
            ]
        ], $code);
    }
}
