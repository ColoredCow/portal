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
    Route::get('/', 'ProjectContractController@index')->name('projectcontract.index');
    Route::get('/viewForm', 'ProjectContractController@viewForm')->name('projectcontract.view-form');
    Route::post('store', 'ProjectContractController@store')->name('projectcontract.store');
    Route::get('edit/{id}', 'ProjectContractController@edit')->name('projectcontract.edit');
    Route::post('update/{id}', 'ProjectContractController@update')->name('projectcontract.update');
    Route::get('delete/{id}', 'ProjectContractController@delete')->name('projectcontract.delete');
});
