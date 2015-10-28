@extends('layouts/adminLayout')
@section('content')
<section>
    @include('report/partials/menuLeftColgate')
    <div class="cuerpo">
        <div class="cuerpo-content">

                <div class="row pt pb">
                    <div class="col-sm-12">
                        <h4 class="report-title">Resultados
                        </h4>

                        <div class="row pt pb">
                            <div class="col-sm-12 center">
                                <div class="btn-group" role="group" aria-label="...">
                                      <div   class="btn btn-default btn-si">Total de Productos encontrados:</div>
                                      <div   class="btn btn-default btn-valor">{{count($presences)}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row pt pb">
                            <div class="col-sm-12">
                                <table class="table-responsive table table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Producto</th>
                                        <th>Ean</th>
                                        <th>Nro. Auditorias</th>
                                        <th class="text-right">Acciones</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($presences as $index => $presence)
                                    <tr>
                                        <td>{{$index +1}}</td>
                                        <td><a href="{{ route('product', [$presence->presence->product->id]) }}" target="_blank">{{ $presence->presence->product->fullname }}</a></td>
                                        <td >{{ $presence->presence->product->eam }}</td>
                                        <td>{{$presence->num}}</td>
                                        <td class="text-right"><a href="{{ route('DetailPresencia', [$presence->presence_id,$audit_id]) }}" class="btn btn-info" title="Ver Detalle">Ver</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
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