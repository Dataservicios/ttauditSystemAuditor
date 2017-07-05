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
                    @if(($ubigeoext<>"0") or ($categoriaExt<>"0") or ($dexExt<>'0'))
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

                            @if($categoriaExt<>"0")
                                Categoria: {{$categoriaExt}}
                            @endif
                            @if($dexExt<>'0')
                                Dex: {{$dexExt}}
                            @endif
                        </div>
                    @endif

                    <div class="row">
                        <!--Filtros con combos-->
                        {{Form::open(['route' => 'auditReportCategoryAlicorpFilter', 'method' => 'POST', 'role' => 'form'], $audit_id)}}
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="cadena">Categoria Productos</label>
                                {{Form::select('categoria', $categorias, '0', ['id'=>'categoria','class' => 'form-control']);}}

                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                {{ Form::hidden('audit_id', $audit_id) }}
                                {{ Form::hidden('company_id', $company_id) }}
                                {{ Form::hidden('typeStore', "0") }}
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
            <div class="row pt pb">
                @if ($categoria<>"0")
                    <div class="col-md-12 pb">
                        <div class="report-marco ">
                            <div class="row pl">
                                <div class="col-md-12 ">
                                    <h4>{{$subTitulo}}</h4>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 ">
                                    <label for="basic-url" style="padding-left: 10px;">Productos encontrados</label>
                                    <div class="grafico-circle">
                                        <div id="chart1div" style="width: 100%; height: 250px;" ></div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>


                    <div class="col-md-12 pb">
                        <div class="report-marco ">
                            <div class="row pl">
                                <div class="col-md-12 ">
                                    <h4>Precios Visibles</h4>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="grafico-circle">
                                        <div id="chart3div" style="width: 100%; height: 250px;" ></div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                @else
                    <div class="col-md-12 pb">
                        <div class="report-marco ">
                            <div class="row pl">
                                <div class="col-md-12 ">
                                    <h4>Cumple MSL</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 ">
                                    <label for="basic-url" style="padding-left: 10px;">Mini Market</label>
                                    <div class="grafico-circle">
                                        <div id="chartdiv2" style="width: 100%; height: 250px;" ></div>
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <label for="basic-url" style="padding-left: 10px;">Bodega Clásica</label>
                                    <div class="grafico-circle">
                                        <div id="chartdiv3" style="width: 100%; height: 250px;" ></div>
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <label for="basic-url" style="padding-left: 10px;">Bodega Alto Tráfico</label>
                                    <div class="grafico-circle">
                                        <div id="chartdiv4" style="width: 100%; height: 250px;" ></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
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
        @if ($categoria<>"0")
            var chartData0 = JSON.parse('{{$valEncontradosJson}}');
            creaGraficoColumnas(chartData0,"chart1div",true,null,0,100);
            var chartData2 = JSON.parse('{{$valOkJson}}');
            creaGraficoColumnas(chartData2,"chart3div",true,null,0,100);
        @else
            // MSL Mini Market
            var chartData2 = JSON.parse('{{$valMSLMMJson}}');
            createGraphPie(chartData2,"chartdiv2");

            // MSL Bodega Clásica
            var chartData3 = JSON.parse('{{$valMSLBCJson}}');
            createGraphPie(chartData3,"chartdiv3");

            // MSL Bodega Alto Tráfico
            var chartData4 = JSON.parse('{{$valMSLATJson}}');
            createGraphPie(chartData4,"chartdiv4");
        @endif

    </script>
    <script>
        function cargarProductos(valor){
            console.log(valor.value);
            var company_id_var = {{$company_id}};
            user = valor.options[valor.selectedIndex].value;
            $('#producto').prop('disabled',false);
            $('#producto option').remove();
            $("#producto").append("<option value='0'>--Seleccione--</option>");
            $('#producto').prop('disabled',false);
            $('#producto option').remove();
            $.post('http://ttaudit.com/getProductsForCategory',{ category_id : valor.value,company_id : company_id_var }, function(json){
                //if (item.latitud != 0 && item.longitud != 0){
                poblandoCombo(json);
            });
        }

        function poblandoCombo(data) {
            var total_puntos = 0;
            $("#producto").append("<option value='0'>--Seleccione un Producto--</option>");
            $.each(data, function (i, item) {
                console.log(item);
                $("#producto").append("<option value=\""+ item.id +"\">"+ item.fullname +"</option>");
            });
        }
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