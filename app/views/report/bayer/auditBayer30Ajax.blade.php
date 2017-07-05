@extends('layouts/clienteBayer')
@section('content')
<section>
    @include('report/partials/menuPrincipalColgate')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <!--sección titulo y buscador-->
            <div class="row pt pb">
                <div class="col-sm-9">
                    <h4 class="report-title">Encuesta Productos Bayer: {{$titulo}}</h4>
                </div>
                <div class="col-sm-3">
                    <img src="{{$logo}}" width="100px">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    @if(($ubigeoext<>"0") or ($cadena<>"0"))
                        <div id="alertaFiltro" class="alert alert-info alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <strong>Filtrado por:</strong>
                            @if($ubigeoext==5)
                                Todas las Provincias menos Lima
                            @else
                                Departamento {{$ubigeoext}}
                            @endif

                            @if($cadena<>"0")
                                , Cadena {{$cadena}}
                            @endif
                        </div>
                        @endif

                    <div class="row">
                        <!--Filtros con combos-->
                        {{Form::open(['route' => 'auditsBayerFilter', 'method' => 'POST', 'role' => 'form'], $audit_id)}}
                        <div class="col-sm-3">
                            <div class="form-group">
                                {{ Form::hidden('audit_id', $audit_id) }}
                                {{ Form::hidden('company_id', $company_id) }}
                                <label for="ubigeo">Departamento</label>
                                {{Form::select('ubigeo', $ubigeo, '0', ['id'=>'ubigeo','class' => 'form-control']);}}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="cadena">Tipo Farmacia</label>
                                {{Form::select('cadena', $cadenas, '0', ['id'=>'cadena','class' => 'form-control']);}}

                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="ejecutivo">Ejecutivo</label>
                                {{Form::select('ejecutivo', $ejecutivos, '0', ['id'=>'ejecutivo','class' => 'form-control']);}}

                            </div>
                        </div>

                        <div class="col-sm-1">
                            <div class="form-group">
                                <label for="rubro">&emsp;</label>
                                <button class="btn btn-default" type="submit">Filtrar</button>
                            </div>

                        </div>
                        {{ Form::close() }}
                                <!-- Fin Filtros con combos-->
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="rubro">&emsp;</label>
                                {{Form::select('campaigne', $campaignes, '0', ['id'=>'campaigne','class' => 'form-control', 'onchange' => 'newCampaigne(this)']);}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="report-marco ">
                        <div class="contenedor-report">
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">Base Farmacias</div>
                                <div   class="btn btn-default btn-valor">{{$cantidadStoresForCampaigne}}</div>
                            </div>
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">Farmacias Programadas</div>
                                <div   class="btn btn-default btn-valor">{{$cantidadStoresRouting}}</div>
                            </div>
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">Farmacias visitadas</div>
                                <div   class="btn btn-default btn-valor">{{$cantidadStoresAudit}}</div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row pt pb">
                <div class="col-sm-12">

                    <div class="row pt pb">
                        <div class="col-sm-12">
                            @foreach($ListProducts as $product)
                                <div class="row">
                                    <div class="col-md-12 pb">
                                        <div class="report-marco ">
                                            <div class="row pl">
                                                <div class="col-md-6 ">
                                                    <h2>{{$product->product->fullname}}</h2>
                                                </div>
                                                <div class="col-md-6 ">
                                                    <img src="{{$urlProducts.$product->product->imagen}}" width="150px">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    @foreach($valores[$product->product_id] as $valor)
                                        @if($valor['poll_id']<>$valPolls[$company_id]['queRecomendo'])
                                            <div class="col-md-6 pb">
                                                <div class="report-marco ">
                                                    <div class="row pl">
                                                        <div class="col-md-12 ">
                                                            <h4>{{$valor['poll']}}</h4>
                                                        </div>
                                                    </div>
                                                    <div class="grafico-circle">
                                                        <div id="chartdiv{{$product->product_id.$valor['poll_id']}}" style="width: 100%; height: 250px;" ></div>
                                                    </div>
                                                    @if($valor['poll_id']==$valPolls[$company_id]['tieneStock'])
                                                        <div>
                                                            <a href="{{route('getDetailQuestionBayer', $valPolls[$company_id]['tieneStock']."/".$valCiudad."-0-0-0"."/".$company_id."/0/".$product->product_id)}}" class="btn btn-primary btn-sm active" role="button">Ver sin Stock</a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    @foreach($valores[$product->product_id] as $valor)
                                        @if(($valor['poll_id']<>$valPolls[$company_id]['seRecomendo']) and ($valor['poll_id']<>$valPolls[$company_id]['tieneStock']))
                                                {{Form::hidden('poll_id'.$product->product_id.$valor['poll_id'], $valor['poll_id'], ['id'=>'poll_id'.$product->product_id.$valor['poll_id']]);}}
                                                {{Form::hidden('totalAbiertos'.$product->product_id.$valor['poll_id'], $totalAbiertos, ['id'=>'totalAbiertos'.$product->product_id.$valor['poll_id']]);}}
                                                {{Form::hidden('product_id'.$product->product_id.$valor['poll_id'], $product->product_id, ['id'=>'product_id'.$product->product_id.$valor['poll_id']]);}}
                                                {{Form::hidden('ejecutivo'.$product->product_id.$valor['poll_id'], $ejecutivo, ['id'=>'ejecutivo'.$product->product_id.$valor['poll_id']]);}}
                                                {{Form::hidden('ubigeoext'.$product->product_id.$valor['poll_id'], $ubigeoext, ['id'=>'ubigeoext'.$product->product_id.$valor['poll_id']]);}}
                                                {{Form::hidden('cadena'.$product->product_id.$valor['poll_id'], $cadena, ['id'=>'cadena'.$product->product_id.$valor['poll_id']]);}}
                                                {{Form::hidden('company_id'.$product->product_id.$valor['poll_id'], $company_id, ['id'=>'company_id'.$product->product_id.$valor['poll_id']]);}}
                                            <div class="col-md-12 pb">
                                                <div class="report-marco ">
                                                    <div class="row pl">
                                                        <div class="col-md-12 ">
                                                            <h4>{{$valor['poll']}}</h4>
                                                        </div>
                                                    </div>
                                                    <div class="grafico-circle">
                                                        <div id="{{'load'.$product->product_id.$valor['poll_id']}}"></div>
                                                        <div id="{{'chartdiv'.$product->product_id.$valor['poll_id']}}" style="width: 100%; height: 250px;" ></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 pb">
                                                <div class="report-marco ">
                                                    <div class="row pl">
                                                        <div class="col-md-12 ">
                                                            <h4>Prioridades</h4>
                                                        </div>
                                                    </div>
                                                    <div class="grafico-circle">
                                                        <div id="{{'load1'.$product->product_id.$valor['poll_id']}}"></div>
                                                        <div id="{{'chartdivPrio'.$product->product_id.$valor['poll_id']}}" style="width: 100%; height: 250px;" ></div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
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

@section('report')
    <!-- Libreria AMCHART -->


        {{ HTML::script('lib/amcharts/amcharts.js'); }}
        {{ HTML::script('lib/amcharts/serial.js'); }}
        {{ HTML::script('lib/amcharts/pie.js'); }}

        {{ HTML::script('js/graficos/Bayer-chart.js'); }}
    {{ HTML::script('js/ajaxJsonFunction.js'); }}

        <!-- // Libreria AMCHART creaGraficoColumnas(chartData2,"char3");	-->
<script>
    var url_base =  "{{ URL::to('/') }}" ;

    var url = url_base + "/ajaxGetResultQuestion" ;
    @foreach($ListProducts as $product)
        @foreach($valores[$product->product_id] as $valor)
            @if($valor['poll_id']<>$valPolls[$company_id]['queRecomendo'])
                var chartData0 = JSON.parse('{{$valor['grafico']}}');
                createGraphPie(chartData0,"chartdiv{{$product->product_id.$valor['poll_id']}}");
            @endif
        @endforeach
        @foreach($valores[$product->product_id] as $valor)
            @if(($valor['poll_id']<>$valPolls[$company_id]['seRecomendo']) and ($valor['poll_id']<>$valPolls[$company_id]['tieneStock']))
                var poll_id = $('{{'#poll_id'.$product->product_id.$valor['poll_id']}}').val();
                var totalAbiertos = $('{{'#totalAbiertos'.$product->product_id.$valor['poll_id']}}').val();
                var product_id = $('{{'#product_id'.$product->product_id.$valor['poll_id']}}').val();
                var ejecutivo = $('{{'#ejecutivo'.$product->product_id.$valor['poll_id']}}').val();
                var ubigeoext = $('{{'#ubigeoext'.$product->product_id.$valor['poll_id']}}').val();
                var cadena = $('{{'#cadena'.$product->product_id.$valor['poll_id']}}').val();
                var company_id = $('{{'#company_id'.$product->product_id.$valor['poll_id']}}').val();

                var params = JSON.parse('{"poll_id":"' + poll_id + '","totalAbiertos":"' + totalAbiertos + '","product_id":"' + product_id + '","ejecutivo":"' + ejecutivo + '","ubigeoext":"' + ubigeoext + '","cadena":"' + cadena + '","priority":"0","company_id":"' + company_id+ '"}');
                ajaxJson(url_base,url,params,creaGraficoColumnas,"{{'chartdiv'.$product->product_id.$valor['poll_id']}}","{{'load'.$product->product_id.$valor['poll_id']}}","No hay datos");

                var params = JSON.parse('{"poll_id":"' + poll_id + '","totalAbiertos":"' + totalAbiertos + '","product_id":"' + product_id + '","ejecutivo":"' + ejecutivo + '","ubigeoext":"' + ubigeoext + '","cadena":"' + cadena + '","priority":"1","company_id":"' + company_id+ '"}');
                ajaxJson(url_base,url,params,creaGraficoColumnasPorcentajesDinamic,"{{'chartdivPrio'.$product->product_id.$valor['poll_id']}}","{{'load1'.$product->product_id.$valor['poll_id']}}","No hay datos");

            @endif
        @endforeach
    @endforeach
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


@endsection