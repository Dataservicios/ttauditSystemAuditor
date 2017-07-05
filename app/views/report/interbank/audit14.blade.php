@extends('layouts/clienteIBK')
@section('content')
<section>
    @include('report/partials/menuPrincipalInterbank')
    <div class="cuerpo">

        <div class="cuerpo-content">
            <div class="row pt pb">
                <div class="col-sm-9">
                    <h4 class="report-title">{{$titulo}}:{{$audit->fullname}}</h4>
                </div>
                <div class="col-sm-3">
                    <img src="{{$logo}}" width="200px">
                </div>
            </div>
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
                        {{Form::open(['route' => 'auditReportFilter', 'method' => 'POST', 'role' => 'form'], $audit_id)}}
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        {{ Form::hidden('audit_id', $audit_id) }}
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


                            <!-- Inicio de  omparación Campaña -->
                            <div id="alertaCompara" class="alert alert-info  fade in" role="alert" >
                                <button type="button" class="close"   aria-label="Close"><span aria-hidden="true">×</span></button>
                                <div class="row">
                                    <div class="col-md-12">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5> Selecione los estudios que desea comparar</h5>
                                        {{Form::open(['route' => 'comparationStudies', 'method' => 'POST', 'role' => 'form'], $audit_id)}}
                                            {{ Form::hidden('audit_id', $audit_id) }}
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
                                                                {{Form::checkbox('chk[]',  '1', ['class' => 'checkbox1']);}}Estudio 1 2015
                                                                {{--<input type="checkbox" class="checkbox1">Estudio 1--}}
                                                            </label>
                                                        </div>
                                                        <div class="checkbox ">
                                                            <label>
                                                                {{Form::checkbox('chk[]',  '8', ['class' => 'checkbox1']);}}Estudio 2 2015
                                                            </label>
                                                        </div>
                                                        <div class="checkbox ">
                                                            <label>
                                                                {{Form::checkbox('chk[]',  '10', ['class' => 'checkbox1']);}}Estudio 1 2016
                                                            </label>
                                                        </div>
                                                        <div class="checkbox ">
                                                            <label>
                                                                {{Form::checkbox('chk[]',  '12', ['class' => 'checkbox1']);}}Estudio 2 2016
                                                            </label>
                                                        </div>
                                                        <div class="checkbox ">
                                                            <label>
                                                                {{Form::checkbox('chk[]',  '14', ['class' => 'checkbox1']);}}Estudio 3 2016
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
                                                                {{Form::checkbox('chk[]',  '34',null, ['class' => 'checkbox1'])}}Estudio 7 2016
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
                                                        <div class="checkbox ">
                                                            <label>
                                                                {{Form::checkbox('chk[]',  '49',null, ['class' => 'checkbox1'])}}Estudio 10 2016
                                                            </label>
                                                        </div>
                                                        <div class="checkbox ">
                                                            <label>
                                                                {{Form::checkbox('chk[]',  '51',null, ['class' => 'checkbox1'])}}Estudio 11 2016
                                                            </label>
                                                        </div>
                                                        <div class="checkbox ">
                                                            <label>
                                                                {{Form::checkbox('chk[]',  '57',null, ['class' => 'checkbox1'])}}Estudio 01 2017
                                                            </label>
                                                        </div>
                                                        <div class="checkbox ">
                                                            <label>
                                                                {{Form::checkbox('chk[]',  '64',null, ['class' => 'checkbox1'])}}Estudio 02 2017
                                                            </label>
                                                        </div>
                                                        <div class="checkbox ">
                                                            <label>
                                                                {{Form::checkbox('chk[]',  '69',null, ['class' => 'checkbox1'])}}Estudio 03 2017
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



                            <div class="row pt pb">
                            <div class="col-sm-12">
                            @foreach ($resumenes as $resumen)
                                <div class="report-marco ">
                                    <div class="contenedor-report">
                                        <h4>{{ $resumen['question'] }}</h4>
                                        @if ($resumen['limits']==1)
                                        <div class="grafico-circle">
                                            <div id="charLimits{{$resumen['poll_id']}}" style="width: 100%; height: 250px;" ></div>
                                        </div>
                                        @endif

                                        @if ($resumen['sino']==1)
                                        <div class="grafico-circle">
                                            <div id="charSiNo{{$resumen['poll_id']}}" style="width: 100%; height: 400px;" ></div>
                                            @if (($resumen['poll_id'] == $exterior) or ($resumen['poll_id'] == $interior) or ($resumen['poll_id'] == $aceptoOperacion) or ($resumen['poll_id'] == $opExitosa))
                                                <div>
                                                <a href="{{route('getDetailResultQuestion', $resumen['poll_id']."/".$valores.'-0')}}" class="btn btn-primary btn-sm active" role="button">Ver Detalle Respuesta NO</a> </div>
                                            @endif
                                            @if ($resumen['poll_id'] == $cobroFueraVoucher)
                                                <div>
                                                    <a href="{{route('getDetailResultQuestion', $resumen['poll_id']."/".$valores.'-1')}}" class="btn btn-primary btn-sm active" role="button">Ver Detalle Respuesta SI</a> </div>
                                            @endif

                                        </div>
                                        @endif
                                        @if ($resumen['option']==1)
                                        <div class="grafico-circle">
                                            <div id="charOptions{{$resumen['poll_id']}}" style="width: 100%; height: 400px;" ></div>
                                        </div>
                                            @if  ($resumen['poll_id'] == $rubro)
                                                {{--<div class="grafico-circle"><label>Detalle Otros</label>
                                                    <div id="charOptionsOther{{$resumen['poll_id']}}" style="width: 100%; height: 400px;" ></div>
                                                </div>--}}
                                            @endif
                                            @if ($resumen['poll_id'] == $porqueNoTransOK)
                                                <div>
                                                    <a href="{{route('getDetailResultQuestion', $resumen['poll_id']."/".$valores."-0"."/".$porqueNoTransOKOpcionOtro)}}" class="btn btn-primary btn-sm active" role="button">Ver Detalle Otros</a> </div>
                                            @endif
                                            @if ($resumen['poll_id'] == $solucionTrans)
                                                <div>
                                                    <a href="{{route('getDetailResultQuestion', $resumen['poll_id']."/".$valores."-0"."/".$solucionTransOpcionOtro)}}" class="btn btn-primary btn-sm active" role="button">Ver Detalle Otros</a> </div>
                                            @endif
                                            @if ($resumen['poll_id'] == $abierto)
                                                <div>
                                                    <a href="{{route('getDetailResultQuestion', $resumen['poll_id']."/".$valores."-0"."/".$abiertoLocalCerrado)}}" class="btn btn-primary btn-sm active" role="button">Ver Detalle Local Cerrado</a>
                                                    <a href="{{route('getDetailResultQuestion', $resumen['poll_id']."/".$valores."-0"."/".$abiertoYaNoAgente)}}" class="btn btn-primary btn-sm active" role="button">Ver Detalle Ya no es Agente</a>
                                                </div>

                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endforeach
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

        {{ HTML::script('js/graficos/chart.js'); }}

        <!-- // Libreria AMCHART creaGraficoColumnas(chartData2,"char3");	-->
        @foreach ($resumenes as $resumen)
            @if ($resumen['sino']==1)
                <script>
                   // var chartData = JSON.parse('[{"respuesta":"SI","cantidad":385,"porcentaje":97},{"respuesta":"NO","cantidad":9,"porcentaje":3}]');

                    var chartData = JSON.parse('{{$resumen['JSONSiNo']}}');
                    var charDiv = "charSiNo" + "{{$resumen['poll_id']}}";
                    console.log(chartData);
                    /*creaGraficoColumnas(chartData,charDiv);*/
                    creaGraficoColumnas(chartData,charDiv,true);

                </script>
            @endif
            @if ($resumen['option']==1)
                <script>
                    var chartData1 = JSON.parse('{{$resumen['JSONOpciones']}}');
                    var charDiv = "charOptions" + "{{$resumen['poll_id']}}";
                    console.log(chartData1);
                    //creaGraficoColumnasPorcentajesDinamic(chartData1,charDiv,true,true);
                    creaGraficoColumnas(chartData1,charDiv,true);
                </script>
                @if ($resumen['poll_id'] == $rubro)
                    <script>
                        var chartData1 = JSON.parse('{{$resumen['JSONOpcionesOther']}}');
                        var charDiv = "charOptionsOther" + "{{$resumen['poll_id']}}";
                        creaGraficoColumnas(chartData1,charDiv,false);
                    </script>
                @endif
            @endif
            @if ($resumen['limits']==1)
                <script>
                    var chartData1 = JSON.parse('{{$resumen['JSONLimits']}}');
                    var charDiv = "charLimits" + "{{$resumen['poll_id']}}";
                    console.log(chartData1);
                    //creaGraficoColumnasPorcentajesDinamic(chartData1,charDiv,true,true);
                    creaGraficoColumnas(chartData1,charDiv,true);
                </script>

            @endif
        @endforeach
        <script>
            $(document).ready(function(){
                var company_id = $('#company_id').val();
               $('#ejecutivo option').remove();
               $('#rubro option').remove();
                $('#transac option').remove();
               //$('#ejecutivo').prop('disabled',false);

               $.post('http://ttaudit.com/getEjecutivosForCompany',{ company_id : company_id }, function(json){
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
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();

                $('.dropdown-toggle').dropdown()
            });


            //Evento aplicado a las Alertas
            $('#alertaFiltro').on('closed.bs.alert', function () {
                // do something…
                //console.log("Cerrando alerta");
                window.location.href = "{{ route('auditReport', $audit_id) }}";
            })
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

</script>
@endsection