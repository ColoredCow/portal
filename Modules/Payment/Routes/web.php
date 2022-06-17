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

Route::prefix('payment')->middleware('auth')->group(function () {
    Route::get('/', 'PaymentController@index')->name('payment.index');
    Route::get('/transaction', 'PaymentController@transactionIndex')->name('transaction.index');
});

Route::prefix('payment-setting')->middleware('auth')->group(function () {
    Route::get('/', 'PaymentSettingController@index')->name('payment-setting.index');
    Route::post('/', 'PaymentSettingController@update')->name('payment-setting.update');
});

Route::prefix('transaction-index')->middleware('auth')->group(function () {
    Route::get('/expense', 'PaymentController@expense')->name('transaction-index.expense');
    Route::get('/revenue', 'PaymentController@revenue')->name('transaction-index.revenue');
});