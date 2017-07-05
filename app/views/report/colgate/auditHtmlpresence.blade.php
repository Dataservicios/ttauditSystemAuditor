@extends('layouts/adminLayout')
@section('content')
<section>
    @include('report/partials/menuPrincipalColgate')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <!--sección titulo y buscador-->
            <div class="row">
                <div class="col-sm-12">
                    @if($presence_id=="0")
                        <h4 class="report-title">Presencia de Producto</h4>
                    @else
                        <h4 class="report-title">Presencia Producto {{$product_fullname}} total PDV {{$total}}</h4>
                    @endif

                </div>

            </div>

            <!--Filtros con combos-->
            <div class="row">
                <div class="col-md-12">
                    {{Form::open(['route' => 'auditReportColgateFilter', 'method' => 'POST', 'role' => 'form'], $audit_id)}}
                    {{ Form::hidden('audit_id', $audit_id) }}
                    {{ Form::hidden('company_id', $company_id) }}
                        <div class="row">

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="product">Producto</label>
                                    {{Form::select('product', $combo, '0', ['id'=>'product','class' => 'form-control']);}}
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="ciudad">Ciudad</label>
                                    <select class="form-control" id="ciudad">
                                        <option>--Seleccione--</option>
                                        <option>Lima</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="ejecutivo">Mercados Mayoristas</label>
                                    <select class="form-control" id="ejecutivo">
                                        <option>--Seleccione--</option>
                                        <option>Parada</option>
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
                    <div class="report-marco ">
                        <div class="row pl">

                            <div class="col-md-12 ">
                                @if($presence_id=="0")
                                    <h4>19 Mandatorios</h4>
                                @else
                                    <h4>{{$product_fullname}} encontrado en {{$totalProduct}} PDV</h4>
                                @endif

                            </div>
                        </div>
                        <div class="grafico-circle">
                            <div id="chartdiv1" style="width: 100%; height: 250px;" ></div>
                        </div>
                        {{--<div class="row ">

                            <div class="col-md-12 ">
                                <a class="btn btn-default" href="colg-producto-detalle-especifico.html">Detalle no cumplen</a>
                            </div>
                        </div>--}}
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

    @if($presence_id=="0")
         // Presencia 19 mandatorios
        var chartData = [
            {
                "tipo":"Cumple",
                "cantidad": 0,
                "color": "#FE0000"
            },
            {
                "tipo":"No cumple",
                "cantidad": 101,
                "color": "#FFFF00"
            }
        ];

        createGraphPie(chartData,"chartdiv1");
    @else
        var chartData = JSON.parse('{{$valVisibleJson}}');
        createGraphPie(chartData,"chartdiv1");
    @endif

</script>

@endsection