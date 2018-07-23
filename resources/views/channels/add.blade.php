@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session()->has('status'))
            <p class="alert alert-info">
                {{	session()->get('status') }}
            </p>
        @endif
                <div class="col-sm-12">
                    <form action="{{ route('channel.post') }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>Componi il post @if (isset($user)) - Utente selezionato : {{ $user->name }} @endif</h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <small id="messageHelp" class="form-text text-muted">Inserire il testo del messaggio</small>
                                <textarea name="message" value="" rows="5" class="form-control">Cosa vuoi pubblicare ?</textarea>
                            </div>

                            <small id="urlHelp" class="form-text text-muted">Inserire l'eventuale URL da condividere</small>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-addon">http://</span>
                                    <input type="text" class="form-control" value="" name="link">
                                </div>

                            <div class="form-group">
                                <small id="fileHelp" class="form-text text-muted">Scegliere l'eventuale immagine da caricare. L'immagine non deve superare la dimensione di 2MB.</small>
                                <input type="file" class="form-control-file" name="source" id="fileToUpload" aria-describedby="fileHelp">
                            </div>

                        @if (count($channels))
                            <div class="">
                                <small id="channelHelp" class="form-text text-muted text-danger">Prego, scegliere almeno un canale. NB. L'upload via instagram non è disponibile con l'attuale versione del framework.</small>
                                <table class="table table-bordered table-sm m-0">
                                    <thead>
                                    <tr>
                                        <th style="width: 10%">Seleziona</th>
                                        <th style="width: 10%">Social</th>
                                        <th>Nome Canale</th>
                                        <th>Tipo</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($channels as $channel)
                                        @if ($channel->type != 'Profile')
                                            @if (@$channel->socials->name != 'instagram')
                                                <tr>
                                                    <td>
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" style="display: none;" name="channels[]" value="{{ @$channel->id }}">
                                                            <span class="custom-control-indicator"></span>
                                                        </label>
                                                    </td>
                                                    <td><a class="btn btn-social-icon btn-{{ @$channel->socials->name }}"><span class="fa fa-{{ @$channel->socials->name }}"></span></a>                                   </td>
                                                    <td><a href="{{ $channel->channel_URL }}" target=_blank>{{ $channel->name }}</a></td>
                                                    <td>{{ $channel->type }}</td>
                                                </tr>
                                            @endif
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-success" value="Aggiungi Post">
                                    <a href="{{ route('channels.index') }}" class="btn btn-danger"><< Indietro</a>
                                </div>
                            </div>
                            <div class="text-center">
                                {{--{{ $channels->links() }}--}}
                            </div>
                        @else
                            <p class="alert alert-info">
                                Nessun canale disponibile. Andare alla <a href="{{ route('channels.create') }}">Gestione Canali</a>, per aggiungere nuovi social.
                            </p>
                        @endif
                    </div>
                </div>
                    </form>
                </div>
    </div>
@endsection