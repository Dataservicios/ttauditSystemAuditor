@extends('layouts/adminLayout')
@section('content')
<section>
    @include('report/partials/menuPrincipalInterbank')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <div class="row pt pb">
                <div class="col-sm-9">
                    <h4 class="report-title">Detalle Ruta Campaña: {{$titulo}}</h4>
                </div>
                <div class="col-sm-3">
                    <img src="{{$logo}}" width="100px">
                </div>
            </div>
            <div class="row pt pb">
                <div class="col-sm-12">
                    <div class="report-marco ">
                        <div class="contenedor-report">
                            <h4>Nombre Ruta: {{$road->fullname}} </h4>
                            <span id="pdvs">{{count($roadDetalles)}}</span><span> PDV</span><br>
                            Codigo Ruta: {{$road->id}} |
                            Situación:
                            @if(count($roadDetalles) == $auditados)
                                <a href="#" data-toggle="tooltip" data-placement="bottom" title="Puntos totalmente Auditados">
                                    <span class="icon-indicador icon-table-size icon-color-green"></span>
                                </a>
                            @else
                                <a href="#" data-toggle="tooltip" data-placement="bottom" title="PDV aún por Auditar">
                                    <span class="icon-indicador icon-table-size icon-color-red"></span>
                                </a>
                            @endif
                            |
                            PDV Auditados: {{$auditados}} |
                            Auditor: {{$road->user->fullname}} | Campaña:{{$titulo}}
                        </div>
                    </div>

                </div>
            </div>

            <div class="row pt pb">
                <div class="col-sm-12">
                    <div class="report-marco ">
                        <div class="contenedor-report">
                            <h4>Listado de Agentes</h4>
                            <table class="table-responsive table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Id</th>
                                    <th>Tipo</th>
                                    <th>Cadena Ruc</th>
                                    <th>Nombre</th>
                                    <th>Dirección</th>
                                    <th>Distrito</th>
                                    <th>Region</th>
                                    <th>Departamento</th>
                                    <th>Fecha Ingreso</th>
                                    <th>Auditado</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($roadDetalles as $index => $roadDetail)
                                    <tr id="{{$roadDetail->store->id}}">
                                        <td>{{$index +1}}</td>
                                        <td><a href="">{{ $roadDetail->store->id }}</a></td>
                                        <td ><a href="">{{ $roadDetail->store->type }}</a></td>
                                        <td ><a href="">{{ $roadDetail->store->cadenaRuc }}</a></td>
                                        <td>{{ $roadDetail->store->fullname }}</td>
                                        <td>{{ $roadDetail->store->address}}</td>
                                        <td>{{ $roadDetail->store->district }}</td>
                                        <td>{{ $roadDetail->store->region }}</td>
                                        <td>{{ $roadDetail->store->ubigeo }}</td>
                                        <td>{{ $roadDetail->created_at }}</td>
                                        <td><a href="#" data-toggle="tooltip" data-placement="bottom" title="@if($roadDetail->audit==0) No Auditado @else Auditado @endif">
                                                <span class="@if($roadDetail->audit==0)icon-indicador icon-table-size icon-color-red @else icon-indicador icon-table-size icon-color-green @endif"></span>
                                            </a>
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@stop
@section('reportCSS')
    <!-- Galeria de imagenes -->
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/fancybox/jquery.fancybox.css?v=2.1.5') }}" media="screen" />
    <!-- Add Button helper (this is optional) -->
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5') }}" />
@endsection
@section('report')
        <!--LIBRERIA fancybox PARA ZOOM PARA IMÁGENES-->
{{ HTML::script('lib/fancybox/jquery.fancybox.js?v=2.1.5'); }}
{{ HTML::script('lib/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5'); }}
{{ HTML::script('lib/fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7'); }}
{{ HTML::script('lib/fancybox/helpers/jquery.fancybox-media.js?v=1.0.6'); }}
<script>
    $('.zoom1').fancybox(  {
        openEffect : 'elastic',
        openSpeed  : 150,

        closeEffect : 'elastic',
        closeSpeed  : 150,

        prevEffect : 'none',
        nextEffect : 'none',

        closeBtn  : true,

        helpers : {
            title : {
                type : 'inside'
            },
            buttons : {}
        },

        afterLoad : function() {
            this.title = 'Imagen ' + (this.index + 1) + ' de ' + this.group.length + (this.title ? ' - ' + this.title : '');
        }
    });
</script>

<script>
    $('#alertaFiltro').on('closed.bs.alert', function () {
        // do something…
        console.log("Cerrando alerta");
    })
</script>
@endsection