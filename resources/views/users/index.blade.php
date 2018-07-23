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
                    <a href="{{ route('users.create') }}" class="btn btn-success btn-sl">Aggiungi Utente</a>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Gestione Utenti</h4>
            </div>
            <div class="panel-body">
                @if (count($users))
                    <div class="table-responsive">
                        <table id="users" class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Creato il</th>
                                <th>Aggiornato il</th>
                                <th>Ruolo</th>
                                <th>Azioni</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                @if (!($user->name == 'admin'))
                                    <tr id="tr_{{ $user->id }}">
                                        <td><b>{{ $user->name }}</b></td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at->format('m-d-Y') }}</td>
                                        <td>{{ $user->updated_at->format('m-d-Y') }}</td>
                                        <td>{{ @$user->roles->first()->name }}</td>
                                        <td>
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-success btn-xs">Modifica</a>
                                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-xs">Dettagli</a>
                                            {{--<form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button alt="Elimina Utente ..." class="btn btn-danger btn-xs">
                                                    <span>X</span>
                                                </button>
                                            </form>--}}
                                            <a href="{{ route('users.destroy', $user->id) }}" class="btn btn-danger btn-xs"
                                               data-tr="tr_{{$user->id}}"
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
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        {{ $users->links() }}
                    </div>
                @else
                    <p class="alert alert-info">
                        Nessun Utente Trovato.
                    </p>
                @endif
            </div>
            <div class="panel-footer">
                <h4>Guida :</h4>
                @foreach($roles as $role)
                    <b>{{ $role->name }}</b>
                    {{ $role->description }}
                    </br><br>
                @endforeach
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <!-- DataTable -->
    <script type="text/javascript" src="{{ asset('js/DataTables/datatables.min.js') }}"></script>


    <script>
        $(document).ready(function() {
            $('#users').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Italian.json"
                }
            });
        } );
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('[data-toggle=confirmation]').confirmation({
                rootSelector: '[data-toggle=confirmation]',
                onConfirm: function (event, element) {
                    element.trigger('confirm');
                }
            });

            $(document).on('confirm', function (e) {
                var ele = e.target;
                e.preventDefault();

                $.ajax({
                    url: ele.href,
                    type: 'DELETE',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function (data) {

                        if (data['success']) {
                            $("#" + data['tr']).slideUp("slow");
                            alert(data['success']);
                        } else if (data['error']) {
                            alert(data['error']);
                        } else {
                            alert('Qualcosa sembra essere andato storto !');
                        }
                    },
                });

                return false;
            });
        });
    </script>

@endsection