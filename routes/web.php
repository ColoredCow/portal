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
        Route::get('gsuite-sync-all', 'UserController@syncAllWithGSuite')->name('profile.gsuite-sync-all');
    });

    Route::prefix('hr')->namespace('HR')->group(function () {
        Route::prefix('volunteers')->namespace('Volunteers')->group(function () {
            Route::get('reports', 'ReportsController@index')->name('volunteers.reports');
            Route::get('campaigns', 'CampaignsController@index')->name('volunteers.campaigns');
            Route::resource('opportunities', 'VolunteerOpportunityController')
                ->only(['index', 'store', 'update', 'edit'])
                ->names([
                    'index' => 'volunteer.opportunities',
                    'store' => 'volunteer.opportunities.store',
                    'update' => 'volunteer.opportunities.update',
                    'edit' => 'volunteer.opportunities.edit',
                ]);
        });

        Route::prefix('applications')->namespace('Applications')->group(function () {
            Route::get('volunteer/{application}/offer-letter', 'VolunteerApplicationController@viewOfferLetter')->name('applications.volunteer.offer-letter');

            Route::resource('volunteer', 'VolunteerApplicationController')
                ->only(['index', 'edit'])
                ->names([
                    'index' => 'applications.volunteer.index',
                    'edit' => 'applications.volunteer.edit',
                ]);
        });
    });

    Route::prefix('finance')->namespace('Finance')->group(function () {
        Route::resource('invoices', 'InvoiceController')
            ->except(['show', 'destroy'])
            ->names([
                'index' => 'invoices',
                'create' => 'invoices.create',
                'edit' => 'invoices.edit',
                'store' => 'invoices.store',
                'update' => 'invoices.update',
            ]);
        Route::resource('payments', 'PaymentController')
            ->except(['show', 'destroy'])
            ->names([
                'index' => 'payments.index',
                'create' => 'payments.create',
                'store' => 'payments.store',
                'edit' => 'payments.edit',
                'update' => 'payments.update',
            ]);
        Route::get('invoices/download/{year}/{month}/{file}', 'InvoiceController@download');
        Route::get('/reports', 'ReportsController@index');
    });

    // Route::resource('clients', 'ClientController')
    //     ->except(['show', 'destroy'])
    //     ->names(['index' => 'clients', 'create' => 'clients.create', 'edit' => 'clients.edit', 'store' => 'clients.store', 'update' => 'clients.update']);

    // Route::resource('projects-outdated', 'ProjectController')
    //     ->except(['destroy'])
    //     ->names(['index' => 'projects', 'create' => 'projects.create',
    //             'edit' => 'projects.edit', 'store' => 'projects.store',
    //             'update' => 'projects.update', 'show' => 'projects.show']);

    Route::post('projects/{project}/add-employee', 'ProjectController@addEmployee');
    Route::post('projects/{project}/remove-employee', 'ProjectController@removeEmployee');
    // Route::get('my-projects/{employee}', 'hr\Employees\EmployeeController@showProjects')->name('projects.my-projects');
    Route::get('clients/{client}/get-projects', 'ClientController@getProjects');

    Route::prefix('settings')->namespace('Settings')->group(function () {
        Route::get('/', 'SettingController@index')->name('settings.index');

        Route::prefix('permissions')->group(function () {
            Route::get('/', function () {
                return redirect(route('permissions.module.index', ['module' => 'users']));
            })->name('settings.permissions');

            Route::get('{module}', 'PermissionController@index')->name('permissions.module.index');
            Route::put('users/{id}', 'PermissionController@updateUserRoles')->name('permissions.module.update');
            Route::put('roles/{id}', 'PermissionController@updateRolePermissions')->name('permissions.module.update-role');
        });

        Route::prefix('hr')->group(function () {
            Route::get('/', 'HRController@index')->name('settings.hr');
            Route::post('update', 'HRController@update')->name('setting.hr.update');
        });

        Route::get('/nda-template', 'NDAAgreementController@index')->name('setting.agreement.nda');
        Route::get('/invoice-template', 'SettingController@invoiceTemplates')->name('setting.invoice');
        Route::post('/invoice-template', 'SettingController@updateInvoiceTemplates')->name('setting.invoice.update');
    });

    Route::prefix('knowledgecafe')->namespace('KnowledgeCafe')->group(function () {
        Route::get('/', 'KnowledgeCafeController@index')->name('knowledgecafe');
        Route::prefix('library')->namespace('Library')->group(function () {
            Route::resource('books', 'BookController')
                ->names([
                    'index' => 'books.index',
                    'create' => 'books.create',
                    'show' => 'books.show',
                    'store' => 'books.store',
                    'destroy' => 'books.delete',
                    'update' => 'books.update',
                ]);

            Route::prefix('book')->group(function () {
                Route::post('fetchinfo', 'BookController@fetchBookInfo')->name('books.fetchInfo');
                Route::post('markbook', 'BookController@markBook')->name('books.toggleReadStatus');
                Route::post('addtowishlist', 'BookController@addToUserWishList')->name('books.addToWishList');
                Route::get('disablesuggestion', 'BookController@disableSuggestion')->name('books.disableSuggestion');
                Route::get('enablesuggestion', 'BookController@enableSuggestion')->name('books.enableSuggestion');
                Route::get('mark-as-borrowed/{book}', 'BookController@markAsBorrowed')->name('books.markAsBorrowed');
                Route::get('put-back-to-library/{book}', 'BookController@putBackToLibrary')->name('books.putBack');
                Route::post('add-to-bam/{book}', 'BookController@selectBookForCurrentMonth')->name('books.addToBam');
                Route::get('put-back-to-library/{book}', 'BookController@putBackToLibrary')->name('books.putBack');
                Route::post('remove-from-bam/{book}', 'BookController@unselectBookFromCurrentMonth')->name('books.removeFromBam');
                Route::post('add-new-comment/{book}', 'BookController@addNewComment')->name('books.addNewComment');
                Route::post('{book}/comment', 'BookCommentController@store')->name('book-comment.store');
            });

            Route::resource('book-categories', 'BookCategoryController')
                ->only(['index', 'store', 'update', 'destroy'])
                ->names(['index' => 'books.category.index']);

            Route::get('book-a-month', 'BookController@bookAMonthIndex')->name('book.book-a-month.index');
        });
        Route::resource('weeklydoses', 'WeeklyDoseController')->only(['index'])->names(['index' => 'weeklydoses']);
    });

    Route::resource('comments', 'CommentController')->only(['update', 'destroy']);

    Route::get('/crm', 'Crm\CrmController@index')->name('crm');

    Route::get('user/read-books', 'UserBookController@index');
    Route::get('user/wishlist-books', 'UserBookController@booksInWishlist');
    Route::get('user/projects', 'UserController@projects');
});
