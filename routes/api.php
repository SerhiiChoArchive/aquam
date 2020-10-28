<?php

use App\Http\Controllers\JsonController;
use Illuminate\Support\Facades\Route;

/**
 * Keep it for legacy apps
 * @deprecated
 */
Route::get('price-list', [JsonController::class, 'fish']);

Route::get('fish', [JsonController::class, 'fish']);
Route::get('equipment', [JsonController::class, 'equipment']);
Route::get('feed', [JsonController::class, 'feed']);
Route::get('chemistry', [JsonController::class, 'chemistry']);
Route::get('aquariums', [JsonController::class, 'aquariums']);

Route::get('info', [JsonController::class, 'info']);
