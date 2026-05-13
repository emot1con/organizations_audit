<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController as ApiAuthController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;

Route::middleware('throttle:auth')->group(function () {
    Route::post('/register', [ApiAuthController::class, 'register']);
    Route::post('/login', [ApiAuthController::class, 'login']);
});

Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    Route::post('/logout', [ApiAuthController::class, 'logout']);
    Route::get('/me', [ApiAuthController::class, 'me']);
    
    // Rute Organisasi
    // Route::apiResource('organizations', OrganizationController::class)->except(['create', 'edit']);
    
    // Rute Divisi
    Route::apiResource('organizations.divisions', DivisionController::class)->shallow()->except(['create', 'edit']);
    
    // Rute Member / Role
    Route::post('/organizations/{organization}/members', [MemberController::class, 'store']);
    Route::put('/organizations/{organization}/members/{member}', [MemberController::class, 'update']);
    Route::delete('/organizations/{organization}/members/{member}', [MemberController::class, 'destroy']);

    // Rute Kategori
    Route::apiResource('categories', CategoryController::class);

    // Rute Transaksi (dengan throttle spam khusus untuk route POST / pembuatan)
    Route::apiResource('organizations.transactions', TransactionController::class)
        ->shallow()
        ->except(['store']);
        
    Route::post('organizations/{organization}/transactions', [TransactionController::class, 'store'])
        ->name('organizations.transactions.store')
        ->middleware('throttle:transaction_spam');

    Route::patch('/transactions/{transaction}/status', [TransactionController::class, 'changeStatus']);
});
