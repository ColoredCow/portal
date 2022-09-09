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

Route::prefix('revenue')->group(function () {
    Route::get('/', 'RevenueController@index')->name('revenue.index');
    Route::get('create', 'RevenueController@create')->name('revenue.create');
    Route::post('/storeData', 'RevenueController@store')->name('revenue.storeData');
    Route::get('/edit/{id}', 'RevenueController@edit')->name('revenue.edit');
    Route::get('/delete/{id}', 'RevenueController@delete')->name('revenue.delete');
    Route::post('/update/{id}', 'RevenueController@update')->name('revenue.update');
});
