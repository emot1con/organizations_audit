<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\MemberController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    // Rute Organisasi
    Route::get('/organizations', [OrganizationController::class, 'index']);
    Route::post('/organizations', [OrganizationController::class, 'store']);
    
    // Rute Divisi
    Route::get('/organizations/{organization}/divisions', [DivisionController::class, 'index']);
    Route::post('/organizations/{organization}/divisions', [DivisionController::class, 'store']);
    
    // Rute Member / Role
    Route::post('/organizations/{organization}/members', [MemberController::class, 'store']);
});
