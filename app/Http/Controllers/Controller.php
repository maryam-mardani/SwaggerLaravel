<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

/**
* @OA\Info(
* title="Laravel API",
* version="1.0.0",
* )
* @OA\SecurityScheme(
* type="http",
* securityScheme="bearerAuth",
* scheme="bearer",
* bearerFormat="JWT"
* )

*/
abstract class Controller
{
    use AuthorizesRequests, ValidatesRequests;
}
