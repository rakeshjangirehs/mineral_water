<style>
    /* Set the size of the div element that contains the map */
    #map {
        height: 500px;  /* The height is 400 pixels */
        width: 100%;  /* The width is the width of the web page */
    }
</style>
<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-header-right" style="padding:0px 0px;">                        
						Choose User: <select id="user_id">
							<option value="">Choose User</option>
							<?php foreach($users as $user){
								echo "<option value='{$user['id']}'>{$user['first_name']}</option>";
							}?>
						</select>						
                    </div>
                </div>
                <div class="card-block">
                    <div id="map" markerSaveUrl="<?php echo $this->baseUrl.'tracking/saveLatLng';?>" users='<?php echo json_encode($users);?>'></div>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script type="text/javascript">
    $(".tracking_li").active();
</script>

<script src="<?php echo $this->assetsUrl; ?>files/tracking/add_marker.js" async defer></script>
<script src="<?php echo $this->assetsUrl; ?>files/tracking/socket.io.js" async defer></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0Y32XCpdaQf8ixZTQVR0whMoqgUs40G4&callback=initMap" async defer></script>
@endscript
