<?php

namespace App\Http\Controllers;

use Auth;
use App\SocialChannel;
use App\Social;
use App\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Laravel\Socialite\Contracts\User as ProviderUser;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\FacebookController;

use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;

use Twitter;

use App\Http\Controllers\InstagramController;

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

        $channel = SocialChannel::where('id', $socialChannel)->with('socials')->first();

        $provider_id = SocialChannel::with('socials')->where('id', $socialChannel)->pluck('social_id')->first();
        $provider = Social::where('id', $provider_id)->where('id', $provider_id)->pluck('name')->first();

        $posts = $this->getPosts($channel, $provider);
        return view('channels.show', ['channels' => $channel, 'posts' => $posts, 'provider' => $provider]);
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
        if(Auth::check()) {
            $user = Auth::user()->id;
            $role = Auth::user()->role;
        }

        $channels = SocialChannel::with('socials')->latest()->where('user_id',$user)->orderBy('name')->paginate();
        return view('channels.add', compact('channels', $channels));
    }

    public function publish(Request $request)
    {
        $post=[];
        $post['type']='simple';

        $post['message'] = $request->input('message');

        if ($request->source) {

            $fileName = "SocialCampus".time().'.'.request()->source->getClientOriginalExtension();

            $post['source'] = storage_path('app/').$request->source->storeAs('images',$fileName);
            $post['type'] = 'image';
        }

        if ($request->input('link')) { $post['link'] = $request->input('link'); $post['type'] = 'link';}

        $channels = $request->input('channels');

        foreach($channels as $channel)
        {
            $provider_id = SocialChannel::with('socials')->where('id', $channel)->pluck('social_id')->first();
            $provider = Social::where('id', $provider_id)->where('id', $provider_id)->pluck('name')->first();

            switch ($provider) {

                case 'facebook':

                    $fb = new Facebook();

                    $graph = new FacebookController($fb);

                    $post[$channel] = $graph->publishToPage($channel, $post);

                    break;

                case 'twitter':

                    $tw = new TwitterController();

                    $post[$channel] = $tw->publishToChannel($channel, $post);

                    break;

                case 'instagram':
                    echo "i equals 2";
                    break;
            }
        }

        if ($post) {
            session()->flash('status', ' Post inserito correttamente');
        }
        else{
            session()->flash('status', ' Post non inserito. Controllare eventuali errori segnalati.');
        }

        return redirect()->action('SocialChannelController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SocialChannel  $socialChannel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $channel = SocialChannel::find($id);
        $channel->delete();

        // redirect
        session()->flash('status', 'Canale correttamente eliminato.');
        return redirect()->action('SocialChannelController@index');
    }

    public function posts($socialChannel)
    {
        $channel = SocialChannel::where('id', $socialChannel)->with('socials')->first();

        $provider_id = SocialChannel::with('socials')->where('id', $socialChannel)->pluck('social_id')->first();
        $provider = Social::where('id', $provider_id)->where('id', $provider_id)->pluck('name')->first();

        $posts = $this->getPosts($channel, $provider);
        return view('channels.posts', ['channels' => $channel, 'posts' => $posts, 'provider' => $provider]);
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
                return Socialite::driver('facebook')->scopes(["manage_pages", "publish_pages", "instagram_basic"])->redirect();
                break;
            case 'twitter':
                return Socialite::driver('twitter')->redirect();
                break;
            case 'instagram':
                return Socialite::with('instagram')->redirect();
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

        $auth_user = Socialite::driver($provider)->user();

        switch ($provider) {

            case 'facebook':

                if (!$request->has('code') || $request->has('denied')) {
                    return redirect('/');
                }

                /*$user = User::updateOrCreate(
                    [
                        'email' => $auth_user->email
                    ],
                    [
                        'facebook_user_id' => $auth_user->id,
                        'facebook_access_token' => $auth_user->token,
                        'name'  =>  $auth_user->name
                    ]
                );*/

                $type = 'Profile';
                $category = 'Personal Account';
                $url = 'https://www.facebook.com/profile.php?';

                $social = Social::where('name', 'facebook')
                    ->pluck('id')
                    ->first();

                $user_id = Auth::user()->id;

                $social_channel = SocialChannel::updateOrCreate(
                        [
                            'channel_id' => $auth_user->id,
                            'user_id' => $user_id
                        ],
                        [
                            'channel_id' => $auth_user->id,
                            'name' => $auth_user->name,
                            'type' => $type,
                            'category' => $category,
                            'access_token' => $auth_user->token,
                            'access_token_secret' => '',
                            'social_id' => $social,
                            'user_id' => $user_id,
                            'channel_URL' => $url.$auth_user->id
                        ]
                    );

                $fb = new Facebook();

                $graph = new FacebookController($fb);

                $pages = $graph->getFacebookPagesToArray();

                $type = 'Page';
                $social = Social::where('name', 'facebook')
                    ->pluck('id')
                    ->first();

                $user_id = Auth::user()->id;

                foreach ($pages as $id => $details) {
                    $social_channel = SocialChannel::updateOrCreate(
                        [
                            'channel_id' => $details['id'],
                            'user_id' => $user_id
                        ],
                        [
                        'channel_id' => $details['id'],
                        'name' => $details['name'],
                        'type' => $type,
                        'category' => $details['category'],
                        'access_token' => $details['access_token'],
                        'access_token_secret' => '',
                        'social_id' => $social,
                        'user_id' => $user_id,
                        'channel_URL' => $details['link']
                        ]
                    );
                }

                break;

            case 'twitter':

                $type = 'Account';
                $category = 'Generic';
                $url = 'https://www.twitter.com/';

                $social = Social::where('name', $provider)->pluck('id')->first();
                $user_id = Auth::user()->id;

                if (isset($auth_user)) {

                    $social_channel = SocialChannel::updateOrCreate(['channel_id' => $auth_user->id], [
                        'channel_id' => $auth_user->id,
                        'name' => $auth_user->nickname,
                        'type' => $type,
                        'category' => $category,
                        'access_token' => $auth_user->token,
                        'access_token_secret' => $auth_user->tokenSecret,
                        'social_id' => $social,
                        'user_id' => $user_id,
                        'channel_URL' => $url.$auth_user->nickname
                    ]);
                }

                break;

            case 'instagram':

                $type = 'Account';
                $category = 'Generic';
                $url = 'https://www.instagram.com/';

                $social = Social::where('name', $provider)->pluck('id')->first();
                $user_id = Auth::user()->id;

                if (isset($auth_user)) {

                    $social_channel = SocialChannel::updateOrCreate(['channel_id' => $auth_user->id], [
                        'channel_id' => $auth_user->id,
                        'name' => $auth_user->nickname,
                        'type' => $type,
                        'category' => $category,
                        'access_token' => $auth_user->token,
                        'access_token_secret' => '',
                        'social_id' => $social,
                        'user_id' => $user_id,
                        'channel_URL' => $url.$auth_user->nickname
                    ]);
                }

                break;
        }

        return redirect()->to('/channels'); // Redirect to a secure page
    }

    public function getPosts(SocialChannel $socialChannel, $provider){

        switch ($provider) {

            case 'facebook':

                $fb = new Facebook();
                $graph = new FacebookController($fb);

                $posts = $graph->getFacebookPagePosts($socialChannel->name);

                return $posts;

                break;

            case 'twitter':

                $tw = new TwitterController();

                $posts = $tw->getTweetFromChannel($socialChannel->id);

                /*foreach($posts as $post){
                    $comments[] = $tw->getTwitterCommentsOnTweet($socialChannel->id, $post['id']);

                    /*post->comments_data = $comments;
                    $posts_comment[] = $post;

                }
                */

                return $posts;

                break;

            case 'instagram':

                $ig = new InstagramController();

                $posts = $ig->getInstagramPosts($socialChannel->id);

                foreach($posts as $post){
                    $comments = $ig->getInstagramCommentOnPosts($socialChannel->id, $post->id);
                    $post->comments_data = $comments;
                    $posts_comment[] = $post;
                }

                return($posts_comment);

                break;
        }

    }

    public function getComments(SocialChannel $socialChannel, $provider, $id_post){

        switch ($provider) {

            case 'facebook':

                break;

            case 'twitter':

                $tw = new TwitterController();

                $comments = $tw->getTwitterCommentsOnTweet($socialChannel->id, $id_post);

                return $comments;

                break;

            case 'instagram':

                $ig = new InstagramController();

                $comments = $ig->getInstagramCommentOnPosts($socialChannel->id, $id_post );

                return($comments);

                break;
        }

    }

    public function getURLByProfile(SocialChannel $socialChannel, $provider)
    {
        switch ($provider) {

            case 'facebook':

                dd($socialChannel);

                $url = 'https://www.facebook.com/profile.php?'.'';

                return $url;

                break;

            case 'twitter':

                $tw = new TwitterController();

                $posts = $tw->getTweetFromChannel($socialChannel->id);

                return $posts;

                break;

            case 'instagram':
                echo "instagram";
                break;
        }
    }

}
