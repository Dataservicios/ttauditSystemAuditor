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

        </script>

@endsection