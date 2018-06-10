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

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin', 'AdminController@index');
 
Route::get('/superadmin', 'SuperAdminController@index');

// User Controller
Route::resource('users', 'UserController');

// Social Controller
Route::resource('socials', 'SocialController');

// Social Channell
Route::resource('channels', 'SocialChannelController');

// Social Route

// Facebook Zone

Route::get('/login/facebook', 'Auth\LoginController@redirectToFacebookProvider');

Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderFacebookCallback');

Route::get('login/{provider}', 'Auth\LoginController@redirectToFacebookProvider')
    ->where(['provider' => 'facebook|google|twitter']);

Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderFacebookCallback')
    ->where(['provider' => 'facebook|google|twitter']);


Route::group(['middleware' => [
    'auth'
]], function(){
    Route::get('/user', 'GraphController@retrieveUserProfile');

    Route::get('/page', 'GraphController@getFacebookPages');

    Route::post('/user', 'GraphController@publishToProfile');

    Route::post('/page', 'GraphController@publishToPage');
});
