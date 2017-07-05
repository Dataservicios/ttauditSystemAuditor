@extends('layouts/clienteBayer')
@section('content')
@section('pageTitle', $aleatorio)
    <section>
        @include('report/partials/menuPrincipalColgate')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <!--sección titulo y buscador-->

            <div class="row pt pb">
                <div class="col-sm-12">
                    <h4 class="report-title">
                        @if(($question->question=='¿Se encuentra abierto el establecimiento?') and ($pregSino==0))
                            Locales Cerrados {{$companyObj->fullname}}
                        @else
                            @if(($question->question=='¿Recibio Premio?') and ($pregSino==0))
                                No Recibieron Premio {{$companyObj->fullname}}
                            @else
                                @if(($question->question=='¿Tiene exhibición Bayer?') and ($pregSino==1))
                                    Posee Visibilidad de Bayer {{$companyObj->fullname}}
                                @else
                                    {{$question->question}} Respuesta: @if($pregSino==0) NO @else SI @endif
                                @endif
                            @endif
                        @endif
                    </h4>

                    @if($city<>"0")
                        <div id="alertaFiltro" class="alert alert-info alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                                <strong>Filtrado por:</strong> Ciudad
                                @if($city==5)
                                    Todas las Provincias menos Lima
                                @else
                                    {{$city}}
                                @endif

                            @if($district<>"0")
                                , Distrito {{$district}}
                            @endif
                            @if($ejecutivo<>"0")
                                , Ejecutivo {{$ejecutivo}}
                            @endif
                            @if($rubro<>"0")
                                , Rubro {{$rubro}}
                            @endif
                            .
                        </div>
                    @endif
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
                                        <h3 class="panel-title"><span class="badge">{{$index +1}} </span> {{$detailStore['type'].' - '.$detailStore['fullname'].'('.$detailStore['store_id'].')'}}</h3>
                                    </div>
                                    <div class="panel-body">

                                        <div class="row">
                                            <div class="col-sm-8">
                                                <b> CADENA RUC:  </b>{{$detailStore['cadenaRuc']}}<br/>
                                                <b> DEPARTAMENTO:  </b>{{$detailStore['departamento']}}<br/>
                                                <b> PROVINCIA:  </b>{{$detailStore['Provincia']}} <br/>
                                                <b> DISTRITO:  </b>{{$detailStore['distrito']}}<br/>
                                                @if ($detailStore['comentario']<>'')
                                                <b> COMENTARIO DE LA PREGUNTA:  </b>{{$detailStore['comentario']}}<br/>
                                                @endif
                                                @if($detailStore['otroComentario']<>'')
                                                <b> OTROS COMENTARIOS:  </b>{{$detailStore['otroComentario']}}<br/>
                                                @endif
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