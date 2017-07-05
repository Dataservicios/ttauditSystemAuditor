@extends('layouts/clienteColgate')
@section('content')
<section>
    @include('report/partials/menuPrincipalColgate')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <!--sección titulo y buscador-->
            <div class="row">
                <div class="col-sm-12">
                    @if($tipo=="0")
                        <h4 class="report-title">Visibilidad de Materiales de Exhibición - {{$category}} PDV auditados: {{$total}}</h4>
                    @else
                        <h4 class="report-title">Visibilidad de Material {{$publicity_detail_fullname}} - {{$category}} PDV auditados: {{$total}}</h4>
                    @endif

                </div>

            </div>

            <!--Filtros con combos-->
            <div class="row">
                <div class="col-md-12">
                    {{Form::open(['route' => 'auditReportCategoryColgateFilter', 'method' => 'POST', 'role' => 'form'], $audit_id)}}
                    {{ Form::hidden('audit_id', $audit_id) }}
                    {{ Form::hidden('category_id', $category_id) }}
                    {{ Form::hidden('company_id', $company_id) }}
                        <div class="row">

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="tipos">Tipo</label>
                                    {{Form::select('tipos', $combo, '0', ['id'=>'tipos','class' => 'form-control']);}}
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="ciudad">Ciudad</label>
                                    <select class="form-control" id="ciudad">
                                        <option>--Seleccione Ciudad</option>
                                        <option>Lima</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="ejecutivo">Mercados Mayoristas</label>
                                    <select class="form-control" id="ejecutivo">
                                        <option>--Seleccione Mercado</option>
                                        <option>Mercado Parada</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div class="form-group">
                                    <label for="rubro">&emsp;</label>
                                    <button class="btn btn-default" type="submit">Filtrar</button>
                                </div>
                            </div>
                        </div>
                    {{ Form::close() }}

                </div>
            </div>
            <!-- End Filtros con combos-->
            <div class="row pt pb">
                <div class="col-sm-12">

                    <div class="row pt pb">
                        <div class="col-sm-12">

                            <div class="row">

                                <div class="col-md-12 pb">
                                    <div class="report-marco ">
                                        <div class="row pl">
                                            <div class="col-md-12 ">
                                                <h4>Se encontró material total: {{$total_cond[0]['totalVisible']}}</h4>
                                            </div>
                                        </div>
                                        <div class="grafico-circle">
                                            <div id="chartdiv0" style="width: 100%; height: 250px;" ></div>
                                        </div>

                                        @if($total_cond[0]['totalLayout']<>0)
                                            <div class="row pl">
                                                <div class="col-md-12 ">
                                                    <h4>Layout Correcto total: {{$total_cond[0]['totalLayout']}}</h4>
                                                </div>
                                            </div>
                                            <div class="grafico-circle">
                                                <div id="chartdiv1" style="width: 100%; height: 250px;" ></div>
                                            </div>
                                            @if($tipo<>0)
                                                <div class="row ">
                                                    <div class="col-md-12 ">
                                                        <a class="btn btn-default" href="{{route('auditDetailConditionPublicity', array(1, 0,$tipo,$company_id,$category_id))}}">Detalle NO</a>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif


                                        <div class="row pl">
                                            <div class="col-md-12 ">
                                                <h4>Contaminado total: {{$total_cond[0]['totalContamined']}}</h4>
                                            </div>
                                        </div>
                                        <div class="grafico-circle">
                                            <div id="chartdiv2" style="width: 100%; height: 250px;" ></div>
                                        </div>
                                        @if($tipo<>0)
                                            <div class="row ">
                                                <div class="col-md-12 ">
                                                    <a class="btn btn-default" href="{{route('auditDetailConditionPublicity', array(2, 1,$tipo,$company_id,$category_id))}}">Detalle NO</a>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
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
    <!-- Libreria AMCHART -->


        {{ HTML::script('lib/amcharts/amcharts.js'); }}
        {{ HTML::script('lib/amcharts/serial.js'); }}
        {{ HTML::script('lib/amcharts/pie.js'); }}

        {{ HTML::script('js/graficos/colg_chart.js'); }}

        <!-- // Libreria AMCHART creaGraficoColumnas(chartData2,"char3");	-->
<script>

    // Visibilidad categoria VISIBLE
    var chartData = JSON.parse('{{$valVisibleJson}}');
    createGraphPie(chartData,"chartdiv0");

    @if($total_cond[0]['totalLayout']<>0)
        // Visibilidad categoria LAYOUT
        var chartData1 = JSON.parse('{{$valLayoutJson}}');
        createGraphPie(chartData1,"chartdiv1");
    @endif

    // Visibilidad categoria CANTAMINADO
    var chartData2 = JSON.parse('{{$valContaminedJson}}');
    createGraphPie(chartData2,"chartdiv2");


</script>


@endsection