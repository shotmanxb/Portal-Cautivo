<?php

use Illuminate\Http\Request;

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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

// for redirect to facebook auth.
Route::get('auth/login/facebook', 'SocialLoginController@facebookAuthRedirect');
// facebook call back after login success.
Route::get('auth/login/facebook/index', 'SocialLoginController@facebookSuccess');