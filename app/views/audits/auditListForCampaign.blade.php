@extends('layouts/adminLayout')
@section('content')
<section>
    @include('audits/partials/menuLeftAudit')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="report-marco ">
                        <div class="contenedor-report">
                            <h4>Auditoria {{$detailAudit->fullname}}</h4>
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">Cliente:</div>
                                <div   class="btn btn-default btn-valor">{{$customer->fullname}}</div>
                            </div>
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">Campaña:</div>
                                <div   class="btn btn-default btn-valor">{{$campaigne->fullname}}</div>
                            </div>
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">PDV totales:</div>
                                <div   class="btn btn-default btn-valor">{{$QStoresForCompany}}</div>
                            </div>
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">PDV cerrados:</div>
                                <div   class="btn btn-default btn-valor">{{$QAuditClose}}</div>
                            </div>
                            <div class="btn-group" role="group" aria-label="...">
                                @if(($audit_id >=7) and ($audit_id<=11))
                                    <div   class="btn btn-default btn-no">PDV sin Auditar</div>
                                    <div   class="btn btn-default btn-valor">{{$regInsertAudit}}</div>
                                @else
                                    <div   class="btn btn-default btn-si">PDV auditados:</div>
                                    <div   class="btn btn-default btn-valor">{{$regInsertAudit}}</div>
                                @endif

                            </div>
                        </div>
                    </div>

                    <div class="report-marco ">
                        <div class="contenedor-report">
                            Filtros:
                             <a href="{{route('auditListStoresForAudit', array($audit_id, $campaigne->id))}}" data-toggle="tooltip" data-placement="bottom" title="Filtros Por tienda">
                                Por Tienda
                            </a> |
                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="Filtros Por Fecha">
                                Por Fecha
                            </a> |
                            @if($vista == "50 primeros")
                                <a href="{{route('auditListStoresForAudit', array($audit_id,$campaigne->id,"all"))}}" data-toggle="tooltip" data-placement="bottom" title="Mostrar todos los registros">
                                    All
                                </a>
                                @else
                                <a href="{{route('auditListStoresForAudit', array($audit_id,$campaigne->id))}}" data-toggle="tooltip" data-placement="bottom" title="Mostrar 50 últimos ingresos">
                                    50 últimos
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="row pt pb">
                        <div class="col-sm-12">
                            @if ($audit_id==2)
                            <table class="table-responsive table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>codigo</th>
                                    <th>Tienda</th>
                                    <th>Nro. Productos</th>
                                    <th>Fecha</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($storesxCampaigne as $index => $presence)
                                    <tr>
                                        <td>{{$index +1}}</td>
                                        <td><a href="{{route('auditDetailForStore', array($audit_id,$campaigne->id,$presence->id))}}" data-toggle="tooltip" data-placement="bottom" title="Ver Detalle de Productos Encontrados">{{ $presence->id }}</a></td>
                                        <td ><a href="{{route('auditDetailForStore', array($audit_id,$campaigne->id,$presence->id))}}" data-toggle="tooltip" data-placement="bottom" title="Ver Detalle de Productos Encontrados">{{ $presence->fullname}}</a></td>
                                        <td>{{$presence->num_prod}}</td>
                                        <td>{{$presence->created_at}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @endif
                            @if ($audit_id==3)
                                <table class="table-responsive table table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>codigo</th>
                                        <th>Tienda</th>
                                        <th>Publicidad</th>
                                        <th>Layout</th>
                                        <th>Visible</th>
                                        <th>Contaminado</th>
                                        <th>Fecha</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($storesxCampaigne as $index => $presence)
                                        <tr>
                                            <td>{{$index +1}}</td>
                                            <td><a href="{{route('auditDetailForStore', array($audit_id,$campaigne->id,$presence->id))}}" data-toggle="tooltip" data-placement="bottom" title="Ver Detalle de Materiales Encontrados">{{ $presence->id }}</a></td>
                                            <td ><a href="{{route('auditDetailForStore', array($audit_id,$campaigne->id,$presence->id))}}" data-toggle="tooltip" data-placement="bottom" title="Ver Detalle de Materiales Encontrados">{{ $presence->fullname}}</a></td>
                                            @if($presence->Nro_Publi == null)
                                                <td>0</td>
                                            @else
                                                <td>{{$presence->Nro_Publi}}</td>
                                            @endif
                                            @if($presence->Nro_layout_ok == null)
                                                <td>0</td>
                                            @else
                                                <td>{{$presence->Nro_layout_ok}}</td>
                                            @endif
                                            @if($presence->Nro_visible_ok == null)
                                                <td>0</td>
                                            @else
                                                <td>{{$presence->Nro_visible_ok}}</td>
                                            @endif
                                            @if($presence->Nro_contaminado_ok == null)
                                                <td>0</td>
                                            @else
                                                <td>{{$presence->Nro_contaminado_ok}}</td>
                                            @endif
                                            <td>{{$presence->created_at}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
