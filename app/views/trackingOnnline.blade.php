@extends('layouts/adminFull')
@section('reportCSS')
    <style>

        .controles{
            padding: 15px 0;
        }


        .panel-derecho {
            z-index: 20;
            position: absolute;
            top: 28px;
            right: 0px;
            color: #FFF;
            /* padding: 5px; */
            height: 16px;
            width: 14px;
            cursor: pointer;
            /*background: #333 url("../img/arrow.png");*/
        }
        #tools {
            float: right;
            z-index: 10;
            position: absolute;
            top: 28px;
            right: 0px;
            background: #333;
            color: #FFF;
            padding: 20px;
            width: auto;
            opacity: .75;
            -moz-opacity: .75;
            filter: alpha(opacity=75);
            /* visibility: visible; */
        }
        #tools h1 {

            font-size: 18px;
        }

        .btn-print {

            background: #fff1f1;
            margin: 10px 0 10px 0;
            padding: 5px;
            text-decoration: none;
            color: #000000;
        }

        /* Z-index of #mask must lower than #boxes .window */

        #mask {
            position:absolute;
            z-index:9000;
            background-color:#000;
            display:none;
        }

        #boxes .window {
            position:fixed;
            width:440px;
            height:200px;
            display:none;
            z-index:9999;
            padding:20px;
        }

        /* Customize your modal window here, you can add background image too */
        #boxes #dialog {
            width: 375px;
            height: 203px;
            padding: 10px;
            background-color: #ffffff;
            margin: auto;
            top:125px;
            left: 0;
            right: 0;

        }
        #puntosEmpresa a  {

            color: #ffffff ;

        }
    </style>
@endsection
@section('content')
<section>
    <!-- Filtron HOme-->
    <div class="cuerpo">
        <div class="cuerpo-content">
            <div class="row">
                <div class="col-md-12">
                    <!--Filtros con combos-->
                    {{Form::open(['route' => 'trackingOnlineFilter', 'method' => 'POST', 'role' => 'form'])}}
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="auditor">Auditor</label>
                                    {{Form::select('auditor', $auditors, '0', ['id'=>'auditor','class' => 'form-control']);}}
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="rubro">&emsp;</label>
                                    <button class="btn btn-default" type="submit">Filtrar</button>
                                </div>
                            </div>
                        </div>
                    {{ Form::close() }}
                    <!-- Fin Filtros con combos-->
                </div>
            </div>
        </div>
    </div>
    <!-- Filtrotro end-->
    <!-- Section Map-->
    <div >
        <!--sección titulo y buscador-->
        <div class="row">
            <div class="col-sm-12">
                @if($auditor<>"0")
                    <!-- Section Map-->
                    <div >
                        <!--sección titulo y buscador-->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="contenedor">
                                    <div id="control" class="panel-derecho"></div>
                                    <div id="tools" style="visibility: visible;">
                                        <h1>PANEL DE CONTROL</h1>
                                        <div>
                                            <p style="border: 0; margin: 4px ; border-bottom: 1px dotted #ffffff">Usuario: <span id="usuarioName"></span></p>
                                        </div>

                                        <div>
                                            <p style="border: 0; margin: 4px ; border-bottom: 1px dotted #ffffff">Latitud Longitude
                                                <span id="lat"></span>
                                                <span id="lon"></span>
                                            </p>
                                        </div>

                                        <div>
                                            <p style="border: 0; margin: 4px ; border-bottom: 1px dotted #ffffff">Nº de PDVS: <span id="pdv"></span></p>
                                        </div>

                                        <div id="puntosEmpresa">

                                        </div>
                                        <!--<div>-->
                                        <!--<p style="border: 0; margin: 4px ; border-bottom: 1px dotted #ffffff">Selecionados: <span id="pdvSelected"></span></p>-->
                                        <!--</div>-->
                                        <!--<div id="tiendas"></div>-->
                                        <!--<div>-->
                                        <!--<button id="guardar" type="submit" class="btn btn-default">Guardar RUTA</button>-->
                                        <!--</div>-->
                                    </div>
                                    <!-- MAPA CANVAS -->
                                    <div id="map_canvas">
                                        <!-- css3 preLoading-->
                                        <div class="mapPerloading"> <span>Cargando</span>
                                            <span class="l-1"></span>
                                            <span class="l-2"></span>
                                            <span  class="l-3"></span>
                                            <span class="l-4"></span>
                                            <span class="l-5"></span>
                                            <span class="l-6"></span>
                                        </div>
                                    </div>
                                    <!-- END MAPA CANVAS -->
                                    <a href=""></a>



                                </div>
                            </div>

                        </div>

                    </div>
                    <!--end section map -->
                @endif

            </div>

        </div>

    </div>
    <!--end section map -->
