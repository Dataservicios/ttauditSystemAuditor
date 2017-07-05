@extends('layouts/clienteBayer')
@section('content')
<section>
    @include('report/partials/menuPrincipalColgate')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <!--sección titulo y buscador-->
            <div class="row pt pb">
                <div class="col-sm-9">
                    <h4 class="report-title">Reporte de visitas ejecutivos Bayer</h4>
                </div>
                <div class="col-sm-3">
                    <img src="{{$logo}}" width="100px">
                </div>
            </div>


            <div class="row pt pb">
                <div class="col-sm-12">

                    <div class="row pt pb">
                        <div class="col-md-12 pb">
                            <div class="report-marco ">
                                <div class="row pl">
                                    <div class="col-md-12 ">
                                        <h4>Visión General</h4>
                                    </div>
                                </div>
                                <div class="grafico-circle">
                                    <div id="load"></div>
                                    <div id="chartdivVisitors" style="width: 100%; height: 250px;" ></div>
                                    {{Form::hidden('company_id', $company_id, ['id'=>'company_id','class' => 'form-control']);}}
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

        {{ HTML::script('js/graficos/Bayer-chart.js'); }}
    {{ HTML::script('js/ajaxJsonFunction.js'); }}

        <!-- // Libreria AMCHART creaGraficoColumnas(chartData2,"char3");	-->
<script>
    var url_base =  "{{ URL::to('/') }}" ;

    var url = url_base + "/ajaxGetVisitors" ;
    var company_id = '{{$company_id}}';

    var params = JSON.parse('{"company_id":"' + company_id +  '"}');
    ajaxJson(url_base,url,params,creaGraficoColumnas,"{{'chartdivVisitors'}}","{{'load'}}","No hay datos");


//Activa cuadro de comparación de campaªna
    $( "#change" ).on( "click", function( event ) {
        event.preventDefault();
        $('#alertaCompara').show();
        $('#change').hide();
//            $("#alertaFiltro").toggleClass("show");

    });

    $('.close').click(function() {
        $("#alertaCompara").hide();
        $('#change').show();
    });

</script>



@endsection