<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Toolkito\Larasap\SendTo;

class SocialSharingController extends Controller
{
    /**
     * Function For Telegram
     */

    public function sendTextMessageToTelegram()
    {
        SendTo::Telegram('Hello, This is testing Laravel social auto posting');
        dd('Youe message send successfully!!');
    }

    public function sendPhotoToTelegram()
    {
        SendTo::Telegram(
            'Hello, Im testing Laravel social auto posting', // Photo caption (Optional)
            [
                'type' => 'photo', // Message type (Required)
                'file' => 'https://i.imgur.com/j6bzKQc.jpg' // Image url (Required)
            ],
            '' // Inline keyboard (Optional)
        );
        dd('Youe message send successfully!!');
    }

    public function sendAudioToTelegram()
    {
        SendTo::Telegram(
            'Hello, Im testing Laravel social auto posting', // Audio caption (Optional)
            [
                'type' => 'audio', // Message type (Required)
                'file' => 'http://example.com/let-me-be-your-lover.mp3', // Audio url (Required) 
                'duration' => 208, // Duration of the audio in seconds (Optional)
                'performer' => 'Enrique Iglesias', // Performer (Optional)
                'title' => 'Let Me Be Your Lover' // Track name (Optional)
            ],
            '' // Inline keyboard (Optional)
        );
        dd('Youe message send successfully!!');
    }

    public function sendDocumentToTelegram()
    {
        SendTo::Telegram(
           'Hello, Im testing Laravel social auto posting', // Document caption
           [
               'type' => 'document', // Message type (Required)
               'file' => 'http://example.com/larasap.pdf', // Document url (Required)
           ],
          '' // Inline keyboard (Optional)
        );
        dd('Youe message send successfully!!');
    }

    public function sendVideoToTelegram()
    {
        SendTo::Telegram(
            'Hello, Im testing Laravel social auto posting', // Video caption (Optional)
            [
                'type' => 'video', // Message type (Required)
                'file' => 'http://example.com/let-me-be-your-lover.mp4', // Audio url (Required) 
                'duration' => 273, // Duration of sent video in seconds (Optional)
                'width' => 1920, // Video width (Optional)
                'height' => 1080 // Video height (Optional)
            ],
            '' // Inline keyboard (Optional)
        );
        dd('Youe message send successfully!!');
    }

    public function sendVoiceToTelegram()
    {
        SendTo::Telegram(
            'Hello, Im testing Laravel social auto posting', // Voice message caption (Optional)
            [
                'type' => 'voice', // Message type (Required)
                'file' => 'https://upload.wikimedia.org/wikipedia/en/9/9f/Sample_of_%22Another_Day_in_Paradise%22.ogg', // Audio url (Required) 
                'duration' => 28 // Duration of the voice message in seconds (Optional)
            ],
            '' // Inline keyboard (Optional)
        );
        dd('Youe message send successfully!!');
    }

    public function sendMediaGroupToTelegram()
    {
        SendTo::Telegram(
           null,
           [
               'type' => 'media_group', // Message type (Required)
               'files' => // Array describing photos and videos to be sent, must include 2–10 items
               [
                   [
                       'type' => 'photo', // Media type (Required)
                       'media' => 'https://i.imgur.com/j6bzKQc.jpg', // Media url (Required)
                       'caption' => 'Laravel sccial auto posting' // Media caption (Optional)
                   ],
                   [
                       'type' => 'video', // Media type (Required)
                       'media' => 'http://example.com/let-me-be-your-lover.mp4', // Media url (Required)
                       'caption' => 'Let me be your lover' // Media caption (Optional)
                   ]
               ]
           ]
        );
        dd('Youe message send successfully!!');
    }

    public function sendPointOnTheMapToTelegram()
    {
        SendTo::Telegram(
            null,
            [
                'type' => 'location', // Message type (Required)
                'latitude' => 36.1664345, // Latitude of the location (Required)
                'longitude' => 58.8209904, // Longitude of the location (Required)
                'live_period' => 86400, // Period in seconds for which the location will be updated (Optional)
                '' // Inline keyboard (Optional)
            ]    
        );
        dd('Youe message send successfully!!');
    }

    public function sendInformationAboutVenueToTelegram()
    {
        SendTo::Telegram(
            null,
            [
                'type' => 'venue', // Message type (Required)
                'latitude' => 36.166048, // Latitude of the location (Required)
                'longitude' => 58.822121, // Longitude of the location (Required)
                'title' => 'Khayyam', // Name of the venue (Required)
                'address' => 'Neyshabur, Razavi Khorasan Province, Iran', // Address of the venue (Required)
                'foursquare_id' => '', // Foursquare identifier of the venue (Optional)
                '' // Inline keyboard (Optional)
            ]
        );
        dd('Youe message send successfully!!');
    }

    public function sendMessageWithInlineButtonToTelegram()
    {
        SendTo::Telegram(
            'Laravel social auto posting',
            '',
            [
                [
                    [
                        'text' => 'Github',
                        'url' => 'https://github.com/toolkito/laravel-social-auto-posting'
                    ]
                ],
                [
                    [
                        'text' => 'Download',
                        'url' => 'https://github.com/toolkito/laravel-social-auto-posting/archive/master.zip'
                    ],
                ]
            ]
        );

        // OR

        SendTo::Telegram(
            'Laravel social auto posting',
            '',
            [
                [
                    [
                        'text' => 'Github',
                        'url' => 'https://github.com/toolkito/laravel-social-auto-posting'
                    ],
                    [
                        'text' => 'Download',
                        'url' => 'https://github.com/toolkito/laravel-social-auto-posting/archive/master.zip'
                    ],
                ]
            ]
        );

        dd('Youe message send successfully!!');
    }
    
    /**
     * Function For Twitter 
     */

    public function sendTextTweet()
    {
        SendTo::Twitter('Hello, Im testing Laravel social auto posting');
        dd('Youe message send successfully!!');
    }

    public function sendTweetWithMedia()
    {
        SendTo::Twitter(
            'Hello, Im testing Laravel social auto posting',
            [
                public_path('photo-1.jpg'),
                public_path('photo-2.jpg')
            ]
        );
        dd('Youe message send successfully!!');
    }


    /**
     * Function For Facebook
     */
    
    public function sendLinkToFacebook()
    {
        SendTo::Facebook(
            'link',
            [
                'link' => 'https://www.uniecampus.it',
                'message' => 'Messaggio Pubblicato dalla Piattaforma SocialCampus'
            ]
        );
        dd('Youe message send successfully!!');
    }

    public function sendPhotoToFacebook()
    {
        SendTo::Facebook(
            'photo',
            [
                'photo' => public_path('img/1.jpg'),
                'message' => 'Laravel social auto posting'
            ]
        );
        dd('Youe message send successfully!!');
    }

    public function sendVideoToFacebook()
    {
        SendTo::Facebook(
            'video',
            [
                'video' => public_path('upload/1.mp4'),
                'title' => 'Let Me Be Your Lover',
                'description' => 'Let Me Be Your Lover - Enrique Iglesias'
            ]
        );
        dd('Youe message send successfully!!');
    }

}