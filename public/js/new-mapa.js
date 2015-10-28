
	var _map;
	//var _geocoder;
	var _markers=[];
	var _infoBox;
	function init (Latitude, Longitude) {
		setupMapa(jQuery('#map_canvas')[0], Latitude, Longitude);
	}
	function setupMapa(div, Latitude, Longitude){

        _map= new google.maps.Map( div, {
                scrollwheel: false,
                zoom: 16,
                center: new google.maps.LatLng(Latitude, Longitude),
                disableDefaultUI: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
        );
        //console.log("i=" + i + " item = " + item);
        var marker = new google.maps.Marker({
            draggable: true,
            position  	:new google.maps.LatLng(Latitude, Longitude),
            animation 	:google.maps.Animation.DROP,
            icon      	:'http://localhost/ttaudit.com/auditors/backend/public/img/burbuja-map.png',
            origin 		:(18, 38),   // Desfase del png de la burbuja con respecto al punto
            map      	:_map
        });
        google.maps.event.addListener(marker, 'position_changed', update);
        //_markers = marker;


        function update() {
            var latlon = marker.getPosition();

             store.latitude.value = latlon.lat();
             store.longitude.value = latlon.lng();
           console.log(latlon.lat());
            /*opener.ingresar_agente.txt_latitud.value = latlon.lat();
             opener.ingresar_agente.txt_longitud.value = latlon.lng();*/
        }
	}

