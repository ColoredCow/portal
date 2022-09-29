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
    Route::get('/delete/{id}', 'ReportController@delete')->name('report.delete');
    Route::post('/update/{id}', 'ReportController@update')->name('report.update');

    Route::prefix('finance')->group(function () {
        Route::get('dashboard', 'FinanceReportController@dashboard')->name('reports.finance.dashboard');
        Route::get('profit-and-loss', 'FinanceReportController@profitAndLoss')->name('reports.finance.profit-and-loss');
        Route::get('get-report-data', 'FinanceReportController@getReportData')->name('reports.finance.get-report-data');
    });
});
