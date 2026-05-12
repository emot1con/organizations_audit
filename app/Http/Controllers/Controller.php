<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(title: "Expenses Tracker API", version: "1.0.0", description: "Dokumentasi API untuk sistem Multi-Tenant Expenses Tracker")]
#[OA\Server(url: L5_SWAGGER_CONST_HOST, description: "API Server")]
#[OA\SecurityScheme(securityScheme: "sanctum", type: "http", scheme: "bearer")]
abstract class Controller
{
    //
}
