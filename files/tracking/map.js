const mapDiv = document.getElementById('map');
const server_url = mapDiv.getAttribute('node_url');	//URL of the NPM Server

var socket = null;
const node_url = "http://zoopapps.com";
const connect_options = {
	path: '/neervana/neervana_node/socket.io'
};

const letsEnkindle = {lat: 23.047325, lng: 72.570479};	// The location of letsEnkindle

function tracking_map() {

	socket = io.connect(node_url,connect_options);

	var initial_load = false;
	var markers = [];

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
				content : `<div>
								<div style="margin-bottom: 7px;"><i class="feather icon-user"></i> <span style="margin-left:5px;">${found_user.first_name}</span></div>
								<div style="margin-bottom: 7px;"><i class="feather icon-award"></i> <span style="margin-left:5px;">${found_user.role_name}</span></div>
								<div style="margin-bottom: 7px;"><i class="feather icon-phone"></i> <span style="margin-left:5px;">${found_user.phone}</span></div>
							</div>`
			});

			marker.addListener('mouseover', function(event) {
				infoWindow.open(map,marker);
			});
			marker.addListener('mouseout', function(event) {
				infoWindow.close();
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

function add_marker() {

	socket = io.connect(node_url,connect_options);

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

function tracking_path() {

	var markers = [];

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

function set_route() {

	socket = io.connect(node_url,connect_options);
	var markers = [];

	var markerSaveUrl = mapDiv.getAttribute('markerSaveUrl');
	var users = JSON.parse(mapDiv.getAttribute('users'));
	var userSelect = document.getElementById('user_id');

	var mapOptions = {
		zoom: 12,
		center: letsEnkindle
	};

	var map = new google.maps.Map(mapDiv,mapOptions);

	var directionsRenderer = new google.maps.DirectionsRenderer;
	directionsRenderer.setMap(map);
	var directionsService = new google.maps.DirectionsService;
	var service = new google.maps.places.PlacesService(map);

	google.maps.event.addListener(map, 'click', function(event) {

		var currentLat = event.latLng.lat();
		var currentLng = event.latLng.lng();

		drawMarker(currentLat,currentLng);
	});

	var menuDisplayed = false;
	var menuBox = document.getElementById("menu");

	document.oncontextmenu = function(){
		return false;
	}

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
						draggable:true,
						title:found_user.first_name,
						// animation:google.maps.Animation.Lm,	//Lm/Nm,/DROP/BOUNCE (Lm is default)
						label:found_user.first_name.substring(0,1).toUpperCase()
					};

					var marker = new google.maps.Marker(markerOptions);
					var infoWindow = new google.maps.InfoWindow({
						content : `<div>Name: ${found_user.first_name}<br/>Role: ${found_user.role_name}</div>`
					});

					map.addListener('click',function(e){
						if (menuDisplayed == true) {
							menuBox.style.display = "none";
						}
					});
					marker.addListener('click', function(event) {
						if (menuDisplayed == true) {
							menuBox.style.display = "none";
						}
						infoWindow.open(map,marker);
						console.log(this.getPosition().lat(),this.getPosition().lng());
					});

					marker.addListener('rightclick', function(e) {
						for (prop in e) {
							if (e[prop] instanceof MouseEvent) {
								mouseEvt = e[prop];
								var left = mouseEvt.clientX;
								var top = mouseEvt.clientY;
								menuBox.style.left = left + "px";
								menuBox.style.top = top + "px";
								menuBox.style.display = "block";

								mouseEvt.preventDefault();

								menuDisplayed = true;
								infoWindow.close();
							}
						}

					});
					markers.push(marker);
					draw_route();
				}
			});
		}else{
			alert("Please Choose a User");
		}
	}

	function draw_route(){

		if(markers.length>=2){

			var routeOptions = {
				travelMode: google.maps.TravelMode.DRIVING,
				optimizeWaypoints: true,
			};
			var waypoints = [];

			markers.forEach(function(item,index,all){
				if(index==0){
					routeOptions.origin = item.getPosition();
				}else if(index==(all.length-1)){
					routeOptions.destination = item.getPosition();
				}else{
					waypoints.push({
						location: item.getPosition(),
						stopover: true
					});
				}
				console.log(item.getPosition().lat(),item.getPosition().lng());
			});

			if(waypoints.length>0){
				routeOptions.waypoints = waypoints;
			}

			directionsService.route(routeOptions, function(response, status) {
				if (status == 'OK') {
					directionsRenderer.setDirections(response);
				} else {
					window.alert('Directions request failed due to ' + status);
				}
			});
		}
	}

}

function client_location(){

	var mapDiv = document.getElementById('map');
	var letsEnkindle = {lat: 23.047325, lng: 72.570479};	// The location of letsEnkindle
	var mapOptions = {
		zoom: 12,
		center: letsEnkindle
	};

	var map = new google.maps.Map(mapDiv,mapOptions);



}

//For testing
/*
window.myFunction = function(){
    socket.emit('test_save', {date:new Date().toUTCString()},function(response){
        console.log("client callback : ",response);
    });
}
setTimeout(function(){
		socket.on('test_emit', function(obj){
		console.log(obj);
	});
},1000);
*/

