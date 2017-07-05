@extends('layouts/adminLayout')
@section('content')
<section>
    @include('audits/partials/menuLeftAudit')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="report-marco ">
                        <div class="contenedor-report">
                            <h4>Detalle Auditoria {{$detailAudit->fullname}}</h4>
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">Cliente:</div>
                                <div   class="btn btn-default btn-valor">{{$customer->fullname}}</div>
                            </div>
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">Campaña:</div>
                                <div   class="btn btn-default btn-valor">{{$campaigne->fullname}}</div>
                            </div>
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">PDV auditadas:</div>
                                <div   class="btn btn-default btn-valor">{{$registros}}</div>
                            </div>
                        </div>
                    </div>

                    <div class="report-marco ">
                        <div class="contenedor-report">
                            Codigo: {{$store_detail->id}}
                             |
                            Tienda: {{$store_detail->fullname}}
                             |
                            Dirección: {{$store_detail->address}}
                        </div>
                    </div>

                    <div class="row pt pb">
                        <div class="col-sm-12">
                            @if ($audit_id==2)
                            <table class="table-responsive table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>codigo Prod.</th>
                                    <th>Producto</th>
                                    <th>EAN</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($datosDetail as $index => $presence)
                                    <tr>
                                        <td>{{$index +1}}</td>
                                        <td>{{ $presence->presence->product_id }}</td>
                                        <td >{{ $presence->presence->product->fullname }}</td>
                                        <td >{{ $presence->presence->product->eam }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @endif

                            @if ($audit_id==3)

                                @foreach ($datosDetail as $index => $detailStore)
                                    <div class="panel panel-default">
                                        @if($detailStore['publicity_id']==0)
                                            <div class="panel-heading">
                                                <h3 class="panel-title">No hay datos</h3>
                                            </div>
                                        @else
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><span class="badge">{{$index +1}} </span> {{$detailStore['publicity_id'].' - '.$detailStore['fullname']}}</h3>
                                            </div>
                                            <div class="panel-body">

                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <b> LAYOUT:  </b>@if($detailStore['layout']==1) Cumple @else No Cumple @endif<br/>
                                                        <b> VISIBLE:  </b>@if($detailStore['visible']==1) Visible @else No Visible @endif <br/>
                                                        <b> CONTAMINADO:  </b>@if($detailStore['contaminated']==1) Contaminado @else No Contaminado @endif<br/>
                                                        <b> COMENTARIOS:  </b>{{$detailStore['comment']}}<br/>
                                                        <b> FECHA DE INGRESO:  </b>{{$detailStore['fechaCreated']}}<br/>
                                                        <b> FECHA DE ACTUALIZACIÓN:  </b>{{$detailStore['fechaUpdated']}}<br/>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">

                                                        @foreach ($detailStore['arrayFoto'] as $index1 => $detailFoto)
                                                            @if ($detailFoto['id']==0)

                                                            @else
                                                                <a href="{{$detailFoto['urlFoto']}}" class="zoom1 btn btn-default" data-fancybox-group="button"><img src="{{$detailFoto['urlFoto']}}" width="90px" class="img-thumbnail"></a>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>

                                            </div>
                                        @endif

                                    </div>
                                @endforeach
                            @endif

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

@endsection