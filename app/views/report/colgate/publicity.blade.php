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
                                      <div   class="btn btn-default btn-si">Total de Publicidades encontrados:</div>
                                      <div   class="btn btn-default btn-valor">{{count($publicities)}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row pt pb">
                            <div class="col-sm-12">
                                <table class="table-responsive table table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Publicidad</th>
                                        <th>Categoria</th>
                                        <th>Nro. Auditorias</th>
                                        <th class="text-right">Acciones</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($publicities as $index => $publi)
                                    <tr>
                                        <td>{{$index +1}}</td>
                                        <td><a href="{{ route('product', [$publi->publicity->id]) }}" target="_blank">{{ $publi->publicity->fullname }}</a></td>
                                        <td >{{ $publi->publicity->categoryProduct->fullname }}</td>
                                        <td>{{$publi->num}}</td>
                                        <td class="text-right"><a href="{{ route('DetailPublicidad', [$publi->publicity_id,$audit_id]) }}" class="btn btn-info" title="Ver Detalle">Ver</a>
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