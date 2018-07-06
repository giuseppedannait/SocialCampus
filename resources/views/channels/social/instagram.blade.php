@if (count($posts))

    @if (isset($posts['0']->user->profile_picture))
        @php
            $icon = $posts['0']->user->profile_picture;
        @endphp
    @endif

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="fb-stream">
                <div class="fb-stream-head">
                    <div class="fb-stream-pic-name">
                        <div class="fb-stream-pic-container">
                            <img class="fb-stream-pic" src="{{ $icon }}" >
                        </div>

                        <div style="display:table;">
                            <div><a class="fb-stream-name" href="http://www.instagram.com/{{ $posts['0']->user->id }}" title="{{ $posts['0']->user->id }}" target="_blank">{{ $posts['0']->user->full_name }}</a></div>
                            <div><a class="fb-stream-name" href="http://www.instagram.com/{{ $posts['0']->user->id }}" title="{{ $posts['0']->user->id }}" target="_blank">ID: {{ $posts['0']->user->id }}</a></div>
                        </div>
                    </div>
                    <div style="clear:both;"></div>
                </div>

                @foreach($posts as $post)
                    <div class="fb-stream-box">

                        @if (isset($post->created_time))
                            <div style="clear:both;"></div>
                            <span class="fb-stream-date"><img class="fb-stream-icon" src="{{ $icon }}" title="link">Creato il {{ $post->created_time }}
                                @if (isset($post->id))
                                    <br><a href="{{ $post->link }}" target="_blank">Vai al Post</a>
                                @endif
                            </span>
                            <div style="clear:both;"></div>
                        @endif

                        @if (isset($post->images))
                            <div class="fb-stream-media"><a href='{{ $post->link }}' target="_blank" class="fb-stream-media-link"><img class="fb-stream-picture" src="{{ $post->images->standard_resolution->url }}"></a></div>
                            <div style="clear:both;"></div>
                        @endif

                        @if (isset($post->caption))
                            <div class="fb-stream-message">{{ $post->caption->text }}</div>
                        @endif

                        <div class="fb-stream-comment">
                            @if (isset($post->likes))
                                   LIKE : {{ $post->likes->count }}
                            @endif

                            @if (isset($post->comments_data))
                                @php
                                    $counter=1;
                                @endphp
                                @foreach($post->comments_data as $comment)
                                    @if (isset($comment->text))
                                        <div class="fb-stream-comment">
                                            Commento #{{ $counter }}
                                            <div class="fb-stream-comment">
                                                Da: <a href="https://www.instagram.com/profile.php?id={{ $comment->from->username }}" target="_blank">{{ $comment->from->username }}</a> {{ $comment->text }}
                                            </div>
                                        </div>
                                        @endif

                                    @if (isset($comment->created_time))
                                        <div class="fb-stream-comment-date"><img class="fb-stream-icon" src="" title="link">Inserito il {{ $comment->created_time }}
                                            @if (isset($comment->id))
                                                <a href="http://www.instagram.com/{{ $comment->id }}" target="_blank">(Vai al commento)</a>
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
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@else
    <p class="alert alert-info">
        Nessun post presente sul canale.
    </p>
@endif
