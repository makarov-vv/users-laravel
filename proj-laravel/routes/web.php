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

Route::get('/', 'UserController@index');

Route::post('/', 'UserController@store');


Route::get('/add', 'UserController@add');

Route::get('/{id}/edit', 'UserController@edit');

Route::post('/{id}/edit', 'UserController@update');

Route::get('/import', 'UserController@import');

Route::post('/import', 'UserController@upload');