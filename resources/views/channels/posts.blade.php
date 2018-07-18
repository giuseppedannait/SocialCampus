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

    <!-- CSS Datatables Button -->
    <link type="text/css" href="https://cdn.datatables.net/buttons/1.1.2/css/buttons.dataTables.min.css" rel="stylesheet">

    <!-- DataTable -->
    <script type="text/javascript" src="{{ asset('js/DataTables/datatables.min.js') }}"></script>

    <!-- Buttons -->
    <script type="text/javascript" src="https://cdn.datatables.net/tabletools/2.2.4/js/dataTables.tableTools.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/tabletools/2.2.2/swf/copy_csv_xls_pdf.swf"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

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
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Italian.json",
                },
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print', {
                        text: 'JSON',
                        action: function ( e, dt, button, config ) {
                            var data = dt.buttons.exportData();

                            $.fn.dataTable.fileSave(
                                new Blob( [ JSON.stringify( data ) ] ),
                                'Export.json'
                            );
                        }
                    }

                ]
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
                    type: 'GET',
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

