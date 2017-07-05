<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="css/stylesheet.css"/>
    <link rel="stylesheet" href="css/mapa-styles.css"/>
    <style>
        /* Z-index of #mask must lower than #boxes .window */
        p{
            margin: 2px;
        }
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
    </style>
</head>
<body>
<div class="contenedor">
    <div id="boxes">
        <!-- #customize your modal window here -->
        <div id="dialog" class="window">
            <b>Ingrese Nombre de la Ruta</b> |
            <!-- close button is defined as close class -->
            <!--                <a href="#" class="close">Close it</a>-->

            <input type="text" id="name_ruta" ><br>
            <p id="mensaje" style="color: red ; font-weight: bold"></p>
            <button type="button" id="guarda_ruta">GUARDAR RUTA</button>
        </div>
        <!-- Do not remove div#mask, because you'll need it to fill the whole screen -->
        <div id="mask">
            </div>
    </div>

    <div id="control" class="panel-derecho"></div>
    <div id="tools" style="visibility: visible;">
        <h1>PANEL DE CONTROL</h1>
        <div>
            <p style="border: 0; margin: 4px ; border-bottom: 1px dotted #ffffff">Usuario: <span id="usuarioName"></span></p>
        </div>
        <div>
            <p style="border: 0; margin: 4px ; border-bottom: 1px dotted #ffffff">Nº de PDVS: <span id="pdv"></span></p>
        </div>

        <div id="puntosEmpresa">

        </div>
        <div>
            <p style="border: 0; margin: 4px ; border-bottom: 1px dotted #ffffff">Selecionados: <span id="pdvSelected"></span></p>
        </div>
        <div id="tiendas"></div>
        <div>
            <button id="guardar" type="submit" class="btn btn-default">Guardar RUTA</button>
        </div>
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





<script type="text/javascript" src="lib/jquery.js"></script>
<!-- google maps -->
<!--<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>-->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7tL9pwWTxpywD6zMUDw32yaml7lr9oi4"></script>
<script type="text/javascript" src="lib/mapa/infobox.js"></script>


