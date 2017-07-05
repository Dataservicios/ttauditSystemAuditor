@extends('layouts/adminLayout')
@section('content')
<section>
    @include('audits/partials/menuLeftAudit')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <div class="row pt pb">
                <div class="col-sm-9">
                    <h4 class="report-title">SOD {{$titulo}}</h4>
                </div>
                <div class="col-sm-3">
                    <img src="{{$logo}}" width="100px">
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 pb">
                    @if(count($datosStores)>0)
                        @foreach($datosStores as $index => $store)
                            <div class="report-marco ">
                                <div class="row pl">
                                    <div class="col-md-12 ">
                                        <h4><span class="badge">{{$index +1}}</span>PDV {{$store['fullname']."( Id: ".$store['store_id'].")"}}</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-7 ">
                                        @foreach ($store['arrayFoto'] as $index1 => $detailFoto)
                                            @if ($detailFoto['id']==0)

                                            @else
                                                <a href="{{$detailFoto['urlFoto']}}" class="zoom1 btn btn-default" data-fancybox-group="button"><img src="{{$detailFoto['urlFoto']}}"  class="img-thumbnail"></a>
                                            @endif
                                        @endforeach

                                    </div>
                                    <div class="col-md-5 ">
                                        <a class="btn btn-default" href="{{route('detailsPublicitySod',[$company_id,$audit_id,$store['store_id'],$publicity_id,$store['foto'],$store['publicity_details_id'],$city,$auditor])}}" target="_blank">Ver detalle</a>

                                        <div class="btn-group" role="group" aria-label="...">
                                            @if(is_object($store['comoEstaVent']['objeto']) and (count($store['comoEstaVent']['objeto'])>0))
                                                @if(count($store['comoEstaVent']['options'][0])>0)
                                                    <div class="btn btn-default btn-si">Como esta SOD:</div>
                                                @else
                                                    <div class="btn btn-default btn-no">Como esta SOD:</div>
                                                @endif
                                            @else
                                                <div class="btn btn-default btn-no">Como esta SOD:</div>
                                            @endif
                                            <div   class="btn btn-default btn-valor">{{$store['comoEstaVent']['texto']}}</div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    @endif

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
    var url_base =  "{{ URL::to('/') }}" ;


</script>

@endsection