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

Route::prefix('legaldocument')->middleware('auth')->group(function () {
    Route::get('/', 'LegalDocumentController@index')->name('legal-document.index');

    Route::prefix('/nda')->group(function () {
        Route::get('/', 'NDA\NDADocumentController@index')->name('legal-document.nda.index');
        Route::get('/templates', 'NDA\NDATemplateController@index')->name('legal-document.nda.template.index');
        Route::get('/template/preview', 'NDA\NDATemplateController@showPreview')->name('legal-document.nda.template.preview');
        Route::get('/template/create', 'NDA\NDATemplateController@create')->name('legal-document.nda.template.create');
        Route::post('/template/create', 'NDA\NDATemplateController@store')->name('legal-document.nda.template.store');
        Route::get('/template/{template_id}', 'NDA\NDATemplateController@show')->name('legal-document.nda.template.show');
        Route::post('/template/{template_id}/update', 'NDA\NDATemplateController@update')->name('legal-document.nda.template.update');

        Route::get('/email-templates/preview', 'NDA\NDATemplateController@showPreview')->name('legal-document.nda.email.template.preview');
        Route::get('/email-templates/create', 'NDA\NDATemplateController@create')->name('legal-document.nda.email.template.create');
        Route::post('/email-templates', 'NDA\NDATemplateController@store')->name('legal-document.nda.email.template.store');
        Route::get('/email-templates/{template_id}', 'NDA\NDATemplateController@show')->name('legal-document.nda.email.template.show');
        Route::post('/email-templates/{template_id}/update', 'NDA\NDATemplateController@update')->name('legal-document.nda.email.template.update');
    });
});
