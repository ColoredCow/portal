<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('knowledgecafe')->namespace('KnowledgeCafe')->group(function () {
    Route::prefix('library')->namespace('Library')->group(function () {
        Route::get('book/getList', 'BookController@getBookList');
        Route::get('book/getCount', 'BookController@getBooksCount');
    });
    Route::resource('weeklydoses', 'WeeklyDoseController')->only(['store']);
});
