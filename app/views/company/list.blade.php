@extends('layouts/adminLayout')
@section('content')
<section>
    @include('company/partials/menuLeft')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <!--sección titulo y buscador-->
            <div class="row">
                <div class="col-sm-8">
                    <h4>Lista de Empresas</h4>
                </div>
                <div class="col-sm-4">
                    <form action="">
                        <input type="text" class="form-control" placeholder="Buscar">
                    </form>
                </div>
            </div>

            <!--Lista de usuario-->
            <table class="table-responsive table table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Fecha Creación</th>
                    <th>Email</th>
                    <th class="text-right">Acciones</th>

                </tr>
                </thead>
                <tbody>
                <?php $c=0 ?>
                @foreach ($companies as $company)
                <?php $c=$c+1 ?>
                <tr>
                    <td>{{ $c}}</td>
                    <td><a href="users-info.html">{{ $company->id }}</a></td>
                    <td ><a href="users-info.html">{{ $company->fullname }}</a></td>
                    <td>{{ $company->created_at }}</td>
                    <td></td>
                    <td class="text-right">
                        <a href="" data-toggle="tooltip" data-placement="bottom" title="Editar Usuario"><span class="icon-editarusuario"></span></a>

                    </td>
                </tr>
                @endforeach

                </tbody>
            </table>
            <!-- Paginador-->
             <div class="row">
                 <div class="col-md-12">
                     <nav class="text-center">
                         {{ $companies->links() }}
                     </nav>
                 </div>
             </div>
      </div>
    </div>
</section>
@stop