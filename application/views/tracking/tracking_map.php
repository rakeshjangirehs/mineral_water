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
<!--                <div class="card-header">-->
<!--                    <div class="card-header-right" style="padding:0px 0px;">-->
<!--                        <ul class="list-unstyled card-option">-->
<!--                            <li><i class="feather icon-maximize full-card"></i></li>-->
<!--                        </ul>-->
<!--                    </div>-->
<!--                </div>-->
                <div class="card-block">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script type="text/javascript">
    $(".tracking_li").active();
</script>

<script>
    // Initialize and add the map
    function initMap() {
        // The location of Uluru
        var uluru = {lat: -25.344, lng: 131.036};
        // The map, centered at Uluru
        var map = new google.maps.Map(
            document.getElementById('map'), {zoom: 4, center: uluru});
        // The marker, positioned at Uluru
        var marker = new google.maps.Marker({position: uluru, map: map});
        console.log(google.maps);
    }
</script>
<!--Load the API from the specified URL
    * The async attribute allows the browser to render the page while the API loads
    * The key parameter will contain your own API key (which is not needed for this tutorial)
    * The callback parameter executes the initMap() function
    -->
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0Y32XCpdaQf8ixZTQVR0whMoqgUs40G4&callback=initMap">
</script>
@endscript
