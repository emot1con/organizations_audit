<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    // Rute Organisasi
    Route::apiResource('organizations', OrganizationController::class)->except(['create', 'edit']);
    
    // Rute Divisi
    Route::apiResource('organizations.divisions', DivisionController::class)->shallow()->except(['create', 'edit']);
    
    // Rute Member / Role
    Route::post('/organizations/{organization}/members', [MemberController::class, 'store']);
    Route::put('/organizations/{organization}/members/{member}', [MemberController::class, 'update']);
    Route::delete('/organizations/{organization}/members/{member}', [MemberController::class, 'destroy']);

    // Rute Kategori
    Route::apiResource('categories', CategoryController::class);

    // Rute Transaksi
    Route::apiResource('organizations.transactions', TransactionController::class)->shallow();
    Route::patch('/transactions/{transaction}/status', [TransactionController::class, 'changeStatus']);
});
