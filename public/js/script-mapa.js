
	var _map;
	//var _geocoder;
	var _markers=[];
	var _infoBox;
	function init (Url) {
		setupMapa(jQuery('#map_canvas')[0], Url);
	}
	function setupMapa(div, Url){
        var urlLimpia;
        urlLimpia = Url.split('/storeMap?id=');
        //console.log("Url Limpia : " + urlLimpia[0]);
		// Carga los datos de las burbujas de un JSON externo
		//$.getJSON('http://localhost/ttaudit.com/auditors/backend/public/storeMap?id=1', function(json){
        $.getJSON(Url, function(json){
			_map= new google.maps.Map( div, {
					scrollwheel: false,
					zoom: 16,
					center: new google.maps.LatLng(json[0].latitude, json[0].longitude),
					disableDefaultUI: false,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				}
			);
			populateMap(json,urlLimpia[0]);
		});
	}
	//----------------------- ---
	// Rellena el mapa de burbujitas con los datos del json
	function populateMap(data,UrlLimpia){

		$.each(data, function(i, item){
			console.log("i=" + i + " item = " + item);
			var marker = new google.maps.Marker({
				id 		:i,
				clickable 	:true,
				position  	:new google.maps.LatLng(item.latitude, item.longitude),
				animation 	:google.maps.Animation.DROP,
				icon      	:UrlLimpia + '/img/burbuja-map.png',
				origin 		:(18, 38),   // Desfase del png de la burbuja con respecto al punto
				map      	:_map
			});
			// Escucho los eventos de raton sobre las burbujas
			google.maps.event.addListener(marker, 'click', function() {
				openInfoBox(marker, item , UrlLimpia);
			});
			// Escucho los eventos de raton sobre las burbujas
				openInfoBox(marker, item , UrlLimpia);
			_markers[i] = marker;
		});
		// Abre la ventana de info cuando se hace click sobre una burbuja
		function openInfoBox(marker, item , UrlPhoto) {
			_map.panTo(marker.position);
			var myOptions = {
				content 			:createInfoboxHtml(UrlPhoto + "/img/stores/" +item.photo, item.fullname, item.address)
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
      			_infoBox.open(_map, marker);
		}

		// Devuelve el HTML de la cartela de informacion de la burbuja
		function createInfoboxHtml(image, titulo, contenido) {
			var boxText = document.createElement("div");
			boxText.innerHTML = "<div class='IFcontainer'>"+
									"<a href='#' class='IFclose'></a>"+
									"<img class='IFheader' src='" + image + "' />"+
									"<div id='IFtitleBox'>" + titulo + "</div>"+
									"<div class='contenido'>"+ contenido + "</div>"+
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
	//init();
