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

// Socialite Route

Route::get('login/{provider}', 'SocialChannelController@redirectToProvider')
    ->where(['provider' => 'facebook|google|twitter']);

Route::get('login/{provider}/callback', 'SocialChannelController@handleProviderCallback')
    ->where(['provider' => 'facebook|google|twitter']);

/*// Socialite Route

Route::get('login/{provider}', 'Auth\LoginController@redirectToFacebookProvider')
    ->where(['provider' => 'facebook|google|twitter']);

Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderFacebookCallback')
    ->where(['provider' => 'facebook|google|twitter']);*/

// Facebook Zone

Route::group(['middleware' => [
    'auth'
]], function(){
    Route::get('/facebook/user', 'GraphController@retrieveUserProfile');

    Route::get('/facebook/page', 'GraphController@getFacebookPages')->name('facebook_page');

    Route::post('/facebook/user', 'GraphController@publishToProfile');

    Route::post('/facebook/page', 'GraphController@publishToPage');

    Route::get('/facebook/{name}/posts', 'GraphController@getFacebookPagePosts')->name('facebook.posts.show');
});

/*Route::get('/facebook/user', 'GraphController@retrieveUserProfile');

Route::get('/facebook/page', 'GraphController@getFacebookPages');

Route::post('/facebook/user', 'GraphController@publishToProfile');

Route::post('/facebook/page', 'GraphController@publishToPage');*/
