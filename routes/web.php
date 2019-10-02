<?php

Route::get('/price-list', 'JsonController@priceList');
Route::get('/info', 'JsonController@info');
Route::post('/upload', 'UploadController@upload');
Route::post('/upload-images', 'UploadController@uploadImages');

Auth::routes();

Route::redirect('/', '/home');
Route::get('/home', 'HomeController@index');
