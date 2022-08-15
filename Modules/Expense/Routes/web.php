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

Route::prefix('expense')->group(function () {
    Route::get('/', 'ExpenseController@index')->name('expense.index');

    Route::prefix('recurring')->group(function () {
        Route::get('/', 'RecurringExpenseController@index')->name('expense.recurring.index');
        Route::get('create', 'RecurringExpenseController@create')->name('expense.recurring.create');
        Route::post('/', 'RecurringExpenseController@store')->name('expense.recurring.store');
       
    });

});
