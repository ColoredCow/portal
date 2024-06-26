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
    Route::get('/employee/{employee}/', 'SalaryController@employee')->name('salary.employee');
    Route::post('/employee/store/{employee}', 'SalaryController@storeOrUpdateSalary')->name('salary.employee.store');
    Route::post('/contractor/store/{employee}', 'SalaryController@storeOrUpdateContractorSalary')->name('salary.contractor.store');
    Route::post('{employee}/generate-appraisal-letter', 'SalaryController@generateAppraisalLetter')->name('salary.employee.generate-appraisal-letter');
});

Route::prefix('salary-settings')->middleware('auth')->group(function () {
    Route::get('/', 'SalarySettingController@index')->name('salary.settings');
    Route::post('/update/', 'SalarySettingController@update')->name('salary-settings.update');
});
