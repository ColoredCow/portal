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

Route::prefix('prospect')->middleware('auth')->group(function () {
    Route::get('/', 'ProspectController@index')->name('prospect.index');
    Route::get('/create', 'ProspectController@create')->name('prospect.create');
    Route::post('/store', 'ProspectController@store')->name('prospect.store');
    Route::get('/{prospect}/edit', 'ProspectController@edit')->name('prospect.edit');
    Route::get('/{prospect}/show', 'ProspectController@show')->name('prospect.show');
    Route::put('/{prospect}/update', 'ProspectController@update')->name('prospect.update');
    Route::put('/{prospect}/comment/update', 'ProspectController@commentUpdate')->name('prospect.comment.update');
    Route::put('/{prospect}/insights/update', 'ProspectController@insightsUpdate')->name('prospect.insights.update');
});
