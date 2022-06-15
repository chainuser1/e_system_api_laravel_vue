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
    // get the user via Passport 
    return $request->user();
});
// Route::post('/token','Auth\LoginController@getToken');
Route::post('/verify_srn','Auth\RegisterController@verifySrn')->name('api.auth.verify_srn');
Route::post('/register','Auth\RegisterController@create')->name('api.auth.register');
Route::post('/login','Auth\LoginController@store')->name('api.auth.login');
Route::middleware('auth:api')->delete('/logout','Auth\LoginController@destroy')->name('api.auth.logout');
// verify_srns

Route::middleware(['auth:api'])->group(function () {
    Route::apiResource('students', 'StudentController');
    Route::apiResource('personnels', 'PersonnelController');
});

