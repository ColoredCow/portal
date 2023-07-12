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
        Route::get('/{codeTrekApplicant}', 'CodeTrekSessionController@index')->name('codetrek.session.index');
        Route::post('/{codeTrekApplicant}', 'CodeTrekSessionController@store')->name('codetrek.session.store');
        Route::put('/session/{session}/codetrekapplicant/{codeTrekApplicant}', 'CodeTrekSessionController@update')->name('codetrek.session.update');
        Route::post('/session/{session}/codetrekapplicant/{codeTrekApplicant}', 'CodeTrekSessionController@destroy')->name('codetrek.session.delete');
    });
});
