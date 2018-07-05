
    <div class="container">
        @if(session()->has('status'))
            <p class="alert alert-info">
                {{	session()->get('status') }}
            </p>
        @endif

        <div class="col-sm-12 col-sm-offset-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div></div>
                    Channel Feed
                    <table>
                        <tr>
                            <td>
                                <a href="{{ route('channels.index') }}" class="btn btn-danger btn-xs"><< Back</a>
                                <a href="{{ route('twitter.posts.show', ['id' => $channels->id]) }}" class="btn btn-info btn-xs">Visualizza JSON</a>
                                <a href="{{ route('channels.show', $channels->id) }}" class="btn btn-success btn-xs">Aggiorna i dati</a>
                            </td>
                        </tr>
                    </table>
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
