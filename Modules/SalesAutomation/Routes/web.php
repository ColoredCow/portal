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

Route::middleware('auth')->group(function () {
    Route::get('salesautomation', 'SalesAutomationController@index')->name('salesautomation.index');
    Route::prefix('salesautomation')->group(function () {
        Route::resource('sales-area', 'SalesAreaController');
        Route::resource('sales-characteristic', 'SalesCharacteristicController');
    });
});
