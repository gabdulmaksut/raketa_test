<?php

//Route::get('/', [], function () {
//    return view('welcome');
//});
Route::get('/', 'ApiController@getIndex');
Route::post('/', 'ApiController@postIndex');

Route::get('/requests', 'ApiController@getUsersRequests');

