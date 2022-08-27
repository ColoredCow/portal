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

Route::prefix('effortreport')->group(function () {
    Route::get('/employee/{employee}/', 'EffortReportController@barGraph')->name('effortreport.barGraph');
});
