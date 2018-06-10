<?php

namespace App\Http\Controllers;

use Auth;
use SammyK;
use App\SocialChannel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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

        //$channels = DB::table('social_channels')->where('user_id',1)->orderBy('name')->paginate();
        $channels = SocialChannel::latest()->where('user_id',$user)->orderBy('name')->paginate();
        //return $channels;
        return view('channels.index', compact('channels',$channels));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {

        // Facebook

        $fb = app(SammyK\LaravelFacebookSdk\LaravelFacebookSdk::class);

        // Send an array of permissions to request
        $fb_login_url = $fb->getLoginUrl(['email']);

        return view('channels.create', compact('fb_login_url', $fb_login_url));
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
    public function show(SocialChannel $socialChannel)
    {
        return view('channels.show', compact('SocialChannel', $socialChannel));
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

    public function ShowChannel()
    {
        //
    }
}
