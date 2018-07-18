<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

use GuzzleHttp\Client;

use App\SocialChannel;

class InstagramController extends Controller
{
    private $client;
    private $access_token;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.instagram.com/v1/',
        ]);
    }

    public function setAccessToken($token)
    {
        $this->access_token = $token;
    }

    public function getUser()
    {
        if ($this->access_token) {
            $response = $this->client->request('GET', 'users/self/', [
                'query' => [
                    'access_token' => $this->access_token
                ]
            ]);
            return json_decode($response->getBody()->getContents())->data;
        }
        return [];
    }

    /**
     * @param $channel
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getInstagramPosts($channel)
    {
        $page = new SocialChannel();

        $page_access_token = $page::where('id', $channel)
            ->pluck('access_token')
            ->first();

        $ig_response = "";

        try {

            $ig_response = $this->client->request('GET', 'users/self/media/recent/',
                [
                    'query' => [
                        'access_token' => $page_access_token
                    ]
                ]);

        } catch (GuzzleException $e) {
            dd($e); // handle exception
        }
        return json_decode($ig_response->getBody()->getContents())->data;
    }

    public function getInstagramCommentOnPosts($channel, $id_post)
    {
        $page = new SocialChannel();

        $page_access_token = $page::where('id', $channel)
            ->pluck('access_token')
            ->first();

        $ig_response = "";

        try {

            $ig_response = $this->client->request('GET', 'media/' . $id_post . '/comments',
                [
                    'query' => [
                        'access_token' => $page_access_token
                    ]
                ]);

        } catch (GuzzleException $e) {
            dd($e);
        }

        return json_decode($ig_response->getBody()->getContents())->data;
    }

    public function getMediaId($URL) {

        $api = file_get_contents("http://api.instagram.com/oembed?callback=&url=" . $URL);
        $media_id = json_decode($api,true)['media_id'];

        return $media_id;

    }

    public function publishToChannel($channel, $post){

       //

    }

    public function deleteInstagramPost($channel, $post){

        $page = new SocialChannel();

        $page_access_token = $page::where('id', $channel)
            ->pluck('access_token')
            ->first();

        $ig_response = "";

        try {

            $ig_response = $this->client->request('DELETE', 'media/' . $post,
                [
                    'query' => [
                        'access_token' => $page_access_token
                    ]
                ]);

        } catch (GuzzleException $e) {
            dd($e);
        }

        return json_decode($ig_response->getBody()->getContents())->data;

    }
}

