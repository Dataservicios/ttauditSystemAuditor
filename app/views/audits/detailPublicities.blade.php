@extends('layouts/adminLayout')
@section('content')
    <section>
        @include('audits/partials/menuLeftAudit')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <!--sección titulo y buscador-->

            <div class="row pt pb">
                <div class="col-sm-12">
                    <h4 class="report-title">Lista de Materiales Alicorp Campaña: {{$campaigne_name}}</h4>

                    <div class="row pt pb">
                        <div class="col-sm-12">
                            @foreach ($datosStores as $index => $detailStore)
                            <div class="panel panel-default">
                                @if($detailStore['store_id']==0)
                                    <div class="panel-heading">
                                        <h3 class="panel-title">No hay datos</h3>
                                    </div>
                                @else
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><span class="badge">{{$index +1}} </span> {{$detailStore['tipo'].' - '.$detailStore['tipo_bodega'].' - '.$detailStore['fullname'].'('.$detailStore['store_id'].')'}}</h3>
                                    </div>
                                    <div class="panel-body">

                                        <div class="row">
                                            <div class="col-sm-8">
                                                <b> DIRECCIÓN:  </b>{{$detailStore['direccion']}}<br/>
                                                <b> DEPARTAMENTO:  </b>{{$detailStore['departamento']}}<br/>
                                                <b> PROVINCIA:  </b>{{$detailStore['Provincia']}} <br/>
                                                <b> DISTRITO:  </b>{{$detailStore['distrito']}}<br/>
                                                <b> FECHA:  </b>{{$detailStore['fecha']}}<br/>
                                            </div>
                                            <div class="col-sm-4">

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