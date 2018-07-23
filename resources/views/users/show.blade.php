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
                <div class="panel-body">
                    <div class="btn-group">
                        <a href="{{ url()->previous() }}" class="btn btn-danger btn-xs"><< Indietro</a>
                        &nbsp;
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-success btn-xs">Modifica Utente</a>
                        @if (count($channels))
                            <a href="{{ route('channels.user', $user->id) }}" class="btn btn-info btn-xs">Gestisci Canali</a>
                        @endif
                    </div>
                </div>
             </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Dettagli Utente</h4>
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="name">Nome</label>
                            <div class="col-sm-9">
                                <p class="form-control">{{ $user->name }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="name">Email</label>
                            <div class="col-sm-9">
                                <p class="form-control">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="name">Ruolo</label>
                            <div class="col-sm-9">
                                <p class="form-control">{{ @$user->roles->first()->name }}</p>
                            </div>
                        </div>
                        @if(@$user->roles->first()->name == 'SOCIAL_USER')
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="name">SMM Associato</label>
                                <div class="col-sm-9">
                                    <p class="form-control"> @if (!is_null(@$smm->name)) {{ @$smm->name }} @else Nessun SMM Associato. @endif</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @if(@$user->roles->first()->name != 'SOCIAL_USER')
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Utenti Associati</h4>
                    </div>
                    <div class="panel-body">
                        @if (count($associates))
                            <table id="users_channels" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Utente</th>
                                        <th>Azioni</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($associates as $associate)
                                        <tr>
                                            <td>{{ $associate->name }}</td>
                                            <td>
                                                <a href="{{ route('users.show', $associate->id) }}" class="btn btn-info btn-xs">Vedi Utente</a>
                                                <a href="{{ route('channels.index', $associate->id) }}" class="btn btn-success btn-xs">Vedi Canali</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="alert alert-info">
                                Nessun Utente Trovato.
                            </p>
                        @endif
                    </div>
                </div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Canali Associati al Profilo</h4>
                </div>
                <div class="panel-body">
                    @if (count($channels))
                        <table id="channels" class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Canale</th>
                                <th>Nome</th>
                                <th>Azioni</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($channels as $channel)
                                <tr>
                                    <td><a class="btn btn-social-icon btn-{{ @$channel->socials->name }}"><span class="fa fa-{{ @$channel->socials->name }}"</a></td>
                                    <td><a href="{{ $channel->channel_URL }}" target="_blank">{{ $channel->name }}</a></td>
                                    <td><a href="{{ route('channels.user', $user->id) }}" class="btn btn-info btn-xs">Gestisci</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="alert alert-info">
                            Nessun Canale Associato.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <!-- DataTable -->
    <script type="text/javascript" src="{{ asset('js/DataTables/datatables.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#users_channels').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Italian.json"
                }
            });
        } );
    </script>

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