</section>
@stop
@section('mapa')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7tL9pwWTxpywD6zMUDw32yaml7lr9oi4"></script>
    {{ HTML::script('lib/mapa/infobox.js'); }}
@if($auditor<>"0")
    <script>

        $('#usuarioName').html('{{$nameAuditor}}');
        $(document).ready(function() {
            $("#control").click(function () {  //This slides
                if($("#tools").css("visibility")=="visible"){
                    $("#tools").css("visibility","hidden");
                }else {

                    $("#tools").css("visibility","visible");
                }
            });
        });

        var _map;
        //var _geocoder;
        var _markers=[];
        var _infoBox;
        var countIBK=0,countBayer= 0,countAlicorp= 0,countAlicorpAASS=0, countKasnet=0 , countFullCarga=0, countBCP=0 ,countBIM=0;
        var url_base =  "{{ URL::to('/') }}" ;
        var dominio = url_base;
        var idReg = 0;

        // var marker;
        $(document).ready(function($) {
            function init () {
                setupMapa(jQuery('#map_canvas')[0]);
            }
            function setupMapa(div){
                // Carga los datos de las burbujas de un JSON externo
                //lib/mapa/burbujas.json
                $.post(dominio + '/getPhoneForUser' , { user_id : '{{$auditor}}' },  function(data) {

                })
                        .done(function(data) {
                            //
                            console.log(data.length);

                            _map= new google.maps.Map( div, {
                                        scrollwheel: true,
                                        zoom: 16,
                                        center: new google.maps.LatLng(data.objeto[0].latitud, data.objeto[0].longitud),
                                        disableDefaultUI: false,
                                        mapTypeId: google.maps.MapTypeId.ROADMAP
                                    }
                            );


                            populateMap(data.objeto);
                        })
                        .fail(function() {
                            //
                            console.log("Error");
                        })
                        .always(function() {
                            // alert( "finished" );
                            console.log("always");
                        });

            }

            //----------------------- ---
            // Rellena el mapa de burbujitas con los datos del json
            function populateMap(data){

                var total_puntos = 0;
                $.each(data, function(i, item){
                    // console.log(item);

                    total_puntos ++;
                    var icono_store;
                    icono_store='img/icons/maker_gps.png';
                    var marker = new google.maps.Marker({
                        id 		:i,
                        clickable 	:true,
                        draggable:true,
                        position  	:new google.maps.LatLng(item.latitud, item.longitud),
                        animation 	:google.maps.Animation.DROP,
                        icon      	:icono_store,
                        origin 		:(18, 38),   // Desfase del png de la burbuja con respecto al punto
                        map      	:_map
                    });

                    moveMarker(  marker );
                    // Escucho los eventos de raton sobre las burbujas
                    //if(item.status=="true") {
                    google.maps.event.addListener(marker, 'click', function() {
                        openInfoBox(marker, item, icono_store);
                    });

                    google.maps.event.addListener(marker, 'dragend', function() {
                        openInfoBox(marker, item, icono_store);
                    });

                    google.maps.event.addListener(marker, 'drag', function() {
                        //updateMarkerStatus('Dragging...');
                        updateMarkerPosition(marker.getPosition());
                    });
                    _markers[i] = marker;

                });

                function moveMarker( marker ) {

                    setInterval( function () {
                        refreshMarker(marker)
                    } , 25000 );

                };

                function refreshMarker(marker){

                    $.post(dominio + '/getPhoneForUser' , { user_id : '{{$auditor}}' },  function(data) {

                    })
                            .done(function(data) {
                                //
                                marker.setPosition( new google.maps.LatLng(data.objeto[0].latitud , data.objeto[0].longitud) );
                                _map.panTo( new google.maps.LatLng(data.objeto[0].latitud , data.objeto[0].longitud) );  // Centra el mapa a la nueva posición del latidud y longitud

                            })
                            .fail(function() {
                                //
                                console.log("Error");
                            })
                            .always(function() {
                                // alert( "finished" );
                                console.log("always");
                            });

                }

                function updateMarkerPosition(latLng) {
                    document.getElementById('lat').innerHTML = [
                        latLng.lat(),
                        latLng.lng()
                    ].join(', ');

                }

                function updateMarkerStatus(str) {
                    document.getElementById('markerStatus').innerHTML = str;
                }

                function updateMarkerAddress(str) {

                    document.getElementById('address').innerHTML = str;
                }

                // Abre la ventana de info cuando se hace click sobre una burbuja
                function openInfoBox(marker, item,icono) {
                    _map.panTo(marker.position);
                    var myOptions = {
                        // content 			:createInfoboxHtml(item.cadenaRuc,item.tipo,item.codclient, item.fullname, item.departamento, item.address, item.referencia, item.district ,item.id, item.company_id)
                        content 			:createInfoboxHtml(item.phone,item.sdk,item.updated_at)
                        ,alignBottom 			:true
                        ,disableAutoPan 		:false
                        ,maxWidth 			:0
                        ,pixelOffset 			:new google.maps.Size(-114, -55) // Desfase del cartel con respecto a la burbuja
                        ,zIndex 			:null
                        ,closeBoxURL 			:""
                        ,infoBoxClearance 		:new google.maps.Size(0, 60) // margen superior del cartel con el borde superior del mapa
                        ,isHidden 			:false
                        ,pane 				:"floatPane"
                        ,enableEventPropagation 	:false
                        ,zoom					:15

                    };

                    // Si ya hay un infoBox abierto lo cierro
                    if(_infoBox){
                        _infoBox.close();
                    }
                    _infoBox = new InfoBox(myOptions);
                    // Escucho el evento para poder cerrar la ventana de info
                    google.maps.event.addListener(_infoBox, 'domready', function() {
                        jQuery('.IFclose', '.infoBox').unbind('click', closeInfoBox);
                        jQuery('.IFclose', '.infoBox').bind('click', closeInfoBox);


                    });
                    //console.log(item);
                    _infoBox.open(_map, marker);
                }

                // Devuelve el HTML de la cartela de informacion de la burbuja
                //createInfoboxHtml(item.fullname, item.address, item.urbanization, item.district ,item.id)
                function createInfoboxHtml(phone,sdk,fecha) {
                    var boxText = document.createElement("div");

                    boxText.innerHTML = "<div class='IFcontainer'>"+
                            "<a href='#' class='IFclose'></a>"+
                            "<div id='IFtitleBox'>Telefono: "  + phone + "</div>"+
                            "<div class='contenido'>Android Versión : "+ sdk + "</div>"+
                            "<div class='contenido'>Fecha: "+ fecha + "</div>"+
                            "<div class='IFcorner'></div>"+
                            "</div>";
                    return boxText;
                }
                // Cierra la ventana de info
                function closeInfoBox(e){
                    e.preventDefault();
                    _infoBox.close();
                }

            }

            //Create new markers y añadiendo al mapa
            setInterval( function () {
                getNewMarker()
            } , 25000 );

            function getNewMarker(){

                $.post(dominio + '/getJsonLastDayControlTime',{ auditor : '{{$auditor}}' , id : idReg},  function(data) {
                })
                        .done(function(data) {
                            //
                            pupulateNewMarker(data);
                        })
                        .fail(function() {
                            //
                            console.log("Error");
                        })
                        .always(function() {
                            // alert( "finished" );
                            console.log("always");
                        });
            }

            function pupulateNewMarker(data){

                var total_puntos = 0;
                $.each(data, function(i, item){
                    // console.log(item);
                    idReg = item.id;
                    total_puntos ++;
                    var icono_store;
                    icono_store='img/icons/maker_store.png';
                    icono_store_open='img/icons/maker_store_open.png';
                    icono_store_close='img/icons/maker_store_close.png';

                    var marker = new google.maps.Marker({
                        id 		:i,
                        clickable 	:true,
                        position  	:new google.maps.LatLng(item.latitude_store, item.longitude_store),
                        animation 	:google.maps.Animation.DROP,
                        icon      	:icono_store,
                        origin 		:(18, 38),   // Desfase del png de la burbuja con respecto al punto
                        map      	:_map
                    });

                    var marker_open = new google.maps.Marker({
                        id 		:i,
                        clickable 	:true,
                        position  	:new google.maps.LatLng(item.latitude_open, item.longitude_open),
                        animation 	:google.maps.Animation.DROP,
                        icon      	:icono_store_open,
                        origin 		:(18, 38),   // Desfase del png de la burbuja con respecto al punto
                        map      	:_map
                    });
                    var marker_close = new google.maps.Marker({
                        id 		:i,
                        clickable 	:true,
                        position  	:new google.maps.LatLng(item.latitude_close, item.longitude_close),
                        animation 	:google.maps.Animation.DROP,
                        icon      	:icono_store_close,
                        origin 		:(18, 38),   // Desfase del png de la burbuja con respecto al punto
                        map      	:_map
                    });
                    // Escucho los eventos de raton sobre las burbujas
                    //if(item.status=="true") {
                    google.maps.event.addListener(marker, 'click', function() {
                        openInfoBox(marker, item, icono_store);
                    });
                    google.maps.event.addListener(marker_open, 'click', function() {
                        openInfoBox(marker_open, item, icono_store_open);
                    });
                    google.maps.event.addListener(marker_close, 'click', function() {
                        openInfoBox(marker_close, item, icono_store_close);
                    });
                    createListStore(marker,marker_open,marker_close, item, icono_store_close);
                    //openInfoBox(marker, item);
                    // }
                    // Escucho los eventos de raton sobre las burbujas
                    _markers[i] = marker;
                });
                $('#pdv').html(total_puntos);

                // Abre la ventana de info cuando se hace click sobre una burbuja
                function openInfoBox(marker, item,icono) {
                    _map.panTo(marker.position);
                    var myOptions = {
                        // content 			:createInfoboxHtml(item.cadenaRuc,item.tipo,item.codclient, item.fullname, item.departamento, item.address, item.referencia, item.district ,item.id, item.company_id)
                        content 			:createInfoboxHtml(item.fullname,item.store_id, item.time_open,item.time_close)
                        ,alignBottom 			:true
                        ,disableAutoPan 		:false
                        ,maxWidth 			:0
                        ,pixelOffset 			:new google.maps.Size(-114, -55) // Desfase del cartel con respecto a la burbuja
                        ,zIndex 			:null
                        ,closeBoxURL 			:""
                        ,infoBoxClearance 		:new google.maps.Size(0, 60) // margen superior del cartel con el borde superior del mapa
                        ,isHidden 			:false
                        ,pane 				:"floatPane"
                        ,enableEventPropagation 	:false
                        ,zoom					:15
                    };

                    // Si ya hay un infoBox abierto lo cierro
                    if(_infoBox){
                        _infoBox.close();
                    }
                    _infoBox = new InfoBox(myOptions);
                    // Escucho el evento para poder cerrar la ventana de info
                    google.maps.event.addListener(_infoBox, 'domready', function() {
                        jQuery('.IFclose', '.infoBox').unbind('click', closeInfoBox);
                        jQuery('.IFclose', '.infoBox').bind('click', closeInfoBox);


                    });
                    //console.log(item);
                    _infoBox.open(_map, marker);
                }

                // Devuelve el HTML de la cartela de informacion de la burbuja
                //createInfoboxHtml(item.fullname, item.address, item.urbanization, item.district ,item.id)
                function createInfoboxHtml(fullname, id,time_open,time_close) {
                    var boxText = document.createElement("div");
                    var textCadena = "";
                    boxText.innerHTML = "<div class='IFcontainer'>"+
                            "<a href='#' class='IFclose'></a>"+
                            "<div id='IFtitleBox'>" +  fullname + "(" + id + ")" + "</div>"+
                            "<div class='contenido'>Fecha/Hora Apertura: "+ time_open + "</div>"+
                            "<div class='contenido'>Fecha/Hora Cierre: "+ time_close + "</div>"+
                            "<div class='IFcorner'></div>"+
                            "</div>";
                    return boxText;
                }

                function createListStore(marker,marker_open,marker_close , item,icono) {

                    //var strHtml = "";
                    strHtml = "<label class='checkbox-inline '><input id='store_" +  item.store_id  + "' type='checkbox'  checked='checked' id='inlineCheckbox1' value='option1'>" + item.fullname + " </label>";
                    strAnimation= "<a class='store_"+ item.store_id +" btn btn-info btn-xs' href='#' > <span class='glyphicon glyphicon-repeat' aria-hidden='true'></span>  </a>" ;
                    strStore= "<a class='store__"+ item.store_id +" ' href='#' >  <img src='img/icons/maker_store.png' height='38' alt=''/>  </a>" ;
                    strOpen= "<a class='store_open"+ item.store_id +" ' href='#' >   <img src='img/icons/maker_store_open.png' height='38' alt=''/>  </a>" ;
                    strClose= "<a class='store_close"+ item.store_id +" ' href='#' >  <img src='img/icons/maker_store_close.png' height='38' alt=''/>  </a>" ;

                    $('#puntosEmpresa').append("<p >" + strHtml + strAnimation  + strStore +  strOpen +  strClose +"</p>");

                    $(".store_"+item.store_id).on('click',function(e){
                        e.preventDefault();
//                        if (!marker.getVisible()) {
//                            marker.setVisible(true);
//                        } else {
//                            marker.setVisible(false);
//                        }
//                        console.log(marker);

                        marker.setAnimation(google.maps.Animation.BOUNCE);
                        marker_open.setAnimation(google.maps.Animation.BOUNCE);
                        marker_close.setAnimation(google.maps.Animation.BOUNCE);
                        setTimeout(function(){ marker.setAnimation(null); }, 1500);
                        setTimeout(function(){ marker_open.setAnimation(null); }, 1500);
                        setTimeout(function(){ marker_close.setAnimation(null); }, 1500);

                    });

                    $("#store_"+item.store_id).click(function(){
                        if($(this).is(':checked')){
                            marker.setVisible(true);
                            marker_open.setVisible(true);
                            marker_close.setVisible(true);
                        }else{
                            marker.setVisible(false);
                            marker_open.setVisible(false);
                            marker_close.setVisible(false);
                        }
                    });


                    $(".store__"+item.store_id).on('click',function(e){
                        e.preventDefault();
                        if (!marker.getVisible())   marker.setVisible(true); else  marker.setVisible(false);
                    });

                    $(".store_open"+item.store_id).on('click',function(e){
                        e.preventDefault();
                        if (!marker_open.getVisible())   marker_open.setVisible(true); else  marker_open.setVisible(false);
                    });

                    $(".store_close"+item.store_id).on('click',function(e){
                        e.preventDefault();
                        if (!marker_close.getVisible())   marker_close.setVisible(true); else  marker_close.setVisible(false);
                    });

                }

                // Cierra la ventana de info
                function closeInfoBox(e){
                    e.preventDefault();
                    _infoBox.close();
                }

            }
            init();
        });


        //select all the a tag with name equal to modal
        $('#guardar').click(function(e) {
            //Cancel the link behavior
            e.preventDefault();
            //Get the A tag
            var id = $(this).attr('href');

            //Get the screen height and width
            var maskHeight = $(document).height();
            var maskWidth = $(window).width();

            //Set height and width to mask to fill up the whole screen
            $('#mask').css({'width':maskWidth,'height':maskHeight});

            //transition effect
            $('#mask').fadeIn(1000);
            $('#mask').fadeTo("slow",0.8);

            //Get the window height and width
            var winH = $(window).height();
            var winW = $(window).width();

            //Set the popup window to center
            $(id).css('top',  winH/2-$(id).height()/2);
            $(id).css('left', winW/2-$(id).width()/2);

            //transition effect
            $(id).fadeIn(2000);
            $('.window').show();
        });

        //if close button is clicked
        $('.window .close').click(function (e) {
            //Cancel the link behavior
            e.preventDefault();
            $('#mask, .window').hide();
        });

        //if mask is clicked
        $('#mask').click(function () {
            $(this).hide();
            $('.window').hide();
        });
    </script>
@endif

@endsection