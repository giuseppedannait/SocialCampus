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
                    @if (!isset($user))
                        <a href="{{ route('channels.create') }}" class="btn btn-success btn-sl">Aggiungi Canale</a>
                    @else
                        <a href="{{ route('channels.user.add', $user->id) }}" class="btn btn-info btn-sl">Scrivi Post</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Canali Social @if (isset($user)) - Utente Selezionato : {{ $user->name }} @endif</h4>
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
                                <tr id="tr_{{ $channel->id }}">
                                    <td><a class="btn btn-social-icon btn-{{ @$channel->socials->name }}"><span class="fa fa-{{ @$channel->socials->name }}"></span></a></td>
                                    <td><a href="{{ $channel->channel_URL }}" target="_blank">{{ $channel->name }}</a></td>
                                    <td>{{ $channel->type }}</td>
                                    <td>{{ $channel->category }}</td>
                                    <td>{{ $channel->created_at->format('m-d-Y') }}</td>
                                    <td>
                                        @if($channel->type != 'Profile')
                                            <a href="{{ route('channels.show', $channel->id ) }}" class="btn btn-success btn-xs">Vedi Canale</a>
                                            <a href="{{ route('channels.posts', $channel->id ) }}" class="btn btn-info btn-xs">Vedi Posts</a>
                                        @endif
                                        {{--<form action="{{ route('channels.destroy', $channel->id) }}" method="POST" style="display:inline-block">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button class="btn btn-danger btn-xs">
                                                <span>X</span>
                                            </button>
                                        </form>--}}
                                            <a href="{{ route('channels.destroy', $channel->id) }}" class="btn btn-danger btn-xs"
                                               data-tr="tr_{{$channel->id}}"
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
