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

Route::prefix('invoice')->middleware('auth')->group(function () {
    Route::get('/', 'InvoiceController@index')->name('invoice.index');
    Route::get('/tax-report', 'InvoiceController@taxReport')->name('invoice.tax-report');
    Route::get('/tax-report-export', 'InvoiceController@taxReportExport')->name('invoice.tax-report-export');
    Route::get('/create', 'InvoiceController@create')->name('invoice.create');
    Route::get('/dashboard', 'InvoiceController@dashboard')->name('invoice.dashboard');
    Route::post('/send-invoice-mail', 'InvoiceController@sendInvoice')->name('invoice.send-invoice-mail');
    Route::post('/', 'InvoiceController@store')->name('invoice.store');
    Route::get('/{invoice}/edit', 'InvoiceController@edit')->name('invoice.edit');
    Route::post('/{invoiceId}/update', 'InvoiceController@update')->name('invoice.update');
    Route::delete('/{invoiceId}/delete', 'InvoiceController@destroy')->name('invoice.delete');
    Route::post('/generate-invoice-client', 'InvoiceController@generateInvoiceForClient')->name('invoice.generate-invoice-for-client');
    Route::post('/generate-invoice', 'InvoiceController@generateInvoice')->name('invoice.generate-invoice');
    Route::post('/{invoice}', 'InvoiceController@sendEmail')->name('invoice.sendEmail');
    Route::get('/monthly-gst-report', 'InvoiceController@invoiceDetails')->name('invoice.details');
    Route::get('/monthly-GST-Tax-report-export', 'InvoiceController@monthlyGSTTaxReportExport')->name('invoice.monthly-tax-report-export');
    Route::get('/{invoiceId}/{filename}', 'InvoiceController@getInvoiceFile')->name('invoice.get-file');
});
