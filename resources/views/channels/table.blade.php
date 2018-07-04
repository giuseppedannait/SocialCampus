@extends('layouts.app')

@if(isset($provider))
    @switch($provider)

        @case('facebook')

            @section('content')
                <div class="container">
                    @if(session()->has('status'))
                        <p class="alert alert-info">
                            {{	session()->get('status') }}
                        </p>
                    @endif

                    @if (isset($posts['picture']))
                        @php
                            $icon = $posts['picture']['url']
                        @endphp
                    @endif

                    <div class="col-sm-12 col-sm-offset-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a href="{{ route('channels.index') }}" class="btn btn-danger btn-xs"><< Back</a>
                                <a href="{{ route('facebook.posts.show', ['name' => $channels->name]) }}" class="btn btn-info btn-xs">Visualizza JSON</a>
                                <a href="{{ route('channels.show', $channels->id) }}" class="btn btn-success btn-xs">Aggiorna i dati</a>
                                <div></div>
                                Channel Feed - Table Version
                                <div style="display:table;">
                                    <div><a class="fb-stream-name" href="http://www.facebook.com/{{ $posts['id'] }}" title="{{ $posts['id'] }}" target="_blank">Canale: {{ $posts['name'] }}</a></div>
                                    <div><a class="fb-stream-name" href="http://www.facebook.com/{{ $posts['id'] }}" title="{{ $posts['id'] }}" target="_blank">ID: {{ $posts['id'] }}</a></div>
                                    <div><a class="fb-stream-name" href="http://www.facebook.com/{{ $posts['id'] }}" title="{{ $posts['id'] }}" target="_blank">Fans totali: {{ $posts['fan_count'] }}</a></div>
                                </div>
                            </div>
                                <div class="panel-body">
                                    @if (count($posts['posts']))
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>Canale</th>
                                                    <th>Tipo</th>
                                                    <th>Testo</th>
                                                    <th>Creato il</th>
                                                    <th>Attachment</th>
                                                    <th>Azioni</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($posts['posts'] as $post)
                                                    <tr>
                                                        <td><img class="fb-stream-pic" src="{{ $icon }}" >  <a href="http://www.facebook.com/{{ $posts['id'] }}" title="{{ $posts['id'] }}" target="_blank"> {{ $channels->name }}</a></td>
                                                        <td>
                                                            @if (isset($post['attachments']))
                                                                @foreach($post['attachments'] as $attachment)
                                                                    @switch($attachment['type'])

                                                                        @case('share')
                                                                            SHARE
                                                                        @break

                                                                        @case('photo')
                                                                            PHOTO
                                                                        @break

                                                                        @case('video')
                                                                            VIDEO
                                                                        @break

                                                                    @endswitch
                                                                @endforeach
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if (isset($post['message']))
                                                                {{ $post['message'] }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if (isset($post['created_time']))
                                                                <a href="http://www.facebook.com/{{ $post['id'] }}" target="_blank">{{ $post['created_time']->setTimezone(new DateTimeZone('Europe/Rome'))->format('Y-m-d H:i:s') }}</a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if (isset($post['attachments']))
                                                                @foreach($post['attachments'] as $attachment)
                                                                    @switch($attachment['type'])

                                                                        @case('share')
                                                                        @if (isset($attachment['media']))
                                                                            @foreach($attachment['media'] as $media)
                                                                                <img class="fb-stream-pic" src="{{ $media['src'] }}">
                                                                            @endforeach
                                                                        @endif
                                                                        @break

                                                                        @case('photo')
                                                                        @if (isset($attachment['media']))
                                                                            @foreach($attachment['media'] as $media)
                                                                                <img class="fb-stream-pic" src="{{ $media['src'] }}">                                                                            @endforeach
                                                                        @endif
                                                                        @break

                                                                        @case('video')

                                                                        @break

                                                                    @endswitch
                                                                @endforeach
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-info btn-xs">
                                                                <span>Commenti</span>
                                                            </button>
                                                            <form action="" method="POST" style="display:inline-block">
                                                                {{ csrf_field() }}
                                                                {{ method_field('DELETE') }}
                                                                <button class="btn btn-danger btn-xs">
                                                                    <span>X</span>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
            @endsection
        @break

        @case('twitter')
            @section('content')
                <div class="container">
                    @if(session()->has('status'))
                        <p class="alert alert-info">
                            {{	session()->get('status') }}
                        </p>
                    @endif

                    @if (isset($posts['picture']))
                        @php
                            $icon = $posts['picture']['url']
                        @endphp
                    @endif

                    <div class="col-sm-12 col-sm-offset-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a href="{{ route('channels.index') }}" class="btn btn-danger btn-xs"><< Back</a>
                                <a href="{{ route('twitter.posts.show', ['id' => $channels->id]) }}" class="btn btn-info btn-xs">Visualizza JSON</a>
                                <a href="{{ route('channels.show', $channels->id) }}" class="btn btn-success btn-xs">Aggiorna i dati</a>
                                <div></div>
                                Channel Feed - Table Version
                                <div style="display:table;">
                                    <div><a class="fb-stream-name" href="http://www.twitter.com/{{ $channels->name }}" title="" target="_blank">Nome Canale: {{ $channels->name }}</a></div>
                                    <div><a class="fb-stream-name" href="http://www.twitter.com/{{ $channels->name }}" title="" target="_blank">ID: {{ $channels->channel_id }}</a></div>
                                    <div><a class="fb-stream-name" href="http://www.twitter.com/{{ $channels->name }}" title="" target="_blank">Follower totali: {{ $posts[1]['user']['followers_count'] }}</a></div>
                                </div>
                            </div>
                            <div class="panel-body">
                                @if (count($posts))
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Canale</th>
                                                <th>Tipo</th>
                                                <th>Testo</th>
                                                <th>Creato il</th>
                                                <th>Attachment</th>
                                                <th>Azioni</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($posts as $post)
                                                <tr>
                                                    <td><img class="fb-stream-pic" src="{{ $posts[1]['user']['profile_image_url'] }}" ><a href="http://www.twitter.com/{{ $channels->name }}" target="_blank"> {{ $channels->name }}</a></td>
                                                    <td>
                                                        @if (isset($post['entities']['media']))

                                                            @foreach($post['entities']['media'] as $media)

                                                                @switch($media['type'])

                                                                    @case('photo')
                                                                        PHOTO
                                                                    @break

                                                                    @case('video')
                                                                        VIDEO
                                                                    @break

                                                                    @default
                                                                        SIMPLE
                                                                @endswitch
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (isset($post['text']))
                                                            {{ $post['text'] }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (isset($post['created_at']))
                                                            <a href="http://www.twitter.com/{{ $post['id'] }}" target="_blank">{{ $post['created_at'] }}</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (isset($post['entities']['media']))

                                                            @foreach($post['entities']['media'] as $media)

                                                                @switch($media['type'])

                                                                    @case('photo')
                                                                        <a href='http://www.twitter.com/{{ $post['id'] }}' target="_blank" class="fb-stream-media-link"><img class="fb-stream-pic" src="{{ $media['media_url'] }}"></a>                                                                    <div style="clear:both;"></div>
                                                                    @break

                                                                    @case('video')

                                                                    @break

                                                                @endswitch
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <form action="" method="POST" style="display:inline-block">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                            <button class="btn btn-danger btn-xs">
                                                                <span>X</span>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                            @endif
                            @endsection

        @break

        @case('instagram')
        instagram
        @break

    @endswitch
@endif

