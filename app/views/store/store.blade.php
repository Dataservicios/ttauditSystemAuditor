@extends('layouts/adminLayout')
@section('content')
    <section>
        @include('store/partials/menuLeft')
        <div class="cuerpo">
            <div class="cuerpo-content">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Editar Punto de Venta</h4>
                        <div class="cuerpo-content">
                            <div class="row">
                                <div class="col-md-6">
                                    {{ Form::model($store, ['route' => ['storeUpdate',$store->id], 'method' => 'PUT', 'role' => 'form', 'class' => 'form-horizontal' , 'validate']) }}
                                    <div class="form-group">
                                        {{ Form::label('codclient', 'DIR',['class' => 'col-sm-4 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::text('codclient', null, ['class' => 'form-control']) }}
                                            {{ $errors->first('codclient', '<div class="alert alert-danger" role="alert">:message</div>') }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('fullname', 'Nombre',['class' => 'col-sm-4 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::text('fullname', null, ['class' => 'form-control']) }}
                                            {{ $errors->first('fullname', '<div class="alert alert-danger" role="alert">:message</div>') }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('cadenaRuc', 'Cadena/Ruc',['class' => 'col-sm-4 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::text('cadenaRuc', null, ['class' => 'form-control']) }}
                                            {{ $errors->first('cadenaRuc', '<div class="alert alert-danger" role="alert">:message</div>') }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('latitude', 'Latitud',['class' => 'col-sm-4 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::text('latitude', null, ['class' => 'form-control']) }}
                                            {{ $errors->first('latitude', '<div class="alert alert-danger" role="alert">:message</div>') }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('longitude', 'Longitud',['class' => 'col-sm-4 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::text('longitude', null, ['class' => 'form-control']) }}
                                            {{ $errors->first('longitude', '<div class="alert alert-danger" role="alert">:message</div>') }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('address', 'Direcc.',['class' => 'col-sm-4 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::text('address', null, ['class' => 'form-control']) }}
                                            {{ $errors->first('address', '<div class="alert alert-danger" role="alert">:message</div>') }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('urbanization', 'Urban.',['class' => 'col-sm-4 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::text('urbanization', null, ['class' => 'form-control']) }}
                                            {{ $errors->first('urbanization', '<div class="alert alert-danger" role="alert">:message</div>') }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('district', 'Distrito',['class' => 'col-sm-4 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::text('district', null, ['class' => 'form-control']) }}
                                            {{ $errors->first('district', '<div class="alert alert-danger" role="alert">:message</div>') }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('region', 'Reg',['class' => 'col-sm-4 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::text('region', null, ['class' => 'form-control']) }}
                                            {{ $errors->first('region', '<div class="alert alert-danger" role="alert">:message</div>') }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('ubigeo', 'Departamento',['class' => 'col-sm-4 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::text('ubigeo', null, ['class' => 'form-control', 'placeholder' => 'Ubigeo']) }}
                                            {{ $errors->first('ubigeo', '<div class="alert alert-danger" role="alert">:message</div>') }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class=" col-sm-10">
                                            <input type="submit" value="Actualizar" class="btn btn-success">
                                        </div>
                                    </div>
                                    {{ Form::close() }}

                                </div>
                                <div class="col-md-6">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop