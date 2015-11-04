@extends('layouts/adminLayout')

@section('content')
<section>
    @if ($userType == 'auditor')
        @include('auditors/partials/menuLeft')
        @else
        @include('store/partials/menuLeft')
    @endif

    <div class="cuerpo">
        <div class="cuerpo-content">

            <!--Lista de usuario-->
            <table class="table-responsive table table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Auditor</th>
                    <th>Campaña</th>
                    <th>Fecha Creación</th>

                    <th class="text-right">Acciones</th>

                </tr>
                </thead>
                <tbody>
                <?php $c=0 ?>
                @foreach ($roads as $road)
                <?php $c=$c+1 ?>
                <tr>
                    <td>{{ $c}}</td>
                    <td><a href="">{{ $road->id }}</a></td>
                    <td ><a href="">{{ $road->fullname }}</a></td>
                    <td>{{ $road->user->fullname }}</td>
                    <td>{{ $road->company->fullname}}</td>
                    <td>{{ $road->created_at }}</td>

                    <td class="text-right">
                        <a href="" data-toggle="tooltip" data-placement="bottom" title="Editar Ruta"><span class="icon-editarusuario"></span></a>

                    </td>
                </tr>
                @endforeach

                </tbody>
            </table>
            <!-- Paginador-->
             <div class="row">
                 <div class="col-md-12">
                     <nav class="text-center">
                         {{ $roads->links() }}
                     </nav>
                 </div>
             </div>
      </div>
    </div>
</section>
@stop