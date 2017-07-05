@extends('layouts/clienteBayer')
@section('content')
<section>
    @include('report/partials/menuPrincipalColgate')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <!--sección titulo y buscador-->
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="report-title">Encuesta de Productos Bayer: {{$titulo}}</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    @section('Mensajes')
                        @if(($ubigeoextLink<>"0") or ($cadenaLink<>"0") or ($ejecutivo<>"0") or ($horizontalLink<>"0"))
                            <div id="alertaFiltro" class="alert alert-info alert-dismissible" role="alert" style=" width:100%;position:fixed !important;  top:0px; z-index:10 !important;">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <strong>Filtrado por:</strong>
                                Departamento(s) {{$ubigeoextLink}}

                                @if($cadenaLink<>"0")
                                    , Cadena(s) {{$cadenaLink}}
                                @endif
                                @if($horizontalLink<>"0")
                                    , Horizontal(s) {{$horizontalLink}}
                                @endif
                                @if($ejecutivo<>"0")
                                    , Ejecutivo {{$ejecutivo}}
                                @endif
                            </div>
                        @endif
                    @endsection

                    <div class="row">
                        <!--Filtros con combos-->
                        {{Form::open(['route' => 'auditsBayerFilter', 'method' => 'POST', 'role' => 'form'], $audit_id)}}
                        <div class="col-sm-2">
                            <div class="form-group">
                                {{ Form::hidden('audit_id', $audit_id) }}
                                {{ Form::hidden('company_id', $company_id) }}
                                <label for="ubigeo">Departamento</label>
                                {{ Form::hidden('ubigeo', "0") }}
                                @foreach($ListUbigeos as $ubigeo)
                                    <div class="checkbox">
                                        <label>
                                            {{Form::checkbox('ubigeo[]', $ubigeo,null, ['class' => 'checkbox1']);}} {{$ubigeo}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="cadena">Cadenas</label>
                                {{ Form::hidden('cadena', "0") }}
                                @foreach($ListCadenas as $cadena1)
                                    <div class="checkbox">
                                        <label>
                                            {{Form::checkbox('cadena[]', $cadena1,null, ['class' => 'checkbox1']);}} {{$cadena1}}
                                        </label>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="cadena">Horizontales</label>
                                {{ Form::hidden('horizontal', "0") }}
                                @foreach($ListHorizontales as $cadena2)
                                    <div class="checkbox">
                                        <label>
                                            {{Form::checkbox('horizontal[]', $cadena2,null, ['class' => 'checkbox1']);}} {{$cadena2}}
                                        </label>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="ejecutivo">Ejecutivo</label>
                                {{Form::select('ejecutivo', $ejecutivos, '0', ['id'=>'ejecutivo','class' => 'form-control']);}}

                            </div>
                        </div>

                        <div class="col-sm-1">
                            <div class="form-group">
                                <label for="rubro">&emsp;</label>
                                <button class="btn btn-default" type="submit">Filtrar</button>
                            </div>

                        </div>
                    {{ Form::close() }}
                    <!-- Fin Filtros con combos-->
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="rubro">&emsp;</label>
                                {{Form::select('campaigne', $campaignes, '0', ['id'=>'campaigne','class' => 'form-control', 'onchange' => 'newCampaigne(this)']);}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row pt pb">
                <div class="col-sm-12">

                    <div class="row pt pb">
                        <div class="col-sm-12">
                            @foreach($ListProducts as $product)
                                <div class="row">
                                    <div class="col-md-12 pb">
                                        <div class="report-marco ">
                                            <div class="row pl">
                                                <div class="col-md-6 ">
                                                    <h2>{{$product->product->fullname}}</h2>
                                                </div>
                                                <div class="col-md-6 ">
                                                    <img src="{{$urlProducts.$product->product->imagen}}" width="150px">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    @foreach($valores[$product->product_id] as $valor)
                                        @if($valor['poll_id']<>109)
                                            <div class="col-md-6 pb">
                                                <div class="report-marco ">
                                                    <div class="row pl">
                                                        <div class="col-md-12 ">
                                                            <h4>{{$valor['poll']}}</h4>
                                                        </div>
                                                    </div>
                                                    <div class="grafico-circle">
                                                        <div id="chartdiv{{$product->product_id.$valor['poll_id']}}" style="width: 100%; height: 250px;" ></div>
                                                    </div>
                                                    @if($valor['poll_id']==110)
                                                        <div>
                                                            <a href="{{route('getDetailQuestionBayer', "110/".$valCiudad."-0-0-0"."/".$company_id."/0/".$product->product_id)}}" class="btn btn-primary btn-sm active" role="button">Ver sin Stock</a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    @foreach($valores[$product->product_id] as $valor)
                                        @if(($valor['poll_id']<>108) and ($valor['poll_id']<>110))
                                            <div class="col-md-12 pb">
                                                <div class="report-marco ">
                                                    <div class="row pl">
                                                        <div class="col-md-12 ">
                                                            <h4>{{$valor['poll']}}</h4>
                                                        </div>
                                                    </div>
                                                    <div class="grafico-circle">
                                                        <div id="chartdiv{{$product->product_id.$valor['poll_id']}}" style="width: 100%; height: 250px;" ></div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endforeach

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</section>
@stop

@section('report')
    <!-- Libreria AMCHART -->


        {{ HTML::script('lib/amcharts/amcharts.js'); }}
        {{ HTML::script('lib/amcharts/serial.js'); }}
        {{ HTML::script('lib/amcharts/pie.js'); }}

        {{ HTML::script('js/graficos/Bayer-chart.js'); }}

        <!-- // Libreria AMCHART creaGraficoColumnas(chartData2,"char3");	-->
<script>

    @foreach($ListProducts as $product)
        @foreach($valores[$product->product_id] as $valor)
            @if($valor['poll_id']<>109)
                var chartData0 = JSON.parse('{{$valor['grafico']}}');
                createGraphPie(chartData0,"chartdiv{{$product->product_id.$valor['poll_id']}}");
            @endif
        @endforeach
        @foreach($valores[$product->product_id] as $valor)
            @if(($valor['poll_id']<>108) and ($valor['poll_id']<>110))
                var chartData1 = JSON.parse('{{$valor['graficoOptions']}}');
                creaGraficoColumnas(chartData1,"chartdiv{{$product->product_id.$valor['poll_id']}}",false,null);
            @endif
        @endforeach
    @endforeach
//Activa cuadro de comparación de campaªna
    $( "#change" ).on( "click", function( event ) {
        event.preventDefault();
        $('#alertaCompara').show();
        $('#change').hide();
//            $("#alertaFiltro").toggleClass("show");

    });

    $('.close').click(function() {
        $("#alertaCompara").hide();
        $('#change').show();
    });

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