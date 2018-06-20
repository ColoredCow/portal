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

Route::middleware('auth')->group(function () {
    Route::prefix('profile')->group(function () {
        Route::get('gsuite-sync', 'UserController@syncWithGSuite')->name('profile.gsuite-sync');
    });

    Route::prefix('hr')->namespace('HR')->group(function () {
        Route::get('/', 'HRController@index');

        Route::prefix('recruitment')->namespace('Recruitment')->group(function () {
            Route::get('reports', 'ReportsController@index')->name('recruitment.reports');
            Route::get('campaigns', 'CampaignsController@index')->name('recruitment.campaigns');
        });

        Route::prefix('applications')->namespace('Applications')->group(function () {
            Route::resource('/evaluation', 'EvaluationController')->only(['show', 'update']);
            Route::resource('job', 'JobApplicationController')
                ->only(['index', 'edit', 'update'])
                ->names(['index' => 'applications.job.index', 'edit' => 'applications.job.edit', 'update' => 'applications.job.update']);
            Route::resource('internship', 'InternshipApplicationController')
                ->only(['index', 'edit'])
                ->names(['index' => 'applications.internship.index', 'edit' => 'applications.internship.edit']);
        });

        Route::prefix('employees')->namespace('Employees')->group(function () {
            Route::get('/', 'EmployeeController@index')->name('employees');
            Route::get('/{employee}', 'EmployeeController@show')->name('employees.show');
        });
        // A better version of employee-reports would be employees/reports. The
        // route below can be merged with employees grouped route above.
        Route::get('employee-reports', 'Employees\ReportsController@index')->name('employees.reports');

        Route::resource('applicants', 'ApplicantController')->only(['index', 'edit']);
        Route::resource('applications/rounds', 'ApplicationRoundController')->only(['store', 'update']);
        Route::resource('jobs', 'JobController')->except(['create', 'show', 'destroy']);
        Route::resource('rounds', 'RoundController')->only(['update'])->names(['update' => 'hr.round.update']);
        Route::post('application-round/{applicationRound}/sendmail', 'ApplicationRoundController@sendMail');
    });

    Route::prefix('finance')->namespace('Finance')->group(function () {
        Route::resource('invoices', 'InvoiceController')->except(['show', 'destroy']);
        Route::get('invoices/download/{year}/{month}/{file}', 'InvoiceController@download');
        Route::get('/reports', 'ReportsController@index');
    });

    Route::resource('clients', 'ClientController')->except(['show', 'destroy']);
    Route::resource('projects', 'ProjectController')
        ->except(['show', 'destroy'])
        ->names(['index' => 'projects', 'create' => 'projects.create', 'edit' => 'projects.edit', 'store' => 'projects.store', 'update' => 'projects.update']);

    Route::get('clients/{client}/get-projects', 'ClientController@getProjects');
    Route::resource('project/stages', 'ProjectStageController')->only(['store', 'update']);
    Route::get('settings/{module}', 'SettingController@index');
    Route::post('settings/{module}/update', 'SettingController@update');

    Route::prefix('knowledgecafe')->namespace('KnowledgeCafe')->group(function () {
        Route::get('/', 'KnowledgeCafeController@index');

        Route::prefix('library')->namespace('Library')->group(function () {
            Route::resource('books', 'BookController')
                ->names(['index' => 'books.index', 'create' => 'books.create', 'show' => 'books.show', 'store' => 'books.store']);

            Route::prefix('book')->group(function () {
                Route::post('fetchinfo', 'BookController@fetchBookInfo')->name('books.fetchInfo');
                Route::post('markbook', 'BookController@markBook')->name('books.toggleReadStatus');
                Route::post('addtowishlist', 'BookController@addToUserWishList')->name('books.addToWishList');
                Route::get('disablesuggestion', 'BookController@disableSuggestion')->name('books.disableSuggestion');
                Route::get('enablesuggestion', 'BookController@enableSuggestion')->name('books.enableSuggestion');
            });

            Route::resource('book-categories', 'BookCategoryController')
                ->only(['index', 'store', 'update', 'destroy'])
                ->names(['index' => 'books.category.index']);
        });

        Route::resource('weeklydoses', 'WeeklyDoseController')->only(['index'])->names(['index' => 'weeklydoses']);
    });
});
