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

Route::prefix('user')->middleware('auth')->group(function () {
    Route::get('/', 'UserController@index')->name('user.index');
    Route::get('get-roles', 'RolesController@getAllRoles')->name('user.role-all');
    Route::get('roles', 'RolesController@index')->name('user.role-index');
    Route::delete('{user}/delete', 'UserController@destroy')->name('user.delete');
    Route::put('update-roles', 'UserController@updateUserRoles')->name('user.update-roles');

    /*
     * User Profile
    */
    Route::get('/profile', 'ProfileController@index')->name('user.profile');
    Route::get('/user-settings', 'UserSettingsController@index')->name('user.settings');
    Route::post('/user-settings', 'UserSettingsController@update')->name('user.settings.update');
});
