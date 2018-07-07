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
                <div><a href="{{ route('users.create') }}" class="btn btn-success btn-xs">Add User</a></div>
                Utenti associati al tuo account :
            </div>
            <div class="panel-body">
                @if (count($users))
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Creato il</th>
                                <th>Aggiornato il</th>
                                <th>Ruolo</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                @if (!($user->name == 'Paperino'))
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('m-d-Y') }}</td>
                                    <td>{{ $user->updated_at->format('m-d-Y') }}</td>
                                    <td>{{ @$user->roles->first()->name }}</td>
                                    <td>
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-success btn-xs">Edit</a>
                                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-xs">View</a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button class="btn btn-danger btn-xs">
                                                <span>DELETE</span>
                                            </button>
                                        </form>
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
                        No Listing Found
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection