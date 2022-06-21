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
Route::view('/{path?}', 'spa')
->where('path', '^(?!api|register|login|home|assets/background|admin|student|instructor).*$');

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
