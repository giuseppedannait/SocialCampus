<?php

namespace App\Http\Controllers;

use App\Social;
use Illuminate\Http\Request;

use Auth;

class SocialController extends Controller
{

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

        $socials = Social::latest()->orderBy('name')->paginate();
        return view('social.index', compact('socials',$socials));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Social  $social
     * @return \Illuminate\Http\Response
     */
    public function show(Social $social)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Social  $social
     * @return \Illuminate\Http\Response
     */
    public function edit(Social $social)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Social  $social
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Social $social)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Social  $social
     * @return \Illuminate\Http\Response
     */
    public function destroy(Social $social)
    {
        //
    }
}
