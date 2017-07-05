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
                                <div   class="btn btn-default btn-si">Base PDV:</div>
                                <div   class="btn btn-default btn-valor">{{$cantidadStoresForCampaigne}}</div>
                            </div>
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">PDV Programados:</div>
                                <div   class="btn btn-default btn-valor">{{$cantidadStoresRouting}}</div>
                            </div>
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">PDV Visitados:</div>
                                <div   class="btn btn-default btn-valor">{{$cantidadStoresAudit}}</div>
                            </div>
                        </div>
                    </div>

                    <div class="report-marco ">
                        <div class="contenedor-report">
                            @if($alertas<>"")
                                <div id="alertaFiltro" class="alert alert-info alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <strong>Filtrado por:</strong>
                                    @if(is_object($objStore))
                                        {{$alertas."pdv= ".$objStore->fullname.'('.$objStore->id.')'}}
                                    @else
                                        {{$alertas}}
                                    @endif
                                </div>
                                @endif
                        </div>
                    </div>
                    {{Form::open(['route' => '', 'method' => 'POST', 'role' => 'form'], $audit_id)}}
                    <div class="row pt pb">
                        <!-- MODAL VENTANA-->
                        <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Grabando Valor SOD de {{$objStore->fullname.'('.$objStore->id.')'}}</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>Confirmar Grabación</p>
                                        <!-- Progress bar-->
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%" id="progress-bar">
                                                <span class="sr-only">45% Complete</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                        <button type="button" class="btn btn-primary" id="btnSave">Grabar Cambios</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                        <!-- END MODAL VENTANA-->
                        <div class="report-marco ">
                            <div class="contenedor-report">
                                <div class="row">
                                    <div class="col-sm-2">
                                        {{ Form::label('porcActual', 'Valor actual:') }}
                                    </div>
                                    <div class="col-sm-2 ">
                                        <h3 id="valActual"> {{ $sod }}</h3>
                                    </div>
                                    <div class="col-sm-2">
                                        {{ Form::label('sumaPrincipal', 'Suma Principal:') }}
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            {{ Form::text('sumaPrincipal', 0, ['class' => 'form-control','id' => 'sumaPrincipal']) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        {{ Form::label('suma', 'Suma Sub totales:') }}
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            {{ Form::text('suma', 0, ['class' => 'form-control','id' => 'suma']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <button class="btn btn-default" type="button" id="calcular">Calcular</button>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            {{ Form::text('porcentaje', 0, ['class' => 'form-control','id' => 'porcentaje']) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-4 alert alert-success" role="alert"><span  id="alerta"></span>
                                    </div>
                                    <div class="col-sm-4 center-block">
                                        <div class="form-group">
                                            <label for="rubro">&emsp;</label>
                                            {{ Form::hidden('audit_id', $audit_id) }}
                                            {{ Form::hidden('company_id', $company_id) }}
                                            {{ Form::hidden('foto', $filtro, array('id' => 'foto')) }}
                                            {{ Form::hidden('publicityDetail_id', $publictyDetail_id, array('id' => 'publicityDetail_id')) }}
                                            <button class="btn btn-default" type="submit" id="guardar">Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach($urlsFotos as $photo)
                        <div class="row pt pb">
                            <div class="report-marco ">
                                <div class="contenedor-report">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            {{ Form::label('bajar', 'Bajar Imagen:') }}
                                        </div>
                                        <div class="col-sm-1 ">
                                            <a href="{{$photo['urlFoto']}}" download="{{$photo['archivo']}}">
                                                <button style="position:relative;float: left  "  class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Descargar Imagen" type="button" >
                                                    <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>
                                                </button></a>
                                        </div>
                                        <div class="col-sm-9">
                                            {{ Form::label('ruta', 'Url Imagen:') }} {{$photo['urlFoto']}}<br>
                                            {{ Form::label('fecha', 'Ingresado:') }} {{$photo['ingresado']}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 ">
                                <div class="row">
                                    <div class="col-sm-1">
                                        {{ Form::label('principal-'.$photo['id'], 'Area Principal:') }}
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="form-group">
                                            {{ Form::text('principal-'.$photo['id'], 0, ['class' => 'form-control','id' => 'principal-'.$photo['id'],'style' =>'background-color:#EBEBEB']) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="form-group">
                                            {{ Form::text('valor1-'.$photo['id'], 0, ['class' => 'form-control','id' => 'valor1-'.$photo['id']]) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="form-group">
                                            {{ Form::text('valor2-'.$photo['id'], 0, ['class' => 'form-control','id' => 'valor2-'.$photo['id']]) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="form-group">
                                            {{ Form::text('valor3-'.$photo['id'], 0, ['class' => 'form-control','id' => 'valor3-'.$photo['id']]) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="form-group">
                                            {{ Form::text('valor4-'.$photo['id'], 0, ['class' => 'form-control','id' => 'valor4-'.$photo['id']]) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="form-group">
                                            {{ Form::text('valor5-'.$photo['id'], 0, ['class' => 'form-control','id' => 'valor5-'.$photo['id']]) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="form-group">
                                            {{ Form::text('valor6-'.$photo['id'], 0, ['class' => 'form-control','id' => 'valor6-'.$photo['id']]) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="form-group">
                                            {{ Form::text('valor7-'.$photo['id'], 0, ['class' => 'form-control','id' => 'valor7-'.$photo['id']]) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="form-group">
                                            {{ Form::text('valor8-'.$photo['id'], 0, ['class' => 'form-control','id' => 'valor8-'.$photo['id']]) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="form-group">
                                            {{ Form::text('valor9-'.$photo['id'], 0, ['class' => 'form-control','id' => 'valor9-'.$photo['id']]) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="form-group">
                                            {{ Form::text('valor10-'.$photo['id'], 0, ['class' => 'form-control','id' => 'valor10-'.$photo['id']]) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row pt pb">
                            <div class="col-sm-12 center-block">
                                <img src="{{$photo['urlFoto']}}">
                            </div>
                        </div>
                    @endforeach
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</section>
@stop
@section('report')
<script>
    var url_base =  "{{ URL::to('/') }}" ;
    $('#calcular').click(function(e) {
        e.preventDefault();
        var data_store = [];
        console.log(data_store);
        var suma =0;var total =0;var sumaPrin=0;var division=0;
        @foreach($urlsFotos as $photo)
                sumaPrin = sumaPrin + parseFloat($('#principal-{{$photo['id']}}').val());
                suma = parseFloat($('#valor1-{{$photo['id']}}').val()) + parseFloat($('#valor2-{{$photo['id']}}').val())+ parseFloat($('#valor3-{{$photo['id']}}').val())+ parseFloat($('#valor4-{{$photo['id']}}').val())+ parseFloat($('#valor5-{{$photo['id']}}').val())+ parseFloat($('#valor6-{{$photo['id']}}').val())+ parseFloat($('#valor7-{{$photo['id']}}').val())+ parseFloat($('#valor8-{{$photo['id']}}').val())+ parseFloat($('#valor9-{{$photo['id']}}').val())+ parseFloat($('#valor10-{{$photo['id']}}').val());
                total = suma + total;
        @endforeach
        $('#suma').val(total);
        $('#sumaPrincipal').val(sumaPrin);
        if (sumaPrin>0){
            division = parseFloat(total)/parseFloat(sumaPrin);
        }else{
            division =0;
        }
        $('#porcentaje').val(division);

    });

    $('#guardar').click(function(e) {
        e.preventDefault();
        $('#myModal').modal('show');
    });
    $( "#btnSave" ).on( "click", function(event) {
        event.preventDefault();

        var publicityDetail_id = $('#publicityDetail_id').val();
        var sod = $('#porcentaje').val();
        var ciudad = $('#porcentaje').val();
        var foto = $('#foto').val();
        var data_store = [];
        console.log(data_store);
        $('.progress-bar').css('width', '50%').attr('aria-valuenow', "50");
        $.post(url_base + '/saveSOD',  { publicityDetail_id : publicityDetail_id,  sod : sod, foto : foto },
                function(data){
                    //if (item.latitud != 0 && item.longitud != 0){
                    //console.log(data);

                    if(data.success==1 ){
                        $('#alerta').text('Registro actualizado correctamente');
                        $('#valActual').text(sod);
                        $('.progress-bar').css('width', '100%').attr('aria-valuenow', "100");
                        //history.go(-1);
//                        setTimeout(function(){
//                            $('#myModal').modal('hide');
//                        },6000);
                        location.href = '{{ route('getListStoresPublicity' , array($city,$publicity_id,$auditor,$audit_id,$company_id))}}';
                    }

                } );

    });
</script>
@endsection