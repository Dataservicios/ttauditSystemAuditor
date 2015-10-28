@extends('layouts/layout')
@section('content')
    <div class="container-full-width">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 pb pt">
                    <img class="logo" src="img/logo.png" alt=""/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="cuadro-login">
                    <div class="row">
                        <div class="col-md-12">
                        @if (Auth::check())
                            @if (Auth::user()->type=='auditor')
                                {{Redirect::to('auditor');}}
                            @endif
                            @if (Auth::user()->type=='admin')
                                {{ Redirect::to('admin/panel'); }}
                            @endif
                            @if (Auth::user()->type=='company')
                                {{ Redirect::to('report'); }}
                            @endif
                        @else
                            {{ Form::open(['route' => 'login', 'method' => 'POST', 'role' => 'form', 'class' => '']) }}
                                @if (Session::has('login_error'))
                                    <span class="label label-danger">Credenciales NO válidas</span>
                                @endif
                                <p><span class="icon-security"> </span>Iniciar Sesión</p>
                                <div class="controles">
                                    <div class="form-group">
                                        <span class="icon-user"></span>
                                        {{ Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'EMAIL']) }}
                                    </div>
                                    <div class="form-group">
                                        <span class="icon-llave"></span>
                                        {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'PASSWORD']) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="remember-me">
                                        {{ Form::checkbox('remember') }} Recordarme
                                    </label>
                                </div>
                                <input type="submit" class="btn btn-default center-block" value="INGRESAR"/>
                            {{ Form::close() }}
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop