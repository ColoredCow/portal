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

Route::prefix('/hr')->group(function () {
	Route::resource('/jobs', 'Recruitment\JobController')->only(['store']);
	Route::resource('/applicants', 'Recruitment\ApplicantController')->only(['store']);
});
