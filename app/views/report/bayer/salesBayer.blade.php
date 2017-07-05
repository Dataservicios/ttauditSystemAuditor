@extends('layouts/clienteBayer')
@section('content')
<section>
    @include('report/partials/menuPrincipalColgate')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <!--sección titulo y buscador-->
            <div class="row pt pb">
                <div class="col-sm-9">
                    <h4 class="report-title">{{$titulo}}</h4>
                </div>
                <div class="col-sm-3">
                    <img src="{{$logo}}" width="100px">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    @section('Mensajes')
                        @if(($nombProduct<>"0") or ($cadenaLink<>"0") or ($horizontalLink<>"0"))
                            <div id="alertaFiltro" class="alert alert-info alert-dismissible" role="alert" style=" width:100%;position:fixed !important;  top:0px; z-index:10 !important;">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <strong>Filtrado por:</strong>
                                @if($cadenaLink<>"0")
                                    Cadena(s) {{$cadenaLink}}
                                @endif
                                @if($horizontalLink<>"0")
                                    , Horizontal(s) {{$horizontalLink}}
                                @endif
                                @if($nombProduct<>"0")
                                    , Producto {{$nombProduct}}
                                @endif
                            </div>
                        @endif
                    @endsection

                    <div class="row">
                        <!--Filtros con combos-->
                        {{Form::open(['route' => 'getSellersCampaigneFilter', 'method' => 'POST', 'role' => 'form'], $audit_id)}}
                        {{Form::hidden('company_id', $company_id, ['id'=>'company_id','class' => 'form-control']);}}

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="cadenaF">Cadenas</label>
                                {{ Form::hidden('cadena', "0") }}
                                @foreach($ListCadenas as $cadena1)
                                    <div class="checkbox">
                                        <label>
                                            {{Form::checkbox('cadena[]', $cadena1,null, ['class' => 'checkbox1']);}} {{$cadena1}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="cadena">Horizontales</label>
                                {{ Form::hidden('horizontal', "0") }}
                                @foreach($ListHorizontales as $cadena2)
                                    <div class="checkbox">
                                        <label>
                                            {{Form::checkbox('horizontal[]', $cadena2,null, ['class' => 'checkbox1']);}} {{$cadena2}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="product">Marca</label>
                                {{Form::select('product', $products, '0', ['id'=>'product','class' => 'form-control']);}}
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="rubro">&emsp;</label>
                                <button class="btn btn-default" type="submit">Filtrar</button>
                            </div>

                        </div>
                        {{ Form::close() }}
                                <!-- Fin Filtros con combos-->

                    </div>
                </div>
            </div>

            @foreach($ejecutivos as $ejecutivo)
                {{Form::hidden('ejecutivo'.$ejecutivo->id, $ejecutivo->ejecutivo, ['id'=>'ejecutivo'.$ejecutivo->id,'class' => 'form-control']);}}
                {{Form::hidden('cadena'.$ejecutivo->id, $cadenaLink, ['id'=>'cadena'.$ejecutivo->id]);}}
                {{Form::hidden('horizontal'.$ejecutivo->id, $horizontalLink, ['id'=>'horizontal'.$ejecutivo->id]);}}
                {{Form::hidden('product_id'.$ejecutivo->id, $product_id, ['id'=>'product_id'.$ejecutivo->id,'class' => 'form-control']);}}
                <div class="row pt pb">
                    <div class="col-sm-12">
                        <div class="row pt pb">
                            <div class="col-sm-12">
                                <h3>{{$ejecutivo->ejecutivo}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pt pb">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-md-12 pb">
                                <div class="report-marco ">

                                    <div class="row pl">
                                        <div class="col-md-12 ">
                                            <h4>{{$subtitulo}}</h4>
                                        </div>
                                    </div>
                                    <div class="grafico-circle">
                                        <div id="{{'load'.$ejecutivo->id}}"></div>
                                        <div id="{{'chartdiv'.$ejecutivo->id}}" style="width: 100%; height: 250px;" ></div>
                                        <div style="text-align: center"><small>El Gráfico muestra los 4 productos más recomendados en todos los estudios y los compara entre ellos.</small></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

</section>
@stop

@section('report')
    <!-- Libreria AMCHART -->


        {{ HTML::script('lib/amcharts/amcharts.js'); }}
        {{ HTML::script('lib/amcharts/serial.js'); }}
        {{ HTML::script('lib/amcharts/pie.js'); }}

        {{ HTML::script('js/graficos/Bayer-chart-ventas.js'); }}
        {{ HTML::script('js/ajaxJsonFunction.js'); }}

        <!-- // Libreria AMCHART creaGraficoColumnas(chartData2,"char3");	-->
<script>
//Activa cuadro de comparación de campaªna
    $( "#change" ).on( "click", function( event ) {
        event.preventDefault();
        $('#alertaCompara').show();
        $('#change').hide();
//            $("#alertaFiltro").toggleClass("show");

    });

    $('.close').click(function() {
        $("#alertaCompara").hide();
        $('#change').show();
    });

</script>
<script>
    function newCampaigne(valor){

        if(valor.value != 0){
            var fullname = valor.options[valor.selectedIndex].text;
            var url= "{{ $urlBase }}" + valor.value ;
            var win = window.open(url, '_blank');
            win.focus();
        }
    }
</script>
<script>
    var url_base =  "{{ URL::to('/') }}" ;
    $(document).ready(function(){
        var company_id = $('#company_id').val();
        var ubigeoext = 0;

        var url = url_base + "/ajaxGetRecomendSalesForSeller" ;

        @foreach($ejecutivos as $ejecutivo)
            var ejecutivo = $('{{"#ejecutivo".$ejecutivo->id}}').val();
            var cadena = $('{{"#cadena".$ejecutivo->id}}').val();
            var horizontal = $('{{"#horizontal".$ejecutivo->id}}').val();
            var product_id = $('{{"#product_id".$ejecutivo->id}}').val();
            var params = JSON.parse('{"company_id":"' + company_id + '","cadena":"' + cadena + '","ejecutivo":"' + ejecutivo + '","product_id":"' + product_id + '","horizontal":"' + horizontal + '","ubigeoext":"' + ubigeoext + '"}');
        @if($product_id<>534)
            ajaxJson(url_base,url,params,creaGraficoColumnasGroupDinamic,"{{'chartdiv'.$ejecutivo->id}}","{{'load'.$ejecutivo->id}}","No hay datos");
        @else
            ajaxJson(url_base,url,params,createChartLineal,"{{'chartdiv'.$ejecutivo->id}}","{{'load'.$ejecutivo->id}}","No hay datos");
        @endif

        @endforeach

    });


</script>

@endsection