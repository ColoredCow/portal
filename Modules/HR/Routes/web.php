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
    Route::get('/evaluation/segments', 'EvaluationController@index')->name('hr.evaluation');
    Route::get('evaluation/segment/{segmentID}/parameters', 'EvaluationController@segmentParameters')->name('hr.evaluation.segment-parameters');
    // Route::get('evaluation/segment/{segmentID}/parameters', 'EvaluationController@segmentParameters')->name('hr.evaluation.segment-parameters');
    Route::post('evaluation/segment', 'EvaluationController@createSegment')->name('hr.evaluation.segment.store');
    Route::post('evaluation/segment/{segmentID}/update', 'EvaluationController@updateSegment')->name('hr.evaluation.segment.update');

    Route::post('evaluation/{segmentId}/parameter/create', 'EvaluationController@createSegmentParameter')->name('hr.evaluation.parameter.store');
    Route::post('evaluation/segment/{segmentID}/parameter/{parameterID}/update', 'EvaluationController@updateSegmentParameter')->name('hr.evaluation.parameter.update');
});

// Route::prefix('hr-new')->group(function () {
//     Route::get('/', 'HRController@index')->name('hr-new.index');
// });
