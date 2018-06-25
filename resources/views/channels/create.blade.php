@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session()->has('status'))
            <p class="alert alert-info">
                {{	session()->get('status') }}
            </p>
        @endif
        <div class="col-sm-8 col-sm-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Aggiungi Canale Social
                </div>
                <div class="panel-body">
                    <div class="col-md-7 col-md-offset-2">
                        @include('partials.flash-messages')
                    </div>
                    <div class="col-md-8 col-md-offset-1">
                        <ul>
                            <li>
                                <a href="/login/facebook" class="btn btn-block btn-lg btn-social btn-facebook social-button">
                                    <span class="fa fa-facebook"></span> Effettua il Login Facebook
                                </a>
                            </li>
                            <li>
                                <a href="/login/twitter" class="btn btn-block btn-lg btn-social btn-twitter social-button">
                                    <span class="fa fa-twitter"></span> Effettua il Login con Twitter
                                </a>
                            </li>
                            <li>
                                <a href="/login/instagram" class="btn btn-block btn-lg btn-social btn-instagram social-button">
                                    <span class="fa fa-instagram"></span> Effettua il Login con Instagram
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection