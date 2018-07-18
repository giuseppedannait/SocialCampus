@if (isset($posts['0']->user->profile_picture))
    @php
        $icon = $posts['0']->user->profile_picture;
    @endphp
@else
    @php
        $icon = '';
    @endphp
@endif


<div class="col-xs-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <img class="fb-stream-pic" src="{{ $icon }}" > <a href=" {{ $channels->channel_URL }}"  target="_blank"> {{ $channels->name }}</a>
        </div>

        <div class="panel-body">
            <div>Canale : <a class="fb-stream-name" href="http://www.instagram.com/{{ $posts['0']->user->id }}" title="{{ $posts['0']->user->id }}" target="_blank"> {{ $posts['0']->user->full_name }}</a></div>
            <div>ID : <a class="fb-stream-name" href="http://www.instagram.com/{{ $posts['0']->user->id }}" title="{{ $posts['0']->user->id }}" target="_blank"> {{ $posts['0']->user->id }}</a></div>
        </div>
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
                        <th><span class="glyphicon glyphicon-heart" aria-hidden="true"></span></th>
                        <th><span class="glyphicon glyphicon-comment" aria-hidden="true"></span></th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($posts as $post)
                    <tr id="tr_{{ $post->id }}">
                        <td>PHOTO</td>
                        <td>
                            @if (isset($post->caption))
                                {{ $post->caption->text }}
                            @endif
                        </td>
                        <td>
                            @if (isset($post->created_time))
                                <a href="{{ $post->link }}" target="_blank">{{ date('d/m/Y - H:i.s', $post->created_time) }}</a>
                            @endif
                        </td>
                        <td>
                            @if (isset($post->images))
                                <a href="{{ $post->link }}" target="_blank"><img class="fb-stream-pic" src="{{ $post->images->standard_resolution->url  }}"></a>
                            @endif
                        </td>
                        <td align="center">
                            @if (isset($post->likes))
                                {{ $post->likes->count }}
                            @endif
                        </td>
                        <td align="center">
                            @if (isset($post->comments_data))
                                @php
                                    $counter=0;
                                @endphp
                                @foreach($post->comments_data as $comment)
                                    @php
                                        $counter++;
                                    @endphp
                                @endforeach

                                {{ $counter }}
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('channels.posts.comments', ['id' => $channels->id, 'post' => $post->id]) }}" class="btn btn-info btn-xs">Commenti</a>
                            <a href="{{ route('channels.posts.delete', ['id' => $channels->id, 'post' => $post->id]) }}" class="btn btn-danger btn-xs"
                               data-tr="tr_{{ $post->id }}"
                               data-toggle="confirmation"
                               data-btn-ok-label="CANCELLA" data-btn-ok-icon="fa fa-remove"
                               data-btn-ok-class="btn btn-sm btn-danger"
                               data-btn-cancel-label="Annulla"
                               data-btn-cancel-icon="fa fa-chevron-circle-left"
                               data-btn-cancel-class="btn btn-sm btn-default"
                               data-title="Sei sicuro di voler eliminare questa riga ?"
                               data-placement="left" data-singleton="true">X</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="alert alert-info">
            Nessun post presente sul canale.
        </p>
    @endif
</div>