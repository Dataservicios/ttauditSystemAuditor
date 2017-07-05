@extends('layouts/clienteAlicorp')
@section('content')
<section>
    @include('report/partials/menuPrincipalAlicorp')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <div class="row pt pb">
                <div class="col-sm-9">
                    <h4 class="report-title">Resumen Campaña: {{$titulo}}</h4>
                </div>
                <div class="col-sm-3">
                    <img src="{{$logo}}" >
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="report-marco ">
                        <div class="contenedor-report">
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">Base Bodegas</div>
                                <div   class="btn btn-default btn-valor">{{$cantidadStoresForCampaigne}}</div>
                            </div>
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">Bodegas Programadas</div>
                                <div   class="btn btn-default btn-valor">{{$cantidadStoresRouting}}</div>
                            </div>
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">Bodegas visitadas</div>
                                <div   class="btn btn-default btn-valor">{{$cantidadStoresAudit}}</div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-sm-12">
                    @if($ubigeoext<>"0")
                        <div id="alertaFiltro" class="alert alert-info alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <strong>Filtrado por:</strong>
                            @if($ubigeoext==5)
                                Todas las Provincias menos Lima
                            @else
                                Departamento {{$ubigeoext}}
                            @endif

                        </div>
                    @endif

                    <div class="row">
                        <!--Filtros con combos-->
                        {{Form::open(['route' => 'reportAlicorpFilter', 'method' => 'POST', 'role' => 'form'], $audit_id)}}

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
                                <label for="ubigeo">Dex</label>
                                {{Form::select('dex', $dex, '0', ['id'=>'dex','class' => 'form-control']);}}
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="ubigeo">Tipo Tienda</label>
                                {{Form::select('typeStore', $typeStore, '0', ['id'=>'typeStore','class' => 'form-control']);}}
                            </div>
                        </div>

                        <div class="col-sm-1">
                            <div class="form-group">
                                <label for="rubro">&emsp;</label>
                                <button class="btn btn-default" type="submit">Filtrar</button>
                            </div>
                        </div>
                        {{ Form::close() }}
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="rubro">&emsp;</label>
                                {{Form::select('campaigne', $campaignes, '0', ['id'=>'campaigne','class' => 'form-control', 'onchange' => 'newCampaigne(this)']);}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pt pb">
                    <div class="row">
                        <div class="col-md-6 pb">
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
                                    <a href="{{route('getDetailQuestionAlicorp', $QuestionOpen."/".$valores."-0"."/".$company_id."/0")}}" class="btn btn-primary btn-sm active" role="button">Detalle Bodegas Cerradas</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 pb">

                            <div class="report-marco ">
                                <div class="row pl">
                                    <div class="col-md-12 ">
                                        <h4>Permitio Auditoria</h4>
                                    </div>
                                </div>
                                <div class="grafico-circle">
                                    <div id="chartdiv1" style="width: 100%; height: 250px;" ></div>
                                </div>
                                <div>
                                    <a href="{{route('getDetailQuestionAlicorp', $QuestionPermitio."/".$valores."-0"."/".$company_id."/0")}}" class="btn btn-primary btn-sm active" role="button">No permitieron Auditoria</a>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12 pb">
                            <div class="report-marco ">
                                <div class="row pl">
                                    <div class="col-md-12 ">
                                        <h4>Cumple MSL</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    @if($tituloMSL=="")
                                        <div class="col-md-4 ">
                                            <label for="basic-url" style="padding-left: 10px;">Mini Market</label>
                                            <div class="grafico-circle">
                                                <div id="chartdiv2" style="width: 100%; height: 250px;" ></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 ">
                                            <label for="basic-url" style="padding-left: 10px;">Bodega Clásica</label>
                                            <div class="grafico-circle">
                                                <div id="chartdiv3" style="width: 100%; height: 250px;" ></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 ">
                                            <label for="basic-url" style="padding-left: 10px;">Bodega Alto Tráfico</label>
                                            <div class="grafico-circle">
                                                <div id="chartdiv4" style="width: 100%; height: 250px;" ></div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-md-12 ">
                                            <label for="basic-url" style="padding-left: 10px;">{{$tituloMSL}}</label>
                                            <div class="grafico-circle">
                                                <div id="chartdivFilter" style="width: 100%; height: 250px;" ></div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 pb">
                            <div class="report-marco ">
                                <div class="row pl">
                                    <div class="col-md-12 ">
                                        <h4>Materiales de Exhibición</h4>
                                    </div>
                                </div>
                                <div class="grafico-circle">
                                    <div id="chartdiv5" style="width: 100%; height: 250px;" ></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 pb">
                            <div class="report-marco ">
                                <div class="row pl">
                                    <div class="col-md-12 ">
                                        <h4>SOD Ventanas</h4>
                                    </div>
                                </div>
                                <div class="grafico-circle">
                                    <div id="chartdiv6" style="width: 100%; height: 250px;" ></div>
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

    {{ HTML::script('js/graficos/alicorp-chart.js'); }}
    <script>

        // Grafico Abierto Cerrado
        var chartData0 = JSON.parse('{{$valSINOJson}}');
        createGraphPie(chartData0,"chartdiv0");

        // Grafico Permitio
        var chartData1 = JSON.parse('{{$valPermitioJson}}');
        createGraphPie(chartData1,"chartdiv1");

        @if($tituloMSL=="")
            // MSL Mini Market
            var chartData2 = JSON.parse('{{$valMSLMMJson}}');
            createGraphPie(chartData2,"chartdiv2");

            // MSL Bodega Clásica
            var chartData3 = JSON.parse('{{$valMSLBCJson}}');
            createGraphPie(chartData3,"chartdiv3");

            // MSL Bodega Alto Tráfico
            var chartData4 = JSON.parse('{{$valMSLATJson}}');
            createGraphPie(chartData4,"chartdiv4");
        @else
            var chartDataFilter = JSON.parse('{{$valMSLFilterJson}}');
            createGraphPie(chartDataFilter,"chartdivFilter");
        @endif


        // Grafico Exhibidores totalOptionSODJSON
        var chartData5 = JSON.parse('{{$totalOptionExhiJSON}}');
        creaGraficoColumnas(chartData5,"chartdiv5",true,null,0,100);

        // Grafico Exhibidores
        var chartData6 = JSON.parse('{{$totalOptionSODJSON}}');
        creaGraficoColumnas(chartData6,"chartdiv6",true,null,0,100,null,true);

    </script>
    <script>
        function newCampaigne(valor){

            if(valor.value != 0){
                var fullname = valor.options[valor.selectedIndex].text;
                var url= "{{ $urlBase }}" + valor.value + "/0" ;
                var win = window.open(url, '_blank');
                win.focus();
            }
        }
    </script>
@endsection