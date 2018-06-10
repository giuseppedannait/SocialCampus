<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use SammyK;
use Facebook;

class FacebookController extends Controller
{
    public function getUserInfo(SammyK\LaravelFacebookSdk\LaravelFacebookSdk  $fb)
    {
        try {
            $response = $fb->get('/me?fields=id,name,email', 'user-access-token');
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            dd($e->getMessage());
        }

        $userNode = $response->getGraphUser();
        printf('Hello, %s!', $userNode->getName());
    }

    public function showPages(SammyK\LaravelFacebookSdk\LaravelFacebookSdk  $fb)
    {
        try {
            $response = $fb->get('/me?fields=id,name,email');
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            dd($e->getMessage());
        }
    }
}
