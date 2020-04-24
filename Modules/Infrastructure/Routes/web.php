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

Route::prefix('infrastructure')->middleware('auth')->group(function () {
    Route::get('/', 'InfrastructureController@index')->name('infrastructure.index');
    Route::get('/instances', 'InfrastructureController@getInstances')->name('infrastructure.get-instances');
    Route::get('/billing-details', 'InfrastructureController@getBillingDetails')->name('infrastructure.billing-details');
});
