@extends('layouts/clienteBayer')
@section('content')
<section>
    @include('report/partials/menuPrincipalBayer')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <!--sección titulo y buscador-->
            <div class="row pt pb">
                <div class="col-sm-9">
                    <h4 class="report-title">
                        @if($subopcion=='Tradicional')
                            Marca Tradicional
                        @endif
                        @if($subopcion=='Moderno')
                            Marca Moderno
                        @endif
                        {{$titulo}}</h4>

                    @if(($ubigeoextLink<>"0") or ($cadenaLink<>"0") or ($ejecutivo<>"0") or ($horizontalLink<>"0"))
                        <div id="alertaFiltro" class="alert alert-info alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <strong>Filtrado por:</strong>
                            @if($ubigeoextLink<>'0')
                                Departamento(s) {{$ubigeoextLink}}
                            @endif

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
                </div>
                <div class="col-sm-3">
                    <img src="{{$logo}}" width="100px">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">

                    @section('Mensajes')

                    @endsection

                    <div class="row">
                        <!--Filtros con combos-->
                        {{Form::open(['route' => 'auditsBayerFilter', 'method' => 'POST', 'role' => 'form'], $audit_id)}}
                        @if(count($ListCadenas)>0)
                            <div class="col-sm-3">
                        @else
                            <div class="col-sm-4">
                        @endif
                            <div class="form-group">
                                {{ Form::hidden('audit_id', $audit_id) }}
                                {{ Form::hidden('company_id', $company_id) }}
                                {{ Form::hidden('ejecutivo', '0') }}
                                {{ Form::hidden('subopcion', $subopcion) }}
                                @if((count($ListHorizontales)>0) or (count($ListCadenas)>0))
                                    <label for="ubigeo">Departamento</label>
                                    {{ Form::hidden('ubigeo', "0") }}
                                    @foreach($ListUbigeos as $ubigeo)
                                        <div class="checkbox">
                                            <label>
                                                @if(is_array($ubigeoext))
                                                    @if(in_array($ubigeo,$ubigeoext))
                                                        {{Form::checkbox('ubigeo[]', $ubigeo,true, ['class' => 'checkbox1']);}} {{$ubigeo}}
                                                    @else
                                                        {{Form::checkbox('ubigeo[]', $ubigeo,null, ['class' => 'checkbox1']);}} {{$ubigeo}}
                                                    @endif
                                                @else
                                                    {{Form::checkbox('ubigeo[]', $ubigeo,null, ['class' => 'checkbox1']);}} {{$ubigeo}}
                                                @endif
                                            </label>
                                        </div>
                                    @endforeach
                                @endif

                            </div>
                        </div>
                        @if(count($ListCadenas)>0)
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="cadena">Cadenas</label>
                                    {{ Form::hidden('cadena', "0") }}
                                    @foreach($ListCadenas as $cadena1)
                                        <div class="checkbox">
                                            <label>
                                                @if(is_array($cadena))
                                                    @if(in_array($cadena1,$cadena))
                                                        {{Form::checkbox('cadena[]', $cadena1,true, ['class' => 'checkbox1']);}} {{$cadena1}}
                                                    @else
                                                        {{Form::checkbox('cadena[]', $cadena1,null, ['class' => 'checkbox1']);}} {{$cadena1}}
                                                    @endif
                                                @else
                                                    {{Form::checkbox('cadena[]', $cadena1,null, ['class' => 'checkbox1']);}} {{$cadena1}}
                                                @endif
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            {{ Form::hidden('cadena', "0") }}
                        @endif

                        @if(count($ListCadenas)>0)
                            <div class="col-sm-3">
                        @else
                            <div class="col-sm-4">
                        @endif
                            <div class="form-group">
                                @if(count($ListHorizontales)>0)
                                    <label for="cadena">Horizontales</label>
                                    {{ Form::hidden('horizontal', "0") }}
                                    @foreach($ListHorizontales as $cadena2)
                                        <div class="checkbox">
                                            <label>
                                                @if(is_array($horizontal))
                                                    @if(in_array($cadena2,$horizontal))
                                                        {{Form::checkbox('horizontal[]', $cadena2,true, ['class' => 'checkbox1']);}} {{$cadena2}}
                                                    @else
                                                        {{Form::checkbox('horizontal[]', $cadena2,null, ['class' => 'checkbox1']);}} {{$cadena2}}
                                                    @endif
                                                @else
                                                    {{Form::checkbox('horizontal[]', $cadena2,null, ['class' => 'checkbox1']);}} {{$cadena2}}
                                                @endif

                                            </label>
                                        </div>
                                    @endforeach
                                @else
                                    {{ Form::hidden('horizontal', "0") }}
                                @endif


                            </div>
                        </div>
                        @if((count($ListHorizontales)>0) or (count($ListCadenas)>0))
                            <div class="col-sm-1">
                                <div class="form-group">
                                    <label for="rubro">&emsp;</label>
                                    <button class="btn btn-default" type="submit">Filtrar</button>
                                </div>

                            </div>
                        @endif

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
                                                <div class="col-md-12 ">
                                                    <img src="{{$urlProducts.$product->product->imagen}}" width="300px">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    @foreach($valores[$product->product_id] as $valor)
                                        @if($valor['poll_id']<>$valPolls[$company_id]['queRecomendo'])
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
                                                    @if((count($ListHorizontales)>0) or (count($ListCadenas)>0))
                                                        @if($valor['poll_id']==$valPolls[$company_id]['tieneStock'])
                                                            <div>
                                                                <a href="{{route('getDetailQuestionBayer', $valPolls[$company_id]['tieneStock']."/".$valCiudad."-0-0-0-".$horizontalLink."/".$company_id."/0/".$product->product_id)}}" class="btn btn-primary btn-sm active" role="button">Ver sin Stock</a>
                                                            </div>
                                                        @endif
                                                    @endif

                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    @foreach($valores[$product->product_id] as $valor)
                                        @if(($valor['poll_id']<>$valPolls[$company_id]['seRecomendo']) and ($valor['poll_id']<>$valPolls[$company_id]['tieneStock']))
                                                {{Form::hidden('poll_id'.$product->product_id.$valor['poll_id'], $valor['poll_id'], ['id'=>'poll_id'.$product->product_id.$valor['poll_id']]);}}
                                                {{Form::hidden('totalAbiertos'.$product->product_id.$valor['poll_id'], $totalAbiertos, ['id'=>'totalAbiertos'.$product->product_id.$valor['poll_id']]);}}
                                                {{Form::hidden('product_id'.$product->product_id.$valor['poll_id'], $product->product_id, ['id'=>'product_id'.$product->product_id.$valor['poll_id']]);}}
                                                {{Form::hidden('ejecutivo'.$product->product_id.$valor['poll_id'], $ejecutivo, ['id'=>'ejecutivo'.$product->product_id.$valor['poll_id']]);}}
                                                {{Form::hidden('ubigeoext'.$product->product_id.$valor['poll_id'], $ubigeoextLink, ['id'=>'ubigeoext'.$product->product_id.$valor['poll_id']]);}}
                                                {{Form::hidden('cadena'.$product->product_id.$valor['poll_id'], $cadenaLink, ['id'=>'cadena'.$product->product_id.$valor['poll_id']]);}}
                                                {{Form::hidden('horizontal'.$product->product_id.$valor['poll_id'], $horizontalLink, ['id'=>'horizontal'.$product->product_id.$valor['poll_id']]);}}
                                                {{Form::hidden('company_id'.$product->product_id.$valor['poll_id'], $company_id, ['id'=>'company_id'.$product->product_id.$valor['poll_id']]);}}
                                            <div class="col-md-12 pb">
                                                <div class="report-marco ">
                                                    <div class="row pl">
                                                        <div class="col-md-12 ">
                                                            <h4>{{$valor['poll']}}</h4>
                                                        </div>
                                                    </div>
                                                    <div class="grafico-circle">
                                                        <div id="{{'load'.$product->product_id.$valor['poll_id']}}"></div>
                                                        <div id="{{'chartdiv'.$product->product_id.$valor['poll_id']}}" style="width: 100%; height: 300px;" ></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 pb">
                                                <div class="report-marco ">
                                                    <div class="row pl">
                                                        <div class="col-md-12 ">
                                                            <h4>Prioridades</h4>
                                                        </div>
                                                    </div>
                                                    <div class="grafico-circle">
                                                        <div id="{{'load1'.$product->product_id.$valor['poll_id']}}"></div>
                                                        <div id="{{'chartdivPrio'.$product->product_id.$valor['poll_id']}}" style="width: 100%; height: 300px;" ></div>
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
    {{ HTML::script('js/ajaxJsonFunction.js'); }}

        <!-- // Libreria AMCHART creaGraficoColumnas(chartData2,"char3");	-->
<script>
    var url_base =  "{{ URL::to('/') }}" ;

    var url = url_base + "/ajaxGetResultQuestion" ;
    @if((count($ListHorizontales)>0) or (count($ListCadenas)>0))
        @foreach($ListProducts as $product)
            @foreach($valores[$product->product_id] as $valor)
                @if($valor['poll_id']<>$valPolls[$company_id]['queRecomendo'])
                    var chartData0 = JSON.parse('{{$valor['grafico']}}');
                    createGraphPie(chartData0,"chartdiv{{$product->product_id.$valor['poll_id']}}");
                @endif
            @endforeach
            @foreach($valores[$product->product_id] as $valor)
                @if(($valor['poll_id']<>$valPolls[$company_id]['seRecomendo']) and ($valor['poll_id']<>$valPolls[$company_id]['tieneStock']))
                    var poll_id = $('{{'#poll_id'.$product->product_id.$valor['poll_id']}}').val();
                    var totalAbiertos = $('{{'#totalAbiertos'.$product->product_id.$valor['poll_id']}}').val();
                    var product_id = $('{{'#product_id'.$product->product_id.$valor['poll_id']}}').val();
                    var ejecutivo = $('{{'#ejecutivo'.$product->product_id.$valor['poll_id']}}').val();
                    var ubigeoext = $('{{'#ubigeoext'.$product->product_id.$valor['poll_id']}}').val();
                    var cadena = $('{{'#cadena'.$product->product_id.$valor['poll_id']}}').val();
                    var horizontal = $('{{'#horizontal'.$product->product_id.$valor['poll_id']}}').val();
                    var company_id = $('{{'#company_id'.$product->product_id.$valor['poll_id']}}').val();

                    var params = JSON.parse('{"poll_id":"' + poll_id + '","totalAbiertos":"' + totalAbiertos + '","product_id":"' + product_id + '","ejecutivo":"' + ejecutivo + '","ubigeoext":"' + ubigeoext + '","cadena":"' + cadena + '","priority":"0","company_id":"' + company_id+ '","horizontal":"' + horizontal+ '"}');
                    ajaxJson(url_base,url,params,creaGraficoColumnas,"{{'chartdiv'.$product->product_id.$valor['poll_id']}}","{{'load'.$product->product_id.$valor['poll_id']}}","No hay datos");

                    var params = JSON.parse('{"poll_id":"' + poll_id + '","totalAbiertos":"' + totalAbiertos + '","product_id":"' + product_id + '","ejecutivo":"' + ejecutivo + '","ubigeoext":"' + ubigeoext + '","cadena":"' + cadena + '","priority":"1","company_id":"' + company_id+ '","horizontal":"' + horizontal+ '"}');
                    ajaxJson(url_base,url,params,creaGraficoColumnasPorcentajesDinamic,"{{'chartdivPrio'.$product->product_id.$valor['poll_id']}}","{{'load1'.$product->product_id.$valor['poll_id']}}","No hay datos");

                @endif
            @endforeach
        @endforeach
    @endif

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
            var url= "{{ $urlBase }}" + valor.value + "{{ "/".$subopcion }}";
            var win = window.open(url, '_blank');
            win.focus();
        }
    }
</script>


@endsection