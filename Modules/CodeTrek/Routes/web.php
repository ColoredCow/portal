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

Route::prefix('codetrek')->middleware('auth')->group(function () {
    Route::get('/', 'CodeTrekController@index')->name('codetrek.index');
    Route::post('/', 'CodeTrekController@store')->name('codetrek.store');
    Route::get('/edit/{applicant}', 'CodeTrekController@edit')->name('codetrek.edit');
    Route::post('/edit/{applicant}', 'CodeTrekController@update')->name('codetrek.update');
    Route::delete('/delete/{applicant}', 'CodeTrekController@delete')->name('codetrek.delete');
    Route::get('/evaluate/{applicant}', 'CodeTrekController@evaluate')->name('codetrek.evaluate');
    Route::post('/action/{applicant}', 'CodeTrekApplicantRoundDetailController@takeAction')->name('codetrek.action');
    Route::post('/update-feedback/{applicantDetail}', 'CodeTrekApplicantRoundDetailController@update')->name('codetrek.update-feedback');
    Route::post('/update-Status/{applicant}', 'CodeTrekApplicantRoundDetailController@updateStatus')->name('codetrek.updateStatus');

    Route::resource('session', 'SessionController')
            ->only(['index', 'edit', 'update', 'store'])
            ->names(['index' => 'codetrek.session.index', 'edit' => 'codetrek.session.edit', 'update' => 'codetrek.session.update', 'store' => 'codetrek.session.store']);
            
    Route::get('/session', 'SessionController@index')->name('codetrek.session.index');
    Route::get('/session/{applicant}', 'SessionController@show')->name('codetrek.session.show');
    Route::put('sessions/{session}', 'SessionController@update')->name('codetrek.session.update');
    Route::post('/session/{session_id}/{applicant_id}','SessionController@destroy')->name('codetrek.session.delete');           
});
