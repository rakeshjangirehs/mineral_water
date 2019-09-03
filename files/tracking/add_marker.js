// Initialize and add the map
    function initMap() {

		var server_url = "http://172.16.3.123:3000";	//URL of the NPM Server
		var socket = io(server_url);

        var letsEnkindle = {lat: 23.047325, lng: 72.570479};	// The location of letsEnkindle		
        var mapDiv = document.getElementById('map');
		var markerSaveUrl = mapDiv.getAttribute('markerSaveUrl');
		var users = JSON.parse(mapDiv.getAttribute('users'));
		var userSelect = document.getElementById('user_id');
		var mapOptions = {
				zoom: 12,
				center: letsEnkindle
		};
			
		var map = new google.maps.Map(mapDiv,mapOptions);
        
		google.maps.event.addListener(map, 'click', function(event) {
			
			var currentLat = event.latLng.lat();
			var currentLng = event.latLng.lng();
		
			drawMarker(currentLat,currentLng);
		});

		function drawMarker(currentLat,currentLng){

			var user_id = userSelect.options[userSelect.selectedIndex].value;
			// var userName = userSelect.options[userSelect.selectedIndex].text;
						
			if(user_id){
				
				var data = {
					lat	:	currentLat,
					lng	:	currentLng,
					user_id:user_id,
				};

				socket.emit('save_coordinates', data, function(response){
					if(response.id){
						var latLng = new google.maps.LatLng(currentLat,currentLng);		//{lat: lat, lng: lng}

						var found_user = users.find(function(o){
							return o.id == response.user_id
						});

						var markerOptions = {
							map: map,
							position: latLng,
							title:found_user.first_name,
							// animation:google.maps.Animation.Lm,	//Lm/Nm,/DROP/BOUNCE (Lm is default)
							label:found_user.first_name.substring(0,1).toUpperCase()
						};

						var marker = new google.maps.Marker(markerOptions);
						var infoWindow = new google.maps.InfoWindow({
							content : `<div>Name: ${found_user.first_name}<br/>Role: ${found_user.role_name}</div>`
						});
						marker.addListener('click', function(event) {
							infoWindow.open(map,marker);
						});

						return marker;
					}
				});
			}else{
				alert("Please Choose a User");
				return false;
			}
		}
		
    }