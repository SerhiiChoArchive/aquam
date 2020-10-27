<?php

use App\Http\Controllers\JsonController;
use Illuminate\Support\Facades\Route;

Route::get('price-list', [JsonController::class, 'priceList']);
Route::get('info', [JsonController::class, 'info']);
