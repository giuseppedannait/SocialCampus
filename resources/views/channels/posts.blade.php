@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session()->has('status'))
            <p class="alert alert-info">
                {{ session()->get('status') }}
            </p>
        @endif

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="btn-group">

                        <a href="{{ route('channels.index') }}" class="btn btn-danger btn-sm"><< Indietro</a>
                        <a href="{{ route('channels.show', $channels->id) }}" class="btn btn-success btn-sm">Aggiorna i dati</a>
                        <a href="{{ route('facebook.posts.show', ['name' => $channels->name]) }}" class="btn btn-info btn-sm">Visualizza JSON</a>
                        <a href="/public/export12341451.cvs" target="_blank" class="btn btn-info btn-sm">Esporta in CVS</a>

                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2><a class="btn btn-social-icon btn-{{ $provider }}"><span class="fa fa-{{ $provider }}"></span></a> Tabella dei Post per {{ ucfirst($provider) }} </h2>
                </div>
            </div>

    @if(isset($provider))
        @switch($provider)

            @case('facebook')
                @include('channels.posts.facebook')
            @break

            @case('twitter')
                @include('channels.posts.twitter')
            @break

            @case('instagram')
                @include('channels.posts.instagram')
            @break

        @endswitch
    @endif

    </div>

@endsection

@section('scripts')

    <!-- DataTable -->
    <script type="text/javascript" src="{{ asset('js/DataTables/datatables.min.js') }}"></script>

    <script>
        
        $(document).ready(function() {
            // Setup - add a text input to each footer cell
            $('#posts tfoot th').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" placeholder="Cerca '+title+'" />' );
            } );

            // DataTable
            var table = $('#posts').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Italian.json"
                }
            });

            // Apply the search
            table.columns().every( function () {
                var that = this;

                $( 'input', this.footer() ).on( 'keyup change', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        } );
    </script>

@endsection

