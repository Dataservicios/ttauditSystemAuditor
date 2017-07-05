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
                                <h4>Detalle Material {{$detailStores[0]['publicidad']}}</h4>
                                <div class="btn-group" role="group" aria-label="...">
                                    <div   class="btn btn-default btn-si">Condición:</div>
                                    <div   class="btn btn-default btn-valor">{{$detCond}}</div>
                                </div>
                                <div class="btn-group" role="group" aria-label="...">
                                    <div   class="btn btn-default btn-si">Cumple:</div>
                                    <div   class="btn btn-default btn-valor">{{$detTipo}}</div>
                                </div>
                                <div class="btn-group" role="group" aria-label="...">
                                    <div   class="btn btn-default btn-si">Material encontrado en:</div>
                                    <div   class="btn btn-default btn-valor">{{count($detailStores)}} PDV</div>
                                </div>
                            </div>
                        </div>


                        <div class="row pt pb">
                            <div class="col-sm-12">
                                @if ($numPublicidad<>0)
                                    @foreach ($detailStores as $index => $detailStore)
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><span class="badge">{{$index+1}} </span> Mayorista: {{$detailStore['mayorista']}}</h3>
                                            </div>
                                            <div class="panel-body">

                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <b> CODIGO:  </b>{{$detailStore['store_id']}}<br/>
                                                        <b> DIRECCIÓN:  </b>{{$detailStore['store_direccion']}}<br/>
                                                        <b> COMENTARIOS:  </b>{{$detailStore['comentario']}}<br/>
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
                                        </div>
                                    @endforeach
                                    @else
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">No hay datos</h3>
                                        </div>
                                    </div>
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