<?php

Route::get('/', 'PageController@home');
Route::get('/price-list', 'JsonController@priceList');
Route::post('/upload', 'UploadController@upload');
