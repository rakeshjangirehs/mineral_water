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
                                    <li title="Export Excel"><a href="<?php echo $this->baseUrl; ?>brands/brands_export"><i class="fa fa-file-excel-o"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>brands/index" style="width:100%;">
                                    <thead>
                                    <tr>
                                        <th>Brand Name</th>
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
                    <form action="<?php echo $this->baseUrl; ?>brands/index/<?php echo $vehicle_id; ?>" id="tagFrm" method="post">
                        <div class="card">
                            <div class="card-header">
                                <h5><?php echo $form_title; ?></h5>
                            </div>
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-sm-12 ">
                                        <div class="form-group">
                                            <label for="brand_name" class="control-label">Brand Name:</label>
                                            <input type="text" name="brand_name" id="brand_name" class="form-control" value="<?php echo (isset($_POST['brand_name']))? set_value('brand_name') : $vehicle_details['brand_name']; ?>" />
                                            <span class="messages"><?php echo form_error('brand_name');?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <button type="submit" class="btn btn-sm btn-primary"><?php echo ($vehicle_id) ? "Update" : "Add";?></button>
                                    <a class="btn btn-sm btn-default" href="<?php echo $this->baseUrl.'brands/index'; ?>">Cancel</a>
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
    $(".brands_li").active();


    var validator = $("#tagFrm").validate({
        rules   : 	{
                        "brand_name"		:	{
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
                { "data": "brand_name" },
                {
                    "data": 'link',
                    "orderable" : false,
                    "render": function ( data, type, row, meta ) {
                        return "<a class='' href='<?php echo $this->baseUrl; ?>brands/index/"+data.id+"' title='Edit Brand'><i class='feather icon-edit'></i></a>" +
                                "<a class='text-danger' id='delete_vehicle' href='<?php echo $this->baseUrl; ?>brands/delete/"+data.id+"' title='Delete Brand'><i class='feather icon-trash-2'></i></a>";
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
                    title: "Delete Brand ?",
                    text: "You will not be able to recover this brand!",
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