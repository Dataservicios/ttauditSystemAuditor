@extends('layouts/adminLayout')
@section('content')
<section>
    @include('report/partials/menuLeft')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <div class="row pt pb">
                <div class="col-sm-12">
                    <div class="report-marco ">
                        <div class="contenedor-report">
                            <h4>Auditorias Reportes Excel</h4>
                            @if($cantidadStoresForCompany==$CantidadStoresAudits)
                                <div class="list-group">
                                    <a href="{{URL::to('media/archivos/Reporte_final_Interbank_fase1.xlsx')}}">  <span class="glyphicon glyphicon-ok"></span> Reporte General Excel </a>

                                </div>
                                <div class="list-group">
                                    <a href="{{URL::to('media/archivos/reporte_geolocalizaciones.xlsx')}}"> <span class="glyphicon glyphicon-ok"></span> Reporte Geolocalizaciones Excel</a>

                                </div>
                            @else
                                {{--@for ($i = 0; $i <= $entItems; $i++)
                                    <div class="list-group">
                                        <a href="{{URL::to('pruebas/prueba.php?limite_inf='.$i.'&id_company=8')}}">  <span class="glyphicon glyphicon-ok"></span> Reporte Parcial Excel Parte {{$i}} </a>

                                    </div>
                                @endfor--}}
                                    <div class="list-group">
                                        <a href="{{URL::to('http://www.ttaudit.com/reportes_excel/reporte_company_8.php')}}">  <span class="glyphicon glyphicon-ok"></span> Reporte Completo </a>

                                    </div>
                                    <div class="list-group">
                                        <a href="{{URL::to('http://www.ttaudit.com/reportes_excel/reporte_dia_company_8.php')}}"> <span class="glyphicon glyphicon-ok"></span> Reporte diario</a>

                                    </div>

                            @endif


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@stop

