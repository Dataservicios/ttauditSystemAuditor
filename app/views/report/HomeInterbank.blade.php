@extends('layouts/adminLayout')
@section('content')
<section>
    @include('report/partials/menuPrincipalInterbank')
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
                                {{Form::select('ciudad', $ciudades, '0', ['id'=>'ciudad','onchange'=>'ejecutaEvento(this,1)','class' => 'form-control']);}}

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

                        <div class="row">
                            <div class="col-md-12">
                                <a href="#" id="change" class="label label-success"> Comparar Estudios </a>
                            </div>
                        </div>

                        <div id="alertaCompara" class="alert alert-info  fade in" role="alert" >
                            <button type="button" class="close"   aria-label="Close"><span aria-hidden="true">×</span></button>
                            <div class="row">
                                <div class="col-md-12">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h5> Selecione los estudios que desea comparar</h5>
                                    {{Form::open(['route' => 'homeComparationStudies', 'method' => 'POST', 'role' => 'form', 'id' => 'frmComparacion'], $audit_id)}}
                                    {{ Form::hidden('company_id', $company_id) }}
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <label class="radio-inline">
                                                <input type="radio" id="unselect" name="inlineRadioOptions" id="inlineRadio1" value="option1" checked="true"> Selección individual
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" id="selectall" name="inlineRadioOptions" id="inlineRadio2" value="option2"> Seleccionar todo
                                            </label>
                                        </div>
                                        <div class="panel-body">
                                            <!-- SCROLL PANEL-->
                                            <div data-spy="scroll" data-target="#navbar-example2" data-offset="0" class="scrollspy-example">
                                                <div class="checkbox">
                                                    <label>
                                                        {{Form::checkbox('chk[]',  '1',null, ['class' => 'checkbox1'])}}Estudio 1
                                                        {{--<input type="checkbox" class="checkbox1">Estudio 1--}}
                                                    </label>
                                                </div>
                                                <div class="checkbox ">
                                                    <label>
                                                        {{Form::checkbox('chk[]',  '8',null, ['class' => 'checkbox1'])}}Estudio 2
                                                    </label>
                                                </div>

                                            </div>
                                            <button type="submit" class="btn btn-primary">Comparar</button>
                                        </div>
                                    </div>

                                    {{ Form::close() }}
                                </div>
                            </div>

                        </div>
                </div>
            </div>


            <div class="row pt pb">
                <div class="col-sm-12">
                    <div class="report-marco ">
                        <div class="contenedor-report">
                            <h4>Disponibilidad de Agentes</h4>

                            <div class="grafico-circle">
                                <div id="chartdivSiNo" style="width: 100%; height: 330px;" ></div>
                            </div>
                            <div class="grafico-circle">
                                <div id="charOptionsSiNo" style="width: 100%; height: 400px;" ></div>
                            </div>
                            <div>
                                @if($company_id==8)
                                    <a href="{{route('getDetailResultQuestion', "67/".$valores."-0"."/222")}}" class="btn btn-primary btn-sm active" role="button">Ver Detalle Local Cerrado</a>
                                    <a href="{{route('getDetailResultQuestion', "67/".$valores."-0"."/223")}}" class="btn btn-primary btn-sm active" role="button">Ver Detalle Ya no es Agente</a>
                                    <a href="{{route('getDetailResultQuestion', "67/".$valores."-0"."/224")}}" class="btn btn-primary btn-sm active" role="button">Ver Detalle Pidio Retiro</a>
                                @endif
                                @if($company_id==10)
                                    <a href="{{route('getDetailResultQuestion', "99/".$valores."-0"."/288")}}" class="btn btn-primary btn-sm active" role="button">Ver Detalle Local Cerrado</a>
                                    <a href="{{route('getDetailResultQuestion', "99/".$valores."-0"."/289")}}" class="btn btn-primary btn-sm active" role="button">Ver Detalle Ya no es Agente</a>
                                    <a href="{{route('getDetailResultQuestion', "99/".$valores."-0"."/290")}}" class="btn btn-primary btn-sm active" role="button">Ver Detalle Pidio Retiro</a>
                                @endif
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

                            <div class="grafico-circle">
                                <div id="chartdiv1" style="width: 100%; height: 330px;" ></div>
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
            var chartData = JSON.parse('{{$valSINOJson1}}');
            var charDiv = "chartdivSiNo";
            creaGraficoColumnas(chartData,charDiv,true);

            var chartData1 = JSON.parse('{{$totalOptionsJSON}}');
            var charDiv1 = "charOptionsSiNo";

            creaGraficoColumnas(chartData1,charDiv1,false);

            var chartData2 = JSON.parse('{{$valSINOJson}}');
            var charDiv2 = "chartdiv0";
            creaGraficoColumnas(chartData2,charDiv2,true);

            var chartData3 = JSON.parse('{{$totalOptionsJSON56}}');
            var charDiv3 = "chartdiv1";

            creaGraficoColumnas(chartData3,charDiv3,false);

            var chartData4 = JSON.parse('{{$valLimitsJson}}');
            //console.log("Char3" + chartData3);
            creaGraficoColumnasPorcentajesDinamic(chartData4,"chartdiv2",true,true);
        </script>
    <script>
        $('.prueba').on( "click", function( event ) {
            event.preventDefault();
            console.log('hola');
        });



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
        //--------------Seleccionando todo los radio buttoms ------////

        $('#selectall').click(function(event) {  //on click
            if(this.checked) { // check select status
                $('.checkbox1').each(function() { //loop through each checkbox
                    this.checked = true;  //select all checkboxes with class "checkbox1"
                });
            }
//                else{
//                    $('.checkbox1').each(function() { //loop through each checkbox
//                        this.checked = false; //deselect all checkboxes with class "checkbox1"
//                    });
//                }
        });

        //---------------------Quitrando la selecci'on
        $('#unselect').click(function(event) {  //on click

            if(this.checked){
                $('.checkbox1').each(function() { //loop through each checkbox
                    this.checked = false; //deselect all checkboxes with class "checkbox1"
                });
            }
        });

        //-----------Validation Form/////////////

        $( "#frmComparacion" ).submit(function( event ) {
//        alert( "Handler for .submit() called." );
//        event.preventDefault();

            var countChecked=0;
            $('.checkbox1').each(function() { //loop through each checkbox
                //this.checked = true;  //select all checkboxes with class "checkbox1"
                if(this.checked) {
                    countChecked++;
                }
            });

            if (countChecked < 2 ) {
                alert( "Seleccione al menos 2 estudios" );
                event.preventDefault();
            }
        });
    </script>

@endsection