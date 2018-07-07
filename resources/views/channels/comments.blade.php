@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session()->has('status'))
            <p class="alert alert-info">
                {{ session()->get('status') }}
            </p>
        @endif

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="btn-group">

                        <a href="{{ URL::previous() }}" class="btn btn-danger btn-sm"><< Indietro</a>
                        <a href="{{ route('channels.show', $channels->id) }}" class="btn btn-success btn-sm">Aggiorna i dati</a>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2><a class="btn btn-social-icon btn-{{ $provider }}"><span class="fa fa-{{ $provider }}"></span></a> Tabella dei Commenti</h2>
                </div>
            </div>

    @if(isset($provider))
        @switch($provider)

            @case('facebook')
                @include('channels.comments.facebook')
            @break

            @case('twitter')
                @include('channels.comments.twitter')
            @break

            @case('instagram')
                @include('channels.comments.instagram')
            @break

        @endswitch
    @endif

    </div>

@endsection