<script>

    $('#usuarioName').html('<?php echo $_GET['user'] ?>');
    $(document).ready(function() {
        // var $elem = $("#contenido");
        //var docwidth =  $(document).width();
        //var inileft = docwidth - $elem.outerWidth();
        //$elem.css("left", inileft);  //Position element tho the right
        $("#control").click(function () {  //This slides
            //alert("hola");
            // $elem.animate({
            //   left: (parseInt($elem.css("left"), 10) >= docwidth ?  inileft : docwidth)

            // });
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
    var _markersCompany=[];
    var _infoBox;
    var countIBK=0,countRiqra=0,countBayer= 0,countBayerV= 0,countAlicorp= 0,countAlicorpHulk= 0,countAlicorpAASS=0, countAlicorpClientes=0,countKasnet=0 , countFullCarga=0, countBCP=0 ,countBIM=0;
    var dominio = "http://ttaudit.com";
   //var dominio = "http://appfiliaibk.com/";
   // var dominio = "http://localhost/ttaudit.com/backend/ttaudit1/public";


   // var marker;
    $(document).ready(function($) {


        function init () {
            setupMapa(jQuery('#map_canvas')[0]);
        }
        function setupMapa(div){
            // Carga los datos de las burbujas de un JSON externo

            //lib/mapa/burbujas.json
           $.post(dominio + '/getPointStoresForCompanyDepartament',{ departament : "<?php echo $_GET['departament'] ?>" }, function(json){

                //if (item.latitud != 0 && item.longitud != 0){
                console.log(json.length);
               if(json.length==0){
                   _map= new google.maps.Map( div, {
                           scrollwheel: true,
                           zoom: 14,
                           center: new google.maps.LatLng('-12.046612','-77.042096'),
                           disableDefaultUI: false,
                           mapTypeId: google.maps.MapTypeId.ROADMAP
                       }
                   );
                   $('#guardar').css({'display':'none'});

               } else {
                   _map= new google.maps.Map( div, {
                           scrollwheel: true,
                           zoom: 14,
                           center: new google.maps.LatLng(json[0].latitud, json[0].longitud),
                           disableDefaultUI: false,
                           mapTypeId: google.maps.MapTypeId.ROADMAP
                       }
                   );

               }
//                _map= new google.maps.Map( div, {
//                        scrollwheel: true,
//                        zoom: 14,
//                        center: new google.maps.LatLng(json[0].latitud, json[0].longitud),
//                        disableDefaultUI: false,
//                        mapTypeId: google.maps.MapTypeId.ROADMAP
//                    }
//                );
                populateMap(json);
            });
        }
        //----------------------- ---
        // Rellena el mapa de burbujitas con los datos del json
        function populateMap(data){

            var total_puntos = 0;
            $.each(data, function(i, item){
                valor = item.latitud + item.longitud ;
                console.log(item);


                total_puntos ++;
                var icono;

                 if(item.customer_id ==1) {

                     if(item.company_id==23){
                         countKasnet ++;
                         icono='img/maker_kasnet.png'
                     }else if (item.company_id==24) {
                         countFullCarga ++;
                         icono='img/maker_full_carga.png'

                     }else if (item.company_id==25) {
                         countBCP ++;
                         icono='img/maker_bcp.png'

                     } else {
                         icono='img/maker_interbank.png';
                         countIBK ++;
                     }

                    //icono = google.maps.SymbolPath.CIRCLE;
                 } else if (item.customer_id ==5 ) {

                     if(item.company_id==77){
                         countBayerV ++;
                         icono='img/ic_marker_bayer_v.png'
                     }else {
                         countBayer ++;
                         icono='img/maker_bayer.png'
                     }

                 } else if (item.customer_id ==4 ) {
                     if(item.company_id==15){
                         countAlicorpAASS ++;
                         icono='img/maker_alicorp_aass.png'
                     } else if(item.company_id==48 ){
                         countAlicorpClientes ++;
                         icono='img/maker_alicorp_cliente.png'
                     } else if(item.company_id==62 ){
                         countAlicorpHulk ++;
                         icono='img/ic_marker_alicorp_h.png'

                     }else {
                         countAlicorp ++;
                         icono='img/maker_alicorp.png'
                     }
                 } else if (item.customer_id == 7 ) {
                     countBIM ++;
                     icono='img/maker_bim.png'

                 } else if (item.customer_id == 10 ) {
                    countRiqra ++;
                    icono='img/ic_marker_riqra.png'
                 }

                var marker = new google.maps.Marker({
                    id 		:i,
                    clickable 	:true,
                    position  	:new google.maps.LatLng(item.latitud, item.longitud),
                    animation 	:google.maps.Animation.DROP,
                    icon      	:icono,
                    origin 		:(18, 38),   // Desfase del png de la burbuja con respecto al punto
                    map      	:_map
                });
                // Escucho los eventos de raton sobre las burbujas
                //if(item.status=="true") {
                google.maps.event.addListener(marker, 'click', function() {
                    openInfoBox(marker, item, icono);
                });
                //openInfoBox(marker, item);
                // }

               // _markersCompany[i] = [marker,item.customer_id];
                _markersCompany[i] = [marker,item.customer_id];
               // selectShowHidenMarker(_markersCompany);
                // Escucho los eventos de raton sobre las burbujas
                _markers[i] = marker;

            });

            // Añadiendo cantidad total de stores por Company
            if(countAlicorp > 0) $('#puntosEmpresa').append('<p><input class="customer_id" type="checkbox"  checked="checked"  value="4"><img src="img/maker_alicorp.png"  > ' + countAlicorp +' PDVS </p>')
            if(countIBK > 0) $('#puntosEmpresa').append('<p><input class="customer_id" type="checkbox"  checked="checked"  value="1"><img src="img/maker_interbank.png"  > ' + countIBK +' PDVS </p>')
            if(countRiqra > 0) $('#puntosEmpresa').append('<p><input class="customer_id" type="checkbox"  checked="checked"  value="1"><img src="img/ic_marker_riqra.png"  > ' + countRiqra +' PDVS </p>')
            if(countKasnet > 0) $('#puntosEmpresa').append('<p><input class="customer_id" type="checkbox"  checked="checked"  value="1"><img src="img/maker_kasnet.png"  > ' + countKasnet +' PDVS </p>')
            if(countFullCarga > 0) $('#puntosEmpresa').append('<p><input class="customer_id" type="checkbox"  checked="checked"  value="1"><img src="img/maker_full_carga.png"  > ' + countFullCarga +' PDVS </p>')
            if(countBCP > 0) $('#puntosEmpresa').append('<p><input class="customer_id" type="checkbox"  checked="checked"  value="1"><img src="img/maker_bcp.png"  > ' + countBCP +' PDVS </p>')
            if(countAlicorpAASS > 0) $('#puntosEmpresa').append('<p><input class="customer_id" type="checkbox"  checked="checked"  value="4"><img src="img/maker_alicorp_aass.png"  > ' + countAlicorpAASS +' PDVS</p>')
            if(countAlicorpHulk > 0) $('#puntosEmpresa').append('<p><input class="customer_id" type="checkbox"  checked="checked"  value="4"><img src="img/ic_marker_alicorp_h.png"  > ' + countAlicorpHulk +' PDVS</p>')
            if(countAlicorpClientes > 0) $('#puntosEmpresa').append('<p><input class="customer_id" type="checkbox"  checked="checked"  value="4"><img src="img/maker_alicorp_cliente.png"  > ' + countAlicorpClientes +' PDVS</p>')
            if(countBayer > 0) $('#puntosEmpresa').append('<p><input class="customer_id" type="checkbox"  checked="checked"  value="5" ><img src="img/maker_bayer.png"  > ' + countBayer +' PDVS</p>')
            if(countBayerV > 0) $('#puntosEmpresa').append('<p><input class="customer_id" type="checkbox"  checked="checked"  value="5" ><img src="img/ic_marker_bayer_v.png"  > ' + countBayerV +' PDVS</p>')
            if(countBIM > 0) $('#puntosEmpresa').append('<p><input class="customer_id" type="checkbox"  checked="checked"  value="7" ><img src="img/maker_bim.png"  > ' + countBIM +' PDVS</p>')




            $('#pdv').html(total_puntos);

//            function selectShowHidenMarker (marker) {
//                console.log(marker);
//
//                $.each(marker, function(i, item){
//
//
//
//                });
//            }

            // Abre la ventana de info cuando se hace click sobre una burbuja
            function openInfoBox(marker, item,icono) {
                _map.panTo(marker.position);
                var myOptions = {
                   // content 			:createInfoboxHtml(item.cadenaRuc,item.tipo,item.codclient, item.fullname, item.departamento, item.address, item.referencia, item.district ,item.id, item.company_id)
                    content 			:createInfoboxHtml(item.cadenaRuc,item.tipo,item.codclient, item.fullname, item.departamento, item.address, item.referencia, item.district ,item.id, item.company_id,item.campaigne)
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
                    $('#add').unbind('click', addPDV(marker,icono));
                    $('#add').bind('click', addPDV(marker,icono));
                    //marker.icon="img/delete.png";
                    //$('.IFclose', '.infoBox').bind('click', closeInfoBox);
                });
                //console.log(item);
                _infoBox.open(_map, marker);
            }

            // Devuelve el HTML de la cartela de informacion de la burbuja
            //createInfoboxHtml(item.fullname, item.address, item.urbanization, item.district ,item.id)
            function createInfoboxHtml(cadenaRuc,tipo,codclient,fullname, departamento, address, referencia,district,id,company_id,campaigne) {
                var boxText = document.createElement("div");
                var textCadena = "";
                if (codclient == ""){
                    textCadena = tipo;
                }else{
                    textCadena = codclient;
                }
                boxText.innerHTML = "<div class='IFcontainer'>"+
                    "<a href='#' class='IFclose'></a>"+
                    "<div id='IFtitleBox'>" + cadenaRuc + " - " + fullname + "</div>"+
                    "<span class='codigo' >" + id + "</span>"+
                    "<span class='company_id' style='visibility:hidden'>" + company_id + "</span>"+
                    "<div class='contenido'>Campaña: "+ campaigne + "</div>"+
                    "<div class='contenido'>Codigo: "+ textCadena + "</div>"+
                    "<div class='contenido'>Dirección: "+ address + "</div>"+
                    "<div class='contenido'>Referencia: "+ referencia + "</div>"+
                    "<div class='contenido'>Distrito: "+ district + "</div>"+
                    "<div class='contenido'>Departamento: "+ departamento + "</div>"+
                    "<div><button id='add' type='submit' class='add'>Agregar Tienda</button></div>"+
                    "<div class='IFcorner'></div>"+
                    "</div>";
                return boxText;
            }

            // Cierra la ventana de info
            function closeInfoBox(e){
                e.preventDefault();
                _infoBox.close();
            }

            //Añadiendo PDV
            function addPDV(val,icono){
                return function(e) {
                    // your code that does something with param
                    e.preventDefault();
                    var contador = 0;
                    //console.log( "codigo: " +$('.codigo').text());
                    $(".cod").each(function( index ) {
                        //contador ++ ;
                        //console.log( index + ": " +   $(this).text());
                        var codgigo1 = "";
                        var codgigo2 = "" ;
                        codgigo1 = $(this).text();
                        codgigo2 = $(".codigo").text() ;
                        if (codgigo1 == codgigo2) {
                            //$( "span" ).text( "Stopped at div index #" + index );
                            contador ++;
                            return false;
                        } else {
                            //$('#tiendas ').append("<p>"+ $('#IFtitleBox').text() +"(<span>" + $('.codigo').text() + "</span>)</p>")
                            contador=0;
                        }
                    });

                    if(contador > 0){
                        return;
                    } else {
                        $('#tiendas ').append("<p id='"
                            + $('.codigo').text() +"' company-id='" + $('.company_id').text() + "'>"
                            + $('#IFtitleBox').text()
                            + " <img src='" + icono +"' height='20'/> "
                            +"(<span class='cod'>" + $('.codigo').text()
                            + "</span>)" + "<a href='#'  id=code" + $('.codigo').text() + " data-id=" + $('.codigo').text()  +"><img src='img/delete.png' alt=''/></a></p>");
                    }

                    //val.setIcon("img/burbuja-map.png");
                    val.setVisible(false);
                    links = $("#code" + $('.codigo').text());
                    links.on("click",  function(e) {
                        e.preventDefault();
                        //console.log($(this).attr("data-id"));
                        selected = $('#' + $(this).attr("data-id")).remove();
                       // val.setIcon("img/burbuja-map-active.png");
                        val.setVisible(true);
                        elemetSelected=0;
                        $(".cod").each(function( index ) {
                            elemetSelected ++ ;
                        });
                        //console.log(elemetSelected);
                        $('#pdvSelected').html(elemetSelected);
                    });

                    elemetSelected=0;
                    $(".cod").each(function( index ) {
                        elemetSelected ++ ;
                    });

                    //console.log(elemetSelected);
                    $('#pdvSelected').html(elemetSelected);

                    // Cierra la ventana de info
                    _infoBox.close();

                };
            }



            $(".customer_id").click(function(){
                id=$(this).val();
                if($(this).is(':checked')){
//                    marker.setVisible(true);
//                    marker_open.setVisible(true);
//                    marker_close.setVisible(true);
                    //alert($(this).val());

                    $.each(_markersCompany, function(i,item){
                        //item[0].setVisible(true);
                        if(id == item[1] ){
                            item[0].setVisible(true);
                            setTimeout(function(){ item[0].setAnimation(null); }, 1500);
                            console.log(item[0]);
                        }

                    });

                }else{
//                    marker.setVisible(false);
//                    marker_open.setVisible(false);
//                    marker_close.setVisible(false);
                     $.each(_markersCompany, function(i,item){
                    //item[0].setVisible(true);
                            if(id == item[1] ){
                                item[0].setVisible(false);
                                console.log(item[0]);
                            }

                     });
                }


            });

        }
        init();
    });




    // -------------------------------PANEL--------------------------------
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


    ///-------------------------------- Save Road-----------------------------------
    $('#guarda_ruta').click(function(e) {
        e.preventDefault();
        var company_id ;
        var nombre = $('#name_ruta').val();
        var data_store = [];

        //var str_datos="";
        $('#tiendas p').each(function(index, element ) {
            company_id = $(this).attr("company-id");
            //console.log($(this).attr("company-id"));
            data_store[index]= element.id + "|" + company_id ;
            //str_datos = str_datos + element.id + "|" + company_id  ;
            //console.log(str_datos);
        });

        if(data_store.length < 1) {
            alert("Debe seleccionar al menos una ruta");
            return;
        } else {

            $("#guarda_ruta").prop( "disabled", true );
            $("#mensaje").text("Espere se está guardando la ruta ...");

            console.log(data_store);
            var response = $.post(dominio + '/saveRoute',  { nombreRuta : nombre, user_id : <?php echo $_GET['user_id'] ?> , id_store : data_store},
                function(data){
                //if (item.latitud != 0 && item.longitud != 0){
                    //console.log(data);
                    if(data.success==1 ){
                        location.reload();
                    } else if(data.success==0) {
                        alert( "No se pudo guardar los datos inténtelo nuevamente" );
                        location.reload();
                    }

               } );

            response.fail(function() {
                alert( "Error no pudo recibir respuesta del servidor" );
                location.reload();
            })
        }


    });

</script>
</body>
</html>