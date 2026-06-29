<?php

namespace App\Utilities\Response;

use Illuminate\Http\Response as JsonResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response as HttpResponseCode;

class Response
{
    public function paginate($data)
    {
        $data = $data->resource ?? $data;

        return response([
            'code' => HttpResponseCode::HTTP_OK,
            'data' => method_exists($data, 'items') ? $data->items() : $data,
            'meta' => [
                'current_page' => method_exists($data, 'currentPage') ? $data->currentPage() : null,
                'next_page' => method_exists($data, 'nextPageUrl') ? $data->nextPageUrl() : null,
                'last_page' => method_exists($data, 'lastPage') ? $data->lastPage() : null,
                'path' => method_exists($data, 'path') ? $data->path() : null,
                'total' => method_exists($data, 'total') ? $data->total() : null,
                'per_page' => method_exists($data, 'perPage') ? $data->perPage() : null,
            ]
        ], HttpResponseCode::HTTP_OK);
    }
    public function success($message = 'Ok')
    {
        return response([
            'code' => HttpResponseCode::HTTP_OK,
            'message' => $message
        ], HttpResponseCode::HTTP_OK);
    }

    public function error($message, $status, ?array $data = []): JsonResponse
    {
        return response([
            'code' => $status,
            'message' => $message,
            'data' => $data
        ], $status);
    }


    public function item($data): JsonResponse
    {
        return response([
            'code' => HttpResponseCode::HTTP_OK,
            'data' => $data
        ], HttpResponseCode::HTTP_OK);
    }

    public function list($data): \Illuminate\Foundation\Application|JsonResponse|\Illuminate\Contracts\Routing\ResponseFactory
    {
        return response([
            'code' => HttpResponseCode::HTTP_OK,
            'data' => $data->resource ?? $data,
        ], HttpResponseCode::HTTP_OK);
    }

    public function download(string $path, string $mimeType) : false|string
    {
        return response()->streamDownload(function () use ($path) {
            echo Storage::get($path);
        }, basename($path), [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'attachment; filename="' . basename($path) . '"',
        ]);
    }
}