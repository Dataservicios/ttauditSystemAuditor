@extends('layouts/clienteAlicorp')
@section('content')
<section>
    @include('report/partials/menuPrincipalAlicorp')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <div class="row pt pb">
                <div class="col-sm-9">
                    <h4 class="report-title">Auditoria {{$objAudit->fullname}} Campaña: {{$titulo}}</h4>
                </div>
                <div class="col-sm-3">
                    <img src="{{$logo}}" >
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="report-marco ">
                        <div class="contenedor-report">
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">Base Bodegas</div>
                                <div   class="btn btn-default btn-valor">{{$cantidadStoresForCampaigne}}</div>
                            </div>
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">Bodegas Programadas</div>
                                <div   class="btn btn-default btn-valor">{{$cantidadStoresRouting}}</div>
                            </div>
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">Bodegas visitadas</div>
                                <div   class="btn btn-default btn-valor">{{$cantidadStoresAudit}}</div>

                            </div>
                            <div class="btn-group" role="group" aria-label="...">
                                <div   class="btn btn-default btn-si">Aceptaron Auditoria</div>
                                <div   class="btn btn-default btn-valor">{{$totalAbiertos}}</div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    @if(($ubigeoext<>"0") or ($dexExt<>'0') or ($typeStoreExt<>'0'))
                        <div id="alertaFiltro" class="alert alert-info alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <strong>Filtrado por:</strong>
                            @if($ubigeoext==5)
                                Todas las Provincias menos Lima
                            @else
                                @if($ubigeoext<>'0')
                                    Departamento: {{$ubigeoext}}
                                @endif
                            @endif
                            @if($dexExt<>'0')
                                Dex: {{$dexExt}}
                            @endif
                            @if($typeStoreExt<>'0')
                                Tipo Bodega: {{$typeStoreExt}}
                            @endif
                        </div>
                    @endif

                    <div class="row">
                        <!--Filtros con combos-->
                        {{Form::open(['route' => 'auditReportCategoryAlicorpFilter', 'method' => 'POST', 'role' => 'form'], $audit_id)}}

                        <div class="col-sm-3">
                            <div class="form-group">
                                {{ Form::hidden('audit_id', $audit_id) }}
                                {{ Form::hidden('company_id', $company_id) }}
                                {{ Form::hidden('categoria', "") }}
                                <label for="ubigeo">Departamento</label>
                                {{Form::select('ubigeo', $ubigeo, '0', ['id'=>'ubigeo','class' => 'form-control']);}}
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="ubigeo">Dex</label>
                                {{Form::select('dex', $dex, '0', ['id'=>'dex','class' => 'form-control']);}}
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="ubigeo">Tipo Tienda</label>
                                {{Form::select('typeStore', $typeStore, '0', ['id'=>'typeStore','class' => 'form-control']);}}
                            </div>
                        </div>

                        <div class="col-sm-1">
                            <div class="form-group">
                                <label for="rubro">&emsp;</label>
                                <button class="btn btn-default" type="submit">Filtrar</button>
                            </div>
                        </div>
                        {{ Form::close() }}
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="rubro">&emsp;</label>
                                {{Form::select('campaigne', $campaignes, '0', ['id'=>'campaigne','class' => 'form-control', 'onchange' => 'newCampaigne(this)']);}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pt pb">
                @if($audit_id==3)
                    @foreach($exhibidores as $index => $product)
                        <div class="row">
                            <div class="col-md-12 pb">
                                <div class="report-marco ">
                                    <div class="row pl">
                                        <div class="col-md-12 ">
                                            <h4>{{$product['nombre']}}</h4>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 ">
                                            <label for="basic-url" style="padding-left: 10px;">Se encontro</label>
                                            <div class="grafico-circle">
                                                <div id="chart1div{{$product['id']}}" style="width: 100%; height: 250px;" ></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 ">
                                            <label for="basic-url" style="padding-left: 10px;">Es visible</label>
                                            <div class="grafico-circle">
                                                <div id="chart2div{{$product['id']}}" style="width: 100%; height: 250px;" ></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 ">
                                            <label for="basic-url" style="padding-left: 10px;">Contaminado</label>
                                            <div class="grafico-circle">
                                                <div id="chart3div{{$product['id']}}" style="width: 100%; height: 250px;" ></div>
                                            </div>
                                            <div>
                                                @if($totalAbiertos<>0)
                                                <a href="{{route('getDetailPublicitiesAlicorp', $product['id']."/".$valores."/1/".$company_id)}}" class="btn btn-primary btn-sm active" role="button">Ver Detalle contaminados</a>
                                                @endif
                                            </div>
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
@section('report')
    {{ HTML::script('lib/amcharts/amcharts.js'); }}
    {{ HTML::script('lib/amcharts/serial.js'); }}
    {{ HTML::script('lib/amcharts/pie.js'); }}

    {{ HTML::script('js/graficos/alicorp-chart.js'); }}

    <script>
        @if($audit_id==3)
            @foreach($exhibidores as $product)
            var chartData0 = JSON.parse('{{$product['graficoEncontrados']}}');
            createGraphPie(chartData0,"chart1div{{$product['id']}}");

            var chartData1 = JSON.parse('{{$product['graficoVisible']}}');
            createGraphPie(chartData1,"chart2div{{$product['id']}}");

            var chartData2 = JSON.parse('{{$product['graficoContamined']}}');
            createGraphPie(chartData2,"chart3div{{$product['id']}}");
            @endforeach
        @endif


    </script>

    <script>
        function newCampaigne(valor){

            if(valor.value != 0){
                var fullname = valor.options[valor.selectedIndex].text;
                var url= "{{ $urlBase }}" + valor.value ;
                var win = window.open(url, '_blank');
                win.focus();
            }
        }
    </script>
@endsection