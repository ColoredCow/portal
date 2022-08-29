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

use Modules\Salary\Http\Controllers\SalaryController;

Route::prefix('employee-salary')->middleware('auth')->group(function () {
    // Route::get('/', 'SalaryController@index')->name('salary.index');
    Route::get('/employee/{employee}/', 'SalaryController@employee')->name('salary.employee');
    Route::post('/employee/store/{employee}', 'SalaryController@storeSalary')->name('salary.employee.store');
});

Route::prefix('salary-settings')->middleware('auth')->group(function () {
    Route::get('/', 'SalarySettingController@index')->name('salary.settings');
    Route::post('/update/', 'SalarySettingController@update')->name('salary-settings.update');
});

Route::prefix('salary')->middleware('auth')->group(function () {
    Route::get('/', 'SalaryController@salaryReport')->name('salary.report');
    // Route::get('/salary',[SalaryController::class,'index'])->name('Salary.index');
});
