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
        @foreach($posts['posts'] as $post)
            @if ($post['id'] == $post_id)
                @if (isset($post['comments']))
                    @php
                        $counter=0;
                    @endphp
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Commento</th>
                                <th>Utente</th>
                                <th>Creato il</th>
                                <th>Azioni</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($post['comments'] as $comment)
                                @php
                                    $counter++;
                                @endphp
                                <tr>
                                    <td>{{ $counter }}</td>
                                    <td>
                                        @if (isset($comment['message']))
                                            {{ $comment['message'] }}
                                        @endif
                                    </td>
                                    <td>
                                        @if (isset($comment['from']))
                                            <a href="https://www.facebook.com/profile.php?id={{ $comment['from']['id'] }}" target="_blank">{{ $comment['from']['name'] }}</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if (isset($comment['created_time']))
                                            {{ $comment['created_time']->setTimezone(new DateTimeZone('Europe/Rome'))->format('Y-m-d H:i:s') }}

                                        @endif
                                    </td>

                                    <td>
                                        @if (isset($comment['id']))
                                            <a class="btn btn-info btn-xs" href="http://www.facebook.com/{{ $comment['id'] }}" target="_blank">Vai al commento</a>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="alert alert-info">
                        Nessun commento presente su questo post.
                    </p>
                @endif
            @endif
        @endforeach
    @endif
</div>