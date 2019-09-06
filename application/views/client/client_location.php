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

                </div>
                <div class="card-block">
                    <div
                        id="map"
                        locationSaveUrl="<?php echo $this->baseUrl.'clients/add_update_location/'.$client['id'];?>"
                        node_url="<?php echo NODE_URL;?>"
                    ></div>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script type="text/javascript">
    $(".add_cilent_li").active();
</script>

<script src="<?php echo $this->assetsUrl; ?>files/tracking/map.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo MAP_API_KEY;?>&callback=client_location" async defer></script>
@endscript
