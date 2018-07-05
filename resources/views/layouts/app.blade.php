<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap CDN -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css"> -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script> -->

    <!-- Bootstrap Local -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

     <!-- Asset Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Asset Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Social -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-social/5.0.0/bootstrap-social.min.css">

    <!-- jQuery -->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
    <!--<script src="//code.jquery.com/jquery-1.11.1.min.js"></script> -->

</head>
<body>
<div id="app">
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">SocialCampus</a>
            </div>

            <ul id="navbar" class="collapse navbar-collapse">                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">

                    <li><a href="{{ action('HomeController@index') }}">Dashboard</a></li>

                    @guest

                    @else

                        @if (isset(Auth::user()->roles->first()->name))

                            @if (Auth::user()->roles->first()->name === 'SOCIAL_USER')
                                <li><a class="" href="{{ url('/channels') }}">Gestione Canali</a></li>
                                <li><a class="" href="{{ url('/channel/add') }}">Scrivi Post</a></li>
                            @elseif (Auth::user()->roles->first()->name === 'SOCIAL_ADMIN')
                                <li><a class="n" href="{{ url('/users') }}">Utenti</a></li>
                                <li><a class="" href="{{ url('/channels') }}">Gestione Canali</a></li>
                                <li><a class="" href="{{ url('/channel/add') }}">Scrivi Post</a></li>
                            @elseif (Auth::user()->roles->first()->name === 'SOCIAL_SUPER_ADMIN')
                                <li><a class="" href="{{ url('/users') }}">Utenti</a></li>
                                <li><a class="" href="{{ url('/channels') }}">Gestione Canali</a></li>
                                <li><a class="" href="{{ url('/socials') }}">Gestione Provider</a></li>
                                <li><a class="" href="{{ url('/channel/add') }}">Scrivi Post</a></li>
                            @endif

                        @endif

                    @endguest

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @guest
                        <li><a class="" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                        <li><a class="" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Ciao, {{ Auth::user()->name }} ( {{ Auth::user()->roles->first()->name }} ) <span class="caret"></span></a>

                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                    </a>
                                </li>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

@yield('content')

</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{ asset('js/bootstrap.min.js') }}"></script>

</body>
</html>
