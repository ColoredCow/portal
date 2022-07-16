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

Route::prefix('report')->group(function () {
    Route::get('/', 'ReportController@index');
    Route::post('/', 'ReportController@store')->name('report.store');
    Route::get('/edit/{id}', 'ReportController@edit')->name('report.edit');
    Route::get('/show/{id}', 'ReportController@show')->name('report.show');
    Route::post('/update/{id}', 'ReportController@update')->name('report.update');


    Route::prefix('finance')->group(function () {
        Route::get('profit-and-loss', 'FinanceReportController@profitAndLoss')->name('reports.finance.profit-and-loss');
    });
});
