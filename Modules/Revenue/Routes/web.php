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
<<<<<<< Updated upstream
    Route::get('/', 'RevenueProceedController@index')->name('revenue.proceeds.index');
    Route::post('/store', 'RevenueProceedController@store')->name('revenue.proceeds.store');
    Route::post('/update/{id}', 'RevenueProceedController@update')->name('revenue.proceeds.update');
    Route::get('/delete/{id}', 'RevenueProceedController@delete')->name('revenue.proceeds.delete');
=======
    Route::get('/', 'RevenueController@index')->name('revenue.index');
    Route::get('create', 'RevenueController@create')->name('revenue.create');
    Route::get('store', 'RevenueController@store')->name('revenue.store');
    Route::get('/edit/{id}', 'RevenueController@edit')->name('revenue.edit');
    Route::get('/delete/{id}', 'RevenueController@delete')->name('revenue.delete');
    Route::post('/update/{id}', 'RevenueController@update')->name('revenue.update');
>>>>>>> Stashed changes
});
