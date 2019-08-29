<style>
    .editing_vehicle{
        background: #337ab7!important;
        color: #fff!important;
    }
</style>

<div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>vehicles/index" style="width:100%;">
                                    <thead>
                                    <tr>
                                        <th>Vehicle No</th>
                                        <th>Capacity (In Tons)</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <form action="<?php echo $this->baseUrl; ?>vehicles/index/<?php echo $vehicle_id; ?>" id="tagFrm" method="post">
                        <div class="card">
                            <div class="card-header">
                                <h5><?php echo $form_title; ?></h5>
                            </div>
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-sm-12 ">
                                        <div class="form-group">
                                            <label for="equipment_id">Vehicle Name:</label>
                                            <input type="text" name="name" id="name" class="form-control" value="<?php echo $vehicle_details['name']; ?>" />
                                        </div>
                                        <div class="form-group">
                                            <label for="equipment_id">Vehicle Number:</label>
                                            <input type="text" name="number" id="number" class="form-control" value="<?php echo $vehicle_details['number']; ?>" required />
                                        </div>
                                        <div class="form-group">
                                            <label for="equipment_id">Capactiy (In Tons):</label>
                                            <input type="text" name="capacity_in_ton" id="capacity_in_ton" class="form-control" value="<?php echo $vehicle_details['capacity_in_ton']; ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <button type="submit" class="btn btn-sm btn-primary"><?php echo ($vehicle_id) ? "Update" : "Add";?></button>
                                    <?php if($vehicle_id):?>
                                    <a class="btn btn-sm btn-default" href="<?php echo $this->baseUrl.'vehicles/index'; ?>">Cancel</a>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script type="text/javascript">
    // to active the sidebar
    // $('.nav .nav-list').activeSidebar('.vehicle_li');
    $(".vehicle_li").active();

    var vehicle_id = <?php echo ($vehicle_id) ? $vehicle_id : "null";?>;
    var table = $("#dynamic-table");
    var imgUrl = table.attr('data-imageUrl');
    var oTable = table
        .DataTable({
            "processing": true,
            "serverSide": true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "ajax":{
                "url": table.data('url'),
                "dataType": "json",
                "type": "POST",
            },
            "columns": [
                { "data": "number" },
                { "data": "capacity_in_ton" },
                {
                    "data": 'link',
                    "orderable" : false,
                    "render": function ( data, type, row, meta ) {
                        return "<a class='' href='<?php echo $this->baseUrl; ?>vehicles/index/"+data.id+"' title='Edit Vehicle'><i class='feather icon-edit'></i></a>";
                    }
                }
            ],
            "createdRow": function ( row, data, index ) {
                if(vehicle_id == data.id){
                    $(row).addClass('editing_vehicle');
                }
            }
        });
</script>
@endscript