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
        @foreach($posts as $post)
            @if ($post->id == $post_id)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Testo</th>
                                <th>Utente</th>
                                <th>Creato il</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php
                            $counter=0;
                        @endphp
                        @foreach($post->comments_data as $comment)
                            <tr>
                                <td>{{ $counter }}</td>
                                <td>
                                    @if (isset($comment->text))
                                        {{ $comment->text }}
                                    @endif
                                </td>
                                <td>
                                    @if (isset($comment->from))
                                        {{ $comment->from->username }}
                                    @endif
                                </td>
                                <td>
                                    @if (isset($comment->created_time))
                                        {{ $post->created_time }}
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-info btn-xs" href="http://www.instagram.com/{{ $comment->id }}" target="_blank">Vai al commento</a>
                                    <form action="" method="POST" style="display:inline-block">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-danger btn-xs" alt="Elimina il commento">
                                            <span>X</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @php
                                $counter++;
                            @endphp
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        @endforeach
    @else
        <p class="alert alert-info">
            Nessun post presente sul canale.
        </p>
    @endif
</div>