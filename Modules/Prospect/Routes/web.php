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

Route::prefix('prospect')->middleware('auth')->group(function() {
    Route::get('/', 'ProspectController@index');
    Route::get('/create','ProspectController@create')->name('prospect.create');
});
