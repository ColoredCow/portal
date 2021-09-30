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

Route::middleware('auth')->group(function () {
    Route::prefix('effort-tracking')->group(function () {
        Route::get('task', 'TasksController@index')->name('task.index');
        Route::get('task/{project}', 'TasksController@show')->name('task.show');
        Route::post('task', 'TasksController@store')->name('task.store');
        Route::put('task/{task}', 'TasksController@update')->name('task.update');
        Route::delete('task/{task}', 'TasksController@destroy')->name('task.destroy');
        Route::get('project/{project}', 'EffortTrackingController@show')->name('project.effort-tracking');
    });
});
