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

Route::get('appointment-slots/select/{user_id}', 'AppointmentSlotsController@showAppointments')
    ->name('select-appointments');
Route::post('appointment-slots/selected', 'AppointmentSlotsController@appointmentSelected');

Route::middleware('auth')->group(function () {
    Route::get('userappointmentslots/{user}', 'UserAppointmentSlotsController@show')
    ->name('userappointmentslots.show');
    Route::post('userappointmentslots', 'UserAppointmentSlotsController@store')
    ->name('userappointmentslots.store');
    Route::patch('userappointmentslots/{appointmentSlot}', 'UserAppointmentSlotsController@update');
    Route::delete('userappointmentslots/{appointmentSlot}', 'UserAppointmentSlotsController@destroy');
    Route::get('/user_appointments', 'AppointmentSlotsController@index')->name('userappointments.show');
    Route::post('/user_appointments', 'AppointmentSlotsController@update')->name('userappointments.show.update');
});
