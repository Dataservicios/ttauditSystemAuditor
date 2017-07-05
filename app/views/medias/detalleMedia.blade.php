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
                                <div   class="btn btn-default btn-valor">
                                    @if(count($objRoadDetail)>0)
                                        {{$objRoadDetail[0]->road->fullname."(".$objRoadDetail[0]->road->id.")"}}
                                    @else
                                        No tiene ruta
                                    @endif
                                </div>
                            </div>
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">Auditor:</div>
                                <div   class="btn btn-default btn-valor">
                                    @if(count($objRoadDetail)>0)
                                        {{$objRoadDetail[0]->road->user->fullname."(".$objRoadDetail[0]->road->user->id.")"}}
                                    @else
                                        No figura auditor
                                    @endif
                                </div>
                            </div>
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">Fecha creado:</div>
                                <div   class="btn btn-default btn-valor">
                                    @if(count($objRoadDetail)>0)
                                        {{$objRoadDetail[0]->created_at}}
                                    @else
                                        No hay fecha
                                    @endif
                                    </div>
                            </div>
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">Fecha cerrado:</div>
                                <div   class="btn btn-default btn-valor">
                                    @if(count($objRoadDetail)>0)
                                        {{$objRoadDetail[0]->updated_at}}
                                    @else
                                        No hay fecha
                                    @endif
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row pt pb">
                @if(count($objPublicity)>0)
                    @foreach($objPublicity as $index => $publicity)
                        <div class="row">
                            <div class="col-md-12 pb">
                                <div class="report-marco ">
                                    <div class="row pl">
                                        <div class="col-md-12 ">
                                            <h4><span class="badge">{{$index +1}}</span> Categoria {{$publicity->fullname."( Id: ".$publicity->id.")"}}</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5 ">
                                        @if(count($valFotos[$publicity->id]['arrayFoto'])>0)
                                            @foreach($valFotos[$publicity->id]['arrayFoto'] as $foto)
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

                                                                        @if(count($valFotos[$publicity->id]['publicity_detail'])>0)
                                                                            <p>Confirmar Eliminación</p>
                                                                            {{ Form::label('respEliminar'.$foto['id'], 'Desea eliminar tambien el registro de la respuesta?') }}
                                                                            {{ Form::checkbox('respEliminar'.$foto['id'], 1, null, ['class' => 'form-control','id' => 'respEliminar'.$foto['id']]) }}

                                                                            {{ Form::hidden('publicity_detail_id'.$foto['id'], $valFotos[$publicity->id]['publicity_detail'][0]->id, ['id' => 'publicity_detail_id'.$foto['id']]) }}
                                                                        @else
                                                                            {{ Form::hidden('publicity_detail_id'.$foto['id'], 0, ['id' => 'publicity_detail_id'.$foto['id']]) }}
                                                                            {{ Form::checkbox('respEliminar'.$foto['id'], 0, null, ['style' => 'display:none;','id' => 'respEliminar'.$foto['id']]) }}
                                                                        @endif
                                                                        {{ Form::hidden('media_id'.$foto['id'], $foto['id'], ['id' => 'media_id'.$foto['id']]) }}
                                                                        {{ Form::hidden('file_photo'.$foto['id'], $foto['archivo'], ['id' => 'file_photo'.$foto['id']]) }}
                                                                        {{ Form::hidden('url_photo'.$foto['id'], $foto['urlFoto'], ['id' => 'url_photo'.$foto['id']]) }}
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
                                        @endif

                                        </div>
                                        <div class="col-md-4 ">
                                            @if($detailAudit->id==1)
                                                @if(count($valFotos[$publicity->id]['arrayFoto'])>0)
                                                    <div class="btn-group" role="group" aria-label="...">
                                                        @if(is_object($valFotos[$publicity->id]['pollsResult']['abierto']['objeto']) and (count($valFotos[$publicity->id]['pollsResult']['abierto']['objeto'])>0))
                                                            @if($valFotos[$publicity->id]['pollsResult']['abierto']['objeto'][0]->result==1)
                                                                <div class="btn btn-default btn-si">Abierto:</div>
                                                            @else
                                                                <div class="btn btn-default btn-no">Abierto:</div>
                                                            @endif
                                                        @else
                                                            <div class="btn btn-default btn-no">Abierto:</div>
                                                        @endif
                                                        <div   class="btn btn-default btn-valor">{{$valFotos[$publicity->id]['pollsResult']['abierto']['texto']}}</div>
                                                    </div>
                                                    <div class="btn-group" role="group" aria-label="...">
                                                        @if(is_object($valFotos[$publicity->id]['pollsResult']['permitio']['objeto']) and (count($valFotos[$publicity->id]['pollsResult']['permitio']['objeto'])>0))
                                                            @if($valFotos[$publicity->id]['pollsResult']['permitio']['objeto'][0]->result==1)
                                                                <div class="btn btn-default btn-si">Permitio:</div>
                                                            @else
                                                                <div class="btn btn-default btn-no">Permitio:</div>
                                                            @endif
                                                        @else
                                                            <div class="btn btn-default btn-no">Permitio:</div>
                                                        @endif
                                                        <div   class="btn btn-default btn-valor">{{$valFotos[$publicity->id]['pollsResult']['permitio']['texto']}}</div>
                                                    </div>
                                                    <div class="btn-group" role="group" aria-label="...">
                                                        @if(is_object($valFotos[$publicity->id]['pollsResult']['existe']['objeto']) and (count($valFotos[$publicity->id]['pollsResult']['existe']['objeto'])>0))
                                                            @if($valFotos[$publicity->id]['pollsResult']['existe']['objeto'][0]->result==1)
                                                                <div class="btn btn-default btn-si">Existe SOD:</div>
                                                            @else
                                                                <div class="btn btn-default btn-no">Existe SOD:</div>
                                                            @endif
                                                        @else
                                                            <div class="btn btn-default btn-no">Existe SOD:</div>
                                                        @endif
                                                        <div   class="btn btn-default btn-valor">{{$valFotos[$publicity->id]['pollsResult']['existe']['texto']}}</div>
                                                    </div>
                                                    <div class="btn-group" role="group" aria-label="...">
                                                        @if(is_object($valFotos[$publicity->id]['pollsResult']['visible']['objeto']) and (count($valFotos[$publicity->id]['pollsResult']['visible']['objeto'])>0))
                                                            @if($valFotos[$publicity->id]['pollsResult']['visible']['objeto'][0]->result==1)
                                                                <div class="btn btn-default btn-si">SOD Visible:</div>
                                                            @else
                                                                <div class="btn btn-default btn-no">SOD Visible:</div>
                                                            @endif
                                                        @else
                                                            <div class="btn btn-default btn-no">SOD Visible:</div>
                                                        @endif
                                                        <div   class="btn btn-default btn-valor">{{$valFotos[$publicity->id]['pollsResult']['visible']['texto']}}</div>
                                                    </div>
                                                    <div class="btn-group" role="group" aria-label="...">
                                                        @if(is_object($valFotos[$publicity->id]['pollsResult']['trabajada']['objeto']) and (count($valFotos[$publicity->id]['pollsResult']['trabajada']['objeto'])>0))
                                                            @if($valFotos[$publicity->id]['pollsResult']['trabajada']['objeto'][0]->result==1)
                                                                <div class="btn btn-default btn-si">SOD Trabajado:</div>
                                                            @else
                                                                <div class="btn btn-default btn-no">SOD Trabajado:</div>
                                                            @endif
                                                        @else
                                                            <div class="btn btn-default btn-no">SOD Trabajado:</div>
                                                        @endif
                                                        <div   class="btn btn-default btn-valor">{{$valFotos[$publicity->id]['pollsResult']['trabajada']['texto']}}</div>
                                                    </div>
                                                    <div class="btn-group" role="group" aria-label="...">
                                                        @if(is_object($valFotos[$publicity->id]['pollsResult']['comoEstaVent']['objeto']) and (count($valFotos[$publicity->id]['pollsResult']['comoEstaVent']['objeto'])>0))
                                                            @if(count($valFotos[$publicity->id]['pollsResult']['comoEstaVent']['options'][0])>0)
                                                                <div class="btn btn-default btn-si">Como esta SOD:</div>
                                                            @else
                                                                <div class="btn btn-default btn-no">Como esta SOD:</div>
                                                            @endif
                                                        @else
                                                            <div class="btn btn-default btn-no">Como esta SOD:</div>
                                                        @endif
                                                        <div   class="btn btn-default btn-valor">{{$valFotos[$publicity->id]['pollsResult']['comoEstaVent']['texto']}}</div>
                                                    </div>
                                                @endif
                                            @endif
                                            @if($detailAudit->id==3)
                                                    @if(count($valFotos[$publicity->id]['arrayFoto'])>0)
                                                        <div class="btn-group" role="group" aria-label="...">
                                                            @if(is_object($valFotos[$publicity->id]['pollsResult']['abierto']['objeto']) and (count($valFotos[$publicity->id]['pollsResult']['abierto']['objeto'])>0))
                                                                @if($valFotos[$publicity->id]['pollsResult']['abierto']['objeto'][0]->result==1)
                                                                    <div class="btn btn-default btn-si">Abierto:</div>
                                                                @else
                                                                    <div class="btn btn-default btn-no">Abierto:</div>
                                                                @endif
                                                            @else
                                                                <div class="btn btn-default btn-no">Abierto:</div>
                                                            @endif
                                                            <div   class="btn btn-default btn-valor">{{$valFotos[$publicity->id]['pollsResult']['abierto']['texto']}}</div>
                                                        </div>
                                                        <div class="btn-group" role="group" aria-label="...">
                                                            @if(is_object($valFotos[$publicity->id]['pollsResult']['permitio']['objeto']) and (count($valFotos[$publicity->id]['pollsResult']['permitio']['objeto'])>0))
                                                                @if($valFotos[$publicity->id]['pollsResult']['permitio']['objeto'][0]->result==1)
                                                                    <div class="btn btn-default btn-si">Permitio:</div>
                                                                @else
                                                                    <div class="btn btn-default btn-no">Permitio:</div>
                                                                @endif
                                                            @else
                                                                <div class="btn btn-default btn-no">Permitio:</div>
                                                            @endif
                                                            <div   class="btn btn-default btn-valor">{{$valFotos[$publicity->id]['pollsResult']['permitio']['texto']}}</div>
                                                        </div>
                                                        <div class="btn-group" role="group" aria-label="...">
                                                            @if(is_object($valFotos[$publicity->id]['pollsResult']['existe']['objeto']) and (count($valFotos[$publicity->id]['pollsResult']['existe']['objeto'])>0))
                                                                @if($valFotos[$publicity->id]['pollsResult']['existe']['objeto'][0]->result==1)
                                                                    <div class="btn btn-default btn-si">Existe:</div>
                                                                @else
                                                                    <div class="btn btn-default btn-no">Existe:</div>
                                                                @endif
                                                            @else
                                                                <div class="btn btn-default btn-no">Existe:</div>
                                                            @endif
                                                            <div   class="btn btn-default btn-valor">{{$valFotos[$publicity->id]['pollsResult']['existe']['texto']}}</div>
                                                        </div>
                                                    @endif
                                                        @if(count($valFotos[$publicity->id]['publicity_detail'])>0)
                                                            <div class="btn-group" role="group" aria-label="...">
                                                                @if($valFotos[$publicity->id]['publicity_detail'][0]->visible==1)
                                                                    <div class="btn btn-default btn-si">Visible:</div>
                                                                    <div   class="btn btn-default btn-valor">Sí({{$valFotos[$publicity->id]['publicity_detail'][0]->created_at}})</div>
                                                                @else
                                                                    <div class="btn btn-default btn-no">Visible:</div>
                                                                    <div   class="btn btn-default btn-valor">No({{$valFotos[$publicity->id]['publicity_detail'][0]->created_at}})</div>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <div class="btn btn-default btn-no">Visible:</div>
                                                            <div   class="btn btn-default btn-valor">No hay registros</div>
                                                        @endif
                                                        @if(count($valFotos[$publicity->id]['publicity_detail'])>0)
                                                            <div class="btn-group" role="group" aria-label="...">
                                                                @if($valFotos[$publicity->id]['publicity_detail'][0]->contaminated==1)
                                                                    <div class="btn btn-default btn-si">Contaminado:</div>
                                                                    <div   class="btn btn-default btn-valor">Sí({{$valFotos[$publicity->id]['publicity_detail'][0]->created_at}})</div>
                                                                @else
                                                                    <div class="btn btn-default btn-no">Contaminado:</div>
                                                                    <div   class="btn btn-default btn-valor">No({{$valFotos[$publicity->id]['publicity_detail'][0]->created_at}})</div>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <div class="btn btn-default btn-no">Contaminado:</div>
                                                            <div   class="btn btn-default btn-valor">No hay registros</div>
                                                        @endif
                                                        @if(count($valFotos[$publicity->id]['publicity_detail'])>0)
                                                            <div class="btn-group" role="group" aria-label="...">
                                                                @if($valFotos[$publicity->id]['publicity_detail'][0]->comment<>'')
                                                                    <div class="btn btn-default btn-si">Comentario:</div>
                                                                    <div   class="btn btn-default btn-valor">{{$valFotos[$publicity->id]['publicity_detail'][0]->comment}}</div>
                                                                @else
                                                                    <div class="btn btn-default btn-no">Comentario:</div>
                                                                    <div   class="btn btn-default btn-valor">{{$valFotos[$publicity->id]['publicity_detail'][0]->comment}}</div>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <div class="btn btn-default btn-no">Comentario:</div>
                                                            <div   class="btn btn-default btn-valor">No hay registros</div>
                                                        @endif
                                            @endif
                                        </div>
                                        <div class="col-md-3 ">
                                            @if(count($objRoadDetail)>0)
                                                {{ Form::open(['route' => 'mediaInsertPhotos', 'files' => true, 'method' => 'POST', 'role' => 'form', 'class' => 'form-horizontal', 'id' => 'Photo'.$foto['id'] , 'validate']) }}
                                                {{ Form::hidden('objeto_id', $publicity->id) }}
                                                {{ Form::hidden('tipo', 1) }}
                                                {{ Form::hidden('user_id', $objRoadDetail[0]->road->user->id) }}
                                                {{ Form::hidden('fecha',$objRoadDetail[0]->updated_at) }}
                                                {{ Form::hidden('audit_id', $detailAudit->id) }}
                                                {{ Form::hidden('company_id', $campaigne->id) }}
                                                {{ Form::hidden('store_id', $objStore->id) }}
                                                {{ Form::hidden('cliente', "0") }}
                                                <div class="form-group">
                                                    <div id="" >
                                                        {{ Form::file('archivo', ['id' => 'filePhoto'.$publicity->id])}}
                                                        {{ $errors->first('archivo', '<div class="alert alert-danger" role="alert">:message</div>') }}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div >
                                                        <button type="submit" class="btn btn-default btn-sm">AGREGAR FOTO</button>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div >
                                                        <button type="button" class="btn btn-default btn-sm">SOD MEDIDO:
                                                            @if(count($valFotos[$publicity->id]['publicity_detail'])>0)
                                                                @if(($valFotos[$publicity->id]['publicity_detail'][0]->sod<>null) and ($valFotos[$publicity->id]['publicity_detail'][0]->sod<>0))
                                                                    {{$valFotos[$publicity->id]['publicity_detail'][0]->sod*100}}%
                                                                @else
                                                                    0%
                                                                @endif
                                                            @else
                                                                No Hay registro
                                                            @endif

                                                        </button>
                                                    </div>
                                                </div>
                                                {{ Form::close() }}
                                            @endif


                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
        var publicityDetailID = $('#publicity_detail_id'.concat(mediaID.toString())).val();

        if($('#respEliminar'.concat(mediaID.toString())).is(':checked')) {
            borrarPublicty=1;
        }
        var filePhoto = $('#file_photo'.concat(mediaID.toString())).val();
        var urlPhoto = $('#url_photo'.concat(mediaID.toString())).val();
        $('.progress-bar').css('width', '40%').attr('aria-valuenow', "40");

        $.post(url_base + '/deletePhotoSOD',  { publicityDetail_id : publicityDetailID,  media_id : media_id, filePhoto : filePhoto, responseDeletePubli : borrarPublicty, url_photo : urlPhoto },
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
    <script>
        $("form" ).submit(function( event ) {
            objFormValue = $( this ).find('input[type=file]').val();
            if(objFormValue != "") {
                console.log( objFormValue );
            } else {
                alert( "Selecionar una imagen tipo jpg" );
                return  false  ;
            }
        });
    </script>

@endsection