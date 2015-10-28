@extends('layouts/adminLayout')
@section('content')
<section>
    @include('report/partials/menuLeft')
    @if ($userType == 'company')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <div class="row pt pb">
                <div class="col-sm-12">
                    <div class="report-marco ">
                        <div class="contenedor-report">
                            <h4>Auditorias Programadas</h4>
                            <span>{{$cantidadStoresForCompany}}</span><br>
                            Auditadas: {{$CantidadStoresAudits}} Por Auditar: {{$cantidadStoresForCompany-$CantidadStoresAudits}}
                            <div class="grafico-circle">
                                <div id="chartdiv1" style="width: 100%; height: 250px;" ></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row pt pb">
                <div class="col-sm-12">
                    <div class="report-marco ">
                        <div class="contenedor-report">
                            <h4>Transacciones</h4>

                            <div class="grafico-circle">
                                <div id="chartdiv0" style="width: 100%; height: 330px;" ></div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="row pt pb">

                <div class="col-sm-12">
                    <div class="report-marco ">
                        <div class="contenedor-report">
                            <h4>Trato</h4>

                            <div class="grafico-circle">
                                <div id="chartdiv2" style="width: 100%; height: 250px;" ></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @endif

</section>
@stop
@section('report')
    <!-- Libreria AMCHART -->


        {{ HTML::script('lib/amcharts/amcharts.js'); }}
        {{ HTML::script('lib/amcharts/serial.js'); }}
        {{ HTML::script('lib/amcharts/pie.js'); }}

        {{ HTML::script('js/graficos/chart.js'); }}

        <!-- // Libreria AMCHART creaGraficoColumnas(chartData2,"char3");	-->

        <script>
            {{"creaGraficoDonut(".$jsonCantidadStoresAudits.",".'chartdiv1'.")"}};
            //var chartData2 = JSON.parse('');

           /* var chartData2 = [
                {
                    "tipo": "Agentes sin Disposición",
                    "Op. Con Exito": 0,
                    "Op. Sin Exito": 80,
                    "Ag. Cerrados": 20,
                    "Ag. No Aceptaron Trans.": 50
                },
                {
                    "tipo": "Agentes con Disposición",
                    "Op. Con Exito": 120,
                    "Op. Sin Exito": 0,
                    "Ag. Cerrados": 0,
                    "Ag. No Aceptaron Trans.": 0
                }
            ];*/
            {{"creaGraficoPie(".$valSINOJson.",".'chartdiv0'.",true)"}};

            var chartData3 = JSON.parse('{{$valLimitsJson}}');
            /*var chartData3 = [
                {
                    "tipo": "Disposición",
                    "Debajo Estandar": 20,
                    "Estandar": 80,
                    "Superior": 10
                },
                {
                    "tipo": "Conocimiento",
                    "Debajo Estandar": 40,
                    "Estandar": 30,
                    "Superior": 50
                },
                {
                    "tipo": "Amabilidad",
                    "Debajo Estandar": 32,
                    "Estandar": 45,
                    "Superior": 60
                }
            ];*/
            //trato(chartData3,"chartdiv2",true);
            creaGraficoColumnasPorcentajesDinamic(chartData3,"chartdiv2",true,true);
        </script>

@endsection