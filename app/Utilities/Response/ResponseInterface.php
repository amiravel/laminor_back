<?php

namespace App\Utilities\Response;

use Illuminate\Http\Response as JsonResponse;

interface ResponseInterface
{
    public function paginate($data);

    public function list($data);

    public function item(object $item);

    public function success(string $message);

    public function error($message, $status, ?array $data = []): JsonResponse;
}