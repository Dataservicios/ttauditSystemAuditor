@extends('layouts/home')
@section('content')
<section>
    <div class="cuerpo">
        <div class="cuerpo-content">
            <!--sección titulo y buscador-->
            <div class="row pt pb">
                <div class="col-sm-9">
                    <h4 class="report-title">{{$titulo}}</h4>
                </div>
                <div class="col-sm-3">
                    <img src="{{$logo}}" width="100px">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">

                    <div class="row">
                        <!--Filtros con combos-->

                                <!-- Fin Filtros con combos-->

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
                                        <h4>Pruebas</h4>
                                    </div>
                                </div>
                                <li>
                                @foreach($publicitiesCampaigne as $publicity)
                                    <ul>{{$publicity->id}} | {{$publicity->product->fullname}}</ul>
                                @endforeach
                                </li>
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

        {{ HTML::script('js/graficos/Bayer-chart-ventas.js'); }}
        {{ HTML::script('js/ajaxJsonFunction.js'); }}

        <!-- // Libreria AMCHART creaGraficoColumnas(chartData2,"char3");	-->


<script>

</script>

@endsection