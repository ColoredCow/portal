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

Route::prefix('codetrek')->group(function () {
    Route::get('/', 'CodeTrekController@index')->name('codetrek.index');
    Route::post('/', 'CodeTrekController@store')->name('codetrek.store');
    Route::get('/edit/{applicant}', 'CodeTrekController@edit')->name('codetrek.edit');
    Route::post('/edit/{applicant}', 'CodeTrekController@update')->name('codetrek.update');
    Route::get('/{applicant}', 'CodeTrekController@delete')->name('codetrek.delete');
    Route::get('/evaluate/{applicant}','CodeTrekController@evaluate')->name('codetrek.evaluate');
    Route::post('/action/{applicant}', 'CodeTrekApplicantRoundDetailController@takeAction')->name('action');
    Route::post('/update-feedback/{applicant}', 'CodeTrekApplicantRoundDetailController@update')->name('update-feedback');

});
