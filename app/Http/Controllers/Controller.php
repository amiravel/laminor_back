<?php

namespace App\Http\Controllers;

use App\Services\BaseServiceInterface;
use App\Utilities\Response\ResponseInterface;

abstract class Controller
{
    public function __construct(
        protected ResponseInterface $response,
        protected BaseServiceInterface $service
    )
    {
    }
}
