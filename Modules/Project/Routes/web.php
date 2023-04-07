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

Route::prefix('projects')->middleware('auth')->group(function () {
    Route::get('/', 'ProjectController@index')->name('project.index');
    Route::get('/{project}/edit', 'ProjectController@edit')->name('project.edit');
    Route::get('/{project}/show', 'ProjectController@show')->name('project.show');
    Route::get('/create', 'ProjectController@create')->name('project.create');
    Route::post('/', 'ProjectController@store')->name('project.store');
    Route::post('/{project}/update', 'ProjectController@update')->name('project.update');
    Route::get('/contract/pdf/{contract}', 'ProjectController@showPdf')->name('pdf.show');
    Route::delete('client/{project}/edit', 'ProjectController@destroy')->name('project.destroy');
    Route::get('/project-fte-export', 'ProjectController@projectFTEExport')->name('project.fte.export');
    Route::get('/project-resource', 'ProjectController@projectResource')->name('project.resource-requirement');
    //Route::get('/', 'ProjectController@edit')->name('project.edit');
});
