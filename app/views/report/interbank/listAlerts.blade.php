@extends('layouts/clienteIBK')
@section('content')
<section>
    @include('report/partials/menuPrincipalInterbank')
    <div class="cuerpo">

        <div class="cuerpo-content">
            <div class="row pt pb">
                <div class="col-sm-9">
                    <h4 class="report-title">{{$titulo}}</h4>
                </div>
                <div class="col-sm-3">
                    <img src="{{$logo}}" width="200px">
                </div>
            </div>
            <div class="row pt pb">
                    <div class="col-sm-12">

                        <!-- Inicio de  Alerta para filtros -->

                        <!-- FIn de  Alerta para filtros -->


                        <!--Filtros con combos-->

                        <!-- Fin Filtros con combos-->

                        <div class="row pt pb">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h4>Últimas(50) Notificaciones</h4>
                                    </div>
                                    <div class="col-sm-4">

                                    </div>
                                </div>
                                <!--Lista de usuario-->
                                @if(count($valores)>0)
                                    <table class="table-responsive table table-hover">
                                        <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Titulo</th>
                                            <th>Tipo</th>
                                            <th >Pdv</th>
                                            <th >Ciudad</th>
                                            <th >Ejecutivo</th>
                                            <th >Fecha</th>
                                            <th >Status</th>

                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach ($valores as $valor)
                                            <tr>
                                                <td><a href="{{ route('alertDetail', $valor['id']) }}">{{ $valor['id'] }}</a></td>
                                                <td ><a href="{{ route('alertDetail', $valor['id']) }}">{{ $valor['titulo'] }}</a></td>
                                                <td>{{ $valor['motivo'] }}</td>
                                                <td>{{ $valor['punto'] }}</td>
                                                <td>{{ $valor['ciudad'] }}</td>
                                                <td>{{ $valor['ejecutivo'] }}</td>
                                                <td>{{date('d F Y G:i:s',strtotime($valor['fecha']))}}</td>
                                                <td >

                                                    @if($valor['comentado'])
                                                        <a href="#" title="Notificación ya respondida">
                                                            <span class=" icon-indicador icon-table-size icon-color-green "></span>
                                                        </a>
                                                    @else
                                                        <a href="#" title="Notificación sin responder">
                                                            <span class=" icon-indicador icon-table-size icon-color-red "></span>
                                                        </a>
                                                    @endif

                                                </td>

                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    No Hay Notificaciones
                                @endif

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


        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();

                $('.dropdown-toggle').dropdown()
            });
        </script>
@endsection