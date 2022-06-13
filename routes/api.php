<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// Route::post('/token','Auth\LoginController@getToken');
Route::post('/verify_srn','Auth\RegisterController@verifySrn')->name('api.auth.verify_srn');
Route::post('/register','Auth\RegisterController@register')->name('api.auth.register');
Route::post('/login','Auth\LoginController@store')->name('api.auth.login');
Route::delete('/logout','Auth\LoginController@destroy')->name('api.auth.logout');
Route::apiResource('students', 'StudentController')->only(['index', 'show']);
Route::middleware(['auth:api'])->group(function () {
    Route::apiResource('students', 'StudentController')->only([
         'store', 'update', 'destroy'
    ]);
    Route::apiResource('personnels', 'PersonnelController');
});

