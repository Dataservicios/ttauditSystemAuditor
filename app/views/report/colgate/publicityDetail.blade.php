@extends('layouts/adminLayout')
@section('content')
<section>
    @include('report/partials/menuLeftColgate')
    <div class="cuerpo">
        <div class="cuerpo-content">

                <div class="row pt pb">
                    <div class="col-sm-12">
                        <h4 class="report-title">Detalle de Publicidades: {{$valores[0]['publicidad']}}
                        </h4>

                        <div class="row pt pb">
                            <div class="col-sm-12 center">
                                <div class="btn-group" role="group" aria-label="...">
                                      <div   class="btn btn-default btn-si">Total de Mayoristas auditados:</div>
                                      <div   class="btn btn-default btn-valor">{{count($valores)}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row pt pb">
                            <div class="col-sm-8">
                                <table class="table-responsive table table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Mayorista</th>
                                        <th>Direc</th>
                                        <th>Foto tomada</th>
                                        <th>Fecha</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($valores as $presence)
                                    <tr>
                                        <td>{{$presence['num']}}</td>
                                        <td >{{ $presence['mayorista'] }}</td>
                                        <td >{{ $presence['store_direccion'] }}</td>
                                        <td>
                                            @foreach ($presence['arrayFoto'] as $index1 => $detailFoto)
                                                @if ($detailFoto['id']==0)
                                                    <span class="glyphicon glyphicon-picture"></span>
                                                @else
                                                    <a href="{{$detailFoto['urlFoto']}}" target="_blank"><img src="{{$detailFoto['urlFoto']}}" width="90px" class="img-thumbnail"></a>
                                                @endif
                                            @endforeach

                                        </td>
                                        <td class="text-right">{{$presence['created_at']}}
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-4">
                                <img src="{{URL::to('/media/images/colgate/publicities/'.$valores[0]['imagen']) }}" width="200px">

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

@endsection