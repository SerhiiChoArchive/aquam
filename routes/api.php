<?php

use App\Http\Controllers\JsonController;

Route::get('price-list', [JsonController::class, 'priceList']);
Route::get('info', [JsonController::class, 'info']);
