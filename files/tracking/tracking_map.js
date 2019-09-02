// Initialize and add the map
    function initMap() {
        		
        var letsEnkindle = {lat: 23.047325, lng: 72.570479};	// The location of letsEnkindle		
        var mapDiv = document.getElementById('map');
		var markerGetUrl = mapDiv.getAttribute('markerGetUrl');
		
		var mapOptions = {
				zoom: 12,
				center: letsEnkindle
		};
			
		var map = new google.maps.Map(mapDiv,mapOptions);
        
		get(function(resp){
			
			if(resp.responseText){
				var respJson = JSON.parse(resp.responseText);
				for(var key in respJson){
					drawMarker(respJson[key]);
				}
			}
		});
				
		function drawMarker(obj){
		
			var new_marker = new google.maps.LatLng(obj.lat,obj.lng);
		
				var markerOptions = {
					map: map,
					position: new_marker,
					title:obj.username,
					animation:google.maps.Animation.DROP,
					label:obj.username.substring(0,1).toUpperCase()
				};
				
				var marker = new google.maps.Marker(markerOptions);
				var infoWindow = new google.maps.InfoWindow({
					content : `<div>Name: ${obj.username}<br/>Email: ${obj.email}</div>`
				});
								
				marker.addListener('click', function(event) {
					infoWindow.open(map,marker);
				});
				
				return marker;
		}
		
		function get(callback) {
			
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					callback(this);
				}
			};
			xmlhttp.open("GET", markerGetUrl, true);
			xmlhttp.send()
			return xmlhttp;
		}
		
    }