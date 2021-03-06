<style>
    .delivered{
        background-color:#82da82!important;
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
                            <!--<li title="Export Excel"><a href="<?php //echo $this->baseUrl; ?>users/user_export" ><i class="fa fa-file-excel-o"></i></a></li>-->
                        </ul>
                    </div>
                </div>
                <div class="card-block">
                    <div class="dt-responsive table-responsive">
                        <table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>delivery/index" style="width:100%;">
                            <thead>
                            <tr>
                                <th>Clients</th>
                                <th>Expected Delivery</th>
                                <th>Actual Delivery</th>
                                <th>Pickup Location</th>
                                <th>Warehouse</th>
                                <th>Delivery Staff</th>
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

@script
<script type="text/javascript">
	// to active the sidebar
    // $('.nav .nav-list').activeSidebar('.user_list_li');
    $(".delivery_list_li").active();

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
                { "data": "client_name" },
                { "data": "expected_delivey_datetime_f" },
                { "data": "actual_delivey_datetime_f" },
                { "data": "pickup_location" },
                { "data": "warehouse_name" },                
                { "data": "deliverying_staff" },                
                {
                	"data": 'link',
                    orderable:false,
                    // "sortable": false,
                	"render": function ( data, type, row, meta ) {
				      return "<a href='<?php echo $this->baseUrl; ?>delivery/add_update/"+data.id+"' title='Edit Delete'><i class='feather icon-edit'></i></a>"+
                          "<a class='text-danger' id='delete_user' href='<?php echo $this->baseUrl; ?>delivery/delete/"+data.id+"' title='Delete Delivery'><i class='feather icon-trash-2'></i></a>";
				    }
            	},                
            ],
            createdRow:function(row, data, index){
                if(data.order_status=='Delivered'){
                    row.classList.add('delivered');
                    row.title = "Delivered";
                }
            }
		}).on('click','#delete_user',function(e){
		    e.preventDefault();

		    var url = this.getAttribute('href');

            swal(
                {
                    title: "Delete Delivery ?",
                    text: "You will not be able to recover this Delivery!",
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