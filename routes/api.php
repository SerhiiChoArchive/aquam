<?php

Route::get('/price-list', 'JsonController@priceList');
Route::get('/info', 'JsonController@info');
Route::get('/mail', 'MailController@create');
