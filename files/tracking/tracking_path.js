// Initialize and add the map
    function initMap() {

		var markers = [];

        var letsEnkindle = {lat: 23.047325, lng: 72.570479};	// The location of letsEnkindle		
        var mapDiv = document.getElementById('map');
		var pathGetUrl = mapDiv.getAttribute('pathGetUrl');
		var users = JSON.parse(mapDiv.getAttribute('users'));
		var paths = [];
		var mapOptions = {
				zoom: 12,
				center: letsEnkindle
		};
			
		var map = new google.maps.Map(mapDiv,mapOptions);

		var jqxhr = $.get( pathGetUrl, function(response) {
						response.forEach(function(user,index){
							user.coordinates.forEach(function(coord,i){

								coord = coord.map(function(o){return new google.maps.LatLng(parseFloat(o.lat),parseFloat(o.lng))});

								paths.push({path:coord,user_id:user.id});
								var distance = google.maps.geometry.spherical.computeLength(coord); //meters;
								var meter = parseInt(distance%1000);
								var km = parseInt(distance/1000);
								if(km){
									var distanceStr = km + "." + meter + " km";
								}else{
									var distanceStr = meter + " meters";
								}
								var infoWindow = new google.maps.InfoWindow({
									content : `<div>Name: ${user.first_name}<br/>Role: ${user.role_name}<br/>Distance: ${distanceStr}</div>`
								});

								var path = new google.maps.Polyline({
									path: coord,
									geodesic: true,
									strokeColor: '#5f5ffb',
									// strokeOpacity: 1.0,
									// strokeWeight: 2,
									icons: [{
										icon: {path:google.maps.SymbolPath.FORWARD_OPEN_ARROW},
										repeat: '50%'
									}],
								});

								path.setMap(map);

								path.addListener('mouseover', function(event) {
									infoWindow.setPosition(event.latLng);
									infoWindow.open(map);
								});
							});
						});
					},'json')
					.done(function() {})
					.fail(function() {})
					.always(function() {
						initial_load = true;
					});

		function addMarker(obj){

			var latLng = new google.maps.LatLng(obj.lat,obj.lng);

			var found_user = users.find(function(o){
				return o.id == obj.user_id
			});

			var found_marker = markers.find(function(o){
				return o.user_id == obj.user_id
			});

			var markerOptions = {
				map: map,
				position: latLng,
				title:found_user.first_name,
				animation:google.maps.Animation.DROP,
				label:found_user.first_name.substring(0,1).toUpperCase()
			};

			var marker = new google.maps.Marker(markerOptions);
			var infoWindow = new google.maps.InfoWindow({
				content : `<div>Name: ${found_user.first_name}<br/>Role: ${found_user.role_name}</div>`
			});

			marker.addListener('click', function(event) {
				infoWindow.open(map,marker);
			});
			markers.push({marker:marker,user_id:obj.user_id});

			var mapBounds = map.getBounds();
			if(mapBounds){
				if(!mapBounds.contains(latLng)){
					fit = true;
				}
			}

			if(fit){
				fitBounds();
			}

			return marker;
		}

		function fitBounds(){
			var bounds = new google.maps.LatLngBounds();
			markers.forEach(function(currentValue, index, arr){
				bounds.extend(currentValue.marker.getPosition());	//returns LatLng Object
			});

			map.setCenter(bounds.getCenter());
			map.fitBounds(bounds);
		}

    }