@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session()->has('status'))
            <p class="alert alert-info">
                {{	session()->get('status') }}
            </p>
        @endif
        <div class="panel panel-default">
            <div class="panel-heading">
                <div>
                    <a href="{{ route('channels.create') }}" class="btn btn-success btn-xs">Aggiungi Canale</a>
                    <a href="{{ route('channels.add') }}" class="btn btn-success btn-xs">Aggiungi Post Multicanale</a>
                </div>
                <br>
                <div>Canali Associati all'Utente :</div>
            </div>
            <div class="panel-body">
                @if (count($channels))
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Canale</th>
                                <th>Nome</th>
                                <th>Tipo</th>
                                <th>Categoria</th>
                                <th>Connesso il</th>
                                <th>Ultimo Accesso</th>
                                <th>Azioni</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($channels as $channel)
                                <tr>
                                    <td><a class="btn btn-social-icon btn-{{ @$channel->socials->first()->name }}"><span class="fa fa-{{ @$channel->socials->first()->name }}"></span></a></td>
                                    <td>{{ $channel->name }}</td>
                                    <td>{{ $channel->type }}</td>
                                    <td>{{ $channel->category }}</td>
                                    <td>{{ $channel->created_at->format('m-d-Y') }}</td>
                                    <td>{{ $channel->updated_at->format('m-d-Y') }}</td>
                                    <td>
                                        <a href="{{ route('channels.show', $channel->name ) }}" class="btn btn-info btn-xs">Fetch Posts</a>
                                        <form action="{{ route('channels.destroy', $channel->id) }}" method="POST" style="display:inline-block">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button class="btn btn-danger btn-xs">
                                                <span>DELETE</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        {{--{{ $channels->links() }}--}}
                    </div>
                @else
                    <p class="alert alert-info">
                        Nessun canale attivo!
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection