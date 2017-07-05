@extends('layouts/adminLayout')
@section('content')
<section>
    @include('report/partials/menuLeftPrincipal')

    <div class="cuerpo">
        <div class="cuerpo-content">
            <div class="row pt pb">
                <div class="col-sm-9">
                    <h4 class="report-title">Comparaciones Campaña Actual: {{$titulo}}</h4>
                </div>
                <div class="col-sm-3">
                    <img src="{{$logo}}" width="200px">
                </div>
            </div>
            <div class="row pt pb">
                <div class="col-sm-12">
                    <!-- Inicio de  Alerta para filtros -->
                    @if(($city<>"0") or ($ejecutivo<>"0") or ($rubro<>"0"))
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
                        {{Form::open(['route' => 'homeComparationFilter', 'method' => 'POST', 'role' => 'form'], $audit_id)}}
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    {{ Form::hidden('audit_id', $audit_id) }}
                                    {{ Form::hidden('compaign_link', $compaign_link) }}
                                    {{ Form::hidden('company_id', $company_id) }}
                                    {{ Form::hidden('rubro', "0") }}
                                    <label for="ciudad">Ciudad</label>
                                    {{Form::select('ciudad', $ciudades, '0', ['id'=>'ciudad','class' => 'form-control']);}}

                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="ejecutivo">Ejecutivo</label>
                                    {{Form::select('ejecutivo', array('0' => 'Seleccionar'), '0', ['id'=>'ejecutivo','class' => 'form-control']);}}

                                </div>

                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="rubro">Rubro</label>
                                    {{Form::select('rubro', array('0' => 'Seleccionar'), '0', ['id'=>'rubro','class' => 'form-control']);}}

                                </div>

                            </div>

                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="transac">Transacción</label>
                                    {{Form::select('transac', array('0' => 'Seleccionar'), '0', ['id'=>'transac','class' => 'form-control']);}}

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
                                {{ Form::hidden('company_id', $company_id, array('id' => 'company_id')) }}
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
                                                    {{Form::checkbox('chk[]',  '1',null, ['class' => 'checkbox1'])}}Estudio 1 2015
                                                    {{--<input type="checkbox" class="checkbox1">Estudio 1--}}
                                                </label>
                                            </div>
                                            <div class="checkbox ">
                                                <label>
                                                    {{Form::checkbox('chk[]',  '8',null, ['class' => 'checkbox1'])}}Estudio 2 2015
                                                </label>
                                            </div>
                                            <div class="checkbox ">
                                                <label>
                                                    {{Form::checkbox('chk[]',  '10',null, ['class' => 'checkbox1'])}}Estudio 1 2016
                                                </label>
                                            </div>
                                            <div class="checkbox ">
                                                <label>
                                                    {{Form::checkbox('chk[]',  '12',null, ['class' => 'checkbox1'])}}Estudio 2 2016
                                                </label>
                                            </div>
                                            <div class="checkbox ">
                                                <label>
                                                    {{Form::checkbox('chk[]',  '14',null, ['class' => 'checkbox1'])}}Estudio 3 2016
                                                </label>
                                            </div>
                                            <div class="checkbox ">
                                                <label>
                                                    {{Form::checkbox('chk[]',  '20',null, ['class' => 'checkbox1'])}}Estudio 4 2016
                                                </label>
                                            </div>
                                            <div class="checkbox ">
                                                <label>
                                                    {{Form::checkbox('chk[]',  '26',null, ['class' => 'checkbox1'])}}Estudio 5 2016
                                                </label>
                                            </div>
                                            <div class="checkbox ">
                                                <label>
                                                    {{Form::checkbox('chk[]',  '31',null, ['class' => 'checkbox1'])}}Estudio 6 2016
                                                </label>
                                            </div>
                                            <div class="checkbox ">
                                                <label>
                                                    {{Form::checkbox('chk[]',  '38',null, ['class' => 'checkbox1'])}}Estudio 7 2016
                                                </label>
                                            </div>
                                            <div class="checkbox ">
                                                <label>
                                                    {{Form::checkbox('chk[]',  '40',null, ['class' => 'checkbox1'])}}Estudio 8 2016
                                                </label>
                                            </div>

                                            <div class="checkbox ">
                                                <label>
                                                    {{Form::checkbox('chk[]',  '45',null, ['class' => 'checkbox1'])}}Estudio 9 2016
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
                    <div class="row">
                        <div class="col-md-12">
                            <div id="alertaFiltroWarning"  class="alert alert-warning" role="alert">

                                <a href="{{ route('report') }}" class="close-msj-campana" style="float: right" >
                                    <span class="label label-danger">Volver al estudio Vigente x</span>
                                </a>

                                <h4>{{ $compaign_select }} </h4>
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
                            <h4>Transacciones</h4>

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

                            <div class="grafico-circle pb">
                                <h5 class="text-center">Disposición</h5>
                                <div id="chartdiv2" style="width: 100%; height: 290px;" ></div>
                            </div>

                            <div class="grafico-circle pb">
                                <h5 class="text-center">Conocimiento</h5>
                                <div id="chartdiv3" style="width: 100%; height: 290px;" ></div>
                            </div>

                            <div class="grafico-circle pb">
                                <h5 class="text-center">Amabilidad</h5>
                                <div id="chartdiv4" style="width: 100%; height: 290px;" ></div>
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

        {{ HTML::script('js/graficos/ibk_chart.js'); }}
        <script>
            $(document).ready(function(){
                var company_id = $('#company_id').val();
                $('#ejecutivo option').remove();
                $('#rubro option').remove();
                $('#transac option').remove();
                //$('#ejecutivo').prop('disabled',false);

                $.post('http://ttaudit.com/getEjecutivos', function(json){
                    //if (item.latitud != 0 && item.longitud != 0){
                    poblandoCombo(json,2);
                });
                //$('#rubro').prop('disabled',false);

                $.post('http://ttaudit.com/getRubros',{ company_id : company_id }, function(json){
                    //if (item.latitud != 0 && item.longitud != 0){
                    poblandoCombo(json,3);

                });

                $.post('http://ttaudit.com/getTransaccion',{ company_id : company_id },
                        function(json){
                            poblandoCombo(json,4);

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
                if (tipo==4){
                    $("#transac").append("<option value='0'>--Seleccione Transacción--</option>");
                    $.each(data, function (i, item) {
                        console.log(item);
                        $("#transac").append("<option value=\"" + item.id +"\">"+ item.fullname +"</option>");
                    });
                }
            }
        </script>

        <script>
            var chartData = JSON.parse('{{$valSINOJson1}}');
            var charDiv = "chartdiv0";
            creaGraficoColumnasComparacion(chartData,charDiv, false,null,0,100 )

            var chartData1 = JSON.parse('{{$valSINOJson}}');
            var charDiv1 = "chartdiv1";
            creaGraficoColumnasComparacionTransaccion(chartData1,charDiv1, false,null,0,100 )

            var chartData2 = JSON.parse('{{$valLimitsJson}}');
            var charDiv2 = "chartdiv2";
            creaGraficoColumnasComparacionTrato(chartData2,charDiv2, false,null,0,100 )

            var chartData3 = JSON.parse('{{$valLimitsJson1}}');
            var charDiv3 = "chartdiv3";
            creaGraficoColumnasComparacionTrato(chartData3,charDiv3, false,null,0,100 )

            var chartData4 = JSON.parse('{{$valLimitsJson2}}');
            var charDiv4 = "chartdiv4";
            creaGraficoColumnasComparacionTrato(chartData4,charDiv4, false,null,0,100 )

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