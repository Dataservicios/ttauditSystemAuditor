@extends('layouts/clienteColgate')
@section('content')
<section>
    @include('report/partials/menuPrincipalColgate')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <!--sección titulo y buscador-->
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="report-title">Visibilidad de Materiales de Exhibición</h4>
                </div>

            </div>

            <!--Filtros con combos-->
            <div class="row">
                <div class="col-md-12">

                    <form>
                        <div class="row">


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
                                        <option>Mercado La Parada</option>

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

                    </form>

                </div>
            </div>
            <!-- End Filtros con combos-->
            <div class="row pt pb">
                <div class="col-sm-12">
                    <div class="report-marco ">
                        <div class="grafico-circle">
                            <div id="chartdiv1" style="width: 100%; height: 250px;" ></div>
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

    // Visibilidad Home
    var chartData = JSON.parse('{{$valSINOJson}}');
    var chartData2 = [
        {
            "category": "Sari Sari",
            "Si": 80,
            "No": 20,
            "color":"#ffffff"
        },
        {
            "category": "Exhibiciones Multicategoría",
            "Si": 20,
            "No": 80,
            "color":"#ffffff"
        },
        {
            "category": "Minimueble Jabones + Deos",
            "Si": 60,
            "No": 40,
            "color":"#ffffff"
        },{
            "category": "Cortina Suavitel",
            "Si": 45,
            "No": 55,
            "color":"#ffffff"
        },{
            "category": "Material POP",
            "Si": 35,
            "No": 55,
            "color":"#ffffff"
        }
    ];

    creaGraficoColumnasStaked(chartData,"chartdiv1",false);
</script>

@endsection