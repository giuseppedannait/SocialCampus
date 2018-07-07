@if (isset($posts['picture']))
    @php
        $icon = $posts['picture']['url']
    @endphp
@endif

<div class="col-xs-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <img class="fb-stream-pic" src="{{ $icon }}" > <a href="http://www.facebook.com/{{ $posts['id'] }}" title="{{ $posts['id'] }}" target="_blank"> {{ $channels->name }}</a>
        </div>

        <div class="panel-body">
            <div>Canale : <a class="fb-stream-name" href="http://www.facebook.com/{{ $posts['id'] }}" title="{{ $posts['id'] }}" target="_blank">{{ $posts['name'] }}</a></div>
            <div>ID : <a class="fb-stream-name" href="http://www.facebook.com/{{ $posts['id'] }}" title="{{ $posts['id'] }}" target="_blank">{{ $posts['id'] }}</a></div>
            <div>Fan totali : <a class="fb-stream-name" href="http://www.facebook.com/{{ $posts['id'] }}" title="{{ $posts['id'] }}" target="_blank">{{ $posts['fan_count'] }}</a></div>
        </div>
    </div>
    @if (count($posts['posts']))
        <div class="table-responsive">
            <table id="posts" class="table table-bordered">
                <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Testo</th>
                    <th>Creato il</th>
                    <th>Media</th>
                    <th width="25px"><img width="25px" src="/public/icons/Like-500px.gif"></th>
                    <th width="25px"><img width="25px" src="/public/icons/Love-500px.gif"></th>
                    <th width="25px"><img width="25px" src="/public/icons/Haha-500px.gif"></th>
                    <th width="25px"><img width="25x" src="/public/icons/Sad-500px.gif"></th>
                    <th width="25px"><img width="25px" src="/public/icons/Wow-500px.gif"></th>
                    <th width="25px"><img width="25px" src="/public/icons/Angry-500px.gif"></th>
                    <th width="25px"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span></th>
                    <th width="15%">Azioni</th>
                </tr>
                </thead>
                <tbody>
                @foreach($posts['posts'] as $post)
                    <tr>
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
                            @else
                                SIMPLE
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
                        <td align="center">
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
                            @else
                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            @endif
                        </td>

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

                        @if (isset($post['reactions']))
                                @foreach($post['reactions'] as $reaction)
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
                                            @php
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
                            @endif
                            <td align="center">{{ $LIKE }}</td>
                            <td align="center">{{ $LOVE }}</td>
                            <td align="center">{{ $WOW }}</td>
                            <td align="center">{{ $HAHA }}</td>
                            <td align="center">{{ $SAD }}</td>
                            <td align="center">{{ $ANGRY }}</td>
                            <td>
                                @php
                                    $counter=0;
                                @endphp
                                @if (isset($post['comments']))
                                    @foreach($post['comments'] as $comment)
                                        @php
                                            $counter++;
                                        @endphp
                                    @endforeach
                                @endif
                                {{ $counter }}
                            </td>
                            <td>
                                <a href="{{ route('channels.posts.comments', ['id' => $channels->id, 'post' => $post['id']]) }}" class="btn btn-info btn-xs">Commenti</a>
                                <a href="{{ route('channels.posts.delete', ['id' => $channels->id, 'post' => $post['id']]) }}" class="btn btn-danger btn-xs">X</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>Tipo</th>
                    <th>Testo</th>
                    <th>Creato il</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                </tfoot>
            </table>
        </div>
    @endif
</div>