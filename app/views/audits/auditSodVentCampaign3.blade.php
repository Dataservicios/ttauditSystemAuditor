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
                            @if($publicity_id<>"0")

                                <a href="{{route('getDetailQuestionAdmin',[$pollW,$city.'-0-0-0-0-0-1-0-0',$company_id,"0","0",$publicity_id,1,$auditor])}}" target="_blank">Ver Sod Trabajados</a>
                                <a href="{{route('getDetailQuestionAdmin',[$pollW,$city.'-0-0-0-0-0-0-0-0',$company_id,"0","0",$publicity_id,1,$auditor])}}" target="_blank">Ver Sod NO Trabajados</a>
                            @endif
                        </div>
                    </div>

                    <div class="row pt pb">
                        <div class="col-sm-12 table-responsive">
                            @if ($filtro=='SOD')
                                @if (count($storesxCampaigne)>1)

                                        <table class="table table-hover">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Store_id</th>
                                                <th>fullname</th>
                                                <th>Fecha</th>
                                                <th>Hora</th>
                                                <th>Abierto</th>
                                                <th>Permitio</th>
                                                <th>Existe Sod</th>
                                                <th>Sod Trabajado</th>
                                                <th>Reg. de SOD</th>
                                                <th>Foto</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($storesxCampaigne as $index => $space)
                                                <tr>
                                                    <td>{{$index +1}}</td>
                                                    <td>{{ $space['store_id'] }}</td>
                                                    <td>{{ $space['fullname'] }}</td>
                                                    <td>{{ $space['fecha'] }}</td>
                                                    <td>{{ $space['hora'] }}</td>
                                                    <td>{{ $space['filtros']['abierto'] }}</td>
                                                    <td>{{ $space['filtros']['permitio'] }}</td>
                                                    <td>{{ $space['filtros']['existe'] }}</td>
                                                    <td>{{ $space['filtros']['trabajada'] }}</td>
                                                    <td>{{ $space['result'] }}</td>
                                                    <td>
                                                        @if($space['foto']<>null)
                                                            <a href="{{route('detailsPublicitySod',[$company_id,$audit_id,$space['store_id'],$publicity_id,$space['foto'],$space['publicity_detail_id'],$city,$auditor])}}">Foto</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($space['sod']<>-1)
                                                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="@if($space['sod']==0) Foto no medida @else Foto medida @endif">
                                                                <span class="@if($space['sod']==0)icon-indicador icon-table-size icon-color-red @else icon-indicador icon-table-size icon-color-green @endif"></span>
                                                            </a>
                                                        @endif

                                                    </td>
                                                    <td><a href="{{route('mediaDetailPhoto',[$company_id,$audit_id,1,$publicity_id,$space['store_id']])}}" data-toggle="tooltip" data-placement="bottom" title="Admin fotos {{ $space['fullname'] }}"><span class="glyphicon glyphicon-camera"></span></a>
                                                    </td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>

                                @else
                                    <span class="alert-info">No hay datos</span>
                                @endif
                            @endif
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