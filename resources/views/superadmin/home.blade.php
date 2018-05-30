@extends('layouts.app')
 
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Super Admin Dashboard</div>
 
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
 
                        Questa è la pagina del Super Admin. Devi avere i privilegi per poter accedere a questa sezione.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection