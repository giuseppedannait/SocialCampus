@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session()->has('status'))
            <p class="alert alert-info">
                {{	session()->get('status') }}
            </p>
        @endif

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="btn-group">
                    <a href="{{ route('channels.create') }}" class="btn btn-success btn-sm">Aggiungi Canale</a>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Canali Social</h4>
            </div>
            <div class="panel-body">
                @if (count($channels))
                        <table id="channels" class="table table-bordered display">
                            <thead>
                            <tr>
                                <th>Canale</th>
                                <th>Nome</th>
                                <th>Tipo</th>
                                <th>Categoria</th>
                                <th>Connesso il</th>
                                <th>Azioni</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($channels as $channel)
                                <tr>

                                    <td><a class="btn btn-social-icon btn-{{ @$channel->socials->name }}"><span class="fa fa-{{ @$channel->socials->name }}"></span></a></td>
                                    <td><a href="{{ $channel->channel_URL }}" target="_blank">{{ $channel->name }}</a></td>
                                    <td>{{ $channel->type }}</td>
                                    <td>{{ $channel->category }}</td>
                                    <td>{{ $channel->created_at->format('m-d-Y') }}</td>
                                    <td>
                                        @if($channel->type != 'Profile')
                                            <a href="{{ route('channels.show', $channel->id ) }}" class="btn btn-success btn-xs">Vedi Canale</a>
                                            <a href="{{ route('channels.posts', $channel->id ) }}" class="btn btn-info btn-xs">Vedi Posts</a>
                                            <form action="{{ route('channels.destroy', $channel->id) }}" method="POST" style="display:inline-block">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button class="btn btn-danger btn-xs">
                                                    <span>X</span>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

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

@section('scripts')

    <!-- DataTable -->
    <script type="text/javascript" src="{{ asset('js/DataTables/datatables.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#channels').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Italian.json"
                }
            });
        } );
    </script>

@endsection
