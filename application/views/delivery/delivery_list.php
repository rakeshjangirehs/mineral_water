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
                        <table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>delivery/index" style="width:100%;" data-order="[[0,&quot;desc&quot;]]">
                            <thead>
                            <tr>
                                <th>Delivery Id</th>
                                <th>Order Info</th>
                                <th>To be attempt date</th>
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
                { "data": "delivery_id" },
                {
                	"data": 'order_short_info',
                    orderable:false,
                    // "sortable": false,
                	"render": function ( data, type, row, meta ) {

                        var str = "";
                        $.each(data.split('<br/>'),function(i1,v1){
                            var row = v1.split('-');
                            // console.log(v1,row);
                            if(row.length>1){
                                str += `<a title='View Order' class='open_order' href='<?php echo $this->baseUrl.'orders/order_details/';?>${row[0].trim()}'>${row[0].trim()}</a> - ${row[1].trim()} - ${row[2].trim()}<br/>`;
                            }
                            // console.log(str);
                        });

                        // console.log(str);
                        
                        return str;
				    }
            	},
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
                        // if(data.order_status != 'Delivered'){
                        if(!data.individual_orders_delivery_date){
				            return "<a href='<?php echo $this->baseUrl; ?>delivery/add_update/"+data.id+"' title='Edit Delete'><i class='feather icon-edit'></i></a>"+
                          "<a class='text-danger' id='delete_user' href='<?php echo $this->baseUrl; ?>delivery/delete/"+data.id+"' title='Delete Delivery'><i class='feather icon-trash-2'></i></a>";
                        }else{
                            return "";
                        }
				    }
            	},                
            ],
            createdRow:function(row, data, index){
                // console.log(data.actual_delivey_datetime);
                // console.log(data.order_status);
                // if(data.order_status=='Delivered'){
                if(data.actual_delivey_datetime){
                    row.classList.add('delivered');
                    row.title = "Delivered";
                }
            }
		}).on('click','.open_order',function(e){
            
		    e.preventDefault();

		    var url = this.getAttribute('href');

            window.open(
                url,
                "DescriptiveWindowName",
                "resizable,scrollbars,status"
            );
        });
</script>
@endscript