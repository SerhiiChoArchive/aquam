<?php

use App\Http\Controllers\JsonController;
use App\Http\Controllers\V2\JsonController as V2JsonController;
use Illuminate\Support\Facades\Route;

/**
 * Keep it for legacy apps
 * @deprecated
 */
Route::get('price-list', [JsonController::class, 'fish']);

Route::get('info', [JsonController::class, 'info']);

Route::get('fish', [JsonController::class, 'fish']);
Route::get('equipment', [JsonController::class, 'equipment']);
Route::get('feed', [JsonController::class, 'feed']);
Route::get('chemistry', [JsonController::class, 'chemistry']);
Route::get('aquariums', [JsonController::class, 'aquariums']);

Route::prefix('v2')->group(function () {
    Route::get('fish', [V2JsonController::class, 'fish']);
    Route::get('equipment', [V2JsonController::class, 'equipment']);
    Route::get('feed', [V2JsonController::class, 'feed']);
    Route::get('chemistry', [V2JsonController::class, 'chemistry']);
    Route::get('aquariums', [V2JsonController::class, 'aquariums']);
});
