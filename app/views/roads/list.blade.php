@extends('layouts/adminLayout')

@section('content')
<section>
    @include('roads/partials/menuLeft')


    <div class="cuerpo">
        <div class="cuerpo-content">
            <h4>Listado de Rutas Programadas</h4>
            <!--Lista de usuario-->

            <!-- Inicio de  Alerta para filtros -->
            @if($nameAuditor<>"0")
                <div id="alertaFiltro" class="alert alert-info alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <strong>Filtrado por:</strong>
                    Auditor {{$nameAuditor}}

                </div>
            @endif


                        <!-- FIn de  Alerta para filtros -->

            <!--Filtros con combos-->
            {{Form::open(['route' => 'roadsFilter', 'method' => 'POST', 'role' => 'form'])}}
            <div class="row">

                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="user_id">Auditor</label>
                        {{Form::select('user_id', array('0' => 'Seleccionar'), '0', ['id'=>'user_id','class' => 'form-control']);}}

                    </div>
                </div>


                <div class="col-sm-1">
                    <div class="form-group">
                        <label for="rubro">&emsp;</label>
                        <button class="btn btn-default" type="submit">Filtrar</button>
                    </div>

                </div>

            </div>

            {{ Form::close() }}
                    <!-- Fin Filtros con combos-->
            @if(count($roads)>0)
                <table class="table-responsive table table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Auditor</th>
                        <th>Fecha Creación</th>
                        <th>Situación</th>
                        <th class="text-right">Acciones</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php $c=0 ?>
                    @foreach ($roads as $road)
                        <?php $c=$c+1 ?>
                        <tr id="{{ $road->id }}">
                            <td>{{ $c}}</td>
                            <td><a href="{{ route('roadDetail', [$road->id]) }}">{{ $road->id }}</a></td>
                            <td ><a href="{{ route('roadDetail', [$road->id]) }}">{{ $road->fullname }}</a></td>
                            <td>{{ $road->user->fullname }}</td>
                            <td>{{ $road->created_at }}</td>
                            <td><a href="#" data-toggle="tooltip" data-placement="bottom" title="@if($road->audit==0) PDV aún por Auditar @else PDV fueron Auditados @endif">
                                    <span class="@if($road->audit==0)icon-indicador icon-table-size icon-color-red @else icon-indicador icon-table-size icon-color-green @endif"></span>
                                </a>
                            </td>
                            <td class="text-right">

                                <a href="#!" data-toggle="tooltip" data-placement="bottom" title="Eliminar Ruta" onclick="DeleteRow({{$road->id}});" ><span class="glyphicon glyphicon-remove"></span></a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            @endif


      </div>
    </div>
</section>
{{Form::open(['route' => ['admin.road.destroy',':ROAD_ID'], 'method' => 'DELETE', 'id' => 'form-delete'])}}
{{ Form::close() }}
@stop
@section('scripts_ajax')
    <script type="application/javascript">
        $('#alertaFiltro').on('closed.bs.alert', function () {
            $('.alertaFiltro').hide("slow");
        })
        $(document).ready(function(){
            $('#user_id option').remove();
            $.post('http://ttaudit.com/getAuditors', function(json){
                //if (item.latitud != 0 && item.longitud != 0){
                poblandoCombo(json,1);
            });
        });
        function DeleteRow(id) {
            if (confirm('Seguro que desea eliminar esta ruta?')){
                var form = $('#form-delete');
                /*var pdv = $('pdvs').text();*/
                var url = form.attr('action').replace(':ROAD_ID',id);
                var data = form.serialize();
                $('#' + id).fadeOut();
                $.post(url, data, function (result){
                    alert(result.message);
                    /* pdv = pdv -1;
                     $('pdvs').text(pdv);*/
                }).fail(function (){
                    alert('Esta ruta no pudo ser eliminada');
                    $('#' + id).show();
                });
            }

        }

        function poblandoCombo(data,tipo) {
            var total_puntos = 0;
            if (tipo==1){
                $("#user_id").append("<option value='0'>--Seleccione un Auditor--</option>");
                $.each(data, function (i, item) {
                    console.log(item);
                    $("#user_id").append("<option value=\""+ item.id +"\">"+ item.fullname +"</option>");
                });
            }

        }
    </script>

    </script>
@endsection
