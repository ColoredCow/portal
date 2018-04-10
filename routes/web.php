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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::redirect('/login', '/auth/google');

Route::get('home', 'HomeController@index')->name('home');

Route::get('logout', 'Auth\LoginController@logout');

Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::middleware('auth')->group(function () {
	Route::resource('hr/applicants', 'HR\ApplicantController');
	Route::resource('hr/jobs', 'HR\JobController');
	Route::resource('finance/invoices', 'Finance\InvoiceController');
	Route::resource('clients', 'ClientController');
	Route::resource('projects', 'ProjectController');
	Route::get('finance/invoices/download/{year}/{month}/{file}', 'Finance\InvoiceController@download');
	Route::resource('weeklydoses', 'WeeklyDoseController')->only([ 'index' ]);
	Route::get('clients/{client}/get-projects', 'ClientController@getProjects');
	Route::post('hr/applicant-round/{applicantRound}/sendmail', 'HR\ApplicantRoundController@sendMail');
	Route::resource('project/stages', 'ProjectStageController');
});

