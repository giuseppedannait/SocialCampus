@if (isset($posts['picture']))
    @php
        $icon = $posts['picture']['url']
    @endphp
@endif

    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <img class="fb-stream-pic" src="{{ $posts[1]['user']['profile_image_url'] }}" ><a href="http://www.twitter.com/{{ $channels->name }}" target="_blank"> {{ $channels->name }}</a>
            </div>
            <div class="panel-body">
                <div><a class="fb-stream-name" href="http://www.twitter.com/{{ $channels->name }}" title="" target="_blank">Nome Canale: {{ $channels->name }}</a></div>
                <div><a class="fb-stream-name" href="http://www.twitter.com/{{ $channels->name }}" title="" target="_blank">ID: {{ $channels->channel_id }}</a></div>
                <div><a class="fb-stream-name" href="http://www.twitter.com/{{ $channels->name }}" title="" target="_blank">Follower totali: {{ $posts[1]['user']['followers_count'] }}</a></div>
            </div>

            @if (count($posts))
                <div class="table-responsive">
                    <table id="posts" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Testo</th>
                            <th>Creato il</th>
                            <th>Media</th>
                            <th><span class="glyphicon glyphicon-heart-empty" aria-hidden="true"></span></th>
                            <th><span class="glyphicon glyphicon-retweet" aria-hidden="true"></span></th>
                            <th><span class="glyphicon glyphicon-comment" aria-hidden="true"></span></th>
                            <th>Azioni</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($posts as $post)
                            <tr>
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

                                            @endswitch
                                        @endforeach
                                    @else
                                        SIMPLE
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
                                <td align="center">
                                    @if (isset($post['entities']['media']))
                                        @foreach($post['entities']['media'] as $media)
                                            @switch($media['type'])

                                                @case('photo')
                                                <a href='http://www.twitter.com/{{ $post['id'] }}' target="_blank" class="fb-stream-media-link"><img class="fb-stream-pic" src="{{ $media['media_url'] }}"></a>
                                                <div style="clear:both;"></div>
                                                @break

                                                @case('video')

                                                @break

                                            @endswitch
                                        @endforeach
                                    @else
                                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                    @endif
                                </td>
                                <td align="center">
                                    @if (isset($post['favorite_count']))
                                        {{ $post['favorite_count'] }}
                                    @else
                                        ND
                                    @endif
                               </td>
                                <td align="center">
                                    @if (isset($post['retweet_count']))
                                        {{ $post['retweet_count'] }}
                                    @else
                                        ND
                                    @endif
                                </td>
                                <td>ND</td>
                                <td>
                                    <a href="{{ route('channels.posts.delete', ['id' => $channels->id, 'post' => $post['id']]) }}" class="btn btn-danger btn-xs">X</a>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
@endif