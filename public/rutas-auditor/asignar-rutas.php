<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="css/stylesheet.css"/>
    <link rel="stylesheet" href="css/mapa-styles.css"/>


    <style>

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
            <select class="form-control input-sm" id="Escuela">
                <option>--AUDITOR--</option>
                <option>Jan castro</option>
                <option>Pedro</option>
                <option>Luis Castro</option>
            </select>

        </div>
        <div><p>Nº de PDVS: <span id="pdv"></span></p></div>
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
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script type="text/javascript" src="lib/mapa/infobox.js"></script>


<script>


    // $("div").click(function () {
    //
    //      $("p").slideToggle("slow");
    //
    //
    //    });

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



            /*	if($(this).css('left') == '185px') {
             $(this).css('left', '0px');
             $(this).next().hide();
             }
             else {
             $(this).css('left','185px');
             $(this).next().show();
             }*/
        });
    });

    var _map;
    //var _geocoder;
    var _markers=[];
    var _infoBox;

   // var marker;
    $(document).ready(function($) {
        function init () {
            setupMapa(jQuery('#map_canvas')[0]);
        }
        function setupMapa(div){
            // Carga los datos de las burbujas de un JSON externo
            //http://ttaudit.com/getPointStores
            //lib/mapa/burbujas.json
            $.post('http://ttaudit.com/getPointStoresForCompanyDepartament',{ company_id : <?php echo $_GET['company_id'] ?>,departament : "<?php echo $_GET['departament'] ?>" }, function(json){
                //if (item.latitud != 0 && item.longitud != 0){
                _map= new google.maps.Map( div, {
                        scrollwheel: true,
                        zoom: 14,
                        center: new google.maps.LatLng(json[0].latitud, json[0].longitud),
                        disableDefaultUI: false,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    }
                );
                populateMap(json);
            });
        }
        //----------------------- ---
        // Rellena el mapa de burbujitas con los datos del json
        function populateMap(data){

            var total_puntos = 0;
            $.each(data, function(i, item){
                console.log(item);

                total_puntos ++;
                var icono;
                // if(item.status=="true") {
                icono='img/burbuja-map-active.png'
                //icono = google.maps.SymbolPath.CIRCLE;
                // } else {
                //     icono='img/burbuja-map.png'
                // }
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
                    openInfoBox(marker, item);
                });
                openInfoBox(marker, item);
                // }
                // Escucho los eventos de raton sobre las burbujas
                _markers[i] = marker;

            });

            console.log(total_puntos);
            $('#pdv').html(total_puntos);
            // Abre la ventana de info cuando se hace click sobre una burbuja
            function openInfoBox(marker, item) {
                _map.panTo(marker.position);
                var myOptions = {
                    content 			:createInfoboxHtml(item.codclient, item.fullname, item.departamento, item.address, item.referencia, item.district ,item.id)
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
                    $('#add').unbind('click', addPDV(marker));
                    $('#add').bind('click', addPDV(marker));
                    //marker.icon="img/delete.png";
                    //$('.IFclose', '.infoBox').bind('click', closeInfoBox);
                });
                //console.log(item);
                _infoBox.open(_map, marker);
            }

            // Devuelve el HTML de la cartela de informacion de la burbuja
            //createInfoboxHtml(item.fullname, item.address, item.urbanization, item.district ,item.id)
            function createInfoboxHtml(codclient,fullname, departamento, address, referencia,district,id) {
                var boxText = document.createElement("div");
                boxText.innerHTML = "<div class='IFcontainer'>"+
                    "<a href='#' class='IFclose'></a>"+
                    "<div id='IFtitleBox'>" + fullname + "</div>"+
                    "<span class='codigo' style='visibility:hidden'>" + id + "</span>"+
                    "<div class='contenido'>Codigo: "+ codclient + "</div>"+
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
            function addPDV(val){

                return function(e) {
                    // your code that does something with param
                    e.preventDefault();
                    //="img/delete.png";
                    //$('#tiendas ').append("<p id='" + $('#codigo').text() + "'>"+ $('#IFtitleBox').text() +"</p>")
                    // $('#tiendas ').append("<p>"+ $('#IFtitleBox').text() +"(<span>" + $('.codigo').text() + "</span>)</p>")
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
                            + $('.codigo').text()
                            + "'>"+ $('#IFtitleBox').text()
                            +"(<span class='cod'>" + $('.codigo').text()
                            + "</span>)" + "<a href='#' onClick=deletePDV("
                            +  $('.codigo').text()
                            +  "); ><img src='img/delete.png' alt=''/></a></p>");
                    }
                    //console.log(_markers[1]);

                    val.setIcon({
                        path: google.maps.SymbolPath.CIRCLE,
                        scale: 10,
                        fillColor: "#00F",
                        fillOpacity: 0.8,
                        strokeWeight: 1
                    });
//                    marker.setIcon({
//                        path: google.maps.SymbolPath.CIRCLE,
//                        scale: 10,
//                        fillColor: "#00F",
//                        fillOpacity: 0.8,
//                        strokeWeight: 1
//                    });

                };
            }


            // function addPDV(e) {
            //    // your code that does something with param
            //    e.preventDefault();
            //    //="img/delete.png";
            //    //$('#tiendas ').append("<p id='" + $('#codigo').text() + "'>"+ $('#IFtitleBox').text() +"</p>")
            //    // $('#tiendas ').append("<p>"+ $('#IFtitleBox').text() +"(<span>" + $('.codigo').text() + "</span>)</p>")
            //    var contador = 0;
            //    //console.log( "codigo: " +$('.codigo').text());
            //    $(".cod").each(function( index ) {
            //        //contador ++ ;
            //        //console.log( index + ": " +   $(this).text());
            //        var codgigo1 = "";
            //        var codgigo2 = "" ;
            //        codgigo1 = $(this).text();
            //        codgigo2 = $(".codigo").text() ;
            //        if (codgigo1 == codgigo2) {
            //            //$( "span" ).text( "Stopped at div index #" + index );
            //            contador ++;
            //            return false;
            //        } else {
            //            //$('#tiendas ').append("<p>"+ $('#IFtitleBox').text() +"(<span>" + $('.codigo').text() + "</span>)</p>")
            //            contador=0;
            //        }
            //
            //        //_markers[5].setIcon({
            //        //    path: google.maps.SymbolPath.CIRCLE,
            //        //    scale: 10,
            //        //    fillColor: "#00F",
            //        //    fillOpacity: 0.8,
            //        //    strokeWeight: 1
            //        //});
            //    });
            //    if(contador > 0){
            //        return;
            //    } else {
            //        $('#tiendas ').append("<p id='" + $('.codigo').text() + "'>"+ $('#IFtitleBox').text() +"(<span class='cod'>" + $('.codigo').text() + "</span>)" + "<a href='#' onClick=deletePDV(" +  $('.codigo').text() + ")><img src='img/delete.png' alt=''/></a></p>");
            //    }
            //    console.log(_infoBox);
            //
            //
            //
            //};

        }
        init();


    });

    function deletePDV(id ){
        // console.log("rtrtyrty");
        $( "#"+ id ).remove();

        console.log(marker);

//        marker.setIcon({
//                path: google.maps.SymbolPath.CIRCLE,
//                scale: 10,
//                fillColor: "#00F",
//                fillOpacity: 0.8,
//                strokeWeight: 1
//            });
    };

//    $('#guardar').on( "click",  function() {
//        event.preventDefault();
//       alert("Holla");
//    });


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


    $('#guarda_ruta').click(function(e) {
        e.preventDefault();
        var company_id ;
        var nombre = $('#name_ruta').val();
        var data_store = [];
        $('#tiendas p').each(function(index, element ) {

            data_store[index]=element.id
            console.log(element.id);
        });

        if(data_store.length < 1) {

            alert("Debe seleccionar almenos una ruta");
            return;
        } else {

            $.post('http://ttaudit.com/saveRoute',
                    { nombreRuta : nombre,  company_id : <?php echo $_GET['company_id'] ?> , user_id : <?php echo $_GET['user_id'] ?> , id_store : data_store },
                function(data){
                //if (item.latitud != 0 && item.longitud != 0){
                    //console.log(data);

                if(data.success==1 ){
                    location.reload();
                }

                } );
        }


    });

</script>
</body>
</html>