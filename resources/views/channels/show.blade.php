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
                                                <span class="fb-stream-date"><img class="fb-stream-icon" src="{{ $icon }}" title="link">Creato il {{ $post['created_time']->setTimezone(new DateTimeZone('Europe/Rome'))->format('Y-m-d H:i:s') }}
                                                    @if (isset($post['id']))
                                                        <br><a href="http://www.facebook.com/{{ $post['id'] }}" target="_blank">Vai al Post</a>
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

                                            @if (isset($post['reactions']))
                                                @foreach($post['reactions'] as $reaction)
                                                    @php
                                                        $NONE=0;
                                                        $LIKE=0;
                                                        $LOVE=0;
                                                        $WOW=0;
                                                        $HAHA=0;
                                                        $SAD=0;
                                                        $ANGRY=0;
                                                        $THANKFUL=0;
                                                    @endphp

                                                    @switch($reaction['type'])

                                                        @case('NONE')
                                                            @php
                                                                $NONE++;
                                                            @endphp
                                                        @break

                                                        @case('LIKE')
                                                            @php
                                                                $LIKE++;
                                                            @endphp
                                                        @break

                                                        @case('LOVE')
                                                            @php
                                                                $LOVE++;
                                                            @endphp
                                                        @break

                                                        @case('WOW')
                                                            @php
                                                                $WOW++;
                                                            @endphp
                                                        @break

                                                        @case('HAHA')
                                                            @php
                                                                $HAHA++;
                                                            @endphp
                                                        @break

                                                        @case('SAD')
                                                            @php
                                                                $SAD++;
                                                            @endphp
                                                        @break

                                                        @case('ANGRY')
                                                            @php()
                                                                $ANGRY++;
                                                            @endphp
                                                        @break

                                                        @case('THANKFUL')
                                                            @php
                                                                $THANKFUL++;
                                                            @endphp
                                                        @break

                                                    @endswitch
                                                @endforeach
                                                    <div class="fb-stream-comment">LIKE : {{ $LIKE }} / LOVE : {{ $LOVE }} / WOW : {{ $WOW }} / HAHA : {{ $HAHA }} / SAD : {{ $SAD }} / ANGRY : {{ $ANGRY }} / THANKFUL : {{ $THANKFUL }}</div>
                                            @endif

                                            @if (isset($post['comments']))
                                                @php
                                                    $counter=1;
                                                @endphp
                                                @foreach($post['comments'] as $comment)
                                                    @if (isset($comment['message']))
                                                        <div class="fb-stream-comment">#{{ $counter }} <a href="https://www.facebook.com/profile.php?id={{ $comment['from']['id'] }}" target="_blank">{{ $comment['from']['name'] }}</a> {{ $comment['message'] }}</div>
                                                    @endif

                                                    @if (isset($comment['created_time']))
                                                        <div class="fb-stream-comment-date"><img class="fb-stream-icon" src="" title="link">Inserito il {{ $comment['created_time']->setTimezone(new DateTimeZone('Europe/Rome'))->format('Y-m-d H:i:s') }}
                                                            @if (isset($comment['id']))
                                                                <a href="http://www.facebook.com/{{ $comment['id'] }}" target="_blank">(Vai al commento)</a>
                                                            @endif
                                                        </div>

                                                        <div style="clear:both;"></div>
                                                    @endif

                                                    @php
                                                        $counter++;
                                                    @endphp
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

        @break

        @case('twitter')
            @section('content')
                <div class="container">
                    @if(session()->has('status'))
                        <p class="alert alert-info">
                            {{	session()->get('status') }}
                        </p>
                    @endif

                    <div class="col-sm-12 col-sm-offset-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a href="{{ route('channels.index') }}" class="btn btn-danger btn-xs"><< Back</a>
                                <a href="{{ route('twitter.posts.show', ['id' => $channels->id]) }}" class="btn btn-info btn-xs">Visualizza JSON</a>
                                <a href="{{ route('channels.show', $channels->id) }}" class="btn btn-success btn-xs">Aggiorna i dati</a>
                                <div></div>
                                Channel Feed
                            </div>
                            <div class="panel-body">
                                <div class="fb-stream">
                                    <div class="fb-stream-head">
                                        <div class="fb-stream-pic-name">
                                            <div class="fb-stream-pic-container">
                                                <img class="fb-stream-pic" src="{{ $posts[1]['user']['profile_image_url'] }}" >
                                            </div>

                                            <div style="display:table;">
                                                <div><a class="fb-stream-name" href="http://www.twitter.com/{{ $channels->name }}" title="" target="_blank">{{ $channels->name }}</a></div>
                                                <div><a class="fb-stream-name" href="http://www.twitter.com/{{ $channels->name }}" title="" target="_blank">ID: {{ $channels->channel_id }}</a></div>
                                                <div><a class="fb-stream-name" href="http://www.twitter.com/{{ $channels->name }}" title="" target="_blank">Follower totali: {{ $posts[1]['user']['followers_count'] }}</a></div>
                                            </div>
                                        </div>
                                        <div style="clear:both;"></div>
                                    </div>

                                    @foreach($posts as $post)
                                        <div class="fb-stream-box">

                                            @if (isset($post['created_at']))
                                                <div style="clear:both;"></div>
                                                <span class="fb-stream-date"><img class="fb-stream-icon" src="{{ $posts[1]['user']['profile_image_url'] }}" title="link">Creato il {{ $post['created_at'] }}
                                                    @if (isset($post['id']))
                                                        <br><a href="http://www.twitter.com/{{ $post['id'] }}" target="_blank">Vai al Tweet</a>
                                                    @endif
                                                           </span>
                                                <div style="clear:both;"></div>
                                            @endif

                                            @if (isset($post['text']))
                                                <div class="fb-stream-message">{{ $post['text'] }}</div>
                                            @endif

                                            @if (isset($post['entities']['media']))

                                                @foreach($post['entities']['media'] as $media)

                                                        @switch($media['type'])

                                                            @case('photo')
                                                                        <div class="fb-stream-media"><a href='http://www.twitter.com/{{ $post['id'] }}' target="_blank" class="fb-stream-media-link"><img class="fb-stream-picture" src="{{ $media['media_url'] }}"></a></div>
                                                                        <div style="clear:both;"></div>
                                                            @break

                                                            @case('video')

                                                            @break

                                                        @endswitch
                                                    @endforeach
                                            @endif

                                            <div class="fb-stream-comment">
                                                @if (isset($post['favorite_count']))
                                                        PREFERITI : {{ $post['favorite_count'] }}
                                                @endif
                                                /
                                                @if (isset($post['retweet_count']))
                                                    RT : {{ $post['retweet_count'] }}
                                                @endif
                                                /
                                                    COMMENTI : ND
                                            </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @endsection
        @break

        @case('instagram')
            instagram
        @break

    @endswitch
@endif

