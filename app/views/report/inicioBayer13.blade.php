@extends('layouts/clienteBayer')
@section('content')
<section>
    @include('report/partials/menuPrincipalColgate')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <div class="row pt pb">
                <div class="col-sm-9">
                    <h4 class="report-title">Resumen Campaña: {{$titulo}}</h4>
                </div>
                <div class="col-sm-3">
                    <img src="{{$logo}}" width="100px">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    @section('Mensajes')
                        @if(($ubigeoextLink<>"0") or ($cadenaLink<>"0") or ($ejecutivo<>"0") or ($horizontalLink<>"0"))
                            <div id="alertaFiltro" class="alert alert-info alert-dismissible" role="alert" style=" width:100%;position:fixed !important;  top:0px; z-index:10 !important;">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <strong>Filtrado por:</strong>
                                Departamento(s) {{$ubigeoextLink}}

                                @if($cadenaLink<>"0")
                                    , Cadena(s) {{$cadenaLink}}
                                @endif
                                @if($horizontalLink<>"0")
                                    , Horizontal(s) {{$horizontalLink}}
                                @endif
                                @if($ejecutivo<>"0")
                                    , Ejecutivo {{$ejecutivo}}
                                @endif
                            </div>
                        @endif
                    @endsection

                    <div class="row">
                        <!--Filtros con combos-->
                        {{Form::open(['route' => 'reportBayerFilter', 'method' => 'POST', 'role' => 'form'], $audit_id)}}
                        {{ Form::hidden('audit_id', $audit_id) }}
                        {{ Form::hidden('company_id', $company_id) }}
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="ubigeo">Departamento</label>
                                {{ Form::hidden('ubigeo', "0") }}
                                @foreach($ListUbigeos as $ubigeo)
                                    <div class="checkbox">
                                        <label>
                                            {{Form::checkbox('ubigeo[]', $ubigeo,null, ['class' => 'checkbox1']);}} {{$ubigeo}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="cadena">Cadenas</label>
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
                        <div class="col-sm-2">
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
                        <div class="col-sm-2">
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
                        <div class="col-sm-3">
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
                            @if($cantidadStoresRouting<>0)
                                <div class="btn-group" role="group" aria-label="...">
                                    <div   class="btn btn-default btn-si">Farmacias Programadas</div>
                                    <div   class="btn btn-default btn-valor">{{$cantidadStoresRouting}}</div>
                                </div>
                            @endif
                            @if($cantidadStoresAudit<>0)
                                <div class="btn-group" role="group" aria-label="...">
                                    <div   class="btn btn-default btn-si">Farmacias visitadas</div>
                                    <div   class="btn btn-default btn-valor">{{$cantidadStoresAudit}}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pt pb">
                    <div class="row">
                        <div class="col-md-12 pb">

                            <div class="report-marco ">
                                <div class="row pl">
                                    <div class="col-md-12 ">
                                        <h4>Auditorias desarrolladas</h4>
                                    </div>
                                </div>
                                <div class="grafico-circle">
                                    <div id="chartdiv0" style="width: 100%; height: 250px;" ></div>
                                </div>
                                <div>
                                    <a href="{{route('getDetailQuestionBayer', "142/".$valores."-0-0-0"."/".$company_id."/0")}}" class="btn btn-primary btn-sm active" role="button">Ver Detalle Locales Cerrados</a>
                                </div>
                            </div>

                            <div class="report-marco ">
                                <div class="contenedor-report">
                                    <h4>Total Recomendaciones por producto</h4>
                                </div>
                                <div class="grafico-circle">
                                    <div id="chartdiv1" style="width: 100%; height: 250px;" ></div>
                                </div>
                            </div>

                            <div class="report-marco ">
                                <div class="contenedor-report">
                                    <h4>Total Premiados</h4>
                                </div>
                                <div class="grafico-circle">
                                    <div id="chartdiv2" style="width: 100%; height: 250px;" ></div>
                                </div>
                                <div>
                                    <a href="{{route('getDetailWinnersBayer', "147/".$valores."/".$company_id)}}" class="btn btn-primary btn-sm active" role="button">Ver Premiados</a>
                                    <a href="{{route('getDetailQuestionBayer', "147/".$valores."-0-0-0"."/".$company_id."/0")}}" class="btn btn-primary btn-sm active" role="button">No aceptaron Premio</a>
                                </div>
                            </div>

                            <div class="report-marco ">
                                <div class="contenedor-report">
                                    <h4>¿Tiene exhibición Bayer?</h4>
                                </div>
                                <div class="grafico-circle">
                                    <div id="chartdiv3" style="width: 100%; height: 250px;" ></div>
                                </div>

                                <div class="contenedor-report">
                                    <h4>Si presentan exhibición Bayer</h4>
                                </div>
                                <div class="grafico-circle">
                                    <div id="chartdiv4" style="width: 100%; height: 250px;" ></div>
                                </div>
                                <div>
                                    <a href="{{route('getDetailQuestionBayer', "143/".$valores."-1-0-0"."/".$company_id."/0")}}" class="btn btn-primary btn-sm active" role="button">Ver exhibiciones</a>
                                </div>

                                <div class="contenedor-report">
                                    <h4>No presentan exhibición Bayer</h4>
                                </div>
                                <div class="grafico-circle">
                                    <div id="chartdiv5" style="width: 100%; height: 250px;" ></div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

</section>
@stop
@section('report')
    {{ HTML::script('lib/amcharts/amcharts.js'); }}
    {{ HTML::script('lib/amcharts/serial.js'); }}
    {{ HTML::script('lib/amcharts/pie.js'); }}

    {{ HTML::script('js/graficos/Bayer-chart.js'); }}
    <script>

        // Grafico Abierto Cerrado
        var chartData0 = JSON.parse('{{$valSINOJson}}');
        createGraphPie(chartData0,"chartdiv0");

        // Gafico Productos
        var chartData1 = JSON.parse('{{$valProdJson}}');
        creaGraficoColumnasStaked(chartData1,"chartdiv1",false,null,0,100);

        // Grafico Premiados
        var chartData2 = JSON.parse('{{$valPremiados}}');
        createGraphPie(chartData2,"chartdiv2");

        // Grafico Exhibe
        var chartData3 = JSON.parse('{{$valExhiJson}}');
        createGraphPie(chartData3,"chartdiv3");

        var chartData4 = JSON.parse('{{$totalOptionsJSON}}');
        creaGraficoColumnas(chartData4,"chartdiv4",false,null);

        var chartData5 = JSON.parse('{{$totalOptionsJSON1}}');
        creaGraficoColumnas(chartData5,"chartdiv5",false,null);

    </script>
    <script>
        function newCampaigne(valor){

            if(valor.value != 0){
                var fullname = valor.options[valor.selectedIndex].text;
                var url= "{{ $urlBase }}" + valor.value + "/" + fullname ;
                var win = window.open(url, '_blank');
                win.focus();
            }
        }
    </script>
@endsection