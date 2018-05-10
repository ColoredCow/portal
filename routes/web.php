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
    if (Auth::check()) {
        return redirect('home');
    }
    return redirect('login');
});

Auth::routes();

Route::get('home', 'HomeController@index')->name('home');

Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::middleware(['auth'])->group(function () {
    Route::resource('hr/applicants', 'HR\ApplicantController')->only(['index', 'edit']);
    Route::resource('hr/applicants/rounds', 'HR\ApplicantRoundController')->only(['store', 'update']);
    Route::resource('hr/jobs', 'HR\JobController')->except(['create', 'show', 'destroy']);
    Route::resource('finance/invoices', 'Finance\InvoiceController')->except(['show', 'destroy']);
    Route::resource('clients', 'ClientController')->except(['show', 'destroy']);
    Route::resource('projects', 'ProjectController')->except(['show', 'destroy']);
    Route::get('finance/invoices/download/{year}/{month}/{file}', 'Finance\InvoiceController@download');
    Route::resource('weeklydoses', 'WeeklyDoseController')->only(['index']);
    Route::get('clients/{client}/get-projects', 'ClientController@getProjects');
    Route::post('hr/applicant-round/{applicantRound}/sendmail', 'HR\ApplicantRoundController@sendMail');
    Route::resource('hr/rounds', 'HR\RoundController');
    Route::resource('project/stages', 'ProjectStageController')->only(['store', 'update']);
    Route::get('settings/{module}', 'SettingController@index');
    Route::post('settings/{module}/update', 'SettingController@update');
    Route::get('/knowledgecafe', 'KnowledgeCafe\KnowledgeCafeController@index');
    Route::resource('/knowledgecafe/library/books', 'KnowledgeCafe\Library\BookController')
                ->only(['index', 'create', 'store', 'show'])
                ->names([ 'index' => 'books.index', 'create' => 'books.create', 'show' => 'books.show', 'store' => 'books.store']);

    Route::post('/knowledgecafe/library/book/fetchinfo', 'KnowledgeCafe\Library\BookController@fetchBookInfo')->name('books.fetchInfo');
    Route::get('/finance/reports', 'Finance\ReportsController@index');
});

// Route::middleware(['auth', 'permission:view.finance_reports'])->group(function(){
// });
