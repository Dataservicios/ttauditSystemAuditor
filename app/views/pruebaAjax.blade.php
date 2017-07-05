@extends('layouts/layout')
@section('content')
    <div class="container-full-width">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 pb pt">
                    <img class="logo" src="img/logo.png" alt=""/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="cuadro-login">
                    <div class="row">
                        <div class="col-md-12" id="datos">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12  pb pt">
                <a href="#">lista</a>
            </div>
        </div>
    </div>
@stop
{{ HTML::script('lib/jquery.min.js'); }}
<script>

    $( document ).ready(function() {
        //console.log( "ready!" );
        var jqxhr = $.get("/listaCompanyAjax",  function(data) {
                    // alert( "success" + data );
                    console.log ("success => " + data);
                })
                .done(function() {
                    // alert( "second success" );
                    //console.log ("success => " + data);
                })
                .fail(function() {
                    //alert( "error" );
                })
                .always(function() {
                    // alert( "finished" );
                });
    });
</script>