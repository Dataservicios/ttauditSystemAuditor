@extends('layouts/adminLayout')
@section('content')
<section>
    @include('report/partials/menuLeft')
    @if ($userType == 'company')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <div class="row pt pb">
                <div class="col-sm-12">
                    <!-- Inicio de  Alerta para filtros -->
                    @if($city<>"0")
                        <div id="alertaFiltro" class="alert alert-info alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <strong>Filtrado por:</strong> Ciudad
                            @if($city==5)
                                Todas las Provincias menos Lima
                            @else
                                {{$city}}
                            @endif

                            @if($district<>"0")
                                , Distrito {{$district}}
                            @endif
                            @if($ejecutivo<>"0")
                                , Ejecutivo {{$ejecutivo}}
                            @endif
                            @if($rubro<>"0")
                                , Rubro {{$rubro}}
                            @endif
                            .
                        </div>
                    @endif
                    <!-- FIn de  Alerta para filtros -->
                    <!--Filtros con combos-->
                    {{Form::open(['route' => 'reportFilter', 'method' => 'POST', 'role' => 'form'], $audit_id)}}
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                {{ Form::hidden('audit_id', $audit_id) }}
                                <label for="ciudad">Ciudad</label>
                                {{Form::select('ciudad', array('0' => 'Seleccionar', 'Lima' => 'Lima','Arequipa'=>'Arequipa','Chincha'=>'Chincha','Ica'=>'Ica','Pisco'=>'Pisco','Trujillo'=>'Trujillo','1'=>'Todo Lima','2'=>'Todo Arequipa','3'=>'Toda Ica','4'=>'Todo Trujillo','5'=>'Todo Provincias'), '0', ['id'=>'ciudad','onchange'=>'ejecutaEvento(this,1)','class' => 'form-control']);}}

                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="distrito">Distrito</label>
                                {{Form::select('distrito', array('0' => 'Seleccionar'), '0', ['id'=>'distrito','class' => 'form-control','disabled' => 'true']);}}

                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="ejecutivo">Ejecutivo</label>
                                {{Form::select('ejecutivo', array('0' => 'Seleccionar'), '0', ['id'=>'ejecutivo','class' => 'form-control','disabled' => 'true']);}}

                            </div>

                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="rubro">Rubro</label>
                                {{Form::select('rubro', array('0' => 'Seleccionar'), '0', ['id'=>'rubro','class' => 'form-control','disabled' => 'true']);}}

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
                            <!-- Fin Filtros con combos-->
                </div>
            </div>
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
            $(document).ready(function(){
                $('#ejecutivo option').remove();
                $('#rubro option').remove();
                $('#ejecutivo').prop('disabled',false);

                $.post('http://ttaudit.com/getEjecutivos', function(json){
                    //if (item.latitud != 0 && item.longitud != 0){
                    poblandoCombo(json,2);
                });
                $('#rubro').prop('disabled',false);

                $.post('http://ttaudit.com/getRubros', function(json){
                    //if (item.latitud != 0 && item.longitud != 0){
                    poblandoCombo(json,3);

                });
            });
            function ejecutaEvento(valor,tipo){
                //$('#auditor').on('change', 'select', function (e) {
                // var val = $(e.target).val();
                //  var text = $(e.target).find("option:selected").text(); //only time the find is required
                // var name = $(e.target).attr('name');
                console.log(valor.value);
                if (tipo==1){
                    user = valor.options[valor.selectedIndex].value;
                    $('#distrito').prop('disabled',false);
                    $('#distrito option').remove();
                    $("#distrito").append("<option value='0'>--Seleccione--</option>");
                    if ((user != 1) && (user != 2) && (user != 3) && (user != 4) && (user != 5)){
                        $('#distrito').prop('disabled',false);
                        $('#distrito option').remove();
                        $.post('http://ttaudit.com/getDistrictxRegion',{ region : valor.value }, function(json){
                            //if (item.latitud != 0 && item.longitud != 0){
                            poblandoCombo(json,tipo);
                        });
                    }

                }

                if (tipo==2){
                    $('#ejecutivo').prop('disabled',false);
                    $('#ejecutivo option').remove();
                    $('#rubro option').remove();
                    $('#rubro').prop('disabled',true);
                    $("#rubro").append("<option value='0'>--Seleccione--</option>");
                    user = valor.options[valor.selectedIndex].text;
                    //});
                    $.post('http://ttaudit.com/getEjecutivoxRegionxDistric',{ district : valor.value }, function(json){
                        //if (item.latitud != 0 && item.longitud != 0){
                        poblandoCombo(json,tipo);
                    });
                }

                if (tipo==3){
                    $('#rubro').prop('disabled',false);
                    $('#rubro option').remove();
                    user = valor.options[valor.selectedIndex].text;
                    //});
                    $.post('http://ttaudit.com/getRubroxEjecxRegionxDistric',{ ejecutivo : valor.value }, function(json){
                        //if (item.latitud != 0 && item.longitud != 0){
                        poblandoCombo(json,tipo);
                    });
                }
            }

            function poblandoCombo(data,tipo) {
                var total_puntos = 0;
                if (tipo==1){
                    $("#distrito").append("<option value='0'>--Seleccione un Distrito--</option>");
                    $.each(data, function (i, item) {
                        console.log(item);
                        $("#distrito").append("<option value=\""+ item.region + "|" + item.id +"\">"+ item.fullname +"</option>");
                    });
                }

                if (tipo==2){
                    $("#ejecutivo").append("<option value='0'>--Seleccione un Ejecutivo--</option>");
                    $.each(data, function (i, item) {
                        console.log(item);
                        $("#ejecutivo").append("<option value=\"" + item.id +"\">"+ item.fullname +"</option>");
                    });
                }

                if (tipo==3){
                    $("#rubro").append("<option value='0'>--Seleccione Rubro--</option>");
                    $.each(data, function (i, item) {
                        console.log(item);
                        $("#rubro").append("<option value=\"" + item.id +"\">"+ item.fullname +"</option>");
                    });
                }
            }
        </script>

        <script>
            {{"creaGraficoDonut(".$jsonCantidadStoresAudits.",".'chartdiv1'.")"}};
            //var chartData2 = JSON.parse('');

           /* var chartData2 = [
                {
                    "tipo": "Agentes sin Disposici�n",
                    "Op. Con Exito": 0,
                    "Op. Sin Exito": 80,
                    "Ag. Cerrados": 20,
                    "Ag. No Aceptaron Trans.": 50
                },
                {
                    "tipo": "Agentes con Disposici�n",
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
                    "tipo": "Disposici�n",
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