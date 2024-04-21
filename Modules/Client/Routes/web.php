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

Route::prefix('client')->middleware('auth')->group(function () {
    Route::get('/', 'ClientController@index')->name('client.index');
    Route::get('/create', 'ClientController@create')->name('client.create');
    Route::get('/{client}/edit/{section?}', 'ClientController@edit')->name('client.edit');
    Route::post('/', 'ClientController@store')->name('client.store');
    Route::post('/{client}/update', 'ClientController@update')->name('client.update');
    Route::post('/create/country', 'CountryController@store')->name('country.store');
    Route::get('/settings', 'CountryController@index')->name('settings.country-details');
    Route::post('/delete/{id}', 'CountryController@destroy')->name('country.delete');
    Route::post('/{id}/edit', 'CountryController@edit')->name('country.edit');
});
