<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'IndexController@show');
Route::get('/register/{device_id}', 'IndexController@register');
Route::get('/add_score/{device_id}/{score_id}', 'IndexController@add_score');
Route::get('/get_score/{device_id}/{score_id}', 'IndexController@get_score');
