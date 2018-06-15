<?php

namespace App\Http\Controllers;

use Auth;
use App\SocialChannel;
use App\Social;
use App\User;

use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Laravel\Socialite\Contracts\User as ProviderUser;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\GraphController;

class SocialChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
//      $this->middleware('role:SOCIAL_SUPER_ADMIN');

    }


    public function index()
    {
        if(Auth::check()) {
            $user = Auth::user()->id;
            $role = Auth::user()->role;
        }

        $channels = SocialChannel::with('socials')->latest()->where('user_id',$user)->orderBy('name')->paginate();
        return view('channels.index', compact('channels', $channels));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        return view('channels.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SocialChannel  $socialChannel
     * @return \Illuminate\Http\Response
     */
    public function show($socialChannel)
    {

        $channel = SocialChannel::where('name', $socialChannel)->first();
        $posts = $this->getPosts($channel, 'facebook');
        return view('channels.show', ['channels' => $channel, 'posts' => $posts]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SocialChannel  $socialChannel
     * @return \Illuminate\Http\Response
     */
    public function edit(SocialChannel $socialChannel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SocialChannel  $socialChannel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SocialChannel $socialChannel)
    {
        //
    }

    public function add()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SocialChannel  $socialChannel
     * @return \Illuminate\Http\Response
     */
    public function destroy(SocialChannel $socialChannel)
    {
        //
    }

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        switch ($provider) {

            case 'facebook':
                return Socialite::driver('facebook')->scopes(["manage_pages", "publish_pages"])->redirect();
                break;
            case 'twitter':
                echo "i equals 1";
                break;
            case 'instagram':
                echo "i equals 2";
                break;
        }

    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request, $provider)
    {
        if (!$request->has('code') || $request->has('denied')) {
            return redirect('/');
        }

        $auth_user = Socialite::driver($provider)->user();

        switch ($provider) {

            case 'facebook':

                $user = User::updateOrCreate(
                    [
                        'email' => $auth_user->email
                    ],
                    [
                        'facebook_user_id' => $auth_user->id,
                        'facebook_access_token' => $auth_user->token,
                        'name'  =>  $auth_user->name
                    ]
                );

                $fb = new Facebook();

                $graph = new GraphController($fb);

                $pages = $graph->getFacebookPagesToArray();

                $type = 'Page';
                $social = Social::where('name', 'facebook')
                    ->pluck('id')
                    ->first();
                $user_id = Auth::user()->id;

                foreach ($pages as $id => $details) {
                    $social_channel = SocialChannel::updateOrCreate(['id' => $id], [
                        'name' => $details['name'],
                        'type' => $type,
                        'category' => $details['category'],
                        'access_token' => $details['access_token'],
                        'social_id' => $social,
                        'user_id' => $user_id
                    ]);
                }

                break;

            case 'twitter':
                echo "twitter";
                break;

            case 'instagram':
                echo "instagram";
                break;
        }

        return redirect()->to('/channels'); // Redirect to a secure page
    }

    public function getPosts(SocialChannel $socialChannel, $provider){

        switch ($provider) {

            case 'facebook':

                $fb = new Facebook();
                $graph = new GraphController($fb);

                $posts = $graph->getFacebookPagePosts($socialChannel->name);

                return $posts;

                break;

            case 'twitter':
                echo "twitter";
                break;

            case 'instagram':
                echo "instagram";
                break;
        }

    }

}
