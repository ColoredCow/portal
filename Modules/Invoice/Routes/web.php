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

Route::prefix('invoice')->group(function () {
    Route::get('/', 'InvoiceController@index')->name('invoice.index');
    Route::get('/create', 'InvoiceController@create')->name('invoice.create');
    Route::get('/dashboard', 'InvoiceController@dashboard')->name('invoice.dashboard');
    Route::post('/', 'InvoiceController@store')->name('invoice.store');
    Route::get('/{invoice}/edit', 'InvoiceController@edit')->name('invoice.edit');
    Route::get('/get-file/{invoiceId}', 'InvoiceController@getInvoiceFile')->name('invoice.get-file');
    Route::post('/{invoiceId}/update', 'InvoiceController@update')->name('invoice.update');
});
