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

Route::prefix('hr-new')->group(function () {
    Route::get('/', 'HRController@index')->name('hr-new.index');
    Route::get('/hiring', 'HiringController@index')->name('hr-new.hiring');
});

// Route::prefix('hr-new')->group(function () {
//     Route::get('/', 'HRController@index')->name('hr-new.index');
// });
