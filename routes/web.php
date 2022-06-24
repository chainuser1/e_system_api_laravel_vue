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

// any web route goes here
// where any not equal to api or login or register goes to spa.blade.php
// Route::view('/{path?}', 'spa')->where('path', '^(?!api).*$');
// include public folders for downloading files

Route::view('/{path?}', 'spa')
->where('path', '^(?!api|register|login|home|assets|admin|student|instructor|activities).*$');

// Route::get('/', function () {
//     return view('spa');
// });

// Auth::routes(['verify'=>true]);

// Route::get('/home', 'HomeController@index')->name('home');

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

// routes to load pictures
Route::get('/assets/background', function () {
    return response()->file(public_path('assets/images/background_image.jpg'));
});

Route::get('/activities/{filename}/download', function ($filename) {
    return response()->download(storage_path('app/activities/files/').$filename);
});
// Storage path for uploaded files

