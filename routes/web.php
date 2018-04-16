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
	Route::resource('hr/applicants', 'HR\ApplicantController')->except(['create', 'show', 'destroy']);;
	Route::resource('hr/jobs', 'HR\JobController')->except(['create', 'show', 'destroy']);
	Route::resource('finance/invoices', 'Finance\InvoiceController')->except(['show', 'destroy']);;
	Route::resource('clients', 'ClientController')->except(['show', 'destroy']);
	Route::resource('projects', 'ProjectController')->except(['show', 'destroy']);;
	Route::get('finance/invoices/download/{year}/{month}/{file}', 'Finance\InvoiceController@download');
	Route::resource('weeklydoses', 'WeeklyDoseController')->only([ 'index' ]);
	Route::get('clients/{client}/get-projects', 'ClientController@getProjects');
	Route::post('hr/applicant-round/{applicantRound}/sendmail', 'HR\ApplicantRoundController@sendMail');
	Route::resource('hr/rounds', 'HR\RoundController');
	Route::resource('project/stages', 'ProjectStageController')->only([ 'store', 'update' ]);
	Route::get('settings', 'SettingController@index');
	Route::post('settings/update', 'SettingController@update');
});

