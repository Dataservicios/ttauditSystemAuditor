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
                            <div class="list-group">
                                <a href="{{URL::to('http://www.ttaudit.com/reportes_excel/reporte_company_34.php')}}"> <span class="glyphicon glyphicon-ok"></span> Reporte Excel</a>

                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@stop

