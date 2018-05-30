@extends('layouts.app')
 
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Super Admin Dashboard</div>
 
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
 
                        Questa è la pagina del Super Admin. Devi avere i privilegi per poter accedere a questa sezione.
                        
                    <div class="row">
                        <div class="col-md-7 col-md-offset-2">
                            @include('partials.flash-messages')
                        </div>
                        <div class="col-md-8 col-md-offset-1">
                            <ul>
                                <li>
                                    <a href="/facebook/login" class="btn btn-block btn-lg btn-social btn-facebook social-button">
                                        <span class="fa fa-facebook"></span> Effettua il Login Facebook
                                    </a>
                                </li>
                                <li>
                                    <a href="/twitter/login" class="btn btn-block btn-lg btn-social btn-google social-button">
                                        <span class="fa fa-google"></span> Effettua il Login con Google
                                    </a>
                                </li>
                                <li>
                                    <a href="/google/login" class="btn btn-block btn-lg btn-social btn-twitter social-button">
                                        <span class="fa fa-twitter"></span> Effettua il Login con Twitter
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection