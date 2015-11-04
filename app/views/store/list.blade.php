@extends('layouts/adminLayout')
@section('scripts_angular')
    {{ HTML::script('https://ajax.googleapis.com/ajax/libs/angularjs/1.3.13/angular.min.js') }}
    {{ HTML::script('js/app.js') }}
@stop
@section('content')
<section>
    @if ($userType == 'auditor')
        @include('auditors/partials/menuLeft')
        @else
        @include('store/partials/menuLeft')
    @endif
    <div class="cuerpo" ng-app="MyStores">
        <div class="cuerpo-content" ng-controller="SearchCtrl">
            <div class="row">
                <div class="col-sm-8">
                    <h4>Lista de Puntos de Venta</h4>
                </div>
                <div class="col-sm-4">
                    <form action="">
                        <input type="text" class="form-control" placeholder="Buscar" ng-model="searchInput" ng-change="search()">
                    </form>
                </div>

            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="list-group" ng-repeat="store in stores">
                        <p class="list-group-item-heading">
                            <a href="http://ttaudit.com/admin/storeEdit/@{{ store.id }}" class="list-group-item" >@{{ store.codclient }} | @{{ store.fullname }} | @{{ store.company }}</a>
                        </p>
                    </div>
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
                    <th>Tipo</th>
                    <th>Address</th>
                    <th>Fecha Creación</th>

                    <th class="text-right">Acciones</th>

                </tr>
                </thead>
                <tbody>
                <?php $c=0 ?>
                @foreach ($stores as $store)
                <?php $c=$c+1 ?>
                <tr>
                    <td>{{ $c}}</td>
                    <td><a href="{{ route('storeDetail', [$store->id]) }}">{{ $store->id }}</a></td>
                    <td ><a href="{{ route('storeDetail', [$store->id]) }}">{{ $store->fullname }}</a></td>
                    <td>{{ $store->type }}</td>
                    <td>{{ $store->address}}</td>
                    <td>{{ $store->created_at }}</td>

                    <td class="text-right">
                        <a href="{{ route('storeEdit', [$store->id]) }}" data-toggle="tooltip" data-placement="bottom" title="Editar Punto"><span class="icon-editarusuario"></span></a>

                    </td>
                </tr>
                @endforeach

                </tbody>
            </table>
            <!-- Paginador-->
             <div class="row">
                 <div class="col-md-12">
                     <nav class="text-center">
                         {{ $stores->links() }}
                     </nav>
                 </div>
             </div>
      </div>
    </div>
</section>
@stop