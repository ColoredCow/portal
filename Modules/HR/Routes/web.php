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
        Route::post('evaluation/segment/{segmentID}/delete', 'EvaluationController@deleteSegment')->name('hr.evaluation.segment.delete');
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

        Route::get('universities/reports', 'Universities\ReportController@index')->name('hr.universities.reports');
        Route::get('universities/{university}/reports/show', 'Universities\ReportController@jobWiseApplicationsData')->name('hr.universities.reports.show');

        Route::resource('universities/aliases', 'Universities\UniversityAliasController', [
            'names' => 'universities.aliases',
        ])->only(['update', 'destroy', 'store']);

        Route::resource('tags', 'TagsController')
            ->only(['index', 'edit', 'update', 'store', 'destroy'])
            ->names(['index' => 'hr.tags.index', 'edit' => 'hr.tags.edit', 'update' => 'hr.tags.update', 'store' => 'hr.tags.store', 'destroy' => 'hr.tags.delete']);

        Route::prefix('recruitment')->namespace('Recruitment')->group(function () {
            Route::get('application/{application}/handover', 'JobApplicationController@applicationHandoverRequest')->name('application.handover');
            Route::get('application/{application}/assign-to', 'JobApplicationController@acceptHandoverRequest')->name('application.handover.confirmation');
            Route::post('{applicant}/update-university', 'ApplicantController@updateUniversity')->name('hr.applicant.update-university');
            Route::get('reports', 'ReportsController@index')->name('recruitment.reports');
            Route::post('reports', 'ReportsController@searchBydate')->name('recruitment.report');
            Route::get('campaigns', 'CampaignsController@index')->name('recruitment.campaigns');
            Route::get('Dailyapplicationcount', 'ReportsController@index')->name('recruitment.reports.index');
            Route::get('reportsCard', 'ReportsController@showReportCard')->name('recruitment.daily-applications-count');
            Route::get('rejected-applications', 'ReportsController@rejectedApplications')->name('recruitment.rejected-applications');
            Route::get('applications/jobWiseApplicatonReport', 'ReportsController@jobWiseApplicationsGraph')->name('applications.job-Wise-Applications-Graph');
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
            Route::post('opportunities/{opportunity}/update-resources-count', 'RecruitmentOpportunityController@resourcesRequiredCount')->name('recruitment.opportunities.updateResources');

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

            Route::post('/store', 'JobController@storeJobdomain')->name('hr-job-domains.storeJobdomain');
            Route::post('/store-response/{id}', 'JobController@storeResponse')->name('response.store');
            Route::get('/desired-resume/{name}/{id}', 'JobController@showTable')->name('desired.resume');

            Route::resource('job', 'JobApplicationController')
                ->only(['index', 'edit', 'update', 'store'])
                ->names(['index' => 'applications.job.index', 'edit' => 'applications.job.edit', 'update' => 'applications.job.update', 'store' => 'applications.job.store']);
            Route::get('{application}/get-offer-letter', 'JobApplicationController@getOfferLetter')->name('applications.getOfferLetter');
            Route::get('{application}/save-offer-letter', 'JobApplicationController@saveOfferLetter');
            Route::post('{application}/sendmail', 'JobApplicationController@sendApplicationMail')->name('application.custom-email');
            Route::post('/teaminteraction', 'JobApplicationController@generateTeamInteractionEmail');
            Route::get('/finishinterview', 'JobApplicationController@markInterviewFinished')->name('markInterviewFinished');
            Route::get('/onHoldEmail', 'JobApplicationController@generateOnHoldEmail');

            Route::resource('internship', 'InternshipApplicationController')
                ->only(['index', 'edit'])
                ->names(['index' => 'applications.internship.index', 'edit' => 'applications.internship.edit']);
        });

        Route::resource('/evaluation', 'EvaluationController')->only(['show', 'update']);
        Route::get('/resources/', 'ResourcesController@index')->name('resources.index');
        Route::get('/resources/{jobId}/show/', 'ResourcesController@show')->name('resources.show');
        Route::post('/category/store/', 'ResourcesController@store')->name('resources.store');
        Route::post('/resources/create/', 'ResourcesController@create')->name('resources.create');
        Route::get('/resources/edit/', 'ResourcesController@edit')->name('resources.edit-modal');
        Route::put('/resources/update/{resource}', 'ResourcesController@update')->name('resources.update');
        Route::post('/resources/destroy/{resource}', 'ResourcesController@destroy')->name('resources.destroy');
        Route::post('/channel/create', 'HrChannelController@store')->name('channel.create');

        Route::get('/employee-basic-details/{employee}/', 'EmployeeController@basicDetails')->name('employees.basic.details');
        Route::resource('employees', 'EmployeeController')
            ->only(['index', 'show'])
            ->names([
                'index' => 'employees',
                'show' => 'employees.show',
            ]);
        Route::get('employee-reports', 'EmployeeController@reports')->name('employees.reports');
        Route::get('fte-handler/{domain_id}', 'EmployeeController@showFTEdata')->name('employees.alert');

        Route::resource('requisition', 'RequisitionController')
            ->only(['index', 'show'])
            ->names([
                'index' => 'requisition',
                'show' => 'requisition.show',
            ]);
        Route::post('store', 'RequisitionController@store')->name('requisition.store');
        Route::get('/completed/change-status/{jobRequisition}', 'RequisitionController@storecompleted');
        Route::get('/pending/{jobRequisition}', 'RequisitionController@storePending');
        Route::get('/complete', 'RequisitionController@showCompletedRequisition')->name('requisition.complete');

        Route::resource('designation', 'HrJobDesignationController')
        ->only(['index', 'show'])
        ->names([
            'index' => 'designation',
        ]);
        Route::post('/delete/{id}', 'HrJobDesignationController@destroy')->name('designation.delete');
        Route::get('/{id}/edit', 'HrJobDesignationController@edit')->name('designation.edit');
        Route::post('/store', 'HrJobDesignationController@storeDesignation')->name('hr-job-designation.storeJobDesignation');
    });
});
Route::get('applicantEmailVerification/{applicantEmail}/{applicationID}', 'Recruitment\ApplicantController@applicantEmailVerification')->name('applicant.email.verification');
Route::get('/viewForm/{id}/{email}', 'Recruitment\ApplicantController@viewForm')->name('hr.applicant.view-form');
Route::post('/storeApprovedApplicantDetails', 'Recruitment\ApplicantController@storeApprovedApplicantDetails')->name('hr.applicant.store-approved-applicants-details');
Route::get('/formSubmitted/{id}/{email}', 'Recruitment\ApplicantController@formSubmit')->name('hr.applicant.applicant-onboarding-form');
Route::get('/showApplicantFormDetails/{id}', 'Recruitment\ApplicantController@showOnboardingFormDetails')->name('hr.applicant.show-onboarding-applicant-form-details');
