@extends('layouts/adminLayout')
@section('scripts_angular')
    {{ HTML::script('https://ajax.googleapis.com/ajax/libs/angularjs/1.3.13/angular.min.js') }}
    {{ HTML::script('js/app.js') }}
@stop
@section('content')
<section>
    <div class="cuerpo" ng-app="MyStores">
        <div class="cuerpo-content" ng-controller="SearchCtrl">
            <div class="row">
                <div class="col-sm-8">
                    <h4>Actualizando Store Ejecutivos Lista</h4>
                </div>
                <div class="col-sm-4">

                </div>
            </div>
        </div>
    </div>
    <div class="cuerpo">
        <div class="cuerpo-content">

            <!--Lista de usuario-->
            <table class="table-responsive table table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Ejecutivo</th>
                    <th>Address</th>
                    <th>district</th>
                    <th>region</th>
                    <th>ubigeo</th>
                    <th>latitude</th>
                    <th>longitude</th>
                    <th >ACTUALIZO</th>
                    <th class="text-right">Fecha Actualizado</th>

                </tr>
                </thead>
                <tbody>
                @foreach ($datosActualizados as $index => $store)
                <tr id="{{ $store['store']->id }}">
                    <td>{{$index +1}}</td>
                    <td>{{ $store['store']->id }}</td>
                    <td >{{ $store['store']->fullname }}</td>
                    <td >{{ $store['store']->ejecutivo }}</td>
                    <td>{{ $store['store']->address}}</td>
                    <td>{{ $store['store']->district}}</td>
                    <td>{{ $store['store']->region}}</td>
                    <td>{{ $store['store']->ubigeo}}</td>
                    <td>{{ $store['store']->latitude}}</td>
                    <td>{{ $store['store']->longitude}}</td>
                    <td>{{ $store['actualizado']}}</td>
                    <td class="text-right">
                        {{ $store['store']->updated_at }}
                    </td>

                </tr>
                @endforeach

                </tbody>
            </table>
      </div>
    </div>
</section>
@stop