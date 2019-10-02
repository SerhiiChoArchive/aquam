<?php


Auth::routes();

Route::get('/', 'PageController@index');
Route::get('/update-data', 'PageController@updateData');

Route::post('/upload', 'UploadController@upload');
Route::post('/upload-images', 'UploadController@uploadImages');
