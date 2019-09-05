// Initialize and add the map
    function initMap() {

		var server_url = "http://172.16.3.123:3000";	//URL of the NPM Server
		var socket = io(server_url);
		var initial_load = false;
		var markers = [];

        var letsEnkindle = {lat: 23.047325, lng: 72.570479};	// The location of letsEnkindle		
        var mapDiv = document.getElementById('map');
		var markerGetUrl = mapDiv.getAttribute('markerGetUrl');
		var users = JSON.parse(mapDiv.getAttribute('users'));

		var mapOptions = {
				zoom: 12,
				center: letsEnkindle
		};
			
		var map = new google.maps.Map(mapDiv,mapOptions);

		socket.on('push_coordinates', function(obj){
			addMarker(obj);
		});

		var jqxhr = $.get( markerGetUrl, function(response) {
						for(var key in response){
							addMarker(response[key],true);
						}
					},'json')
					.done(function() {})
					.fail(function() {})
					.always(function() {
						initial_load = true;
					});

		function addMarker(obj,fit=false){

			var latLng = new google.maps.LatLng(obj.lat,obj.lng);

			var found_user = users.find(function(o){
				return o.id == obj.user_id
			});

			var found_marker = markers.find(function(o){
				return o.user_id == obj.user_id
			});

			if(found_marker){
				found_marker.marker.setPosition(latLng);
				marker = found_marker;
			}else{
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
			}

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