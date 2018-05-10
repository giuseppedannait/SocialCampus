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
    return view('welcome');
});

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
