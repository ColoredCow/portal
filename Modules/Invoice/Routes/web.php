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

Route::prefix('finance')->middleware('auth')->group(function () {
    Route::resource('/employee-loan', 'EmployeeLoanController')
        ->only(['index', 'edit', 'update', 'destroy', 'store'])
        ->names([
            'index' => 'employee-loan.index',
            'edit' => 'employee-loan.edit',
            'update' => 'employee-loan.update',
            'destroy' => 'employee-loan.destroy',
            'store' => 'employee-loan.store',
        ]);
    Route::get('/employee-loan/create', 'EmployeeLoanController@create')->name('employee-loan.create');
});

Route::prefix('invoice')->middleware('auth')->group(function () {
    Route::get('/', 'InvoiceController@index')->name('invoice.index');
    Route::get('/tax-report', 'InvoiceController@taxReport')->name('invoice.tax-report');
    Route::get('/tax-report-export', 'InvoiceController@taxReportExport')->name('invoice.tax-report-export');
    Route::get('/create', 'InvoiceController@create')->name('invoice.create');
    Route::get('/dashboard', 'InvoiceController@dashboard')->name('invoice.dashboard');
    Route::post('/send-invoice-mail', 'InvoiceController@sendInvoice')->name('invoice.send-invoice-mail');
    Route::post('/', 'InvoiceController@store')->name('invoice.store');
    Route::get('/{invoice}/edit', 'InvoiceController@edit')->name('invoice.edit');
    Route::post('/{invoice}/update', 'InvoiceController@update')->name('invoice.update');
    Route::delete('/{invoice}/delete', 'InvoiceController@destroy')->name('invoice.delete');
    Route::post('/generate-invoice', 'InvoiceController@generateInvoice')->name('invoice.generate-invoice');
    Route::post('/reminder', 'InvoiceController@sendReminderEmail')->name('invoice.reminder.email');
    Route::post('/payment-received', 'InvoiceController@sendReminderEmail')->name('invoice.payment-received.email');
    Route::get('/yearly-invoice-report', 'InvoiceController@yearlyInvoiceReport')->name('invoice.yearly-report');
    Route::get('/monthly-gst-report', 'InvoiceController@invoiceDetails')->name('invoice.details');
    Route::get('/monthly-gst-tax-report-export', 'InvoiceController@monthlyGstTaxReportExport')->name('invoice.monthly-tax-report-export');
    Route::get('/{invoiceId}/{filename}', 'InvoiceController@getInvoiceFile')->name('invoice.get-file');
    Route::get('/yearly-invoice-report-export', 'InvoiceController@yearlyInvoiceReportExport')->name('invoice.yearly-report-export');
});
