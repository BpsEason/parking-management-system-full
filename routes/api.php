<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ParkingController;

// --- V1 API Routes ---
Route::prefix('v1')->group(function () {
    // Apply Sanctum authentication middleware to all V1 API routes for security
    Route::middleware('auth:sanctum')->group(function () {
        // Parking Module Routes
        Route::prefix('parking')->group(function () {
            Route::post('entry', [ParkingController::class, 'entry']);
            Route::post('exit', [ParkingController::class, 'exit']);
            // TODO: Add other parking-related routes (e.g., check_status, get_available_spaces)
        });
        
        // TODO: Add Billing and User routes
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
