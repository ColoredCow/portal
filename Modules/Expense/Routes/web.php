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
        Route::get('edit/{recurringExpense}', 'RecurringExpenseController@edit')->name('expense.recurring.edit');
        Route::post('/update/{recurringExpense}', 'RecurringExpenseController@update')->name('expense.recurring.update');
        Route::delete('/{recurringExpense}', 'RecurringExpenseController@destroy')->name('expense.recurring.destroy');
    });
});
