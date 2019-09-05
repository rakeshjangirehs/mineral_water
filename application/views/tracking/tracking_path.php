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
                    <div id="map" pathGetUrl="<?php echo $this->baseUrl.'tracking/tracking_path/1';?>" users='<?php echo json_encode($users);?>'></div>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script type="text/javascript">
    $(".tracking_li").active();
</script>

<script src="<?php echo $this->assetsUrl; ?>files/tracking/tracking_path.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0Y32XCpdaQf8ixZTQVR0whMoqgUs40G4&libraries=geometry&callback=initMap"></script>
@endscript
