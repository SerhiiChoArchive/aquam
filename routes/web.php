<?php

Route::get('/', 'PageController@home');
Route::get('/price-list', 'JsonController@priceList');
Route::get('/info', 'JsonController@info');
Route::post('/upload', 'UploadController@upload');
Route::post('/upload-images', 'UploadController@uploadImages');
