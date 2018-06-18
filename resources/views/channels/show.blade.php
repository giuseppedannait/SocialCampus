@extends('layouts.app')

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
                    <a href="{{ route('channels.show', $channels->name) }}" class="btn btn-success btn-xs">Aggiorna i dati</a>
                    <div></div>
                    Channel Feed
                </div>
                <div class="panel-body">
                   <div class="fb-stream">
                        <div class="fb-stream-head">
                            <div class="fb-stream-pic-name">
                                <div class="fb-stream-pic-container">
                                    <img class="fb-stream-pic" src="{{ $icon }}" >
                                </div>

                                <div style="display:table;">
                                    <div><a class="fb-stream-name" href="http://www.facebook.com/{{ $posts['id'] }}" title="{{ $posts['id'] }}" target="_blank">{{ $posts['name'] }}</a></div>
                                    <div><a class="fb-stream-name" href="http://www.facebook.com/{{ $posts['id'] }}" title="{{ $posts['id'] }}" target="_blank">ID: {{ $posts['id'] }}</a></div>
                                    <div><a class="fb-stream-name" href="http://www.facebook.com/{{ $posts['id'] }}" title="{{ $posts['id'] }}" target="_blank">Fans totali: {{ $posts['fan_count'] }}</a></div>
                                </div>
                            </div>
                            <div style="clear:both;"></div>
                        </div>

                        @foreach($posts['posts'] as $post)
                           <div class="fb-stream-box">

                                @if (isset($post['created_time']))
                                   <div style="clear:both;"></div>
                                   <span class="fb-stream-date"><img class="fb-stream-icon" src="{{ $icon }}" title="link">Creato il {{ $post['created_time']->format('Y-m-d H:i:s') }}
                                   @if (isset($post['id']))
                                      <br><a href="http://www.facebook.com/{{ $post['id'] }}" target="_blank">Link Post</a>
                                   @endif
                                   </span>
                                   <div style="clear:both;"></div>
                               @endif

                                @if (isset($post['message']))
                                    <div class="fb-stream-message">{{ $post['message'] }}</div>
                                @endif

                                @if (isset($post['attachments']))
                                    @foreach($post['attachments'] as $attachment)
                                        @switch($attachment['type'])

                                            @case('share')
                                                @if (isset($attachment['media']))
                                                    @foreach($attachment['media'] as $media)
                                                        <div class="fb-stream-media"><a href='{{ $attachment['url'] }}' target="_blank" class="fb-stream-media-link"><img class="fb-stream-picture" src="{{ $media['src'] }}"></a></div>
                                                        <div class="fb-stream-media-container">URL : <a href="{{ $attachment['url'] }}" target="_blank">[{{ $attachment['title']}}]</a><br /></div>
                                                        <div style="clear:both;"></div>
                                                    @endforeach
                                                @endif
                                            @break

                                            @case('photo')
                                                @if (isset($attachment['media']))
                                                    @foreach($attachment['media'] as $media)
                                                        <div class="fb-stream-media"><a href='http://www.facebook.com/{{ $post['id'] }}' target="_blank" class="fb-stream-media-link"><img class="fb-stream-picture" src="{{ $media['src'] }}"></a></div>
                                                        <div style="clear:both;"></div>
                                                    @endforeach
                                                @endif
                                            @break

                                            @case('video')

                                            @break

                                        @endswitch
                                    @endforeach
                                @endif
                            </div>
                    @endforeach
            </div>
        </div>
    </div>
        </div>
</div>


@endsection