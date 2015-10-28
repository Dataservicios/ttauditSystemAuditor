@extends('layouts/adminLayout')
@section('content')
<section>
    @include('users/partials/menuLeft')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <div class="row">
                <div class="col-md-6">
                    <h1>Registrar Usuario</h1>
                    {{ Form::open(['route' => 'register', 'method' => 'POST', 'role' => 'form', 'novalidate']) }}
                        <div class="form-group">
                            {{ Form::label('fullname', 'Nombre completo') }}
                            {{ Form::text('fullname', null, ['class' => 'form-control']) }}
                            {{ $errors->first('fullname', '<div class="alert alert-danger" role="alert">:message</div>') }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('email', 'Correo') }}
                            {{ Form::text('email', null, ['class' => 'form-control']) }}
                            {{ $errors->first('email', '<p class="alert alert-warning">:message</p>') }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('type', 'Tipo') }}
                            {{ Form::select('type', $user_types, ['class' => 'form-control']) }}
                            {{ $errors->first('type', '<p class="alert alert-warning">:message</p>') }}
                        </div>

                        <div class="form-group">
                            {{ Form::label('password', 'Password') }}
                            {{ Form::password('password', ['class' => 'form-control']) }}
                            {{ $errors->first('password', '<p class="alert alert-warning">:message</p>') }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('password_confirmation', 'Repite Password') }}
                            {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
                            {{ $errors->first('password_confirmation', '<p class="alert alert-warning">:message</p>') }}
                        </div>
                        <p>
                            <input type="submit" value="Register" class="btn btn-success">
                        </p>
                    {{ Form::close() }}
                </div>
            </div>

        </div>
    </div>
</section>
@stop