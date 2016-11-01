<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('index', function () {
    return view('index');
});
Route::get('login', function () {
    return view('login');
});
// for redirect to facebook auth.
Route::get('auth/login/facebook', 'SocialLoginController@facebookAuthRedirect');
// facebook call back after login success.
Route::get('auth/login/facebook/index', 'SocialLoginController@facebookSuccess');

Route::get('admin', function () {
    return view('admin_template');
});

Route::get('test', 'TestController@index');
Route::get('table', 'TestController@table');
Route::get('chartjs', 'TestController@chartjs');
Route::get('create', 'loginazo@index');
Route::post('store', 'loginazo@store');