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
    Route::post('update', 'ProjectContractController@update')->name('projectcontract.update');
    Route::get('delete/{id}', 'ProjectContractController@delete')->name('projectcontract.delete');
    Route::get('viewContract/{id}', 'ProjectContractController@viewContract')->name('projectcontract.view-contract');
    Route::get('/review/{user}/{email}', 'ReviewController@index')->name('review')->middleware('signed');
    Route::post('sendreview', 'ProjectContractController@sendReview')->name('projectcontract.sendreview');
    Route::get('clientresponse/{id}', 'ProjectContractController@clientResponse')->name('projectcontract.clientresponse');
    Route::post('clientupdate', 'ProjectContractController@clientUpdate')->name('projectcontract.clientupdate');
    Route::post('sendfinancereview', 'ProjectContractController@sendFinanceReview')->name('projectcontract.sendfinancereview');
    Route::get('internalresponse/{id}', 'ProjectContractController@internalResponse')->name('projectcontract.internalresponse');
    Route::get('commenthistory/{id}', 'ProjectContractController@commentHistory')->name('projectcontract.commenthistory');
});
