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

Route::prefix('infrastructure')->middleware('auth')->group(function () {
    Route::get('/s3-buckets', 'InfrastructureController@getS3Buckets')->name('infrastructure.s3-buckets.index');
    Route::get('/instances', 'InfrastructureController@getInstances')->name('infrastructure.ec2-instances.index');
    Route::get('/billing-details', 'InfrastructureController@getBillingDetails')->name('infrastructure.billing-details');
});
