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
            @if(count($objRoadDetail)>0)
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
                            <?php $imageVal=rand();?>
                            <div class="row">
                                <div class="col-md-12 pb">
                                    <div class="report-marco ">
                                        <div class="row pl">
                                            <div class="col-md-12 ">
                                                <h4><span class="badge">{{$index +1}}</span> Pregunta {{$poll->question."( Id: ".$poll->id.")"}}<a href="#"  onclick="insertRegister('{{$poll->id}}'); return false;"  id="{{'btnInsert'.$poll->id}}">
                                                        <span class="glyphicon glyphicon-plus-sign"></span>
                                                    </a>
                                                </h4>

                                            </div>
                                        </div>

                                        <div class="row">
                                            @if($poll->media ==1)
                                                <?php $valor1=0;$valor2=0;$valor3=0;?>
                                                <div class="col-md-5 ">
                                                    @foreach($valFotos[$poll->id]['ObjArrayClase'] as $objetoArray)
                                                        @if(count($objetoArray['objeto'])>0)
                                                            @foreach($objetoArray['objeto'] as $objeto)
                                                                @if($objetoArray['tipo']<>'Poll')
                                                                    @if($poll->categoryProduct==1)
                                                                        <?php $valor1=$objeto->id?>
                                                                        <div class="row">
                                                                            <div class="col-md-12 ">
                                                                                <h4>{{$objeto->fullname}}</h4>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                    @if($poll->publicity==1)
                                                                        <?php $valor2=$objeto->publicity_id?>
                                                                        <div class="row">
                                                                            <div class="col-md-12 ">
                                                                                <h4>{{$objeto->publicity->fullname}}</h4>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                    @if($poll->product==1)
                                                                        <?php $valor3=$objeto->product_id?>
                                                                        <div class="row">
                                                                            <div class="col-md-12 ">
                                                                                <h4>{{$objeto->product->fullname}}</h4>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @else
                                                                    <?php $valor1=0;$valor2=0;$valor3=0;?>
                                                                    <div class="row">
                                                                        <div class="col-md-12 ">
                                                                            <h4>Por Pregunta</h4>
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                                <div class="row">
                                                                    <div class="col-md-8 ">
                                                                        @if(count($valFotos[$poll->id]['media'])>0)
                                                                            @foreach($valFotos[$poll->id]['media'] as $foto)
                                                                                @if($objetoArray['tipo']=='Publicity')
                                                                                    @if($foto->publicities_id == $objeto->publicity_id)
                                                                                        <?php $valorLogico=true;?>
                                                                                    @else
                                                                                        <?php $valorLogico=false;?>
                                                                                    @endif
                                                                                @endif
                                                                                @if($objetoArray['tipo']=='Product')
                                                                                    @if($foto->product_id == $objeto->product_id)
                                                                                        <?php $valorLogico=true;?>
                                                                                    @else
                                                                                        <?php $valorLogico=false;?>
                                                                                    @endif
                                                                                @endif
                                                                                @if($objetoArray['tipo']=='CategoryProduct')
                                                                                    @if($foto->category_product_id == $objeto->id)
                                                                                        <?php $valorLogico=true;?>
                                                                                    @else
                                                                                        <?php $valorLogico=false;?>
                                                                                    @endif
                                                                                @endif
                                                                                @if($objetoArray['tipo']=='Poll')
                                                                                    @if(($foto->category_product_id == 0) and ($foto->product_id ==0) and ($foto->publicities_id ==0))
                                                                                        <?php $valorLogico=true;?>
                                                                                    @endif
                                                                                @endif
                                                                                @if($valorLogico)
                                                                                    <!-- MODAL VENTANA-->
                                                                                    <div id="Modal{{$foto->id}}" class="modal fade" tabindex="-1" role="dialog">
                                                                                        <div class="modal-dialog">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                                    <h4 class="modal-title">Eliminando Foto de {{$objStore->fullname.'('.$objStore->id.')'}} archivo: {{$foto->archivo}}</h4>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    <p>Confirmar Eliminación</p>
                                                                                                {{ Form::hidden('media_id'.$foto->id, $foto->id, ['id' => 'media_id'.$foto->id]) }}
                                                                                                {{ Form::hidden('file_photo'.$foto->id, $foto->archivo, ['id' => 'file_photo'.$foto->id]) }}
                                                                                                {{ Form::hidden('url_photo'.$foto->id, $foto->archivo, ['id' => 'url_photo'.$foto->id]) }}

                                                                                                {{ Form::hidden('poll_id'.$foto->id, 0, ['id' => 'poll_detail_id'.$foto->id]) }}

                                                                                                <!-- Progress bar-->
                                                                                                    <div class="progress">
                                                                                                        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%" id="progress-bar{{$foto->id}}">
                                                                                                            <span class="sr-only">45% Complete</span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="modal-footer">
                                                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                                                                    <button type="button" class="btn btn-primary" id="btnSave" onclick="eliminarFoto({{$foto->id}})">Confirmar</button>
                                                                                                </div>
                                                                                            </div><!-- /.modal-content -->
                                                                                        </div><!-- /.modal-dialog -->
                                                                                    </div><!-- /.modal -->
                                                                                    <!-- END MODAL VENTANA-->

                                                                                    <div id="{{$foto->id}}">
                                                                                        <div id="{{'Controles'.$foto->id}}">
                                                                                            <a href="#" title="Eliminar Foto {{$foto->archivo}}" onclick="activarModal({{$foto->id}});"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a>
                                                                                            <a href="#" title="Girar Foto {{$foto->archivo}} -90 grados" onclick="girarFoto('{{$foto->archivo}}',1,'{{'Impreso'.$foto->id}}','{{$valFotos[$poll->id]['urlFoto']}}','<?php echo $imageVal?>','-90'); return false;" class="btn btn-default" href="#" role="button">
                                                                                                -90
                                                                                            </a>
                                                                                            <a href="#" title="Girar Foto {{$foto->archivo}} -180 grados" onclick="girarFoto('{{$foto->archivo}}',1,'{{'Impreso'.$foto->id}}','{{$valFotos[$poll->id]['urlFoto']}}','<?php echo $imageVal?>','-180'); return false;" class="btn btn-default" href="#" role="button">
                                                                                                -180
                                                                                            </a>
                                                                                            <a href="#" title="Girar Foto {{$foto->archivo}} 90 grados" onclick="girarFoto('{{$foto->archivo}}',1,'{{'Impreso'.$foto->id}}','{{$valFotos[$poll->id]['urlFoto']}}','<?php echo $imageVal?>','90'); return false;" class="btn btn-default" href="#" role="button">
                                                                                                90
                                                                                            </a>
                                                                                            <a href="#" title="Girar Foto {{$foto->archivo}} 180 grados" onclick="girarFoto('{{$foto->archivo}}',1,'{{'Impreso'.$foto->id}}','{{$valFotos[$poll->id]['urlFoto']}}','<?php echo $imageVal?>','180'); return false;" class="btn btn-default" href="#" role="button">
                                                                                                180
                                                                                            </a>
                                                                                        </div>

                                                                                        <div id="{{'Impreso'.$foto->id}}">
                                                                                            <a href="{{$valFotos[$poll->id]['urlFoto'].$foto->archivo}}?dummy=<?php echo $imageVal?>" class="zoom1 btn btn-default" data-fancybox-group="button"><img src="{{$valFotos[$poll->id]['urlFoto'].$foto->archivo}}?dummy=<?php echo $imageVal?>" width="200px" class="img-thumbnail"></a>

                                                                                        </div>
                                                                                    </div>
                                                                                    <?php $valorLogico=false;?>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    </div>
                                                                    <div class="col-md-4 ">
                                                                        {{ Form::open(['route' => 'mediaInsertPhotos', 'files' => true, 'method' => 'POST', 'role' => 'form', 'class' => 'form-horizontal', 'id' => 'Photo'.$objeto->id, 'validate']) }}

                                                                        @if($objetoArray['tipo']=='Poll')
                                                                            {{ Form::hidden('tipo', 0) }}
                                                                            {{ Form::hidden('objeto_id', $poll->id) }}
                                                                        @endif
                                                                        @if($objetoArray['tipo']<>'Poll')
                                                                            {{ Form::hidden('tipo', 2) }}
                                                                            {{ Form::hidden('objeto_id', $poll->id."|".$valor1."|".$valor2."|".$valor3) }}
                                                                        @endif

                                                                        {{ Form::hidden('user_id', $objRoadDetail[0]->road->user->id) }}
                                                                        {{ Form::hidden('fecha',$objRoadDetail[0]->updated_at) }}
                                                                        {{ Form::hidden('audit_id', $detailAudit->id) }}
                                                                        {{ Form::hidden('company_id', $company_id) }}
                                                                        {{ Form::hidden('store_id', $objStore->id) }}

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
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    @endforeach

                                                </div>
                                            @endif
                                            @if($poll->media ==1)
                                                <div class="col-md-7 ">
                                            @else
                                                <div class="col-md-12">
                                            @endif
                                                    @if(count($valFotos[$poll->id]['responses'])>0)
                                                        @if(count($valFotos[$poll->id]['responses']['poll_details'])>0)
                                                            @foreach($valFotos[$poll->id]['responses']['poll_details'] as $index1 => $poll_detail)
                                                                <div class="report-marco" id="principal{{$poll_detail['poll_detail']->id}}">
                                                                    <div class="row pl">
                                                                        <div class="col-md-12">
                                                                            <div class="btn btn-default btn-valor" id="">
                                                                                Registro {{$index1+1}}{{'- ('.$poll_detail['poll_detail']->id.')'}}
                                                                            </div>
                                                                            <div class="btn btn-default btn-valor" id="">
                                                                                <a href="#"  onclick="editRegister('{{$poll_detail['poll_detail']->id}}'); return false;"  id="{{'btnUpdate'.$poll_detail['poll_detail']->id}}">
                                                                                    <span class="glyphicon glyphicon-pencil"></span></a>
                                                                            </div>
                                                                            <div class="btn btn-default btn-valor" id="">
                                                                                @if($poll->options ==1)
                                                                                    <?php $idPollOptions=''?>
                                                                                    @if(count($poll_detail['poll_option_details'])>0)
                                                                                        @foreach($poll_detail['poll_option_details'] as $poll_option_detail)
                                                                                            @if(count($poll_option_detail)>0)
                                                                                                @foreach($poll_option_detail as $objPollOptionDetail)
                                                                                                    <?php $idPollOptions = $objPollOptionDetail->id.'|'?>
                                                                                                @endforeach
                                                                                            @endif
                                                                                        @endforeach
                                                                                    @endif
                                                                                @else
                                                                                    <?php $idPollOptions = ''?>
                                                                                @endif
                                                                                <a href="#"  id="{{'opcion'.$poll_detail['poll_detail']->id}}" onclick="borrarReg('{{$poll_detail['poll_detail']->id}}','{{$idPollOptions}}'); return false;">
                                                                                    <span class="glyphicon glyphicon-remove"></span></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-12 " id="messagesDeleteReg{{$poll_detail['poll_detail']->id}}">
                                                                        </div>
                                                                    </div>
                                                                    @if(($poll->sino ==1) or ($poll_detail['poll_detail']->product_id<>0))
                                                                        <div class="row">
                                                                            <div class="col-md-12 ">
                                                                                @if($poll_detail['poll_detail']->product_id<>0)
                                                                                    <div class="btn-group" role="group" aria-label="...">
                                                                                        <div class="btn btn-default btn-valor">Producto: </div>
                                                                                        <div class="btn btn-default btn-valor">{{$poll_detail['poll_detail']->product->fullname."(".$poll_detail['poll_detail']->product_id.")"}}</div>
                                                                                    </div>
                                                                                @endif
                                                                                    @if($poll_detail['poll_detail']->publicity_id<>0)
                                                                                        <div class="btn-group" role="group" aria-label="...">
                                                                                            <div class="btn btn-default btn-valor">Publicidad: </div>
                                                                                            <div class="btn btn-default btn-valor">{{$poll_detail['poll_detail']->publicity->fullname."(".$poll_detail['poll_detail']->publicity_id.")"}}</div>
                                                                                        </div>
                                                                                    @endif

                                                                                @if($poll->sino ==1)
                                                                                    <div class="btn-group" role="group" aria-label="...">
                                                                                        <div class="btn btn-default btn-valor">Respuesta {{"(".$poll_detail['poll_detail']->id.")"}}</div>
                                                                                        @if($poll_detail['poll_detail']->result==1)
                                                                                            <div class="btn btn-default btn-si" id="{{$poll_detail['poll_detail']->id}}">
                                                                                                {{"Sí (".$poll_detail['poll_detail']->created_at.")"}}
                                                                                            </div>
                                                                                            <div class="btn btn-default btn-valor" id="{{'editSiNo'.$poll_detail['poll_detail']->id}}">
                                                                                                <a href="#" onclick="changeValueSiNo('{{$poll_detail['poll_detail']->id}}',0,'{{$company_id}}','{{$poll_detail['poll_detail']->id}}'); return false;" id="{{'hrefSiNo'.$poll_detail['poll_detail']->id}}">
                                                                                                    <span class="glyphicon glyphicon-pencil"></span></a>
                                                                                            </div>
                                                                                        @else
                                                                                            <div class="btn btn-default btn-no" id="{{$poll_detail['poll_detail']->id}}">
                                                                                                {{"No (".$poll_detail['poll_detail']->created_at.")"}}
                                                                                            </div>
                                                                                            <div class="btn btn-default btn-valor" id="{{'editSiNo'.$poll_detail['poll_detail']->id}}">
                                                                                                <a href="#" onclick="changeValueSiNo('{{$poll_detail['poll_detail']->id}}',1,'{{$company_id}}','{{$poll_detail['poll_detail']->id}}'); return false;" id="{{'hrefSiNo'.$poll_detail['poll_detail']->id}}">
                                                                                                    <span class="glyphicon glyphicon-pencil"></span></a>
                                                                                            </div>
                                                                                        @endif
                                                                                    </div>
                                                                                @endif

                                                                                <div class="btn-group" role="group" aria-label="...">
                                                                                    <div class="btn btn-default btn-valor">Comentario: </div><div class="btn btn-default btn-valor">{{$poll_detail['poll_detail']->comentario."(".$poll_detail['poll_detail']->id.")"}}</div>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        @if(($poll_detail['poll_detail']->comentario<>'') or ($poll_detail['poll_detail']->limits<>''))
                                                                            <div class="row">
                                                                                <div class="col-md-12 ">
                                                                                    <div class="btn-group" role="group" aria-label="...">
                                                                                        <div class="btn btn-default btn-valor">Comentario: </div><div class="btn btn-default btn-valor">{{$poll_detail['poll_detail']->comentario.$poll_detail['poll_detail']->limite."(".$poll_detail['poll_detail']->id.")"}}</div>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        @endif

                                                                    @endif

                                                                    @if($poll->options ==1)
                                                                        <div class="row">
                                                                            <div class="col-md-12 "><?php $valOptions=[];?>
                                                                                @if(count($poll_detail['poll_option_details'])>0)

                                                                                    @foreach($poll_detail['poll_option_details'] as $poll_option_detail)
                                                                                        @if(count($poll_option_detail)>0)

                                                                                            @foreach($poll_option_detail as $objPollOptionDetail)
                                                                                                <div class="btn-group" role="group" aria-label="...">
                                                                                                    <div class="btn btn-default btn-valor">Opción({{$objPollOptionDetail->poll_option_id}}): </div>
                                                                                                    <div class="btn btn-default btn-valor">
                                                                                                        {{$objPollOptionDetail->pollOption->options.'('.$objPollOptionDetail->id.')'}}
                                                                                                        <?php $valOptions[] = $objPollOptionDetail->poll_option_id?>
                                                                                                    </div>
                                                                                                    <div class="btn btn-default btn-valor" id="">
                                                                                                        <a href="#"  onclick="editOptionDetail('{{$objPollOptionDetail->id}}'); return false;"  id="{{'btnUpdateOption'.$objPollOptionDetail->id}}">
                                                                                                            <span class="glyphicon glyphicon-pencil"></span></a>
                                                                                                    </div>
                                                                                                    @if($objPollOptionDetail->priority<>0)
                                                                                                        <div class="btn btn-default btn-valor">Prioridad: </div>
                                                                                                        <div class="btn btn-default btn-valor">
                                                                                                            {{$objPollOptionDetail->priority}}
                                                                                                            <?php $valPriority[$objPollOptionDetail->poll_option_id] = $objPollOptionDetail->priority?>
                                                                                                        </div>
                                                                                                    @else
                                                                                                        <?php $valPriority[$objPollOptionDetail->poll_option_id] = $objPollOptionDetail->priority?>
                                                                                                    @endif

                                                                                                    @if($objPollOptionDetail->otro<>'')
                                                                                                        <div class="btn btn-default btn-valor">Texto Otros: </div>
                                                                                                        <div class="btn btn-default btn-valor">
                                                                                                            {{' Texto Otros: '.$objPollOptionDetail->otro}}
                                                                                                            <?php $valOtros[$objPollOptionDetail->poll_option_id] = $objPollOptionDetail->otro?>
                                                                                                        </div>
                                                                                                    @else
                                                                                                        <?php $valOtros[$objPollOptionDetail->poll_option_id] = $objPollOptionDetail->otro?>
                                                                                                    @endif

                                                                                                </div>
                                                                                                <!-- MODAL DETAIL OPTION-->
                                                                                                <div id="myModalOption{{$objPollOptionDetail->id}}" class="modal fade" tabindex="-1" role="dialog">
                                                                                                    <div class="modal-dialog">
                                                                                                        <div class="modal-content">
                                                                                                            <div class="modal-header">
                                                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                                                <h4 class="modal-title">Actualizando OPTION de {{$objStore->fullname.'('.$objStore->id.')'}}</h4>
                                                                                                            </div>
                                                                                                            <div class="modal-body">
                                                                                                                <div class="mensaje-option"></div>
                                                                                                                <p>Confirmar Grabación</p>

                                                                                                                @if(count($valFotos[$poll->id]['responses']['options'])>0)
                                                                                                                    @foreach ($valFotos[$poll->id]['responses']['options'] as $option)
                                                                                                                        @if($option->product_id==$poll_detail['poll_detail']->product_id)
                                                                                                                            <div class="radio">
                                                                                                                                <label>
                                                                                                                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="{{ $option->id }}" >
                                                                                                                                    <div id="{{ $option->id }}" > {{ $option->options }}  </div>
                                                                                                                                </label>
                                                                                                                            </div>
                                                                                                                    @endif
                                                                                                                @endforeach
                                                                                                            @endif


                                                                                                            <!-- Progress bar-->
                                                                                                                <div class="progress">
                                                                                                                    <div class="progress-bar progress-bar-striped active"  role="progressbar"  aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%" id="progress-option{{$objPollOptionDetail->id}}">
                                                                                                                        <span class="sr-only">45% Complete</span>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="modal-footer">
                                                                                                                <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCancelOptions{{ $objPollOptionDetail->id }}">Cancelar</button>

                                                                                                                <button type="button" class="btn btn-primary" id="btnSaveOptions{{ $objPollOptionDetail->id }}" onclick="saveOption({{ $objPollOptionDetail->id }})"  >Grabar Cambios</button>
                                                                                                            </div>
                                                                                                        </div><!-- /.modal-content -->
                                                                                                    </div><!-- /.modal-dialog -->
                                                                                                </div><!-- /.modal -->
                                                                                                <!-- END MODAL DETAIL OPTION-->
                                                                                            @endforeach
                                                                                        @endif
                                                                                    @endforeach
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    @endif

                                                                <!-- MODAL VENTANA para update e insert-->
                                                                    <div id="myModal{{$poll_detail['poll_detail']->id}}" class="modal fade" tabindex="-1" role="dialog">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                    <h4 class="modal-title">Editar Valores {{$objStore->fullname.'('.$objStore->id.')'}}</h4>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="mensaje-option"></div>
                                                                                    <p>Fecha auditoria: {{$poll_detail['poll_detail']->created_at}}</p>
                                                                                    <div class="mensaje-option"></div>
                                                                                    <p>Ultima actualización: {{$poll_detail['poll_detail']->updated_at}}</p>
                                                                                    {{Form::hidden('publicity_id'.$poll_detail['poll_detail']->id, 0, ['id'=>'publicity_id'.$poll_detail['poll_detail']->id])}}
                                                                                    {{Form::hidden('company_id', $company_id, ['id'=>'company_id'])}}
                                                                                    {{Form::hidden('poll_detail_id', $poll_detail['poll_detail']->id, ['id'=>'poll_detail_id'])}}
                                                                                    {{Form::hidden('poll_id'.$poll_detail['poll_detail']->id, $poll->id, ['id'=>'poll_id'.$poll_detail['poll_detail']->id])}}
                                                                                    {{Form::hidden('store_id', $objStore->id, ['id'=>'store_id'])}}
                                                                                    {{Form::hidden('user_id', $objRoadDetail[0]->road->user->id, ['id'=>'user_id'])}}
                                                                                    @if($poll_detail['poll_detail']->product_id<>0)
                                                                                        <div class="mensaje-option"></div>
                                                                                        @if(count($valFotos[$poll->id]['products'])>0)
                                                                                            <p>Producto</p>
                                                                                            {{ Form::label('producto'.$poll_detail['poll_detail']->id, $poll_detail['poll_detail']->product->fullname, ['id'=>'producto'.$poll_detail['poll_detail']->id,'class'=>'form-control']) }}
                                                                                            {{Form::hidden('product'.$poll_detail['poll_detail']->id, $poll_detail['poll_detail']->product->id, ['id'=>'product'.$poll_detail['poll_detail']->id])}}
                                                                                        @endif
                                                                                    @else
                                                                                        {{Form::hidden('product'.$poll_detail['poll_detail']->id, 0, ['id'=>'product'.$poll_detail['poll_detail']->id])}}
                                                                                    @endif
                                                                                    @if($poll->sino ==1)
                                                                                        <div class="mensaje-option"></div>
                                                                                        <p>Seleccionar Respuesta</p>
                                                                                        <select name="sino{{$poll_detail['poll_detail']->id}}" id="sino{{$poll_detail['poll_detail']->id}}" class="form-control">
                                                                                            <option value="1" @if($poll_detail['poll_detail']->result==1) selected @endif>Sí</option>
                                                                                            <option value="0" @if($poll_detail['poll_detail']->result==0) selected @endif>No</option>
                                                                                        </select>
                                                                                    @else
                                                                                        {{Form::hidden('sino'.$poll_detail['poll_detail']->id, 0, ['id'=>'sino'.$poll_detail['poll_detail']->id]);}}
                                                                                    @endif
                                                                                    <div class="mensaje-option"></div>
                                                                                    <p>Comentario</p>
                                                                                    <textarea rows="10" cols="20" wrap="soft" id="coment{{$poll_detail['poll_detail']->id}}">{{$poll_detail['poll_detail']->comentario}}</textarea>

                                                                                    @if($poll->options ==1)
                                                                                        <div class="mensaje-option"></div>
                                                                                        <p>Seleccionar Opciones</p>
                                                                                        @if(count($valFotos[$poll->id]['responses']['options'])>0)

                                                                                            @foreach ($valFotos[$poll->id]['responses']['options'] as $option)
                                                                                                @if(($option->product_id==$poll_detail['poll_detail']->product_id) or ($option->product_id<>''))
                                                                                                    {{ Form::checkbox('option'.$poll_detail['poll_detail']->id.'[]', $option->id, in_array($option->id, $valOptions), ['id'=>'option'.$poll_detail['poll_detail']->id.'[]']) }}
                                                                                                    {{ Form::label('role', $option->options) }}
                                                                                                    @if(in_array($option->id, $valOptions))
                                                                                                        @if($customer->id==5)
                                                                                                            {{ Form::text('priority'.$option->id, $valPriority[$option->id], ['id'=>'priority'.$option->id]) }}
                                                                                                        @else
                                                                                                            {{Form::hidden('priority'.$option->id, 0, ['id'=>'priority'.$option->id])}}
                                                                                                        @endif
                                                                                                    @else
                                                                                                        @if($customer->id==5)
                                                                                                            {{ Form::text('priority'.$option->id, 0, ['id'=>'priority'.$option->id]) }}
                                                                                                        @else
                                                                                                            {{Form::hidden('priority'.$option->id, 0, ['id'=>'priority'.$option->id])}}
                                                                                                        @endif
                                                                                                    @endif
                                                                                                    <br>
                                                                                                @endif
                                                                                                @if($option->options=='Otros')
                                                                                                    {{ Form::checkbox('option'.$poll_detail['poll_detail']->id.'[]', $option->id, in_array($option->id, $valOptions), ['id'=>'option'.$poll_detail['poll_detail']->id.'[]']) }}
                                                                                                    {{ Form::label('role', $option->options) }}
                                                                                                    @if(in_array($option->id, $valOptions))
                                                                                                        {{ Form::text('priority'.$option->id, $valPriority[$option->id], ['id'=>'priority'.$option->id]) }}
                                                                                                    @else
                                                                                                        @if($customer->id==5)
                                                                                                            {{ Form::text('priority'.$option->id, 0, ['id'=>'priority'.$option->id]) }}
                                                                                                        @else
                                                                                                            {{Form::hidden('priority'.$option->id, 0, ['id'=>'priority'.$option->id])}}
                                                                                                        @endif
                                                                                                    @endif
                                                                                                    @if(in_array($option->id, $valOptions))
                                                                                                        {{ Form::text('otros'.$option->id, $valOtros[$option->id], ['id'=>'otros'.$option->id]) }}
                                                                                                    @else
                                                                                                        {{ Form::text('otros'.$option->id, '', ['id'=>'otros'.$option->id]) }}
                                                                                                    @endif
                                                                                                    <br>
                                                                                                @endif
                                                                                            @endforeach

                                                                                        @endif

                                                                                    @endif

                                                                                <!-- Progress bar-->
                                                                                    <div class="progress">
                                                                                        <div class="progress-bar progress-bar-striped active"  role="progressbar"  aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%" id="progress-bar{{$poll_detail['poll_detail']->id}}">
                                                                                            <span class="sr-only">45% Complete</span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-12 ">
                                                                                            <div class="text-center" id="messagesUpdateReg{{$poll_detail['poll_detail']->id}}">

                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCancelRegister{{$poll_detail['poll_detail']->id}}">Cancelar</button>

                                                                                    <button type="button" class="btn btn-primary" id="btnUpdateRegister{{$poll_detail['poll_detail']->id}}"  onclick="UpdateRegister('{{$poll_detail['poll_detail']->id}}')"  >Actualizar Registro</button>
                                                                                </div>
                                                                            </div><!-- /.modal-content -->
                                                                        </div><!-- /.modal-dialog -->
                                                                    </div><!-- /.modal -->
                                                                <!-- END MODAL VENTANA para update e insert-->

                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    @else
                                                        @if($poll->sino ==1)
                                                            <div class="row">
                                                                <div class="col-md-12 ">
                                                                    <div class="btn-group" role="group" aria-label="...">
                                                                        <div class="btn btn-default btn-valor">Ingresar Respuesta Si/No</div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if($poll->options ==1)
                                                            <div class="row">
                                                                <div class="col-md-12 ">
                                                                    <div class="btn-group" role="group" aria-label="...">
                                                                        <div class="btn btn-default btn-valor">Ingresar Respuesta Opciones</div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <!-- MODAL VENTANA Insert-->
                                <div id="myModalInsert{{$poll->id}}" class="modal fade" tabindex="-1" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Ingresar Valores {{$objStore->fullname.'('.$objStore->id.')'}}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mensaje-option"></div>
                                                <p>Fecha auditoria: {{$objRoadDetail[0]->created_at}}</p>
                                                {{Form::hidden('company_id_insert', $company_id, ['id'=>'company_id_insert'])}}
                                                {{Form::hidden('user_id_insert', $objRoadDetail[0]->road->user->id, ['id'=>'user_id_insert'])}}
                                                {{Form::hidden('store_id_insert', $objStore->id, ['id'=>'store_id_insert'])}}
                                                {{Form::hidden('fecha_insert'.$poll->id, $objRoadDetail[0]->created_at, ['id'=>'fecha_insert'.$poll->id])}}
                                                <div class="mensaje-option"></div>
                                                @if(count($valFotos[$poll->id]['products'])>0)
                                                    <p>Seleccionar Producto</p>
                                                    <select name="productInsert{{$poll->id}}" id="productInsert{{$poll->id}}" class="form-control">
                                                        <option value="0">Seleccionar</option>
                                                        @foreach($valFotos[$poll->id]['products'] as $product)
                                                            <option value="{{$product->product_id}}">{{$product->product->fullname}}</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    {{Form::hidden('productInsert'.$poll->id, 0, ['id'=>'productInsert'.$poll->id])}}
                                                @endif
                                                @if(count($valFotos[$poll->id]['publicities'])>0)
                                                    <p>Seleccionar Publicidad</p>
                                                    <select name="publicityInsert{{$poll->id}}" id="publicityInsert{{$poll->id}}" class="form-control">
                                                        <option value="0">Seleccionar</option>
                                                        @foreach($valFotos[$poll->id]['publicities'] as $publicity)
                                                            <option value="{{$publicity->publicity_id}}">{{$publicity->publicity->fullname}}</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    {{Form::hidden('publicityInsert'.$poll->id, 0, ['id'=>'publicityInsert'.$poll->id])}}
                                                @endif
                                                @if($poll->sino ==1)
                                                    <div class="mensaje-option"></div>
                                                    <p>Seleccionar Respuesta</p>
                                                    <select name="sinoInsert{{$poll->id}}" id="sinoInsert{{$poll->id}}" class="form-control">
                                                        <option value="1" >Sí</option>
                                                        <option value="0" >No</option>
                                                    </select>
                                                @else
                                                    {{Form::hidden('sinoInsert'.$poll->id, 0, ['id'=>'sinoInsert'.$poll->id]);}}
                                                @endif
                                                <div class="mensaje-option"></div>
                                                <p>Comentario</p>
                                                <textarea rows="10" cols="20" wrap="soft" id="comentInsert{{$poll->id}}"></textarea>

                                            <!-- Progress bar-->
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped active"  role="progressbar"  aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%" id="progress-barInsert{{$poll->id}}">
                                                        <span class="sr-only">45% Complete</span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 ">
                                                        <div class="text-center" id="messageInsert{{$poll->id}}">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCancelInsert{{$poll->id}}">Cancelar</button>

                                                <button type="button" class="btn btn-primary" id="btnInsertRegister{{$poll->id}}"  onclick="InsertRegister('{{$poll->id}}')"   >Ingresar Registro</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                                <!-- END MODAL VENTANA Insert-->

                        @endforeach
                    @else
                        No hay fotos
                    @endif
                </div>

            @else
                <div class="row">
                    <div class="col-sm-12">
                        <div class="report-marco ">
                            <div class="contenedor-report">
                                <h4>No hay rutas para este punto {{$objStore->fullname."(".$objStore->id.")"}}</h4>

                            </div>
                        </div>
                    </div>
                </div>
            @endif

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

    function girarFoto(namePhoto,Tipo,Div,Url,Val,grado) {
        $('#'+Div).hide(1000,'swing');
        var valAlea = "?dummy=" + (Val+1);
        var jqxhrGirarFoto = $.post("{{route('girarFotos')}}", { foto : namePhoto,grado:grado,  tipo : Tipo},  function(data) {
            console.log ("success => " + data);
        })
                .done(function() {

                })
                .fail(function() {
                })
                .always(function() {
                    $('#'+Div).html('<a href="'+Url+namePhoto+valAlea+'" class="zoom1 btn btn-default" data-fancybox-group="button"><img src="'+Url+namePhoto+valAlea+'" width="200px" class="img-thumbnail"></a>');
                    $('#'+Div).show(1000,'swing');
                    location.href = '{{ route('mediaDetailPhoto' , array($company_id,$detailAudit->id,0,"0",$objStore->id,$cliente))}}';
                });
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
<script>
    var url_base =  "{{ URL::to('/') }}" ;
    function changeValueSiNo(idPollDetail, Value, company_id,div) {
        var divLoading = div;
        var loading= "<div class='" + divLoading +"'><img src='"  +  url_base + "/img/loading5.gif" + "' width='30px' ></div>";
        if (Value == 0){
            $("#"+idPollDetail).removeClass("btn btn-default btn-si");
        }
        if (Value == 1){
            $("#"+idPollDetail).removeClass("btn btn-default btn-no");
        }
        $("#"+idPollDetail).addClass("btn btn-default btn-valor");
        $("#"+divLoading).html(loading);
        $("#editSiNo" + idPollDetail).hide('slow');


        var jqxhr = $.post("{{route('updateRegPollDetail')}}", { company_id : company_id, poll_detail_id : idPollDetail , result : Value },  function(data) {
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
            $("#hrefSiNo" + idPollDetail).removeAttr("onclick");
            $("."+divLoading).remove();
            $("#"+idPollDetail).removeClass("btn btn-default btn-valor");
            if (Value == 0){
                $("#hrefSiNo" + idPollDetail).attr("onclick", "changeValueSiNo('" + idPollDetail +"',1,'" + company_id +"','" + idPollDetail +"'); return false;");
                $("#"+idPollDetail).addClass("btn btn-default btn-no");
                $("#"+div).html("No()");
            }
            if (Value == 1){
                $("#hrefSiNo" + idPollDetail).attr("onclick", "changeValueSiNo('" + idPollDetail +"',0,'" + company_id +"','" + idPollDetail +"'); return false;");
                $("#"+idPollDetail).addClass("btn btn-default btn-si");
                $("#"+div).html("Sí()");
            }
            $("#editSiNo" + idPollDetail).show('slow');
        });
    }
</script>
<script>
    function editRegister(pollDetailId) {
        // e.preventDefault();
        $('#myModal'+pollDetailId).modal('show');
        return false;
    }
</script>
<script>
    function insertRegister(pollId) {
        // e.preventDefault();
        $('#myModalInsert'+pollId).modal('show');
        return false;
    }
</script>
<script>
    function editOptionDetail(pollOptionDetailId) {
        // e.preventDefault();
        $('#myModalOption' + pollOptionDetailId).modal('show');
        $( ".mensaje-option > .alert" ).remove()
        return false;
    }
</script>
<script>
    function borrarReg(PollDetail,PollOptionDetails)
    {
        var jqxhrInsert = $.post("{{route('deleteRegsAll')}}", { poll_detail_id : PollDetail, poll_options_detail_id : PollOptionDetails},  function(data) {
            console.log ("success => " + data);
        })
                .done(function() {
                    $("#messagesDeleteReg"+ PollDetail).append("<br><span style='text-decoration: blink;'>Procesando eliminación un momento ...</span>");

                })
                .fail(function() {
                    $('#messagesDeleteReg'+ PollDetail).html('<div class="alert alert-danger" role="alert">ERROR: No se pudo eliminar este registro reinicie todo...</div>');

                })
                .always(function() {
                    $("#messagesDeleteReg"+ PollDetail).append("<br>Eliminado correctamente un momento...");
                    $('#principal'+PollDetail).hide("slow");
                });
    }
</script>

<script>
    function InsertRegister(poll_id)
    {
        $("#btnInsertRegister" + poll_id).hide('slow');
        $("#btnCancelInsert" + poll_id).hide('slow');
        $("#messageInsert"+ poll_id).html("");
        var company_id = $("#company_id_insert").val();
        var store_id = $("#store_id_insert").val();
        var user_id = $("#user_id_insert").val();
        var response_sino = $("#sinoInsert" + poll_id ).val();
        var product_id = $("#productInsert" + poll_id ).val();
        var publicity_id = $("#publicityInsert" + poll_id ).val();
        var fecha_audit = $("#fecha_insert"+ poll_id).val();
        var comentario = $("#comentInsert"+ poll_id).val();
        var optionStrings ='';
        var priorityStrings ='';

        var jqxhrInsertPoll = $.post("{{route('insertRegPollDetailAll')}}", { company_id : company_id, store_id : store_id , product_id :  product_id, publicity_id : publicity_id, options : optionStrings, priorities : priorityStrings, poll_id : poll_id, user_id : user_id, sino : response_sino, fecha: fecha_audit, comentario : comentario},  function(data) {
            console.log ("success => " + data);
        })
        .done(function() {
            $('#progress-barInsert'+poll_id).css('width', '30%').attr('aria-valuenow', "0");
            $("#messageInsert"+ poll_id).append("<br><span style='text-decoration: blink;'>Insert Poll Detail, one moment ...</span>");

        })
        .fail(function() {
            $('#progress-barInsert'+poll_id).css('width', '0%').attr('aria-valuenow', "0");
            $('#messageInsert'+ poll_id).html('<div class="alert alert-danger" role="alert">ERROR: No se pudo ingresar opciones reinicie todo...</div>');

        })
        .always(function() {
            $("#messageInsert"+ poll_id).append("<br>Insert OK...");
            $('#progress-barInsert'+poll_id).css('width', '100%').attr('aria-valuenow', "0");
            location.href = '{{ route('mediaDetailPhoto' , array($company_id,$detailAudit->id,0,"0",$objStore->id,$cliente))}}';
        });
    }
</script>
<script>
    //save and change options
    function UpdateRegister(poll_details_id)
    {
        $("#btnUpdateRegister" + poll_details_id).hide('slow');
        $("#btnCancelRegister" + poll_details_id).hide('slow');
        $("#messagesUpdateReg"+ poll_details_id).html("");
        var company_id = $("#company_id").val();
        var store_id = $("#store_id").val();
        var user_id = $("#user_id").val();
        var optionStrings ='';
        var priorityStrings ='';
        $('input[name="option'+poll_details_id+'[]"]:checked').each(function() {
            optionStrings = optionStrings + "|" + $(this).val();
            priorityStrings = priorityStrings + "|" + $("#priority"+$(this).val()).val();
        });
        var response_sino = $("#sino" + poll_details_id ).val();
        var product_id = $("#product" + poll_details_id ).val();
        var coment = $("#coment" + poll_details_id ).val();
        var poll_id = $("#poll_id"+ poll_details_id).val();

        console.log(optionStrings);
        console.log(priorityStrings);
        console.log(product_id);
        console.log(response_sino);
        console.log(coment);
        var jqxhr = $.post("{{route('updateRegPollDetailAll')}}", { company_id : company_id, poll_detail_id : poll_details_id , result : response_sino, comment : coment, product_id :  product_id, publicity_id : 0  },  function(data) {
            console.log ("success => " + data);
        })
                .done(function() {
                    $('#progress-bar'+poll_details_id).css('width', '10%').attr('aria-valuenow', "0");
                    $("#messagesUpdateReg"+ poll_details_id).html("<span style='text-decoration: blink;'>Actualizando Registro 1 un momento ...</span>");

                })
                .fail(function() {
                    $('#progress-bar'+poll_details_id).css('width', '0%').attr('aria-valuenow', "100");
                    $('#messagesUpdateReg').html('<div class="alert alert-danger" role="alert">ERROR: No se pudo actualizar el registro vuelva a intentar...</div>');
                    $("#btnUpdateRegister" + poll_details_id).show('slow');
                    $("#btnCancelRegister" + poll_details_id).show('slow');
                })
                .always(function() {
                    $("#messagesUpdateReg"+ poll_details_id).html("Registro 1 Actualizado ");

                    if (optionStrings != '')
                    {
                        $('#progress-bar'+poll_details_id).css('width', '30%').attr('aria-valuenow', "0");
                        var jqxhrDelete = $.post("{{route('deleteAllOptions')}}", { company_id : company_id, store_id : store_id , product_id :  product_id, publicity_id : 0  },  function(data) {
                            console.log ("success => " + data);
                        })
                                .done(function() {
                                    $('#progress-bar'+poll_details_id).css('width', '40%').attr('aria-valuenow', "0");
                                    $("#messagesUpdateReg"+ poll_details_id).append("<br><span style='text-decoration: blink;'>Actualizando Registro 2 un momento ...</span>");

                                })
                                .fail(function() {
                                    $('#progress-bar'+poll_details_id).css('width', '30%').attr('aria-valuenow', "100");
                                    $('#messagesUpdateReg').html('<div class="alert alert-danger" role="alert">ERROR: No se pudo actualizar el registro 2 reinicie todo...</div>');

                                })
                                .always(function() {
                                    $("#messagesUpdateReg"+ poll_details_id).append("<br>Registro 2 Actualizado ");
                                    $('#progress-bar'+poll_details_id).css('width', '60%').attr('aria-valuenow', "0");
                                    var jqxhrInsert = $.post("{{route('insertRegPollOptionDetailAll')}}", { company_id : company_id, store_id : store_id , product_id :  product_id, publicity_id : 0, options : optionStrings, priorities : priorityStrings, poll_detail_id : poll_details_id, user_id : user_id},  function(data) {
                                        console.log ("success => " + data);
                                    })
                                            .done(function() {
                                                $('#progress-bar'+poll_details_id).css('width', '60%').attr('aria-valuenow', "0");
                                                $("#messagesUpdateReg"+ poll_details_id).append("<br><span style='text-decoration: blink;'>Ingresando regs Options un momento ...</span>");

                                            })
                                            .fail(function() {
                                                $('#progress-bar'+poll_details_id).css('width', '30%').attr('aria-valuenow', "100");
                                                $('#messagesUpdateReg').html('<div class="alert alert-danger" role="alert">ERROR: No se pudo ingresar opciones reinicie todo...</div>');

                                            })
                                            .always(function() {
                                                $("#messagesUpdateReg"+ poll_details_id).append("<br>Registros ingresados reiniciando...");
                                                $('#progress-bar'+poll_details_id).css('width', '100%').attr('aria-valuenow', "0");
                                                location.href = '{{ route('mediaDetailPhoto' , array($company_id,$detailAudit->id,0,"0",$objStore->id,$cliente))}}';
                                            });
                                });
                    }else{
                        $('#progress-bar'+poll_details_id).css('width', '100%').attr('aria-valuenow', "0");
                    }
                });
    }
</script>
<script>
    function saveOption(poll_option_details_id)
    {
        $("#btnSaveOptions" + poll_option_details_id).hide('slow');
        $("#btnCancelOptions" + poll_option_details_id).hide('slow');
        var selected_pol_options_id = $("input:radio[name=optionsRadios]:checked").val();
        var selected_neme_option = $("#" + selected_pol_options_id ).text();

        $('#progress-option'+poll_option_details_id).css('width', '100%').attr('aria-valuenow', "100");

        $.post("{{route('updatePollOptionsDetails')}}",  { 'poll_option_details_id' : poll_option_details_id, 'selected_pol_options_id' : selected_pol_options_id  },
        function(data){

        })
        .done(function(data) {
            $('#progress-option'+poll_option_details_id).css('width', '100%').attr('aria-valuenow', "100");
            $('#myModalOption' + poll_option_details_id).modal('hide');
            //console.log(data);
            location.href = '{{ route('mediaDetailPhoto' , array($company_id,$detailAudit->id,0,"0",$objStore->id,$cliente))}}';
        })
        .fail(function() {
            $('#progress-option'+poll_option_details_id).css('width', '100%').attr('aria-valuenow', "100");
            $('.mensaje-option').html('<div class="alert alert-danger" role="alert">ERROR: No se pudo guardar el registro vuelva a intentar...</div>');

        })
        .always(function() {
            $('#progress-option'+poll_option_details_id).css('width', '0%').attr('aria-valuenow', "0");
        });

    }
</script>
@endsection