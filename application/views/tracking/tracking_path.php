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
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-maximize full-card"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="card-block">
                    <div
                            id="map"
                            node_url="<?php echo NODE_URL;?>"
                            pathGetUrl="<?php echo $this->baseUrl.'tracking/tracking_path';?>"
                            users='<?php echo json_encode($users);?>'
                    ></div>
                    <div id="userControls">
                        <div style='margin-right: 10px;margin-top: 10px;'>

                            <div class="form-group">
                                <select id="userSelect" class="form-control">
                                    <option value=''>Choose User</option>
                                    <?php foreach($users as $user){
                                        if($user['role_id']==3) {
                                            echo "<option value='{$user['id']}'>{$user['first_name']} {$user['last_name']}</option>";
                                        }
                                    }?>
                                </select>
                            </div>

                            <div class='form-group'>
                                <div class="input-group">
                                    <input type="text" id="date" class='form-control' value="<?php echo date('Y-m-d');?>" readonly/>
                                    <span class="input-group-addon ">
                                        <span class="icofont icofont-ui-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script type="text/javascript">
    $(".tracking_path_li").active();
</script>

<script src="<?php echo $this->assetsUrl; ?>files/tracking/map.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo MAP_API_KEY;?>&libraries=geometry&callback=tracking_path" async defer></script>
@endscript
