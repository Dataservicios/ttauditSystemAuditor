@extends('layouts/adminLayout')
@section('content')
<section>
    @include('store/partials/menuLeft')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <div class="row">
                <div class="col-md-12">
                    <h4>Importar Punto de Venta</h4>
                    <div class="cuerpo-content">
                        <div class="row">
                            <div class="col-md-4">
                                {{ Form::open(['route' => 'registerStore', 'files' => true, 'method' => 'POST', 'role' => 'form', 'class' => 'form-horizontal', 'id' => 'store' , 'validate']) }}


                                    <div class="form-group">
                                        {{ Form::label('photo', 'Importar',['class' => 'col-sm-4 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::file('photo') }}
                                            {{ $errors->first('photo', '<div class="alert alert-danger" role="alert">:message</div>') }}
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