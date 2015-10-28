<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="css/stylesheet.css"/>
    <link rel="stylesheet" href="css/mapa-styles.css"/>
</head>
<body>

<div class="contenedor">
    <div id="control" class="panel-derecho"></div>
    <div id="tools" style="visibility: visible;">
        <h1>PANEL DE CONTROL</h1>
        <div>
            Usuario: <?php echo $_GET['user'] ?>
        </div>
        <div>
            Ruta: <?php echo $_GET['ruta'] ?>
        </div>
        <div><p>Nº de PDVS: <span id="pdv"></span></p></div>
        <div id="tiendas"></div>

        <div>
            <a class="btn-print" href="javascript:print()">Imprimir</a>
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


$(document).ready(function($) {
    var _map;
    //var _geocoder;
    var _markers=[];
    var _infoBox;

    function init () {
        setupMapa(jQuery('#map_canvas')[0]);
    }
    function setupMapa(div){
        // Carga los datos de las burbujas de un JSON externo

        //http://ttaudit.com/getPointStores
        //lib/mapa/burbujas.json
        $.post('http://ttaudit.com/getStoresxRoad',{ road_id : <?php echo $_GET['road_id'] ?> }, function(json){
            //if (item.latitud != 0 && item.longitud != 0){
            _map= new google.maps.Map( div, {
                    scrollwheel: true,
                    zoom: 14,
                    center: new google.maps.LatLng(json[0].latitude , json[0].longitud),
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
            // } else {
            //     icono='img/burbuja-map.png'
            // }
            var marker = new google.maps.Marker({
                id 		:i,
                clickable 	:true,
                position  	:new google.maps.LatLng(item.latitude, item.longitud),
                animation 	:google.maps.Animation.DROP,
               // icon      	:icono,
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
                //$('#add').unbind('click', addPDV(marker));
                //$('#add').bind('click', addPDV(marker));
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


    init();

});



</script>
</body>
</html>