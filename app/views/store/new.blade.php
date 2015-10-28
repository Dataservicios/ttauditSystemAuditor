@extends('layouts/adminLayout')
@section('content')
<section>
    @include('store/partials/menuLeft')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <div class="row">
                <div class="col-md-12">
                    <h4>Nuevo Punto de Venta</h4>
                    <div class="cuerpo-content">
                        <div class="row">
                            <div class="col-md-4">
                                {{ Form::open(['route' => 'registerStore', 'files' => true, 'method' => 'POST', 'role' => 'form', 'class' => 'form-horizontal', 'id' => 'store' , 'validate']) }}
                                    <div class="form-group">
                                        {{ Form::label('fullname', 'Nombre',['class' => 'col-sm-4 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::text('fullname', null, ['class' => 'form-control', 'placeholder' => 'Nombre']) }}
                                            {{ $errors->first('fullname', '<div class="alert alert-danger" role="alert">:message</div>') }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('type', 'Tipo',['class' => 'col-sm-4 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::select('type', $store_types, ['class' => 'form-control']) }}
                                            {{ $errors->first('type', '<div class="alert alert-danger" role="alert">:message</div>') }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('photo', 'Foto',['class' => 'col-sm-4 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::file('photo') }}
                                            {{ $errors->first('photo', '<div class="alert alert-danger" role="alert">:message</div>') }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('latitude', 'Latitud',['class' => 'col-sm-4 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::text('latitude', null, ['class' => 'form-control', 'placeholder' => 'Latitud']) }}
                                            {{ $errors->first('latitude', '<div class="alert alert-danger" role="alert">:message</div>') }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('longitude', 'Longitud',['class' => 'col-sm-4 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::text('longitude', null, ['class' => 'form-control', 'placeholder' => 'Longitud']) }}
                                            {{ $errors->first('longitude', '<div class="alert alert-danger" role="alert">:message</div>') }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('owner', 'Propietario',['class' => 'col-sm-4 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::text('owner', null, ['class' => 'form-control', 'placeholder' => 'Propietario']) }}
                                            {{ $errors->first('owner', '<div class="alert alert-danger" role="alert">:message</div>') }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('address', 'Dirección',['class' => 'col-sm-4 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::text('address', null, ['class' => 'form-control', 'placeholder' => 'Dirección']) }}
                                            {{ $errors->first('address', '<div class="alert alert-danger" role="alert">:message</div>') }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('urbanization', 'Urbanización',['class' => 'col-sm-4 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::text('urbanization', null, ['class' => 'form-control', 'placeholder' => 'Urbanización']) }}
                                            {{ $errors->first('urbanization', '<div class="alert alert-danger" role="alert">:message</div>') }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('district', 'Distrito',['class' => 'col-sm-4 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::text('district', null, ['class' => 'form-control', 'placeholder' => 'Distrito']) }}
                                            {{ $errors->first('district', '<div class="alert alert-danger" role="alert">:message</div>') }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('region', 'Región',['class' => 'col-sm-4 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::text('region', null, ['class' => 'form-control', 'placeholder' => 'Región']) }}
                                            {{ $errors->first('region', '<div class="alert alert-danger" role="alert">:message</div>') }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('ubigeo', 'Ubigeo',['class' => 'col-sm-4 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::text('ubigeo', null, ['class' => 'form-control', 'placeholder' => 'Ubigeo']) }}
                                            {{ $errors->first('ubigeo', '<div class="alert alert-danger" role="alert">:message</div>') }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('distributor', 'Distribuidor',['class' => 'col-sm-4 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::text('distributor', null, ['class' => 'form-control', 'placeholder' => 'Distribuidor']) }}
                                            {{ $errors->first('distributor', '<div class="alert alert-danger" role="alert">:message</div>') }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class=" col-sm-10">
                                            <button type="submit" class="btn btn-default btn-sm">GUARDAR</button>
                                            <button type="submit" class="btn btn-default btn-sm">CANCELAR</button>
                                        </div>
                                    </div>
                                {{ Form::close() }}

                            </div>
                            <div class="col-md-8">
                                <!-- MAPA CANVAS -->
                                <div id="map_canvas">
                                    <!-- css3 preLoading-->
                                    <div class="mapPerloading"> <span>Cargando</span>
                                        <span class="l-1"></span>
                                        <span class="l-2"></span>
                                        <span  class="l-3"></span>
                                        <span class="l-4"></span>
                                                        <span class="l-5">
                                                        </span>
                                        <span class="l-6"></span>
                                    </div>
                                </div>
                                <!-- END MAPA CANVAS -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
@section('mapa')
    <!-- google maps -->
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
        {{ HTML::script('lib/infobox.min.js'); }}
        {{ HTML::script('js/new-mapa.js'); }}
        <!--  end google maps -->

        <script>
            init('-12.08972444990665','-77.02266831398015');
        </script>
@endsection