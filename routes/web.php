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

// Social Channel
Route::resource('channels', 'SocialChannelController');

Route::get('/channel/posts/{id}', 'SocialChannelController@posts')->name('channels.posts');

Route::get('/channel/{id}/posts/{post}/comments', 'SocialChannelController@comments')->name('channels.posts.comments');

Route::get('/channel/{channel_id}/posts/{post_id}/comment/add', 'SocialChannelController@addComment')->name('channels.post.comment.add');

Route::put('/channel/{channel_id}/posts/{post_id}/comment/publish', 'SocialChannelController@publishComment')->name('channels.post.comment.publish');

Route::get('/channel/add', 'SocialChannelController@add')->name('channels.add');

Route::put('/channel/post', 'SocialChannelController@publish')->name('channel.post');

Route::get('/channel/{id}/posts/delete/{post}', 'SocialChannelController@delete')->name('channels.posts.delete');


// Socialite Route

Route::get('login/{provider}', 'SocialChannelController@redirectToProvider')
    ->where(['provider' => 'facebook|instagram|twitter']);

Route::get('login/{provider}/callback', 'SocialChannelController@handleProviderCallback')
    ->where(['provider' => 'facebook|instagram|twitter']);

/*// Socialite Route

Route::get('login/{provider}', 'Auth\LoginController@redirectToFacebookProvider')
    ->where(['provider' => 'facebook|google|twitter']);

Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderFacebookCallback')
    ->where(['provider' => 'facebook|google|twitter']);*/

// Facebook Zone

Route::group(['middleware' => [
    'auth'
]], function(){
    Route::get('/facebook/user', 'FacebookController@retrieveUserProfile');

    Route::get('/facebook/page', 'FacebookController@getFacebookPages')->name('facebook_page');

    Route::post('/facebook/user', 'FacebookController@publishToProfile');

    Route::post('/facebook/page', 'FacebookController@publishToPage');

    Route::get('/facebook/{name}/posts', 'FacebookController@getFacebookPagePosts')->name('facebook.posts.show');

    Route::get('/twitter/{id}/posts', 'TwitterController@getTweetFromChannel')->name('twitter.posts.show');
});

/*Route::get('/facebook/user', 'FacebookController@retrieveUserProfile');

Route::get('/facebook/page', 'FacebookController@getFacebookPages');

Route::post('/facebook/user', 'FacebookController@publishToProfile');

Route::post('/facebook/page', 'FacebookController@publishToPage');*/
