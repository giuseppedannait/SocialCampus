@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session()->has('status'))
            <p class="alert alert-info">
                {{	session()->get('status') }}
            </p>
        @endif
            <form action="{{ route('channel.post') }}" style="display:inline-block" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf

            <div class="panel panel-default">
                <div class="panel-heading">
                    <p>Componi il post :</p>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <textarea name="message" value="" rows="5" class="form-control">Cosa vuoi pubblicare ?</textarea>
                                            <small id="messageHelp" class="form-text text-muted">Inserire il testo del messaggio</small>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" value="" name="link">
                                            <small id="urlHelp" class="form-text text-muted">Inserire l'eventuale URL da condividere</small>
                                        </div>
                                        <div class="form-group">
                                            <input type="file" class="form-control-file" name="source" id="fileToUpload" aria-describedby="fileHelp">
                                            <small id="fileHelp" class="form-text text-muted">Scegliere l'eventuale immagine da caricare. L'immagine non deve superare la dimensione di 2MB.</small>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel-heading">
                    Scegli il canale sul quale pubblicare :
                    <small id="channelHelp" class="form-text text-muted">Prego, scegliere almeno un canale.</small>
                </div>
                <div class="panel-body">
                    @if (count($channels))
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Select</th>
                                    <th>Canale</th>
                                    <th>Nome</th>
                                    <th>Tipo</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($channels as $channel)
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <div class="material-switch pull-right">
                                                        <input type="checkbox" name="channels[]" value="{{  @$channel->id }}"/>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><a class="btn btn-social-icon btn-{{ @$channel->socials->first()->name }}"><span class="fa fa-{{ @$channel->socials->first()->name }}"></span></a></td>
                                            <td>{{ $channel->name }}</td>
                                            <td>{{ $channel->type }}</td>

                                        </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="form-group">
                                <input type="submit" class="btn btn-success" value="Aggiungi Post">
                            </div>
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
     </form>
    </div>
@endsection