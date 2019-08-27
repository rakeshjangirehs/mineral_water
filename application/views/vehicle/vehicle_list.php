<style>
    .editing_vehicle{
        background: #337ab7!important;
        color: #fff!important;
    }
</style>
<div class="row">
    <div class="col-xs-12 col-md-8">
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <?php echo $page_title; ?>
                </div>
                <div class="panel-body">
                    <table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>vehicles/index">
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
    <div class="col-xs-12 col-md-4">
        <form action="<?php echo $this->baseUrl; ?>vehicles/index/<?php echo $vehicle_id; ?>" id="tagFrm" method="post">
            <div class="panel-group">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <?php echo $form_title; ?>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12">
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
                    <div class="panel-footer">
                        <div class="text-right">
                            <button type="submit" class="btn btn-sm btn-primary"><?php echo ($vehicle_id) ? "Update" : "Add";?></button>
                            <a class="btn btn-sm btn-default" href="<?php echo $this->baseUrl.'vehicles/index'; ?>">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@script
<script type="text/javascript">
    // to active the sidebar
    $('.nav .nav-list').activeSidebar('.vehicle_li');

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
                        return "<a class='orange' href='<?php echo $this->baseUrl; ?>vehicles/index/"+data.id+"' title='Edit Vehicle'><i class='ace-icon fa fa-pencil-square bigger-130'></i></a>";
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