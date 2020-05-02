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

Route::prefix('prospect')->middleware('auth')->group(function () {
    Route::get('/', 'ProspectController@index')->name('prospect.index');
    Route::get('open-doc/{documentID}', 'ProspectController@openDocument')->name('prospect.open-doc');
    Route::get('{prospect}/checklist/{checklist_id}', 'ProspectChecklistController@show')->name('prospect.checklist.show');
    Route::post('{prospect}/checklist/{checklist_id}/update', 'ProspectChecklistController@update')->name('prospect.checklist.update');
    Route::get('/create', 'ProspectController@create')->name('prospect.create');
    Route::post('/new-progress-stage', 'ProspectController@newProgressStage')->name('prospect.new-stage');
    Route::post('/', 'ProspectController@store')->name('prospect.store');
    Route::get('/{prospect}/edit/{section?}', 'ProspectController@edit')->name('prospect.edit');
    Route::get('/{prospect}/{section?}', 'ProspectController@show')->name('prospect.show');
    Route::post('/{prospect}/update', 'ProspectController@update')->name('prospect.update');
    Route::post('/{prospect}/history', 'ProspectHistoryController@store')->name('prospect.history-store');
});

Route::get('test-doc', 'ProspectController@openDocument');
