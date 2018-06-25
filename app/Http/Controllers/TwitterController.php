<?php

namespace App\Http\Controllers;

use App\SocialChannel;

use Illuminate\Http\Request;
use Twitter;

use File;

class TwitterController extends Controller
{
    public function publishToChannel($channel, $post){

        $page = new SocialChannel();

        $page_access_token = $page::where('id', $channel)
            ->pluck('access_token')
            ->first();

        $page_access_token_secret = $page::where('id', $channel)
            ->pluck('access_token_secret')
            ->first();

        Twitter::reconfig([
            'consumer_key' => env('TWITTER_CONSUMER_KEY'),
            'consumer_secret' => env('TWITTER_CONSUMER_SECRET'),
            'token' => $page_access_token,
            'secret' => $page_access_token_secret
        ]);

        $tw_response="";

        switch ($post['type']) {

            case 'simple':

                try {
                    $tw_response = Twitter::postTweet(['status' => $post['message'], 'format' => 'json']);
                }
                catch (Exception $e)
                {
                    dd($e);
                }

                break;

            case 'image' :

                if($post['source']) {
                    $uploaded_media = Twitter::uploadMedia(['media' => File::get($post['source'])]);
                }
                else {
                    $uploaded_media="";
                }

                try {
                    $tw_response = Twitter::postTweet(['status' => $post['message'],'media_ids' => $uploaded_media->media_id_string]);
                }
                catch (Exception $e)
                {
                    dd($e);
                }

                break;

            case 'link':

                if($post['link']) {
                    $tweet = $post['message'].' '.$post['link'];
                }
                else {
                    $tweet = $post['message'];
                }

                try {
                    $tw_response = Twitter::postTweet(['status' => $tweet, 'format' => 'json']);
                }
                catch (Exception $e)
                {
                    dd($e);
                }

                break;
        }

        return $tw_response;

    }

    public function getTweetFromChannel($channel){

        $page = new SocialChannel();

        $page_access_token = $page::where('id', $channel)
            ->pluck('access_token')
            ->first();

        $page_access_token_secret = $page::where('id', $channel)
            ->pluck('access_token_secret')
            ->first();

        $page_name = $page::where('id', $channel)
            ->pluck('name')
            ->first();



        Twitter::reconfig([
            'consumer_key' => env('TWITTER_CONSUMER_KEY'),
            'consumer_secret' => env('TWITTER_CONSUMER_SECRET'),
            'token' => $page_access_token,
            'secret' => $page_access_token_secret
        ]);

        $tw_response="";

        try {

            $tw_response = Twitter::getUserTimeline(['screen_name' => $page_name, 'count' => 20, 'format' => 'array']);

        } catch (Exception $e) {
            dd($e); // handle exception
        }

        return $tw_response;

    }
}
