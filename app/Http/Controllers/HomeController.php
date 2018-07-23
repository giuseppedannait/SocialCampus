<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $version = $this->version();

        $version = $version['short'];

        return view('home', compact('version', $version));
    }

    public function version()
    {
        exec('git describe --always',$version_mini_hash);
        exec('git rev-list HEAD | wc -l',$version_number);
        exec('git log -1',$line);
        $version['short'] = "v1.".trim($version_number[0]).".".$version_mini_hash[0];
        $version['full'] = "v1.".trim($version_number[0]).".$version_mini_hash[0] (".str_replace('commit ','',$line[0]).")";
        return $version;
    }
}
