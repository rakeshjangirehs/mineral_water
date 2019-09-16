<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    &nbsp;
                    <div class="card-header-right" style="padding:0px 0px;">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-maximize full-card"></i></li>
<!--                            <li title="Export Excel"><a href="--><?php //echo $this->baseUrl; ?><!--products/product_export"><i class="fa fa-file-excel-o"></i></a></li>-->
                        </ul>
                    </div>
                </div>
                <div class="card-block">
                    <div class="dt-responsive table-responsive">
                        <table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>orders/index" style="width: 100%;">
                            <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Client</th>
                                <th>Order Amount</th>
                                <th>Expected Delivery Date</th>
                                <th>Actual Delivery Date</th>
                                <th>Salesman</th>
                                <th>DeliveryBoy</th>
                                <th>Client Email</th>
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
<!-- Modal static-->
<div class="modal fade" id="delivery_boy_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form method="post" action="<?php echo $this->baseUrl; ?>orders/update_delivery_boy">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add/Update Delivery Boy</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="order_id" id="order_id"/>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <select class="form-control" data-placeholder="Choose Delivery Boy" id="delivery_boy" name="delivery_boy">
                                <option></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary waves-effect waves-light ">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

@script
<script type="text/javascript">
	// to active the sidebar
    // $('.nav .nav-list').activeSidebar('.product_li');
    $(".order_list_li").active();
    $delivery_boy_modal = $("#delivery_boy_modal");
    $delivery_boy = $("#delivery_boy");
    $order_id = $("#order_id");
    $delivery_boy.select2({
        allowClear:true,
        dropdownParent:$delivery_boy_modal
    });

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
            "order": [
                [ 0, "desc" ]
            ],
            "columns": [
                { "data": "id" },
                { "data": "client_name" },
                { "data": "payable_amount" },
                { "data": "expected_delivery_date" },
                { "data": "actual_delivery_date" },
                { "data": "salesman_name" },
                { "data": "deliveryboy_name" },
                { "data": "client_email" },
                {
                	"data": 'link',
                	"sortable": false,
                	"render": function ( data, type, row, meta ) {
				      return "<a class='' href='<?php echo $this->baseUrl; ?>orders/order_details/"+data.id+"' title='View Invoice'><i class='feather icon-credit-card'></i></a>"+
                          "<a class='order_email' href='<?php echo $this->baseUrl; ?>orders/email_order/"+data.id+"' title='Send Invoice to Client'><i class='feather icon-mail'></i></a>"+
                          "<a class='allocate_delivery_boy' href='<?php echo $this->baseUrl; ?>orders/update_delivery_boy' data-order_id='"+data.id+"' data-delivery_boy_id='"+data.delivery_boy_id+"'title='Allocat/Change Delivery Boy'><i class='feather icon-airplay'></i></a>";
				    }
            	}
            ],
            "createdRow": function ( row, data, index ) {}
		});

	oTable.on('click','.order_email',function(e){
	    e.preventDefault();

        $('.theme-loader').fadeIn();

        $.ajax({
            url: this.getAttribute('href'),
            method: 'GET',
            dataType: 'json',
            // data: {},
            success: function(data){

                if(data.success){
                    $("#flash_parent").append("<div class='row align-items-end m-t-5'>\n" +
                        "        <div class='col-sm-12'>\n" +
                        "            <div class='alert alert-success background-success' style='margin-bottom:5px;'>\n" +
                        "                <button type='button' class='close' data-dismiss='alert' aria-label='Close' style='margin-top: 2px;'>\n" +
                        "                    <i class='feather icon-x text-white'></i>\n" +
                        "                </button>\n" +
                        data.message +
                        "            </div>\n" +
                        "        </div>\n" +
                        "    </div>");
                }else{
                    $("#flash_parent").append("<div class='row align-items-end m-t-5'>\n" +
                        "        <div class='col-sm-12'>\n" +
                        "            <div class='alert alert-warning background-warning' style='margin-bottom:5px;'>\n" +
                        "                <button type='button' class='close' data-dismiss='alert' aria-label='Close' style='margin-top: 2px;'>\n" +
                        "                    <i class='feather icon-x text-white'></i>\n" +
                        "                </button>\n" +
                        data.message +
                        "            </div>\n" +
                        "        </div>\n" +
                        "    </div>");
                }
            },
            error	: function(xmlhttprequest,textStatus,error){
                // console.log(xmlhttprequest.responseText);
            },
            complete: function(xmlhttprequest,textStatus ){
                $('.theme-loader').fadeOut();
            }
        });
    }).on('click','.allocate_delivery_boy',function(e) {
        e.preventDefault();
        var $this = $(this);
        var order_id = $this.data('order_id');
        var delivery_boy_id = $this.data('delivery_boy_id');

        $delivery_boy.children().not(":first").remove();
        console.log(order_id,delivery_boy_id);

        $.ajax({
            url: '<?php echo $this->baseUrl; ?>orders/get_deliveryboy_by_order_id',
            method: 'POST',
            dataType: 'json',
            data: {'order_id':order_id},
            success: function(data){
                var optStr = "";

                console.log(data);
                $.each(data,function(i,delivery_boy){
                    var selected = (delivery_boy_id == delivery_boy.id) ? "selected" : "";
                    optStr += "<option value='"+delivery_boy.id+"' "+selected+">"+delivery_boy.first_name+" "+delivery_boy.last_name+"</option>";
                });
                $delivery_boy.append(optStr);
                $order_id.val(order_id);
                $delivery_boy_modal.modal('show');
            },
            error	: function(xmlhttprequest,textStatus,error){
                // console.log(xmlhttprequest.responseText);
                $("#flash_parent").append("<div class='row align-items-end m-t-5'>\n" +
                    "        <div class='col-sm-12'>\n" +
                    "            <div class='alert alert-warning background-warning' style='margin-bottom:5px;'>\n" +
                    "                <button type='button' class='close' data-dismiss='alert' aria-label='Close' style='margin-top: 2px;'>\n" +
                    "                    <i class='feather icon-x text-white'></i>\n" +
                    "                </button>\n" +
                    "Unable to fetch data" +
                    "            </div>\n" +
                    "        </div>\n" +
                    "    </div>");

            },
            complete: function(xmlhttprequest,textStatus ){
                // $('.theme-loader').fadeOut();
            }
        });

        // $delivery_boy.val(delivery_boy_id).trigger('change');
    });

    // $delivery_boy_modal.on('hidden.bs.modal',function(e){
    //     $delivery_boy.val('').trigger('change');
    //     $order_id.val('');
    // });
</script>
@endscript