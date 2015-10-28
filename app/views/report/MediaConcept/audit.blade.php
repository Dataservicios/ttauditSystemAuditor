@extends('layouts/adminLayout')
@section('content')
<section>
    @include('report/partials/menuLeftMediaConcept')
    <div class="cuerpo">
        <div class="cuerpo-content">

                <div class="row pt pb">
                    <div class="col-sm-12">
                        <h4 class="report-title">Resultados
                        @if ($store_id==1244)
                         Mercado Ciudad de Dios
                        @endif
                        @if ($store_id==1245)
                         Mercado Valle Sagrado
                        @endif
                        @if ($store_id==1246)
                         Mercado Virgen de las Mercedes
                        @endif
                        </h4>

                        <div class="row pt pb">
                            <div class="col-sm-12 center">
                                <div class="btn-group" role="group" aria-label="...">
                                      <div   class="btn btn-default btn-si">Total Encuestas Ingresadas</div>
                                      <div   class="btn btn-default btn-valor">{{$CantidadStoresAudits}}</div>
                                </div>

                            </div>
                        </div>


                        <div class="row pt pb">
                            <div class="col-sm-12">
                            @foreach ($resumenes as $index => $resumen)
                                <div class="report-marco ">
                                    <div class="contenedor-report">
                                        <h4>{{$index +1}} - {{ $resumen['question'] }}</h4>
                                        @if ($resumen['limits']==1)
                                        <div class="grafico-circle">
                                            <div id="charLimits{{$resumen['poll_id']}}" style="width: 100%; height: 250px;" ></div>
                                        </div>
                                        @endif
                                        @if ($resumen['sino']==1)
                                        <div class="grafico-circle">
                                            <div id="charSiNo{{$resumen['poll_id']}}" style="width: 100%; height: 400px;" ></div>
                                            @if (($resumen['poll_id'] == 3) or ($resumen['poll_id'] == 2) or ($resumen['poll_id'] == 12) or ($resumen['poll_id'] == 7) )
                                                <div>
                                                <a href="{{route('getDetailResultSiNo', $resumen['poll_id']."/".$valores.'-0')}}" class="btn btn-primary btn-sm active" role="button">Ver Detalle Respuesta NO</a> </div>
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

        @endforeach

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