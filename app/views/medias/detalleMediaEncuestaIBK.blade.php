@extends('layouts/adminLayout')
@section('content')
<section>
    @include('audits/partials/menuLeftAudit')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <div class="row pt pb">
                <div class="col-sm-9">
                    <h4 class="report-title">Archivos PDV tipo {{$titulo}}</h4>
                </div>
                <div class="col-sm-3">
                    <img src="{{$logo}}" width="100px">
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="report-marco ">
                        <div class="contenedor-report">
                            <h4>Detalle PDV</h4>
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">Nombre PDV (id):</div>
                                <div   class="btn btn-default btn-valor">{{$objStore->fullname."(".$objStore->id.")"}}</div>
                            </div>
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">Cliente:</div>
                                <div   class="btn btn-default btn-valor">{{$customer->fullname."(".$customer->id.")"}}</div>
                            </div>
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">Campaña:</div>
                                <div   class="btn btn-default btn-valor">{{$campaigne->fullname."(".$campaigne->id.")"}}</div>
                            </div>
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">Dirección:</div>
                                <div   class="btn btn-default btn-valor">{{$objStore->address}}</div>
                            </div>
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">Ciudad:</div>
                                <div   class="btn btn-default btn-valor">{{$objStore->region}}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="report-marco ">
                        <div class="contenedor-report">
                            <h4>Detalle Auditoria</h4>
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">Nombre(id):</div>
                                <div   class="btn btn-default btn-valor">{{$detailAudit->fullname."(".$detailAudit->id.")"}}</div>
                            </div>
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">Ruta:</div>
                                <div   class="btn btn-default btn-valor">{{$objRoadDetail[0]->road->fullname."(".$objRoadDetail[0]->road->id.")"}}</div>
                            </div>
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">Auditor:</div>
                                <div   class="btn btn-default btn-valor">{{$objRoadDetail[0]->road->user->fullname."(".$objRoadDetail[0]->road->user->id.")"}}</div>
                            </div>
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">Fecha creado:</div>
                                <div   class="btn btn-default btn-valor">{{$objRoadDetail[0]->created_at}}</div>
                            </div>
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">Fecha cerrado:</div>
                                <div   class="btn btn-default btn-valor">{{$objRoadDetail[0]->updated_at}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row pt pb">
                @if(count($Polls)>0)
                    @foreach($Polls as $index => $poll)

                        <div class="row">
                            <div class="col-md-12 pb">
                                <div class="report-marco ">
                                    <div class="row pl">
                                        <div class="col-md-12 ">
                                            <h4><span class="badge">{{$index +1}}</span> Pregunta {{$poll->question."( Id: ".$poll->id.")"}}</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5 ">
                                            @foreach($valFotos[$poll->id]['arrayFoto'] as $foto)
                                            @if($foto['id']<>"0")

                                                    <!-- MODAL VENTANA-->
                                            <div id="Modal{{$foto['id']}}" class="modal fade" tabindex="-1" role="dialog">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title">Eliminando Foto de {{$objStore->fullname.'('.$objStore->id.')'}} archivo: {{$foto['archivo']}}</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Confirmar Eliminación</p>
                                                            {{ Form::hidden('media_id'.$foto['id'], $foto['id'], ['id' => 'media_id'.$foto['id']]) }}
                                                            {{ Form::hidden('file_photo'.$foto['id'], $foto['archivo'], ['id' => 'file_photo'.$foto['id']]) }}
                                                            {{ Form::hidden('url_photo'.$foto['id'], $foto['urlFoto'], ['id' => 'url_photo'.$foto['id']]) }}
                                                            @if (count($valFotos[$poll->id]['poll_detail'])>0)
                                                                {{ Form::hidden('poll_id'.$foto['id'], $valFotos[$poll->id]['poll_detail'][0]->id, ['id' => 'poll_detail_id'.$foto['id']]) }}
                                                            @else
                                                                {{ Form::hidden('poll_id'.$foto['id'], 0, ['id' => 'poll_detail_id'.$foto['id']]) }}
                                                            @endif

                                                                    <!-- Progress bar-->
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%" id="progress-bar{{$foto['id']}}">
                                                                    <span class="sr-only">45% Complete</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                            <button type="button" class="btn btn-primary" id="btnSave" onclick="eliminarFoto({{$foto['id']}})">Confirmar</button>
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                            <!-- END MODAL VENTANA-->

                                            <div id="{{$foto['id']}}">
                                                <a href="#" title="Eliminar Foto {{$foto['archivo']}}" onclick="activarModal({{$foto['id']}});"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a>
                                                <a href="{{$foto['urlFoto']}}" class="zoom1 btn btn-default" data-fancybox-group="button"><img src="{{$foto['urlFoto']}}" width="200px" class="img-thumbnail"></a>
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                        <div class="col-md-4 ">

                                        </div>
                                        <div class="col-md-3 ">
                                            {{ Form::open(['route' => 'mediaInsertPhotos', 'files' => true, 'method' => 'POST', 'role' => 'form', 'class' => 'form-horizontal', 'id' => 'Photo'.$foto['id'] , 'validate']) }}

                                            {{ Form::hidden('tipo', 0) }}
                                            {{ Form::hidden('user_id', $objRoadDetail[0]->road->user->id) }}
                                            {{ Form::hidden('fecha',$objRoadDetail[0]->updated_at) }}
                                            {{ Form::hidden('audit_id', $detailAudit->id) }}
                                            {{ Form::hidden('company_id', $company_id) }}
                                            {{ Form::hidden('store_id', $objStore->id) }}
                                            {{ Form::hidden('objeto_id', $poll->id) }}
                                            {{ Form::hidden('cliente', $cliente) }}
                                            <div class="form-group">
                                                <div id="" >
                                                    {{ Form::file('archivo') }}
                                                    {{ $errors->first('archivo', '<div class="alert alert-danger" role="alert">:message</div>') }}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div >
                                                    <button type="submit" class="btn btn-default btn-sm">AGREGAR FOTO</button>
                                                </div>
                                            </div>

                                            {{ Form::close() }}
                                            <div class="form-group">
                                                <div >
                                                    <a href="{{route('auditListStoresForAudit',[$detailAudit->id,$company_id])}}"><button type="button" class="btn btn-default btn-sm">Volver al Buscador</button></a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    No hay fotos
                @endif

             </div>
        </div>
    </div>

</section>
@stop
@section('reportCSS')
        <!-- Galeria de imagenes -->
<link rel="stylesheet" type="text/css" href="{{ asset('lib/fancybox/jquery.fancybox.css?v=2.1.5') }}" media="screen" />
<!-- Add Button helper (this is optional) -->
<link rel="stylesheet" type="text/css" href="{{ asset('lib/fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5') }}" />
@endsection
@section('report')
        <!--LIBRERIA fancybox PARA ZOOM PARA IMÁGENES-->
{{ HTML::script('lib/fancybox/jquery.fancybox.js?v=2.1.5'); }}
{{ HTML::script('lib/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5'); }}
{{ HTML::script('lib/fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7'); }}
{{ HTML::script('lib/fancybox/helpers/jquery.fancybox-media.js?v=1.0.6'); }}
<script>
    $('.zoom1').fancybox(  {
        openEffect : 'elastic',
        openSpeed  : 150,

        closeEffect : 'elastic',
        closeSpeed  : 150,

        prevEffect : 'none',
        nextEffect : 'none',

        closeBtn  : true,

        helpers : {
            title : {
                type : 'inside'
            },
            buttons : {}
        },

        afterLoad : function() {
            this.title = 'Imagen ' + (this.index + 1) + ' de ' + this.group.length + (this.title ? ' - ' + this.title : '');
        }
    });
</script>
<script>
    var url_base =  "{{ URL::to('/') }}" ;
    function activarModal(valor)
    {
        $('#Modal'.concat(valor.toString())).modal('show');
        $('.progress-bar').css('width', '10%').attr('aria-valuenow', "10");
    }

    function eliminarFoto(mediaID) {
        var borrarPublicty =0;
        var ident_mediaId = '#media_id'.concat(mediaID.toString());
        var media_id = $(ident_mediaId).val();
        var pollID = $('#poll_id'.concat(mediaID.toString())).val();
        borrarPublicty=0;
        var filePhoto = $('#file_photo'.concat(mediaID.toString())).val();
        var urlPhoto = $('#url_photo'.concat(mediaID.toString())).val();
        $('.progress-bar').css('width', '40%').attr('aria-valuenow', "40");

        $.post(url_base + '/deletePhotoSOD',  { publicityDetail_id : pollID,  media_id : media_id, filePhoto : filePhoto, responseDeletePubli : borrarPublicty, url_photo : urlPhoto },
                function(data){
                    //if (item.latitud != 0 && item.longitud != 0){
                    //console.log(data);

                    if(data.success==1 ){
                        $('.progress-bar').css('width', '100%').attr('aria-valuenow', "100");
                        $('#Modal'.concat(mediaID.toString())).modal('hide');
                        $('html,body').animate({
                            scrollTop: $('#'.concat(mediaID.toString())).offset().top
                        }, 1000);
                        $('#'.concat(mediaID.toString())).hide(4000,'swing');
                    }

                } );
    }
</script>

@endsection