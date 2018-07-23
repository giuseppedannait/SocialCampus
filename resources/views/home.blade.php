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
                    <h5>Version @if (isset($version)) {{ $version }} @endif</h5>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
