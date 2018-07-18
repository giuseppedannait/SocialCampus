@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session()->has('status'))
            <p class="alert alert-info">
                {{	session()->get('status') }}
            </p>
        @endif
        <div class="col-sm-12">
            <form action="{{ route('channels.post.comment.publish', ['channel_id' => $channel_id, 'post_id' => $post_id]) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>Scrivi il commento</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <small id="messageHelp" class="form-text text-muted">Inserire il testo del commento</small>
                            <textarea name="comment" value="" rows="5" class="form-control">Scrivi il commento ...</textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" value="Aggiungi Commento">
                            <a href="{{ url()->previous() }}" class="btn btn-danger"><< Indietro</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection