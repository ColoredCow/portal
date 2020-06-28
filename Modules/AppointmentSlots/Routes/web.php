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

Route::prefix('appointmentslots')->group(function () {
    Route::get('/', 'AppointmentSlotsController@index');
});

Route::get('appointment-slots/select/{user_id}', 'AppointmentSlotsController@showAppointments')->name('select-appointments');
Route::post('appointment-slots/selected', 'AppointmentSlotsController@appointmentSelected');
