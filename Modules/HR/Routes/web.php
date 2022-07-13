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
    Route::prefix('hr-new')->group(function () {
        Route::get('/hiring', 'HiringController@index')->name('hr-new.hiring');
        Route::get('/evaluation/segments', 'EvaluationController@index')->name('hr.evaluation');
        Route::get('evaluation/segment/{segmentID}/parameters', 'EvaluationController@segmentParameters')->name('hr.evaluation.segment-parameters');
        // Route::get('evaluation/segment/{segmentID}/parameters', 'EvaluationController@segmentParameters')->name('hr.evaluation.segment-parameters');
        Route::post('evaluation/segment', 'EvaluationController@createSegment')->name('hr.evaluation.segment.store');
        Route::post('evaluation/segment/{segmentID}/update', 'EvaluationController@updateSegment')->name('hr.evaluation.segment.update');

        Route::post('evaluation/{segmentId}/parameter/create', 'EvaluationController@createSegmentParameter')->name('hr.evaluation.parameter.store');
        Route::post('evaluation/segment/{segmentID}/parameter/{parameterID}/update', 'EvaluationController@updateSegmentParameter')->name('hr.evaluation.parameter.update');
        Route::post('evaluation/segment/{segmentID}/parameter/{parameterID}/update-parent', 'EvaluationController@updateSegmentParameterParent')->name('hr.evaluation.parameter.update-parent');
    });

    Route::prefix('hr')->group(function () {
        Route::resource('universities', 'Universities\UniversityController')->except(['show']);
        Route::resource('universities/contacts', 'Universities\UniversityContactController')
            ->only(['update', 'destroy', 'store'])
            ->names([
                'update' => 'universities.contacts.update',
                'destroy' => 'universities.contacts.destroy',
                'store' => 'universities.contacts.store',
            ]);
        Route::get('universities/reports', 'Universities\ReportController@index')->name('universities.reports');

        Route::resource('universities/aliases', 'Universities\UniversityAliasController', [
            'names' => 'universities.aliases',
        ])->only(['update', 'destroy', 'store']);

        Route::resource('tags', 'TagsController')
            ->only(['index', 'edit', 'update', 'store', 'destroy'])
            ->names(['index' => 'hr.tags.index', 'edit' => 'hr.tags.edit', 'update' => 'hr.tags.update', 'store' => 'hr.tags.store', 'destroy' => 'hr.tags.delete']);

        Route::prefix('recruitment')->namespace('Recruitment')->group(function () {
            Route::post('{applicant}/update-university', 'ApplicantController@updateUniversity')->name('hr.applicant.update-university');
            Route::get('reports', 'ReportsController@index')->name('recruitment.reports');
            Route::post('reports', 'ReportsController@searchBydate')->name('recruitment.report');
            Route::get('campaigns', 'CampaignsController@index')->name('recruitment.campaigns');
            Route::resource('opportunities', 'RecruitmentOpportunityController')
                ->only(['index', 'create', 'store', 'update', 'edit', 'destroy'])
                ->names([
                    'index' => 'recruitment.opportunities',
                    'create' => 'recruitment.opportunities.create',
                    'store' => 'recruitment.opportunities.store',
                    'update' => 'recruitment.opportunities.update',
                    'edit' => 'recruitment.opportunities.edit',
                    'destroy' => 'recruitment.opportunities.destroy',
                ]);
            Route::resource('rounds', 'RoundController')->only(['update'])->names(['update' => 'hr.round.update']);

            Route::resource('applicants', 'ApplicantController')->only(['index', 'edit']);
            Route::get('/applicant/create', 'ApplicantController@create')->name('hr.applicant.create');
            Route::post('/applicant', 'ApplicantController@store')->name('hr.applicant.store');
            Route::get('/applicant/details/show/{applicationID}', 'ApplicantController@show')->name('hr.applicant.details.show');
            Route::post('/excel-import', 'ApplicantController@importExcel')->name('hr.applications.excel-import');

            Route::resource('applications/rounds', 'ApplicationRoundController')->only(['store', 'update', 'storeReason']);
            Route::post('/applicationround/{applicationRound}/mail-content/{status}', 'ApplicationRoundController@getMailContent');
            Route::post('/applicationround/{applicationRound}/follow-up', 'ApplicationRoundController@storeFollowUp')->name('hr.application-round.follow-up.store');
            Route::post('/application-round/{applicationRound}/sendmail', 'ApplicationRoundController@sendMail');

            Route::get('job/{application}/offer-letter', 'JobApplicationController@viewOfferLetter')->name('applications.job.offer-letter');
            Route::get('internship/{application}/offer-letter', 'InternshipApplicationController@viewOfferLetter')->name('applications.internship.offer-letter');

            Route::resource('job', 'JobApplicationController')
                ->only(['index', 'edit', 'update', 'store'])
                ->names(['index' => 'applications.job.index', 'edit' => 'applications.job.edit', 'update' => 'applications.job.update', 'store' => 'applications.job.store']);
            Route::get('{application}/get-offer-letter', 'JobApplicationController@getOfferLetter')->name('applications.getOfferLetter');
            Route::post('{application}/sendmail', 'JobApplicationController@sendApplicationMail')->name('application.custom-email');

            Route::resource('internship', 'InternshipApplicationController')
                ->only(['index', 'edit'])
                ->names(['index' => 'applications.internship.index', 'edit' => 'applications.internship.edit']);
        });

        Route::resource('/evaluation', 'EvaluationController')->only(['show', 'update']);
        Route::get('/resources/', 'ResourcesController@index')->name('resources.index');
        Route::get('/resources/{jobId}/show/', 'ResourcesController@show')->name('resources.show');
        Route::post('/category/store/', 'ResourcesController@store')->name('resources.store');
        Route::post('/resources/create/', 'ResourcesController@create')->name('resources.create');
    });
});
Route::get('applicantEmailVerification/{applicantEmail}/{applicationID}', 'Recruitment\ApplicantController@applicantEmailVerification')->name('applicant.email.verification');
