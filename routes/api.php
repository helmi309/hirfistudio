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

Route::resource('spl', 'SplController');
// Rute API tabel User
Route::resource('users', 'UserController');
Route::put('updatePass-users', 'UserController@updatePass');
Route::get('users-aktif/{id}', 'UserController@Activation');
Route::get('get-session', 'UserController@getSession');
Route::post('create-users-by-landingpage', 'UserController@createbylangdingpage');

Route::group(['namespace' => 'Auth'], function () {
    // Authentication routes...
    Route::get('get-login', 'LoginController@getLogin');
    Route::get('logout', 'LoginController@getLogout');
    Route::get('post-login', 'LoginController@getLogin');
    Route::post('post-login', 'LoginController@postLogin');
});
