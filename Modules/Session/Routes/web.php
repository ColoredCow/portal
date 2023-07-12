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

Route::prefix('session')->group(function() {
    Route::get('/', 'SessionController@index');
    Route::prefix('codetrek')->group(function(){
        Route::get('/{applicant}', 'CodeTrekSessionController@show')->name('codetrek.session.show');
        Route::post('/', 'CodeTrekSessionController@store')->name('codetrek.session.store');
        Route::put('/{session}', 'CodeTrekSessionController@update')->name('codetrek.session.update');
        Route::post('/{session_id}/{applicant_id}', 'CodeTrekSessionController@destroy')->name('codetrek.session.delete');
    });
});
