@extends('layouts/adminLayout')
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
                            {{Form::open(['route' => 'reportBayerFilter', 'method' => 'POST', 'role' => 'form'], $audit_id)}}
                            {{ Form::hidden('audit_id', $audit_id) }}
                            {{ Form::hidden('company_id', $company_id) }}
                            <div class="col-sm-3">
                                <div class="form-group">
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
                                    <a href="{{route('getDetailQuestionBayer', $valPolls[$company_id]['abierto']."/".$valores."-0-0-0"."/".$company_id."/0")}}" class="btn btn-primary btn-sm active" role="button">Ver Detalle Locales Cerrados</a>
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
                                    <a href="{{route('getDetailWinnersBayer', $valPolls[$company_id]['premio']."/".$valores."/".$company_id)}}" class="btn btn-primary btn-sm active" role="button">Ver Premiados</a>
                                    <a href="{{route('getDetailQuestionBayer', $valPolls[$company_id]['premio']."/".$valores."-0-0-0"."/".$company_id."/0")}}" class="btn btn-primary btn-sm active" role="button">No aceptaron Premio</a>
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
                                    <h4>Tienen Visbilidad Bayer</h4>
                                </div>
                                <div class="grafico-circle">
                                    <div id="chartdiv4" style="width: 100%; height: 250px;" ></div>
                                </div>
                                <div>
                                    <a href="{{route('getDetailQuestionBayer', $valPolls[$company_id]['exhibicion']."/".$valores."-1-0-0"."/".$company_id."/0")}}" class="btn btn-primary btn-sm active" role="button">Ver exhibiciones</a>
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