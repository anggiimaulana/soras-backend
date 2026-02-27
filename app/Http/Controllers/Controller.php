<?php

namespace App\Http\Controllers;

abstract class Controller
{
    /**
     * Standard success response helper.
     *
     * @param mixed  $data
     * @param string|null $message
     * @param int    $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse(mixed $data = null, ?string $message = null, int $status = 200)
    {
        $payload = [
            'success' => true,
        ];

        if ($message !== null) {
            $payload['message'] = $message;
        }

        if ($data !== null) {
            $payload['data'] = $data;
        }

        return response()->json($payload, $status);
    }
}
