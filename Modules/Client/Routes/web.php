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

Route::prefix('client')->group(function () {
    Route::get('/', 'ClientController@index')->name('client.index');
    Route::get('/create', 'ClientController@create')->name('client.create');
    Route::get('/{client}/edit', 'ClientController@edit')->name('client.edit');
    Route::post('/', 'ClientController@store')->name('client.store');
    Route::put('/{client}/update', 'ClientController@update')->name('client.update');
});
