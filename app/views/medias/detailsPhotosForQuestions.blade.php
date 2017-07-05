@extends('layouts.adminLayout')
@section('content')
<section>
    @include('audits.partials.menuLeftAudit')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <!--sección titulo y buscador-->

            <div class="row pt pb">
                <div class="col-sm-12">
                    <div class="report-marco ">
                        <div class="contenedor-report">
                            <h4>Fotos de Preguntas</h4>
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

                    @if($city<>"0")
                        <div id="alertaFiltro" class="alert alert-info alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                                <strong>Filtrado por:</strong>
                        </div>
                    @endif
                    <div class="row">
                        <!--Filtros con combos-->
                        {{Form::hidden('company_id', $campaigne->id, ['id'=>'company_id','class' => 'form-control']);}}
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="cadenaF">Ciudad</label>
                                {{Form::select('ciudades', $ciudades, '0', ['id'=>'ciudad','class' => 'form-control']);}}

                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="product">Pregunta</label>
                                {{Form::select('preguntas', $preguntas, '0', ['id'=>'pregunta','class' => 'form-control']);}}
                            </div>
                        </div>

                        <div class="col-sm-1">
                            <div class="form-group">
                                <label for="rubro">&emsp;</label>
                                <button class="btn btn-default" onclick="getPDVs()">Filtrar</button>
                            </div>

                        </div>

                    <!-- Fin Filtros con combos-->

                    </div>
                    <div id="load"></div>
                    <div class="report-marco" id="pdvs">

                    </div>

                </div>
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
    $('#alertaFiltro').on('closed.bs.alert', function () {
        // do something…
        console.log("Cerrando alerta");
    })
</script>
        <script>
            var url_base =  "{{ URL::to('/') }}" ;
            var url = url_base + "/ajaxGetPdvsForPollWithPhotos" ;
            function getPDVs(){
                $("#pdvs").empty();
                var company_id = $('#company_id').val();
                var city_select = ciudad.options[ciudad.selectedIndex].text;
                var poll_id_select = pregunta.options[pregunta.selectedIndex].value;
                var product_id = 0;
                var publicity_id=0;
                var poll_option_id=0;
                var message = 'Problemas';
                var divLoading = 'load';
                var params = JSON.parse('{"company_id":"' + company_id + '","poll_id":"' + poll_id_select + '","city":"' + city_select + '","product_id":"' + product_id +'","publicity_id":"' + publicity_id +'","poll_option_id":"' + poll_option_id + '"}');
                //alert(city_select+" - "+poll_id_select);
                var loading= "<div class='" + divLoading +"'><img src='" + url_base +  "/img/loading.gif" + "' ></div>";

                $("#"+divLoading).html(loading);
                $.post(url , params,  function(data) {
                    console.log (data.toString());

                })
                        .done(function(data) {
                            // alert( "second success" );
                            console.log (data);

                            var html;
                            $.each(data, function(i, item){
                                //console.log (item.store_id);
                                html = "<div class=\"panel panel-default\">";
                                html = html + "<div class=\"panel-heading\">";
                                html = html + "<h3 class=\"panel-title\"><span class=\"badge\">" + i + "</span>" + item.store_id + " - " + item.fullname + "</h3>";
                                html = html + "</div>";
                                html = html + "<div class=\"panel-body\">";
                                html = html + "<div class=\"row\">";
                                html = html + "<div class=\"col-sm-4\">";
                                @if($customer->id==1)
                                        html = html + "<b>DIR: </b>" + item.codclient + "<br>";
                                @endif
                                html = html + "<b>DEPARTAMENTO: </b>" + item.departamento + "<br>";
                                html = html + "<b>PROVINCIA: </b>" + item.Provincia + "<br>";
                                html = html + "<b>DISTRITO: </b>" + item.distrito + "<br>";
                                html = html + "<b>FECHA: </b>" + item.fecha + "<br>";
                                html = html + "</div>";
                                html = html + "<div class=\"col-sm-4\">";
                                html = html + "<b>Respuesta: </b>" + item.responseSiNo.texto + "<br>";
                                html = html + "</div>";
                                html = html + "<div class=\"col-sm-4\">";
                                var arrayFotos = item.arrayFoto;
                                if ((arrayFotos.length)>0){
                                    $.each(arrayFotos, function(i, item1){
                                        html = html + "<a href='" + item1.urlFoto + "' class=\"zoom1 btn btn-default\" data-fancybox-group=\"button\">" + "<img src='" + item1.urlFoto + "' width=\"90px\" class=\"img-thumbnail\"></a>";
                                    });
                                }else{
                                    html = html + "No hay fotos";
                                }

                                html = html + "</div>";
                                html = html + "</div>";

                                $('#pdvs').append(html);
                            });

                        })
                        .fail(function() {
                            // alert( "error" );
                            $("#"+divLoading).html("<div class='" + divLoading +"'>" + message + "</div>");

                        })
                        .always(function() {
                            // alert( "finished" );
                            $("."+divLoading + " > img ").hide();
                        });
            }

        </script>
@endsection