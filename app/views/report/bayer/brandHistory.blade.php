@extends('layouts/clienteBayer')
@section('content')
<section>
    @include('report/partials/menuPrincipalColgate')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <!--sección titulo y buscador-->
            <div class="row pt pb">
                <div class="col-sm-9">
                    <h4 class="report-title">{{$titulo}}</h4>

                        <div id="alertaFiltro" class="alert alert-info alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <strong>Filtrado por:</strong>


                        </div>


                    <div class="row">
                        <!--Filtros con combos-->


                    <!-- Fin Filtros con combos-->
                    </div>

                </div>
                <div class="col-sm-3">
                    <img src="{{$logo}}" width="100px">
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
<script>
    function newCampaigne(valor){

        if(valor.value != 0){
            var fullname = valor.options[valor.selectedIndex].text;
            var url= "{{ $urlBase }}" + valor.value ;
            var win = window.open(url, '_blank');
            win.focus();
        }
    }
</script>
<script>

    var url_base =  "{{ URL::to('/') }}" ;


</script>

@endsection