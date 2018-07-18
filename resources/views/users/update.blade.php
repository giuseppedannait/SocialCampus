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
                    <h4>Modifica Utente</h4>
                </div>
                <div class="panel-body">
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

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
                                    <input type="text" class="form-control" name="name" value="{{$user->name}}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="name">Email:</label>
                                    <input type="text" class="form-control" name="email" value="{{$user->email}}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="name">Password:</label>
                                    <input type="password" class="form-control" name="password" hidden value="{{$user->password}}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="name">Ruolo:</label>
                                    <select class="form-control" name="role">
                                        @foreach($roles as $role)
                                            <option name="role" value="{{ $loop->iteration }}" @if ($loop->iteration == $user->roles[0]->id) selected="selected" @endif>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        @if ($selectedRole == 'SOCIAL_USER')
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="name">Associato sl SMM:</label>
                                        <select class="form-control" name="associate">
                                            <option value="" selected="selected">Nessun SMM associato ...</option>
                                            @foreach($associates as $associate)
                                                <option value="{{ $associate->id }}" @if ($user->id_smm == $associate->id) selected="selected" @endif>{{ $associate->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Salva</button>
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