<?php

use Illuminate\Support\Facades\Route;
use App\http\Controller\OfficeLocationController;

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

Route::prefix('operations')->group(function() {
    Route::get('/', 'OperationsController@index');
});
Route::resource('/officelocation', 'OfficeLocationController')
                ->only(['index', 'store', 'update','destroy', 'getEmployee'])
                ->names([
                    'index' => 'officelocation.index',
                    'store' => 'officelocation.store',
                    'update' => 'officelocation.update',
                    'destroy' => 'officelocation.destroy',
                ]);

// Route::get('/delete/{id}', 'OfficeLocationController@delete')->name('officelocation.destroy');
// Route::get('/officelocation','OfficeLocationController@index')->name('officelocation.index');
// Route::post('/officelocationadd','OfficeLocationController@store');
// Route::put('/officelocationupdate/{id}', 'OfficeLocationController@update');