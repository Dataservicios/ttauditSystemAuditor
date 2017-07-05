@extends('layouts/adminLayout')
@section('content')
<section>
    @include('report/partials/menuPrincipalColgate')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="report-title">Resumen Auditorias Colgate PILOTO</h4>
                </div>

            </div>
            <div class="row pt pb">
                    <div class="row">
                        <div class="col-md-12 pb">

                            <div class="report-marco ">
                                <div class="row pl">
                                    <div class="col-md-12 ">
                                        <h4>Presencia de Producto 19 Mandatorios</h4>
                                    </div>
                                </div>
                                <div class="grafico-circle">
                                    <div id="chartdiv0" style="width: 100%; height: 250px;" ></div>
                                </div>
                            </div>

                            <div class="report-marco ">
                                <div class="contenedor-report">
                                    <h4>Visibilidad de Materiales de Exhibición</h4>
                                </div>
                                <div class="grafico-circle">
                                    <div id="chartdiv1" style="width: 100%; height: 250px;" ></div>
                                </div>
                            </div>

                            <div class="report-marco ">
                                <div class="contenedor-report">
                                    <h4>Puntaje Obtenido</h4>
                                </div>
                                <div class="grafico-circle">
                                    <div id="chartdiv2" style="width: 100%; height: 250px;" ></div>
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

    {{ HTML::script('js/graficos/colg_chart.js'); }}
    <script>

        // Grafico 19 Mandatorios
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

        createGraphPie(chartData,"chartdiv0");

        // Visibilidad de Materiales
        var chartData1 = JSON.parse('{{$valTotalVisibility}}');


        creaGraficoColumnasStaked(chartData1,"chartdiv1",false);

        // Gafico Puntajes
        var chartData2 =[
            {
                "respuesta": "0 Pts.",
                "cantidad":2,
                "porcentaje":2,
                "color": "#ffffff"
            },
            {
                "respuesta": "1-499 Pts.",
                "cantidad": 29,
                "porcentaje":29,
                "color": "#ffffff"
            },
            {
                "respuesta": "500-899 Pts.",
                "cantidad": 70,
                "porcentaje":69,
                "color": "#ffffff"
            },
            {
                "respuesta": "900 a más Pts.",
                "cantidad": 0,
                "porcentaje":0,
                "color": "#ffffff"
            }
        ]

        creaGraficoColumnas(chartData2,"chartdiv2")

    </script>
@endsection