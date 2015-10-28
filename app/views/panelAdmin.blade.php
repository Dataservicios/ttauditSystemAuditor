@extends('layouts/adminLayout')
@section('content')
<section>
    @include('users/partials/menuLeft')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <!--sección titulo y buscador-->
            <div class="row">
                <div class="col-sm-8">
                    <h4>Lista de Usuarios</h4>
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
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Email</th>
                    <th class="text-right">Acciones</th>

                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                <tr>
                    <td><a href="users-info.html">{{ $user->id }}</a></td>
                    <td ><a href="users-info.html">{{ $user->fullname }}</a></td>
                    <td>{{ $user->type }}</td>
                    <td>{{ $user->email }}</td>
                    <td class="text-right">
                        <a href="{{ route('userEdit', [$user->id]) }}" data-toggle="tooltip" data-placement="bottom" title="Editar Usuario"><span class="icon-editarusuario"></span></a>
                        {{ Form::open(array('route' => array('admin.users.destroy', $user->id), 'method' => 'DELETE', 'role' => 'form')) }}
                        {{--<a href="#" data-id="{{ $user->id }}" data-toggle="tooltip" data-placement="bottom" title="Eliminar Usuario"><span class="icon-eliminarusuario"></span></a>--}}
                            {{ Form::button('Delete' , ['type' => 'submit', 'class' => 'icon-eliminarusuario']) }}
                        {{ Form::close() }}
                    </td>
                </tr>
                @endforeach

                </tbody>
            </table>
            <!-- Paginador-->
             <div class="row">
                 <div class="col-md-12">
                     <nav class="text-center">
                         {{ $users->links() }}
                     </nav>
                 </div>
             </div>
      </div>
    </div>
</section>



@stop