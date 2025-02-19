<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EventController;
use App\Http\Controllers\API\ReservationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    // Tus rutas protegidas aquí
});

// routes/api.php
// Route::apiResource('events', EventController::class)->withoutMiddleware(['auth:sanctum']);


Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('events', EventController::class);
    Route::apiResource('events.reservations', ReservationController::class);
});
