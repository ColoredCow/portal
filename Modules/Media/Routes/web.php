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
use Illuminate\Support\Facades\Route;

Route::resource('media', 'MediaController')
->parameters([
    'media'=> 'media'
])
->names([
        'index' => 'media.index',
        'show' => 'media.show',
        'create' => 'media.create',
        'store' => 'media.store',
        'update' => 'media.update',
        'edit' => 'media.edit',
        'destroy' => 'media.destroy',
]);
Route::get('/search', 'MediaController@search');

/*
|Media Tags
*/

Route::resource('mediaTag', 'MediaTagController')
->parameters([
    'mediaTag'=> 'mediaTag'
])
->names([
        'index' => 'mediaTag.index',
        'store' => 'mediaTag.store',
        'update' => 'mediaTag.update',
        'destroy' => 'mediaTag.destroy',
        // 'show' => 'mediaTag.show',
        // 'create' => 'mediaTag.create',
        // 'edit' => 'mediaTag.edit',
]);
// Route::get('mediaTag', 'MediaTagController@index')->name('mediaTag.index');

// Route::prefix('media')->group(function () {
//     Route::get('/', function () {
//     });
// });
