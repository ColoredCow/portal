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
