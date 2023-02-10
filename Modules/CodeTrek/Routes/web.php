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

Route::prefix('codetrek')->group(function () {
    Route::get('/', 'CodeTrekController@index')->name('codetrek.index');
    Route::post('/', 'CodeTrekController@store')->name('codetrek.store');
    Route::get('/edit/{id}', 'CodeTrekController@edit')->name('codetrek.edit');
    Route::post('/edit/{id}', 'CodeTrekController@update')->name('codetrek.update');
});
