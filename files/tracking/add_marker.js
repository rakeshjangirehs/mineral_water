// Initialize and add the map
    function initMap() {
        		
        var letsEnkindle = {lat: 23.047325, lng: 72.570479};	// The location of letsEnkindle		
        var mapDiv = document.getElementById('map');
		var markerSaveUrl = mapDiv.getAttribute('markerSaveUrl');
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
			var userName = userSelect.options[userSelect.selectedIndex].text;
						
			if(user_id){
				
				var data = {
					lat	:	currentLat,
					lng	:	currentLng,
					user_id:user_id,
				};
			
				post(data,function(resp){
					
					if(resp.responseText){
						var new_marker = new google.maps.LatLng(currentLat,currentLng);		//{lat: lat, lng: lng}					
				
						var markerOptions = {
							map: map,
							position: new_marker,
							title:userName,
							// animation:google.maps.Animation.Lm,	//Lm/Nm,/DROP/BOUNCE (Lm is default)			
							label:userName.substring(0,1).toUpperCase()
						};
						
						var marker = new google.maps.Marker(markerOptions);
						return marker;
					}
				});
			}else{
				alert("Please Choose a User");
				return false;
			}
		}
		
		function post(data,callback) {
			
			if(data){
				
				var formData =  new FormData();
				for(var key in data){
					formData.append(key,data[key]);
				}			
				
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						callback(this);
					}
				};
				xmlhttp.open("POST", markerSaveUrl, true);
				xmlhttp.send(formData)
				return xmlhttp;
			}
		}
		
    }