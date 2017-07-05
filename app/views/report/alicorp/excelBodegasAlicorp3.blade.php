@extends('layouts/clienteAlicorp')
@section('content')
<section>
    @include('report/partials/menuPrincipalAlicorp')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <div class="row pt pb">
                <div class="col-sm-9">
                    <h4 class="report-title"> Campaña: {{$titulo}}</h4>
                </div>
                <div class="col-sm-3">
                    <img src="{{$logo}}" >
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="report-marco ">
                        <div class="contenedor-report">
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">Base Bodegas</div>
                                <div   class="btn btn-default btn-valor">{{$cantidadStoresForCampaigne}}</div>
                            </div>
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">Bodegas Programadas</div>
                                <div   class="btn btn-default btn-valor">{{$cantidadStoresRouting}}</div>
                            </div>
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">Bodegas visitadas</div>
                                <div   class="btn btn-default btn-valor">{{$cantidadStoresAudit}}</div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pt pb">
                <div class="col-md-12 pb">
                    <div class="report-marco ">
                        <div class="row pl">
                            <div class="col-md-12 ">
                                <h4>Reporte en Excel</h4>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 ">
                                @if($company_id==3)
                                <ul>
                                    <li><a href="http://ttaudit.com/reportes_excel/reporte_company_3_category_43.php" target="_blank">Salsas</a> </li>
                                    <li><a href="http://ttaudit.com/reportes_excel/reporte_company_3_category_45.php" target="_blank">Aceites Domésticos</a> </li>
                                    <li><a href="http://ttaudit.com/reportes_excel/reporte_company_3_category_46.php" target="_blank"> Caramelos</a> </li>
                                    <li><a href="http://ttaudit.com/reportes_excel/reporte_company_3_category_47.php" target="_blank"> Chocolates</a> </li>
                                    <li><a href="http://ttaudit.com/reportes_excel/reporte_company_3_category_48.php" target="_blank"> Detergentes</a> </li>
                                    <li><a href="http://ttaudit.com/reportes_excel/reporte_company_3_category_49.php" target="_blank"> Galletas</a> </li>
                                    <li><a href="http://ttaudit.com/reportes_excel/reporte_company_3_category_50.php" target="_blank"> Margarinas Domésticas</a> </li>
                                    <li><a href="http://ttaudit.com/reportes_excel/reporte_company_3_category_51.php" target="_blank"> Pastas</a> </li>
                                    <li><a href="http://ttaudit.com/reportes_excel/reporte_company_3_category_52.php" target="_blank"> Refrescos Instantáneos</a> </li>
                                    <li><a href="http://ttaudit.com/reportes_excel/reporte_company_3_category_53.php" target="_blank"> Exhibidores</a> </li>
                                    <li><a href="http://ttaudit.com/reportes_excel/reporte_company_3_category_54.php" target="_blank"> SOD Ventanas</a> </li>
                                </ul>
                                @endif
                                @if($company_id==15)
                                    <ul>
                                        <li><a href="http://ttaudit.com/reportes_excel/reporte_company_15_metro.php" target="_blank">Metro</a> </li>
                                        <li><a href="http://ttaudit.com/reportes_excel/reporte_company_15_plazavea.php" target="_blank">Plaza Vea</a> </li>
                                        <li><a href="http://ttaudit.com/reportes_excel/reporte_company_15_tottus.php" target="_blank"> Tottus</a> </li>
                                        <li><a href="http://ttaudit.com/reportes_excel/reporte_company_15_wong.php" target="_blank"> Wong</a> </li>
                                    </ul>
                                @endif
                                @if($company_id==18)
                                    <ul>
                                        <li><a href="http://ttaudit.com/reportes_excel/reporte_company_18_category_43.php" target="_blank">Salsas</a> </li>
                                        <li><a href="http://ttaudit.com/reportes_excel/reporte_company_18_category_45.php" target="_blank">Aceites Domésticos</a> </li>
                                        <li><a href="http://ttaudit.com/reportes_excel/reporte_company_18_category_46.php" target="_blank"> Caramelos</a> </li>
                                        <li><a href="http://ttaudit.com/reportes_excel/reporte_company_18_category_47.php" target="_blank"> Chocolates</a> </li>
                                        <li><a href="http://ttaudit.com/reportes_excel/reporte_company_18_category_48.php" target="_blank"> Detergentes</a> </li>
                                        <li><a href="http://ttaudit.com/reportes_excel/reporte_company_18_category_49.php" target="_blank"> Galletas</a> </li>
                                        <li><a href="http://ttaudit.com/reportes_excel/reporte_company_18_category_50.php" target="_blank"> Margarinas Domésticas</a> </li>
                                        <li><a href="http://ttaudit.com/reportes_excel/reporte_company_18_category_51.php" target="_blank"> Pastas</a> </li>
                                        <li><a href="http://ttaudit.com/reportes_excel/reporte_company_18_category_52.php" target="_blank"> Refrescos Instantáneos</a> </li>
                                        <li><a href="http://ttaudit.com/reportes_excel/reporte_company_18_category_53.php" target="_blank"> Exhibidores</a> </li>
                                        <li><a href="http://ttaudit.com/reportes_excel/reporte_company_18_category_54.php" target="_blank"> SOD Ventanas</a> </li>
                                    </ul>
                                @endif
                                @if($company_id==21)
                                    <ul>
                                        <li><a href="http://ttaudit.com/reportes_excel/reporte_company_21_category_43.php" target="_blank">Salsas</a> </li>
                                        <li><a href="http://ttaudit.com/reportes_excel/reporte_company_21_category_45.php" target="_blank">Aceites Domésticos</a> </li>
                                        <li><a href="http://ttaudit.com/reportes_excel/reporte_company_21_category_46.php" target="_blank"> Caramelos</a> </li>
                                        <li><a href="http://ttaudit.com/reportes_excel/reporte_company_21_category_47.php" target="_blank"> Chocolates</a> </li>
                                        <li><a href="http://ttaudit.com/reportes_excel/reporte_company_21_category_48.php" target="_blank"> Detergentes</a> </li>
                                        <li><a href="http://ttaudit.com/reportes_excel/reporte_company_21_category_49.php" target="_blank"> Galletas</a> </li>
                                        <li><a href="http://ttaudit.com/reportes_excel/reporte_company_21_category_50.php" target="_blank"> Margarinas Domésticas</a> </li>
                                        <li><a href="http://ttaudit.com/reportes_excel/reporte_company_21_category_51.php" target="_blank"> Pastas</a> </li>
                                        <li><a href="http://ttaudit.com/reportes_excel/reporte_company_21_category_52.php" target="_blank"> Refrescos Instantáneos</a> </li>
                                        <li><a href="http://ttaudit.com/reportes_excel/reporte_company_21_category_53.php" target="_blank"> Exhibidores</a> </li>
                                        <li><a href="http://ttaudit.com/reportes_excel/reporte_company_21_category_54.php" target="_blank"> SOD Ventanas</a> </li>
                                    </ul>
                                @endif
                                    @if($company_id==22)
                                        <ul>
                                            <li><a href="http://ttaudit.com/reportes_excel/reporte_company_22_category_53.php" target="_blank"> Exhibidores</a> </li>
                                            <li><a href="http://ttaudit.com/reportes_excel/reporte_company_22_category_54.php" target="_blank"> SOD Ventanas</a> </li>
                                        </ul>
                                    @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@stop
@section('report')


@endsection