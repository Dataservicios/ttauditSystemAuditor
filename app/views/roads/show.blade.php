@extends('layouts/adminLayout')
@section('scripts_angular')
    {{ HTML::script('https://ajax.googleapis.com/ajax/libs/angularjs/1.3.13/angular.min.js') }}
    {{ HTML::script('js/app.js') }}
@stop
@section('content')
    <section>
        @include('roads/partials/menuLeft')
        <div class="cuerpo">
            <div class="cuerpo-content">
                <div class="row pt pb">
                    <div class="col-sm-12">
                        @if (Session::has('info'))
                            <div id="alertaFiltro" class="alert alert-info alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            {{Session::pull('info')}}
                        </div>
                        @endif
                        @if (Session::has('error'))
                            <div id="alertaFiltro" class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                <span class="sr-only">Error:</span>
                                {{Session::pull('error')}}
                            </div>
                        @endif
                        <div class="report-marco ">
                            <div class="contenedor-report">
                                <h4>Nombre Ruta: {{$road->fullname}} </h4>
                                <span id="pdvs">{{count($roadDetails)}}</span><span> PDV</span><br>
                                Codigo Ruta: {{$road->id}} |
                                Situación: <a href="#" data-toggle="tooltip" data-placement="bottom" title="@if($road->audit==0) PDV aún por Auditar @else PDV fueron Auditados @endif">
                                    <span class="@if($road->audit==0)icon-indicador icon-table-size icon-color-red @else icon-indicador icon-table-size icon-color-green @endif"></span>
                                </a> |
                                PDV Auditados: {{$auditados}} |
                                Auditor: {{$road->user->fullname}}
                            </div>
                        </div>

                    </div>
                </div>

                <div class="cuerpo" ng-app="MyStores1">
                    <div class="cuerpo-content" ng-controller="SearchCtrl1">
                        <div class="row">
                            <div class="col-sm-2">

                            </div>
                            <div class="col-sm-8">
                                <form action="">
                                    <input type="text" class="form-control" placeholder="Agregar Punto digitar el id o nombre de punto" ng-model="searchInput" ng-change="search()">
                                </form>
                            </div>
                            <div class="col-sm-2">

                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="list-group" ng-repeat="store in stores">
                                    <p class="list-group-item-heading">
                                        <a href="{{$urlBase}}/admin/addAgentRoad/{{$road->id}}/@{{ store.id }}/@{{ store.company_id }}" class="list-group-item">@{{ store.id }} | @{{ store.fullname }} | @{{ store.company }}</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row pt pb">
                    <div class="col-sm-12">
                        <div class="report-marco ">
                            <div class="contenedor-report">
                                <h4>Listado de Agentes</h4>
                                <table class="table-responsive table table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Id</th>
                                        <th>DIR</th>
                                        <th>Nombre</th>
                                        <th>Dirección</th>
                                        <th>Distrito</th>
                                        <th>Region</th>
                                        <th>Departamento</th>
                                        <th>Campaña</th>
                                        <th>Fecha Ingreso</th>
                                        <th>Auditado</th>
                                        <th class="text-right">Acciones</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($roadDetails as $index => $roadDetail)
                                        <tr id="{{$roadDetail->store->id}}">
                                            <td>{{$index +1}}</td>
                                            <td><a href="">{{ $roadDetail->store->id }}</a></td>
                                            <td ><a href="">{{ $roadDetail->store->codclient }}</a></td>
                                            <td>{{ $roadDetail->store->fullname }}</td>
                                            <td>{{ $roadDetail->store->address}}</td>
                                            <td>{{ $roadDetail->store->district }}</td>
                                            <td>{{ $roadDetail->store->region }}</td>
                                            <td>{{ $roadDetail->store->ubigeo }}</td>
                                            <td>{{ $roadDetail->company->fullname."(".$roadDetail->company_id.")" }}</td>
                                            <td>{{ $roadDetail->created_at }}</td>
                                            <td><a href="#" data-toggle="tooltip" data-placement="bottom" title="@if($roadDetail->audit==0) No Auditado @else Auditado @endif">
                                                <span class="@if($roadDetail->audit==0)icon-indicador icon-table-size icon-color-red @else icon-indicador icon-table-size icon-color-green @endif"></span>
                                                </a>
                                            </td>
                                            <td class="text-right">
                                                @if($roadDetail->audit==0)
                                                    <a href="#!" data-toggle="tooltip" data-placement="bottom" title="Sacar Punto de la ruta y volverlo al mapa" onclick="DeleteRow({{$roadDetail->store->id.",".$roadDetail->company_id.",".$roadDetail->road_id}});" ><span class="glyphicon glyphicon-remove"></span></a>
                                                    @else
                                                @endif

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
    {{Form::open(['route' => ['admin.agent.road.destroy',':VALUES'], 'method' => 'DELETE', 'id' => 'form-delete'])}}
    {{ Form::close() }}
@stop
@section('scripts_ajax')
    <script type="application/javascript">
        $('#alertaFiltro').on('closed.bs.alert', function () {
            $('.alertaFiltro').hide("slow");
        })
        $(document).ready(function(){

        });
        function DeleteRow(id,company,road) {
            if (confirm('Seguro que desea sacar este punto de esta ruta?')){
                var form = $('#form-delete');
                /*var pdv = $('pdvs').text();*/
                var value = id + '|' + company + '|' + road;
                var url = form.attr('action').replace(':VALUES',value);
                var data = form.serialize();
                $('#' + id).fadeOut();
                $.post(url, data, function (result){
                    alert(result.message);
                   /* pdv = pdv -1;
                    $('pdvs').text(pdv);*/
                }).fail(function (){
                    alert('El punto no fue sacado de la ruta');
                    $('#' + id).show();
                });
            }

        }

        function AddRow(id) {
            if (confirm('Seguro que desea agregar este Agente?')){

            }

        }
    </script>
@endsection