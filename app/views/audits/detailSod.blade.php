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
                            <!--Filtros con combos-->
                            {{Form::open(['route' => 'listStoresPublicity', 'method' => 'POST', 'role' => 'form'], $audit_id)}}
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        {{ Form::hidden('audit_id', $audit_id) }}
                                        {{ Form::hidden('company_id', $company_id) }}
                                        {{ Form::hidden('tipo', 'Sod') }}
                                        <label for="ciudad">Ciudad</label>
                                        {{--{{Form::select('ciudad', array('0' => 'Seleccionar', 'Lima' => 'Lima','Piura'=>'Piura','Callao'=>'Callao','1'=>'Todo Lima','2'=>'Todo Arequipa','3'=>'Toda Ica','4'=>'Todo Trujillo','5'=>'Todo Provincias'), '0', ['id'=>'ciudad','onchange'=>'ejecutaEvento(this,1)','class' => 'form-control']);}}--}}
                                        {{Form::select('ciudad', $ciudades, '0', ['id'=>'ciudad','class' => 'form-control']);}}
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="auditor">Auditor</label>
                                        {{Form::select('auditor', $auditors, '0', ['id'=>'auditor','class' => 'form-control']);}}
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="publicity">Categoria</label>
                                        {{Form::select('publicity', $publicities, '0', ['id'=>'publicity','class' => 'form-control']);}}
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
                        </div>
                    </div>
                    <div class="report-marco ">
                        <div class="contenedor-report">

                        </div>
                    </div>

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

                            <div class="col-sm-8 ">
                                <div class="row pt pb">
                                    <div class="col-sm-12  table-responsive">
                                        <table class="table">
                                            <tr>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="...">
                                                        @if(is_object($pollsResult['abierto']['objeto']) and (count($pollsResult['abierto']['objeto'])>0))
                                                            @if($pollsResult['abierto']['objeto'][0]->result==1)
                                                                <div class="btn btn-default btn-si" id="{{$pollsResult['abierto']['objeto'][0]->id}}">Abierto:</div>
                                                            @else
                                                                <div class="btn btn-default btn-no" id="{{$pollsResult['abierto']['objeto'][0]->id}}">Abierto:</div>
                                                            @endif
                                                        @else
                                                            <div class="btn btn-default btn-no">Abierto:</div>
                                                        @endif
                                                        <div   class="btn btn-default btn-valor" id="responseOpen">{{$pollsResult['abierto']['texto']}}</div>
                                                    </div>
                                                </td>
                                                <td>@if(is_object($pollsResult['abierto']['objeto']) and (count($pollsResult['abierto']['objeto'])>0))
                                                        @if($pollsResult['abierto']['objeto'][0]->result==1)
                                                            <a class="btn btn-default" href="#" onclick="changeValueSiNo({{$pollsResult['abierto']['objeto'][0]->id}},0,{{$company_id}},'responseOpen')" role="button" id="button_{{$pollsResult['abierto']['objeto'][0]->id}}">Change</a>
                                                        @else
                                                            <a class="btn btn-default" href="#" onclick="changeValueSiNo({{$pollsResult['abierto']['objeto'][0]->id}},1,{{$company_id}},'responseOpen')" role="button" id="button_{{$pollsResult['abierto']['objeto'][0]->id}}">Change</a>
                                                        @endif
                                                    @else
                                                        <a class="btn btn-default" href="#" role="button">Insert</a>
                                                    @endif</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="...">
                                                        @if(is_object($pollsResult['permitio']['objeto']) and (count($pollsResult['abierto']['objeto'])>0))
                                                            @if($pollsResult['permitio']['objeto'][0]->result==1)
                                                                <div class="btn btn-default btn-si" id="{{$pollsResult['permitio']['objeto'][0]->id}}">Permitio:</div>
                                                            @else
                                                                <div class="btn btn-default btn-no" id="{{$pollsResult['permitio']['objeto'][0]->id}}">Permitio:</div>
                                                            @endif
                                                        @else
                                                            <div class="btn btn-default btn-no">Permitio:</div>
                                                        @endif
                                                        <div   class="btn btn-default btn-valor" id="responsePermitio">{{$pollsResult['permitio']['texto']}}</div>
                                                    </div>
                                                </td><td>
                                                    @if(is_object($pollsResult['permitio']['objeto']) and (count($pollsResult['permitio']['objeto'])>0))
                                                        @if($pollsResult['permitio']['objeto'][0]->result==1)
                                                            <a class="btn btn-default" href="#" onclick="changeValueSiNo({{$pollsResult['permitio']['objeto'][0]->id}},0,{{$company_id}},'responsePermitio')" role="button" id="button_{{$pollsResult['permitio']['objeto'][0]->id}}">Change</a>
                                                        @else
                                                            <a class="btn btn-default" href="#" onclick="changeValueSiNo({{$pollsResult['permitio']['objeto'][0]->id}},1,{{$company_id}},'responsePermitio')" role="button" id="button_{{$pollsResult['permitio']['objeto'][0]->id}}">Change</a>
                                                        @endif
                                                    @else
                                                        <a class="btn btn-default" href="#" role="button">Insert</a>
                                                    @endif</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="...">
                                                        @if(is_object($pollsResult['existe']['objeto']) and (count($pollsResult['existe']['objeto'])>0))
                                                            @if($pollsResult['existe']['objeto'][0]->result==1)
                                                                <div class="btn btn-default btn-si" id="{{$pollsResult['existe']['objeto'][0]->id}}">Existe SOD:</div>
                                                            @else
                                                                <div class="btn btn-default btn-no" id="{{$pollsResult['existe']['objeto'][0]->id}}">Existe SOD:</div>
                                                            @endif
                                                        @else
                                                            <div class="btn btn-default btn-no">Existe SOD:</div>
                                                        @endif
                                                        <div   class="btn btn-default btn-valor" id="responseExiste">{{$pollsResult['existe']['texto']}}</div>
                                                    </div>
                                                </td><td>
                                                    @if(is_object($pollsResult['existe']['objeto']) and (count($pollsResult['existe']['objeto'])>0))
                                                        @if($pollsResult['existe']['objeto'][0]->result==1)
                                                            <a class="btn btn-default" href="#" onclick="changeValueSiNo({{$pollsResult['existe']['objeto'][0]->id}},0,{{$company_id}},'responseExiste')" role="button" id="button_{{$pollsResult['existe']['objeto'][0]->id}}">Change</a>
                                                        @else
                                                            <a class="btn btn-default" href="#" onclick="changeValueSiNo({{$pollsResult['existe']['objeto'][0]->id}},1,{{$company_id}},'responseExiste')" role="button" id="button_{{$pollsResult['existe']['objeto'][0]->id}}">Change</a>
                                                        @endif
                                                    @else
                                                        <a class="btn btn-default" href="#" role="button">Insert</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="...">
                                                        @if(is_object($pollsResult['visible']['objeto']) and (count($pollsResult['visible']['objeto'])>0))
                                                            @if($pollsResult['visible']['objeto'][0]->result==1)
                                                                <div class="btn btn-default btn-si" id="{{$pollsResult['visible']['objeto'][0]->id}}">SOD Visible:</div>
                                                            @else
                                                                <div class="btn btn-default btn-no" id="{{$pollsResult['visible']['objeto'][0]->id}}">SOD Visible:</div>
                                                            @endif
                                                        @else
                                                            <div class="btn btn-default btn-no">SOD Visible:</div>
                                                        @endif
                                                        <div   class="btn btn-default btn-valor" id="responseVisible">{{$pollsResult['visible']['texto']}}</div>
                                                    </div>
                                                </td><td>
                                                    @if(is_object($pollsResult['visible']['objeto']) and (count($pollsResult['visible']['objeto'])>0))
                                                        @if($pollsResult['visible']['objeto'][0]->result==1)
                                                            <a class="btn btn-default" href="#" onclick="changeValueSiNo({{$pollsResult['visible']['objeto'][0]->id}},0,{{$company_id}},'responseVisible')" role="button" id="button_{{$pollsResult['visible']['objeto'][0]->id}}">Change</a>
                                                        @else
                                                            <a class="btn btn-default" href="#" onclick="changeValueSiNo({{$pollsResult['visible']['objeto'][0]->id}},1,{{$company_id}},'responseVisible')" role="button" id="button_{{$pollsResult['visible']['objeto'][0]->id}}">Change</a>
                                                        @endif
                                                    @else
                                                        <a class="btn btn-default" href="#" role="button">Insert</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="...">
                                                        @if(is_object($pollsResult['trabajada']['objeto']) and (count($pollsResult['trabajada']['objeto'])>0))
                                                            @if($pollsResult['trabajada']['objeto'][0]->result==1)
                                                                <div class="btn btn-default btn-si" id="{{$pollsResult['trabajada']['objeto'][0]->id}}">SOD Trabajado:</div>
                                                            @else
                                                                <div class="btn btn-default btn-no" id="{{$pollsResult['trabajada']['objeto'][0]->id}}">SOD Trabajado:</div>
                                                            @endif
                                                        @else
                                                            <div class="btn btn-default btn-no">SOD Trabajado:</div>
                                                        @endif
                                                        <div   class="btn btn-default btn-valor" id="responseW">{{$pollsResult['trabajada']['texto']}}</div>
                                                    </div>
                                                </td><td>
                                                    @if(is_object($pollsResult['trabajada']['objeto']) and (count($pollsResult['trabajada']['objeto'])>0))
                                                        @if($pollsResult['trabajada']['objeto'][0]->result==1)
                                                            <a class="btn btn-default" href="#" onclick="changeValueSiNo({{$pollsResult['trabajada']['objeto'][0]->id}},0,{{$company_id}},'responseW')" role="button" id="button_{{$pollsResult['trabajada']['objeto'][0]->id}}">Change</a>
                                                        @else
                                                            <a class="btn btn-default" href="#" onclick="changeValueSiNo({{$pollsResult['trabajada']['objeto'][0]->id}},1,{{$company_id}},'responseW')" role="button" id="button_{{$pollsResult['trabajada']['objeto'][0]->id}}">Change</a>
                                                        @endif
                                                    @else
                                                        <a class="btn btn-default" href="#" role="button">Insert</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <!-- MODAL VENTANA para OPCIONES SOAD-->
                                            <div id="myModalOptions" class="modal fade" tabindex="-1" role="dialog">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title">Grabando Valor SOD de {{$objStore->fullname.'('.$objStore->id.')'}}</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mensaje-option"></div>
                                                            <p>Confirmar Grabación</p>

                                                            @foreach ($poll_options_text as $poll_option_text)
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio" name="optionsRadios" id="optionsRadios1" value="{{ $poll_option_text->id }}" checked>
                                                                        <div id="{{ $poll_option_text->id }}" > {{ $poll_option_text->options }}  </div>
                                                                    </label>
                                                                </div>
                                                            @endforeach


                                                        <!-- Progress bar-->
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped active"  role="progressbar"  aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%" id="progress-bar">
                                                                    <span class="sr-only">45% Complete</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>

                                                            <button type="button" class="btn btn-primary" id="btnSaveOptions" poll_option_details_id ="{{ $pollsResult['comoEstaVent']['options'][0]->poll_option_details_id }}"  >Grabar Cambios</button>
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                            <!-- END VENTANA para OPCIONES SOAD-->
                                            {{--COMO ESTÄ SOAD--}}
                                            <tr>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="...">
                                                        @if(is_object($pollsResult['comoEstaVent']['objeto']) and (count($pollsResult['comoEstaVent']['objeto'])>0))
                                                            @if(count($pollsResult['comoEstaVent']['options'][0])>0)
                                                                <div class="btn btn-default btn-si">Como esta SOD:</div>
                                                            @else
                                                                <div class="btn btn-default btn-no">Como esta SOD:</div>
                                                            @endif
                                                        @else
                                                            <div class="btn btn-default btn-no">Como esta SOD:</div>
                                                        @endif
                                                        <div  class="btn btn-default btn-valor comoEstaVent">{{$pollsResult['comoEstaVent']['texto']}}</div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a class="btn btn-default" href="#" onclick=" return changeOptions()" role="button" id="button_{{$pollsResult['comoEstaVent']['objeto'][0]->id}}">Change</a>
                                                </td>
                                            </tr>

                                            {{--END COMO ESTÄ SOAD--}}
                                        </table>
                                    </div>

                                </div>
                                <div class="row pt pb">
                                    <div class="col-sm-8 ">
                                        <img src="{{$urlsFotos}}">
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-4 ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{ Form::label('bajar', 'Bajar Imagen:') }}
                                    </div>
                                    <div class="col-sm-8 ">
                                        <a href="{{$urlsFotos}}" download="{{$filtro}}">
                                            <button style="position:relative;float: left  "  class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Descargar Imagen" type="button" >
                                                <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>
                                            </button></a>
                                    </div>
                                </div>
                                {{Form::open(['route' => '', 'method' => 'POST', 'role' => 'form'], $audit_id)}}
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            {{ Form::label('porcActual', 'Valor actual:') }}
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <h3 id="valActual"> {{ $sod }}</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            {{ Form::hidden('audit_id', $audit_id) }}
                                            {{ Form::hidden('company_id', $company_id) }}
                                            {{ Form::hidden('foto', $filtro, array('id' => 'foto')) }}
                                            {{ Form::hidden('publicityDetail_id', $publictyDetail_id, array('id' => 'publicityDetail_id')) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{ Form::label('principal', 'Area Principal:') }}
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            {{ Form::text('principal', 0, ['class' => 'form-control','id' => 'principal']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{ Form::label('valor1', 'Valor1:') }}
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            {{ Form::text('valor1', 0, ['class' => 'form-control','id' => 'valor1']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{ Form::label('valor2', 'Valor2:') }}
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            {{ Form::text('valor2', 0, ['class' => 'form-control','id' => 'valor2']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{ Form::label('valor3', 'Valor3:') }}
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            {{ Form::text('valor3', 0, ['class' => 'form-control','id' => 'valor3']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{ Form::label('valor4', 'Valor4:') }}
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            {{ Form::text('valor4', 0, ['class' => 'form-control','id' => 'valor4']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{ Form::label('valor5', 'Valor5:') }}
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            {{ Form::text('valor5', 0, ['class' => 'form-control','id' => 'valor5']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{ Form::label('valor6', 'Valor6:') }}
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            {{ Form::text('valor6', 0, ['class' => 'form-control','id' => 'valor6']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{ Form::label('valor7', 'Valor7:') }}
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            {{ Form::text('valor7', 0, ['class' => 'form-control','id' => 'valor7']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{ Form::label('valor8', 'Valor8:') }}
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            {{ Form::text('valor8', 0, ['class' => 'form-control','id' => 'valor8']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{ Form::label('valor9', 'Valor9:') }}
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            {{ Form::text('valor9', 0, ['class' => 'form-control','id' => 'valor9']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{ Form::label('valor10', 'Valor10:') }}
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            {{ Form::text('valor10', 0, ['class' => 'form-control','id' => 'valor10']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{ Form::label('suma', 'Suma total:') }}
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            {{ Form::text('suma', 0, ['class' => 'form-control','id' => 'suma']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <button class="btn btn-default" type="button" id="calcular">Calcular</button>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            {{ Form::text('porcentaje', 0, ['class' => 'form-control','id' => 'porcentaje']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 center-block">
                                        <div class="form-group">
                                            <label for="rubro">&emsp;</label>
                                            <button class="btn btn-default" type="submit" id="guardar">Guardar</button>
                                        </div>

                                    </div>
                                </div>

                                {{ Form::close() }}
                                <div class="row">
                                    <div class="col-sm-8 alert alert-success" role="alert"><span  id="alerta"></span>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
@section('report')
<script>
    var url_base =  "{{ URL::to('/') }}" ;
    function changeValueSiNo(idPollDetail, Value, company_id,div) {
        if (div=='responseOpen'){
            @if(is_object($pollsResult['abierto']['objeto']) and (count($pollsResult['abierto']['objeto'])>0))
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
                                if (Value == 0){
                                    $("#{{$pollsResult['abierto']['objeto'][0]->id}}").removeClass("btn btn-default btn-si");
                                    $("#{{$pollsResult['abierto']['objeto'][0]->id}}").addClass("btn btn-default btn-no");
                                    $("#"+div).html("No(" + "{{$pollsResult['abierto']['objeto'][0]->created_at}}" + ")");
                                    $('#button_{{$pollsResult['abierto']['objeto'][0]->id}}').attr("disabled", true);
                                }
                                if (Value == 1){
                                    $("#{{$pollsResult['abierto']['objeto'][0]->id}}").removeClass("btn btn-default btn-no");
                                    $("#{{$pollsResult['abierto']['objeto'][0]->id}}").addClass("btn btn-default btn-si");
                                    $("#"+div).html("Sí(" + "{{$pollsResult['abierto']['objeto'][0]->created_at}}" + ")");
                                    $('#button_{{$pollsResult['abierto']['objeto'][0]->id}}').attr("disabled", true);
                                }
                            });
            @endif
        }
        if (div=='responsePermitio'){
                    @if(is_object($pollsResult['permitio']['objeto']) and (count($pollsResult['permitio']['objeto'])>0))
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
                                if (Value == 0){
                                    $("#{{$pollsResult['permitio']['objeto'][0]->id}}").removeClass("btn btn-default btn-si");
                                    $("#{{$pollsResult['permitio']['objeto'][0]->id}}").addClass("btn btn-default btn-no");
                                    $("#"+div).html("No(" + "{{$pollsResult['permitio']['objeto'][0]->created_at}}" + ")");
                                    $('#button_{{$pollsResult['permitio']['objeto'][0]->id}}').attr("disabled", true);
                                }
                                if (Value == 1){
                                    $("#{{$pollsResult['permitio']['objeto'][0]->id}}").removeClass("btn btn-default btn-no");
                                    $("#{{$pollsResult['permitio']['objeto'][0]->id}}").addClass("btn btn-default btn-si");
                                    $("#"+div).html("Sí(" + "{{$pollsResult['permitio']['objeto'][0]->created_at}}" + ")");
                                    $('#button_{{$pollsResult['permitio']['objeto'][0]->id}}').attr("disabled", true);
                                }
                            });
            @endif
        }

        if (div=='responseExiste'){
                    @if(is_object($pollsResult['existe']['objeto']) and (count($pollsResult['existe']['objeto'])>0))
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
                                if (Value == 0){
                                    $("#{{$pollsResult['existe']['objeto'][0]->id}}").removeClass("btn btn-default btn-si");
                                    $("#{{$pollsResult['existe']['objeto'][0]->id}}").addClass("btn btn-default btn-no");
                                    $("#"+div).html("No(" + "{{$pollsResult['existe']['objeto'][0]->created_at}}" + ")");
                                    $('#button_{{$pollsResult['existe']['objeto'][0]->id}}').attr("disabled", true);
                                }
                                if (Value == 1){
                                    $("#{{$pollsResult['existe']['objeto'][0]->id}}").removeClass("btn btn-default btn-no");
                                    $("#{{$pollsResult['existe']['objeto'][0]->id}}").addClass("btn btn-default btn-si");
                                    $("#"+div).html("Sí(" + "{{$pollsResult['existe']['objeto'][0]->created_at}}" + ")");
                                    $('#button_{{$pollsResult['existe']['objeto'][0]->id}}').attr("disabled", true);
                                }
                            });
            @endif
        }
        if (div=='responseVisible'){
                    @if(is_object($pollsResult['visible']['objeto']) and (count($pollsResult['visible']['objeto'])>0))
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
                                if (Value == 0){
                                    $("#{{$pollsResult['visible']['objeto'][0]->id}}").removeClass("btn btn-default btn-si");
                                    $("#{{$pollsResult['visible']['objeto'][0]->id}}").addClass("btn btn-default btn-no");
                                    $("#"+div).html("No(" + "{{$pollsResult['visible']['objeto'][0]->created_at}}" + ")");
                                    $('#button_{{$pollsResult['visible']['objeto'][0]->id}}').attr("disabled", true);
                                }
                                if (Value == 1){
                                    $("#{{$pollsResult['visible']['objeto'][0]->id}}").removeClass("btn btn-default btn-no");
                                    $("#{{$pollsResult['visible']['objeto'][0]->id}}").addClass("btn btn-default btn-si");
                                    $("#"+div).html("Sí(" + "{{$pollsResult['visible']['objeto'][0]->created_at}}" + ")");
                                    $('#button_{{$pollsResult['visible']['objeto'][0]->id}}').attr("disabled", true);
                                }
                            });
            @endif
        }
        if (div=='responseW'){
                    @if(is_object($pollsResult['trabajada']['objeto']) and (count($pollsResult['trabajada']['objeto'])>0))
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
                                if (Value == 0){
                                    $("#{{$pollsResult['trabajada']['objeto'][0]->id}}").removeClass("btn btn-default btn-si");
                                    $("#{{$pollsResult['trabajada']['objeto'][0]->id}}").addClass("btn btn-default btn-no");
                                    $("#"+div).html("No(" + "{{$pollsResult['trabajada']['objeto'][0]->created_at}}" + ")");
                                    $('#button_{{$pollsResult['trabajada']['objeto'][0]->id}}').attr("disabled", true);
                                }
                                if (Value == 1){
                                    $("#{{$pollsResult['trabajada']['objeto'][0]->id}}").removeClass("btn btn-default btn-no");
                                    $("#{{$pollsResult['trabajada']['objeto'][0]->id}}").addClass("btn btn-default btn-si");
                                    $("#"+div).html("Sí(" + "{{$pollsResult['trabajada']['objeto'][0]->created_at}}" + ")");
                                    $('#button_{{$pollsResult['trabajada']['objeto'][0]->id}}').attr("disabled", true);
                                }
                            });
            @endif
        }
    }

    //save and change options
    $( "#btnSaveOptions" ).on( "click", function(event) {
        event.preventDefault();

        console.log($(this).attr('company_id'));

//        var company_id= $(this).attr('company_id');
//        var poll_options_id= $(this).attr('poll_options_id');
//        var store_id= $(this).attr('store_id');
        // var publicity_id= $(this).attr('publicity_id');
        var poll_option_details_id= $(this).attr('poll_option_details_id');
        var selected_pol_options_id = $("input:radio[name=optionsRadios]:checked").val();
        var selected_neme_option = $("#" + selected_pol_options_id ).text();


        $('.progress-bar').css('width', '100%').attr('aria-valuenow', "100");

        $.post("{{route('updatePollOptionsDetails')}}",  { 'poll_option_details_id' : poll_option_details_id, 'selected_pol_options_id' : selected_pol_options_id  },
                function(data){
                    //if (item.latitud != 0 && item.longitud != 0){
                    //console.log(data);

                    //console.log(data);

                })
                .done(function(data) {
                    // alert( "second success" );
                    //console.log ("success => " + data);
                    $('.progress-bar').css('width', '100%').attr('aria-valuenow', "100");
                    $('#myModalOptions').modal('hide');
                    // comoEstaVent
                    console.log(data);
                    $('.comoEstaVent > ul > li ').text(selected_neme_option);
                    //alert(selected_pol_options_id);;

                })
                .fail(function() {
                    //alert( "error" );

                    $('.progress-bar').css('width', '100%').attr('aria-valuenow', "100");
                    $('.mensaje-option').html('<div class="alert alert-danger" role="alert">ERROR: No se pudo guardar el registro vuelva a intentar...</div>');

                })
                .always(function() {

                    $('.progress-bar').css('width', '0%').attr('aria-valuenow', "0");


                });



        ;

    });

    function changeOptions () {
        // e.preventDefault();
        $('#myModalOptions').modal('show');
        $( ".mensaje-option > .alert" ).remove()
        return false;
    }
    //end save and change options

    $('#calcular').click(function(e) {
        e.preventDefault();
        var data_store = [];
        console.log(data_store);
        var suma = parseFloat($('#valor1').val()) + parseFloat($('#valor2').val())+ parseFloat($('#valor3').val())+ parseFloat($('#valor4').val())+ parseFloat($('#valor5').val())+ parseFloat($('#valor6').val())+ parseFloat($('#valor7').val())+ parseFloat($('#valor8').val())+ parseFloat($('#valor9').val())+ parseFloat($('#valor10').val());
        $('#suma').val(suma);
        var division = parseFloat(suma)/parseFloat($('#principal').val());
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
                        location.href = '{{ route('getListStoresPublicity' , array($city,$publicity_id,$auditor,$audit_id,$company_id,$tipo))}}';
                    }

                } );

    });
</script>
@endsection