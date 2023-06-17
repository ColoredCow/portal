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
    Route::get('viewContract/{id}', 'ProjectContractController@viewContract')->name('projectcontract.view-contract');
    Route::get('/review/{user}/{email}', 'ReviewController@index')->name('review')->middleware('signed');
    Route::post('sendreview', 'ProjectContractController@sendreview')->name('projectcontract.sendreview');
    Route::get('clientresponse/{id}', 'ProjectContractController@clientresponse')->name('projectcontract.clientresponse');
    Route::post('clientupdate', 'ProjectContractController@clientupdate')->name('projectcontract.clientupdate');
    Route::post('sendfinancereview', 'ProjectContractController@sendfinancereview')->name('projectcontract.sendfinancereview');
});
