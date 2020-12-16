<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevicesController;
use App\Http\Controllers\MetricsController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->group(function() {
    Route::get('/devices', [DevicesController::class, 'index']);
    Route::get('/devices/{id}', [DevicesController::class, 'get']);
    Route::post('/devices', [DevicesController::class, 'store']);
    Route::patch('/devices/{id}', [DevicesController::class, 'update']);
    Route::delete('/devices/{id}', [DevicesController::class, 'delete']);

    Route::get('/metrics/{id}', [MetricsController::class, 'get']);
    Route::delete('/metrics/{id}', [MetricsController::class, 'delete']);

    Route::get('/profile', [AuthController::class, 'getProfile']);
    Route::patch('/profile', [AuthController::class, 'updateProfile']);
});

Route::post('/metrics/{token}', [MetricsController::class, 'store']);

Route::get('/health', function() {
    return response()->json(['Iam' => 'fine']);
});
// application json header