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
            <div class="row pt pb">


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



    </script>
    <script>
        function newCampaigne(valor){

            if(valor.value != 0){
                var fullname = valor.options[valor.selectedIndex].text;
                var url= "{{ $urlBase }}" + valor.value + "/" + fullname ;
                var win = window.open(url, '_blank');
                win.focus();
            }
        }
    </script>
@endsection