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

Route::prefix('contractsettings')->group(function() {
    Route::get('/', 'ContractSettingsController@index')->name('contractsettings.index');
    Route::post('/', 'ContractSettingsController@store')->name('contractsettings.store');
    Route::put('/', 'ContractSettingsController@update')->name('contractsettings.update');
    Route::post('/delete/{id}', 'ContractSettingsController@destroy')->name('contractsettings.delete');
    // Route::get('/', 'ContractSettingsController@edit')->name('contractsettings.edit');
});
