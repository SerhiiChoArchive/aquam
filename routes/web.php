<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UpdateDataController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::redirect('/', 'login');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::get('update-data', [UpdateDataController::class, 'index']);

    Route::post('upload', [UploadController::class, 'upload']);
    Route::post('upload-images', [UploadController::class, 'uploadImages']);
});