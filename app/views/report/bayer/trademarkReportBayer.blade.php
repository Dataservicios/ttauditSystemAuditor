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

                    @if(($ubigeoextLink<>"0") or ($cadenaLink<>"0") or ($ejecutivo_id<>"0") or ($horizontalLink<>"0"))
                        <div id="alertaFiltro" class="alert alert-info alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <strong>Filtrado por:</strong>
                            @if($ejecutivo_id<>"0")
                                Ejecutivo: {{$ejecutive_msg}}
                            @endif

                        </div>
                    @endif

                    <div class="row">
                        <!--Filtros con combos-->

                        {{Form::open(['route' => 'traderMarkFilter', 'method' => 'POST', 'role' => 'form'], $audit_id)}}
                        {{Form::hidden('company_id', $company_id, ['id'=>'company_id','class' => 'form-control']);}}
                        {{Form::hidden('ubigeo', '0', ['id'=>'ubigeo','class' => 'form-control']);}}

                        <div class="col-sm-3">
                            <div class="checkbox">
                                <label>
                                    {{ Form::hidden('tipo_cadena', "0") }}
                                    @if($mostrar_filtros==1)
                                        {{Form::checkbox('tipo_cadena', 1,$tipo_cadena, ['class' => 'checkbox1']);}}
                                        <label for="product" style="font-weight: bold">Cadena</label>
                                    @endif
                                </label>
                            </div>
                            @if(count($ListCadenas)>0)
                                @foreach($ListCadenas as $cadena1)
                                    {{Form::hidden('cadena[]', $cadena1,null, ['class' => 'checkbox1']);}}
                                @endforeach
                            @else
                                {{Form::hidden('cadena', '0', ['id'=>'cadena','class' => 'form-control']);}}
                            @endif

                        </div>
                        <div class="col-sm-3">
                            <div class="checkbox">
                                <label>
                                    {{ Form::hidden('tipo_horizontal', "0") }}
                                    @if($mostrar_filtros==1)
                                        {{Form::checkbox('tipo_horizontal', 1,$tipo_horizontal, ['class' => 'checkbox1']);}}
                                        <label for="product" style="font-weight: bold">Horizontal</label>
                                    @endif
                                </label>
                            </div>
                            @if(count($ListHorizontales)>0)
                                @foreach($ListHorizontales as $cadena2)
                                    {{Form::hidden('horizontal[]', $cadena2,null, ['class' => 'checkbox1']);}}
                                @endforeach
                            @else
                                {{Form::hidden('horizontal', '0', ['id'=>'horizontal','class' => 'form-control']);}}
                            @endif

                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="product">Ejecutivo</label>
                                {{Form::select('ejecutivo', $ejecutivos, $ejecutivo_id, ['id'=>'product','class' => 'form-control']);}}
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
                <div class="col-sm-3">
                    <img src="{{$logo}}" width="100px">
                </div>
            </div>

            @foreach($ListProducts as $producto)
                {{Form::hidden('producto'.$producto->id, $producto->id, ['id'=>'producto'.$producto->id,'class' => 'form-control']);}}
                {{Form::hidden('cadena'.$producto->id, $cadenaLink, ['id'=>'cadena'.$producto->id]);}}
                {{Form::hidden('horizontal'.$producto->id, $horizontalLink, ['id'=>'horizontal'.$producto->id]);}}
                {{Form::hidden('ejecutivo'.$producto->id, $ejecutivo_id, ['id'=>'ejecutivo'.$producto->id]);}}
                {{Form::hidden('ubigeoext'.$producto->id, $ubigeoextLink, ['id'=>'ubigeoext'.$producto->id]);}}
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row pt pb">
                            <div class="col-sm-12">
                                <h3>{{$producto->fullname}}</h3>
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
                                        <div id="{{'load'.$producto->id}}"></div>
                                        <div id="{{'chartdiv'.$producto->id}}" style="width: 100%; height: 250px;" ></div>
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

        @foreach($ListProducts as $producto)
            var ejecutivo_id = $('{{'#ejecutivo'.$producto->id}}').val();
            var cadena = $('{{'#cadena'.$producto->id}}').val();
            var horizontal = $('{{'#horizontal'.$producto->id}}').val();
            var product_id = $('{{"#producto".$producto->id}}').val();
            var ubigeoext = $('{{'#ubigeoext'.$producto->id}}').val();

            if (product_id==534){
                var url = url_base + "/ajaxGetRecomendSalesForSeller" ;
            }else{
                var url = url_base + "/ajaxGetRecomendSalesForProduct" ;
            }
            var params = JSON.parse('{"company_id":"' + company_id + '","cadena":"' + cadena + '","ejecutivo":"' + ejecutivo_id + '","product_id":"' + product_id + '","horizontal":"' + horizontal + '","ubigeoext":"' + ubigeoext + '"}');
            ajaxJson(url_base,url,params,createChartLineal,"{{'chartdiv'.$producto->id}}","{{'load'.$producto->id}}","No hay datos");
        @endforeach

    });

</script>

@endsection