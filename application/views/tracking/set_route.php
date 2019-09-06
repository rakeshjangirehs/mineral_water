<style>
    /* Set the size of the div element that contains the map */
    #map {
        height: 500px;  /* The height is 400 pixels */
        width: 100%;  /* The width is the width of the web page */
    }
    .menu {
        width: 150px;
        box-shadow: 3px 3px 5px #888888;
        border-style: solid;
        border-width: 1px;
        border-color: grey;
        border-radius: 2px;
        position: fixed;
        display: none;
        z-index: 999;
    }

    .menu-item {
        height: 20px;
        background-color: white;
    }

    .menu-item:hover {
        background-color: #6CB5FF;
        cursor: pointer;
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
                    <div
                        id="map"
                        node_url="<?php echo NODE_URL;?>"
                        markerSaveUrl="<?php echo $this->baseUrl.'tracking/set_route';?>"
                        users='<?php echo json_encode($users);?>'
                    >
                    </div>
                    <div class="menu" id="menu">
                        <div class="menu-item"><i class="glyphicon glyphicon-file"></i>Remove Marker
                    </div>
                </div>
                <div id="mapSelector">
                    <div class="mapSelector-toggle">
                        <a href="javascript:void(0)"></a>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control place" id="source" placeholder="Choose Source"/>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control place" id="destination" placeholder="Choose Destination"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script type="text/javascript">
    $(".set_route_li").active();
    $('.mapSelector-toggle > a').on("click", function() {
        //debugger;
        $('#mapSelector').toggleClass('open')
    });

</script>

<script src="<?php echo $this->assetsUrl; ?>files/tracking/socket.io.js"></script>
<script src="<?php echo $this->assetsUrl; ?>files/tracking/map.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo MAP_API_KEY;?>&libraries=places&callback=set_route" async defer></script>
@endscript
