@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session()->has('status'))
            <p class="alert alert-info">
                {{	session()->get('status') }}
            </p>
        @endif
        <div class="col-sm-6 col-sm-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Estratto JSON dalla Pagina
                </div>
                <div class="panel-body">

                   {{-- <script>
                    $(document).ready(function() {

                        var jsonString = JSON.stringify({{}});

                        $('<div class="result"></div>')
                            .append(jsonString.message);

                    });

                    </script>--}}

                    {{-- @foreach($posts as $key => $val)
                        {{dd($posts[$key])}}
                            'Id Post: {{ $item->id }}
                            'Post Message: {{ $item->message }}
                            'Timestamp: ' {{ $item->created_time }}
                    @endforeach--}}

                    @foreach($posts as $post)
                        <pre>{{ print_r($post) }}</pre>
                    @endforeach

                </div>
            </div>
        </div>
            <div class="result"></div>
            <div class="col-sm-6 col-sm-offset-3">
                <a href="{{ route('facebook.posts.show', ['name' => $channels->name]) }}" class="btn btn-danger btn-xs">Visualizza JSON</a>
                <a href="{{ route('channels.show', 1) }}" class="btn btn-success btn-xs">Aggiorna i dati</a>
            </div>
    </div>
@endsection