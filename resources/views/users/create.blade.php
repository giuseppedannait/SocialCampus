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
                <div class="panel-heading">
                    <h4>Crea Nuovo Utente</h4>
                </div>
                <div class="panel-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        @method('POST')

                        @if (isset($errors) && (count($errors) > 0))
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="name">Nome:</label>
                                    <input type="text" class="form-control" name="name" value="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="name">Email:</label>
                                    <input type="text" class="form-control" name="email" value="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="name">Password:</label>
                                    <input type="password" class="form-control" name="password" hidden value="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="name">Ruolo:</label>
                                    <select class="form-control" name="role">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Aggiungi</button>
                                    <a href="{{ route('users.index') }}" class="btn btn-danger btn-sm"><< Indietro</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="panel-footer">
                    <h4>Guida :</h4>
                    @foreach($roles as $role)
                        <b>{{ $role->name }}</b>
                        {{ $role->description }}
                        </br></br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection