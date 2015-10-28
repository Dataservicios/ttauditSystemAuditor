@extends('layouts/adminLayout')
@section('content')
<section>
    @include('report/partials/menuLeft')
    <div class="cuerpo">
        <div class="cuerpo-content">

                <div class="row pt pb">
                    <div class="col-sm-12">
                        <h4 class="report-title">{{$audit->fullname}}</h4>

                        <div class="row pt pb">
                            <div class="col-sm-12 center">
                                <div class="btn-group" role="group" aria-label="...">
                                      <div   class="btn btn-default btn-si">Total Agentes</div>
                                      <div   class="btn btn-default btn-valor">{{$cantidadStoresForCompany}}</div>
                                </div>
                                <div class="btn-group" role="group" aria-label="...">
                                      <div   class="btn btn-default btn-si">Total Agentes Auditados</div>
                                      <div   class="btn btn-default btn-valor">{{$CantidadStoresAudits}}</div>
                                </div>
                                <div class="btn-group" role="group" aria-label="...">
                                      <div   class="btn btn-default btn-no">Total Agentes Sin Auditar</div>
                                      <div   class="btn btn-default btn-valor">{{$cantidadStoresForCompany-$CantidadStoresAudits}}</div>
                                </div>
                            </div>
                        </div>

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
                                            @if (($resumen['poll_id'] == 3) or ($resumen['poll_id'] == 2) or ($resumen['poll_id'] == 12) or ($resumen['poll_id'] == 7) or ($resumen['poll_id'] == 41) or ($resumen['poll_id'] == 45) or ($resumen['poll_id'] == 48) or ($resumen['poll_id'] == 60) or ($resumen['poll_id'] == 43) or ($resumen['poll_id'] == 42) or ($resumen['poll_id'] == 52) or ($resumen['poll_id'] == 47) )
                                                <div>
                                                <a href="{{route('getDetailResultQuestion', $resumen['poll_id']."/".$valores.'-0')}}" class="btn btn-primary btn-sm active" role="button">Ver Detalle Respuesta NO</a> </div>
                                            @endif

                                        </div>
                                        @endif
                                        @if ($resumen['option']==1)
                                        <div class="grafico-circle">
                                            <div id="charOptions{{$resumen['poll_id']}}" style="width: 100%; height: 400px;" ></div>
                                        </div>
                                            @if ($resumen['poll_id'] == 26)
                                                <div class="grafico-circle"><label>Detalle Otros</label>
                                                    <div id="charOptionsOther{{$resumen['poll_id']}}" style="width: 100%; height: 400px;" ></div>
                                                </div>
                                            @endif
                                            @if ($resumen['poll_id'] == 67)
                                                <div>
                                                    <a href="{{route('getDetailResultQuestion', $resumen['poll_id']."/".$valores."-0"."/222")}}" class="btn btn-primary btn-sm active" role="button">Ver Detalle de Local Cerrado</a> </div>
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
                    creaGraficoColumnas(chartData1,charDiv,false);
                </script>
                @if ($resumen['poll_id'] == 26)
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
@endsection