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

Route::prefix('salary')->middleware('auth')->group(function () {
    Route::get('/', 'SalaryController@index')->name('salary.index');
    Route::get('/employee', 'SalaryController@employee')->name('salary.employee');
    Route::post('/employee/save', 'SalaryController@saveSalary')->name('salary.employee.save');
});

//Route::prefix('salary-settings')->middleware('auth')->group(function () {
//    Route::get('/', 'SalarySettingController@index')->name('salary-settings.index');
//   Route::post('/update/', 'SalarySettingController@update')->name('salary-settings.update');
//});
