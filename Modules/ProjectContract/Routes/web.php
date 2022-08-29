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

Route::prefix('projectcontract')->group(function () {
    Route::get('/index', 'ProjectContractController@index')->name('projectcontract.index');
    Route::get('/create', 'ProjectContractController@create')->name('projectcontract.create');
    Route::post('/store', 'ProjectcontractController@store')->name('projectcontract.store');
});
