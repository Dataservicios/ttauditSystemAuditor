@extends('layouts/adminLayout')
@section('content')
<section>
    @include('report/partials/menuLeft')
    <div class="cuerpo">
        <div class="cuerpo-content">
            @if ($audit->id=='7')
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
            @endif
                <div class="row pt pb">
                    <div class="col-sm-12">
                        <h4 class="report-title">{{ $audit->fullname }}</h4>
                        <?php $fila=0;$total=0;
                        $totalRegistros = count($resumenes)?>
                        @foreach ($resumenes as $resumen)
                            <?php $fila=$fila+1; $total=$total+1; ?>
                            @if ($fila==1)
                            <div class="row pt pb">
                            @endif
                                @if ($fila==1)
                                <div class="col-sm-6">
                                    @if ($resumen['sino']==1)
                                        <div >
                                            <div class="contenedor-report">
                                                <h4>{{$resumen['question']}}</h4>
                                                <div><a href="/pruebas/create_grafico_excel.php?polls_id={{$resumen['poll_id']}}&audits_id={{$resumen['audit_id']}}&sino=1" target="_blank" title="Obtener Detalle Excel"><img src="../../img/excel.png" width="25px"></a> </div>
                                                <div class="pt pb">
                                                    <p></p>
                                                    <div class="btn-group" role="group" aria-label="...">
                                                          <div   class="btn btn-default btn-si">SI</div>
                                                          <div   class="btn btn-default btn-valor">{{$resumen['result']['si']}}</div>

                                                    </div>
                                                    <div class="btn-group" role="group" aria-label="...">
                                                          <div   class="btn btn-default btn-no">No</div>
                                                          <div   class="btn btn-default btn-valor">{{$resumen['result']['no']}}</div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($resumen['option']==1)
                                        <div >
                                            <div class="contenedor-report">
                                                <h4> {{$resumen['question']}}</h4>

                                                <div class="grafico-circle">
                                                    <div id="{{'P'.$resumen['poll_id']}}" style="width: 100%; height: 250px;" ></div>
                                                    <div>
                                                    <h6>
                                                    @foreach ($resumen['LeyendaOpciones'] as $leyenda)
                                                        {{$leyenda['respuesta']."=".$leyenda['option']."|"}}
                                                    @endforeach
                                                    </h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                @endif


                                @if ($fila==2)
                                <div class="col-sm-6">
                                    @if ($resumen['sino']==1)
                                        <div >
                                            <div class="contenedor-report">
                                                <h4>{{$resumen['question']}}</h4>
                                                <div><a href="/pruebas/create_grafico_excel.php?polls_id={{$resumen['poll_id']}}&audits_id={{$resumen['audit_id']}}&sino=1" target="_blank" title="Obtener Detalle Excel"><img src="../../img/excel.png" width="25px"></a> </div>
                                                <div class="pt pb">
                                                    <p></p>
                                                    <div class="btn-group" role="group" aria-label="...">
                                                          <div   class="btn btn-default btn-si">SI</div>
                                                          <div   class="btn btn-default btn-valor">{{$resumen['result']['si']}}</div>

                                                    </div>
                                                    <div class="btn-group" role="group" aria-label="...">
                                                          <div   class="btn btn-default btn-no">No</div>
                                                          <div   class="btn btn-default btn-valor">{{$resumen['result']['no']}}</div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($resumen['option']==1)
                                        <div >
                                            <div class="contenedor-report">
                                                <h4> {{$resumen['question']}}</h4>

                                                <div class="grafico-circle">
                                                    <div id="{{'P'.$resumen['poll_id']}}" style="width: 100%; height: 250px;" ></div>
                                                    <div>
                                                    <h6>
                                                    @foreach ($resumen['LeyendaOpciones'] as $leyenda)
                                                        {{$leyenda['respuesta']."=".$leyenda['option']."|"}}
                                                    @endforeach
                                                    </h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                @endif
                            @if (($fila==2) or ($totalRegistros==$total))
                                <?php $fila=0?>
                            </div>
                            @endif
                        @endforeach
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
        @if ($audit->id=='7')
            <script>
                {{"creaGraficoDonut(".$jsonCantidadStoresAudits.",".'chartdiv1'.")"}};
            </script>
        @endif
        @foreach ($resumenes as $resumen)
            @if ($resumen['option']==1)
                <script>
                    {{"creaGraficoColumnas(".$resumen['JSONOpciones'].",".'P'.$resumen['poll_id'].")"}};
                </script>
            @endif
        @endforeach
        <!-- Data para grafico y generador del gráfico -->
        {{--{{ HTML::script('js/graficos/grafico1.js'); }}
        {{ HTML::script('js/graficos/grafico2.js'); }}
        {{ HTML::script('js/graficos/grafico3.js'); }}--}}
@endsection