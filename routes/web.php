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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin', 'AdminController@index');
 
Route::get('/superadmin', 'SuperAdminController@index');

Route::get('/sociallogin', 'LoginController@showLoginPage');

Route::get('/dashboard', 'LoginController@showDashBoard')
    ->middleware(['auth']);

// Route that check the provider and then perform the Login
Route::get('/logout', 'LoginController@logout');

//Route::get('/login/{provider}', 'LoginController@auth')
//    ->where(['provider' => 'facebook|google|twitter']);
//
//Route::get('/login/{provider}/callback', 'LoginController@login')
//    ->where(['provider' => 'facebook|google|twitter']);

//// Generate a login URL
//Route::get('/facebook/login', function(SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb)
//{
//    // Send an array of permissions to request
//    $login_url = $fb->getLoginUrl(['email']);
//
//    // Obviously you'd do this in blade :)
//    echo '<a href="' . $login_url . '">Login with Facebook</a>';
//});
//
//// Endpoint that is redirected to after an authentication attempt
//Route::get('/facebook/callback', function(SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb)
//{
//    // Obtain an access token.
//    try {
//        $token = $fb->getAccessTokenFromRedirect();
//    } catch (Facebook\Exceptions\FacebookSDKException $e) {
//        dd($e->getMessage());
//    }
//
//    // Access token will be null if the user denied the request
//    // or if someone just hit this URL outside of the OAuth flow.
//    if (! $token) {
//        // Get the redirect helper
//        $helper = $fb->getRedirectLoginHelper();
//
//        if (! $helper->getError()) {
//            abort(403, 'Unauthorized action.');
//        }
//
//        // User denied the request
//        dd(
//            $helper->getError(),
//            $helper->getErrorCode(),
//            $helper->getErrorReason(),
//            $helper->getErrorDescription()
//        );
//    }
//
//    if (! $token->isLongLived()) {
//        // OAuth 2.0 client handler
//        $oauth_client = $fb->getOAuth2Client();
//
//        // Extend the access token.
//        try {
//            $token = $oauth_client->getLongLivedAccessToken($token);
//        } catch (Facebook\Exceptions\FacebookSDKException $e) {
//            dd($e->getMessage());
//        }
//    }
//
//    $fb->setDefaultAccessToken($token);
//
//    // Save for later
//    Session::put('fb_user_access_token', (string) $token);
//
//    // Get basic info on the user from Facebook.
//    try {
//        $response = $fb->get('/me?fields=id,name,email');
//    } catch (Facebook\Exceptions\FacebookSDKException $e) {
//        dd($e->getMessage());
//    }
//
//    // Convert the response to a `Facebook/GraphNodes/GraphUser` collection
//    $facebook_user = $response->getGraphUser();
//
//    // Create the user if it does not exist or update the existing entry.
//    // This will only work if you've added the SyncableGraphNodeTrait to your User model.
//    $user = App\User::createOrUpdateGraphNode($facebook_user);
//
//    // Log the user into Laravel
//    Auth::login($user);
//
//    return redirect('/')->with('message', 'Successfully logged in with Facebook');
//});

// Send text message to Telegram Route
Route::get('send-text-message-to-telegram', 'SocialSharingController@sendTextMessageToTelegram');

// Send photo to Telegram Route
Route::get('send-photo-to-telegram', 'SocialSharingController@sendPhotoToTelegram');

// Send audio to Telegram Route
Route::get('send-audio-to-telegram', 'SocialSharingController@sendAudioToTelegram');

// Send document to Telegram Route
Route::get('send-document-to-telegram', 'SocialSharingController@sendDocumentToTelegram');

// Send video to Telegram Route
Route::get('send-video-to-telegram', 'SocialSharingController@sendVideoToTelegram');

// Send voice to Telegram Route
Route::get('send-voice-to-telegram', 'SocialSharingController@sendVoiceToTelegram');

// Send media group to Telegram Route
Route::get('send-media-group-to-telegram', 'SocialSharingController@sendMediaGroupToTelegram');

// Send point on the map to Telegram Route
Route::get('send-point-on-the-map-to-telegram', 'SocialSharingController@sendPointOnTheMapToTelegram');

// Send information about a venue to Telegram Route
Route::get('send-information-about-a-venue-to-telegram', 'SocialSharingController@sendInformationAboutVenueToTelegram');

// Send message with inline button to Telegram Route
Route::get('send-message-with-inline-button-to-telegram', 'SocialSharingController@sendMessageWithInlineButtonToTelegram');

// Send text tweet Route
Route::get('send-text-tweet', 'SocialSharingController@sendTextTweet');

// Send tweet with media Route
Route::get('send-tweet-with-media', 'SocialSharingController@sendTweetWithMedia');

// Send link to Facebook Route
Route::get('send-link-to-facebook', 'SocialSharingController@sendLinkToFacebook');

// Send photo to Facebook Route
Route::get('send-photo-to-facebook', 'SocialSharingController@sendPhotoToFacebook');

// Send video to Facebook Route
Route::get('send-video-to-facebook', 'SocialSharingController@sendVideoToFacebook');
