<div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-right" style="padding:0px 0px;">
                                <ul class="list-unstyled card-option">
                                    <li><i class="feather icon-maximize full-card"></i></li>
                                    <li title="Export Excel"><a href="<?php echo $this->baseUrl; ?>warehouses/brands_export"><i class="fa fa-file-excel-o"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>warehouses/index" style="width:100%;">
                                    <thead>
                                    <tr>
                                        <th>Warehouse Name</th>
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
                    <form action="<?php echo $this->baseUrl; ?>warehouses/index/<?php echo $vehicle_id; ?>" id="tagFrm" method="post">
                        <div class="card">
                            <div class="card-header">
                                <h5><?php echo $form_title; ?></h5>
                            </div>
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-sm-12 ">
                                        <div class="form-group">
                                            <label for="name" class="control-label">Name:</label>
                                            <input type="text" name="name" id="name" class="form-control" value="<?php echo (isset($_POST['name']))? set_value('name') : $vehicle_details['name']; ?>" />
                                            <span class="messages"><?php echo form_error('name');?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <button type="submit" class="btn btn-sm btn-primary"><?php echo ($vehicle_id) ? "Update" : "Add";?></button>
                                    <a class="btn btn-sm btn-default" href="<?php echo $this->baseUrl.'warehouses/index'; ?>">Cancel</a>
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
    $(".warehouses_li").active();

    var validator = $("#tagFrm").validate({
        rules   : 	{
                        "name"		:	{
                            required:true,
                            maxlength: 200
                        },
                    },
        errorElement: "p",
        errorClass:"text-danger error",
        errorPlacement: function ( error, element ) {
            $(element).closest(".form-group").append(error);
        },
    });

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
                { "data": "name" },
                {
                    "data": 'link',
                    "orderable" : false,
                    "render": function ( data, type, row, meta ) {
                        return "<a class='' href='<?php echo $this->baseUrl; ?>warehouses/index/"+data.id+"' title='Edit Warehouse'><i class='feather icon-edit'></i></a>" +
                                "<a class='text-danger' id='delete_vehicle' href='<?php echo $this->baseUrl; ?>warehouses/delete/"+data.id+"' title='Delete Warehouse'><i class='feather icon-trash-2'></i></a>";
                    }
                }
            ],
            "createdRow": function ( row, data, index ) {
                if(vehicle_id == data.id){
                    $(row).addClass('active_row');
                }
            }
        }).on('click','#delete_vehicle',function(e){
            e.preventDefault();

            var url = this.getAttribute('href');

            swal(
                {
                    title: "Delete Warehouse ?",
                    text: "You will not be able to recover this Warehouse!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No"
                },
                function(isConfirm) {
                    if (isConfirm) {
                        window.location.href = url;
                    }
                }
            );
        });
</script>
@endscript