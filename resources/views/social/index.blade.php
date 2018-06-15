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
                Social Attualmente Installati e Funzionanti
            </div>
            <div class="panel-body">
                @if (count($socials))
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Canale</th>
                                <th>Nome</th>
                                <th>Tipo</th>
                                <th>Connesso il</th>
                                <th>Ultimo Accesso</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($socials as $social)
                                <tr>
                                    <td><a class="btn btn-social-icon btn-{{ $social->name }}"><span class="fa fa-{{ $social->name }}"></span></a></td>
                                    <td>{{ $social->name }}</td>
                                    <td>{{ $social->description }}</td>
                                    <td>{{ $social->created_at->format('m-d-Y') }}</td>
                                    <td>{{ $social->updated_at->format('m-d-Y') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <p>Per installare nuovi provider, consultare la documentazione allegata.</p>
                    </div>
                    <div class="text-center">
                        {{--{{ $channels->links() }}--}}
                    </div>
                @else
                    <p class="alert alert-info">
                        Nessun social attivo!
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection