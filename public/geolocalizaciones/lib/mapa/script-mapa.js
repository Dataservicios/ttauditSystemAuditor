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
		$.getJSON('lib/mapa/burbujas.json', function(json){
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
                    $('#tiendas ').append("<p id='" + $('.codigo').text() + "'>"+ $('#IFtitleBox').text() +"(<span class='cod'>" + $('.codigo').text() + "</span>)" + "<a href='#' onClick=deletePDV(" +  $('.codigo').text() + ","+ val  + "); ><img src='img/delete.png' alt=''/></a></p>");
                }
                //console.log(_markers[1]);

                //val.setIcon({
                //    path: google.maps.SymbolPath.CIRCLE,
                //    scale: 10,
                //    fillColor: "#00F",
                //    fillOpacity: 0.8,
                //    strokeWeight: 1
                //});

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

function deletePDV(id, val){
    // console.log("rtrtyrty");
    $( "#"+ id ).remove();

    val.setIcon({
        path: google.maps.SymbolPath.CIRCLE,
        scale: 10,
        fillColor: "#00F",
        fillOpacity: 0.8,
        strokeWeight: 1
    });
}
