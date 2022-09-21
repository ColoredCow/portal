<?php

use Illuminate\Support\Facades\Route;

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

Route::prefix('operations')->group(function () {
    Route::get('/', 'OperationsController@index');
});
Route::resource('/officelocation', 'OfficeLocationController')
                ->only(['index', 'store', 'update', 'destroy'])
                ->names([
                    'index' => 'officelocation.index',
                    'store' => 'officelocation.store',
                    'update' => 'officelocation.update',
                    'destroy' => 'officelocation.destroy',
                ]);
