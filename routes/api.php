<?php
use App\Http\Middleware\ForceJsonResponse;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CitizenController;
use App\Http\Controllers\Api\AuthController;

// 🔓 ROUTES PUBLIQUES (temporaire pour test)
Route::get('/citizens', [CitizenController::class, 'index']);
Route::get('/citizens/{citizen}', [CitizenController::class, 'show']);
Route::post('/login', [AuthController::class, 'login']);
// 🔒 ROUTES PROTÉGÉES
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/citizens', [CitizenController::class, 'store']);
    Route::put('/citizens/{citizen}', [CitizenController::class, 'update']);
    Route::delete('/citizens/{citizen}', [CitizenController::class, 'destroy']);
});


Route::middleware([ForceJsonResponse::class])->group(function () {
    // 🔓 ROUTES PUBLIQUES
    Route::get('/citizens', [CitizenController::class, 'index']);
    Route::get('/citizens/{citizen}', [CitizenController::class, 'show']);
    Route::post('/login', [AuthController::class, 'login']);

    // 🔒 ROUTES PROTÉGÉES
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/citizens', [CitizenController::class, 'store']);
        Route::put('/citizens/{citizen}', [CitizenController::class, 'update']);
        Route::delete('/citizens/{citizen}', [CitizenController::class, 'destroy']);
    });
});
