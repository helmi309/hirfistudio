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

// Configuration home template user mobile
Route::get('/', function () {
    return view('home');
});

// Configuration dashboard/backoffice
Route::get('/backoffice', ['as' => 'backoffice', 'uses' => 'PageController@backoffice']);

// Configuration signup template user mobile
Route::get('/signup', ['as' => 'signup', 'uses' => 'PageController@signup']);

// Configuration signin template user mobile
Route::get('/signin', ['as' => 'signin', 'uses' => 'PageController@getLogin']);

// Configuration form template user mobile
Route::get('/form', ['as' => 'form', 'uses' => 'PageController@form']);

// Configuration form_spl template user mobile
Route::get('/form_spl', ['as' => 'form_spl', 'uses' => 'PageController@form_spl']);

// Configuration contact template user mobile
Route::get('/contact', ['as' => 'contact', 'uses' => 'PageController@contact']);

// Configuration location template user mobile
Route::get('/location', ['as' => 'location', 'uses' => 'PageController@location']);

// Configuration employee template user mobile
Route::get('/employee', ['as' => 'employee', 'uses' => 'PageController@employee']);

// Configuration galerry template user mobile
Route::get('/galerry', ['as' => 'galerry', 'uses' => 'PageController@galerry']);
Route::get('give-me-token', ['as' => 'token', 'uses' => 'PageController@token']);

//Auth::routes();
//
//Route::get('/home', 'HomeController@index')->name('home');
