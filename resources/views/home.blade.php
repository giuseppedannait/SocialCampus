<<<<<<< HEAD
@extends('layouts.master')
@section('page-title', 'Social Campus - Home Page')
@section('page-content')
<div class="col-md-10">
    <h2>Benvenuti su SocialCampus.</h2>
    <h3>A Social App powered by eCampus.</h3>
    <h4>Developed by Ing. Giuseppe D'Anna.</h4>
</div>
=======
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h2>Benvenuti su SocialCampus.</h2>
                    <h3>A Social Media Management App powered by eCampus.</h3>
                    <h4>Developed by Ing. Giuseppe D'Anna.</h4>
                </div>
            </div>
        </div>
    </div>
</div>

>>>>>>> Reset
@stop
