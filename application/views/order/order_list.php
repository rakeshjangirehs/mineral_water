<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    &nbsp;
<!--                    <div class="card-header-right" style="padding:0px 0px;">-->
<!--                        <ul class="list-unstyled card-option">-->
<!--                            <li><i class="feather icon-maximize full-card"></i></li>-->
<!--                            <li title="Export Excel"><a href="--><?php //echo $this->baseUrl; ?><!--products/product_export"><i class="fa fa-file-excel-o"></i></a></li>-->
<!--                        </ul>-->
<!--                    </div>-->
                </div>
                <div class="card-block">
                    <div class="dt-responsive table-responsive">
                        <table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>orders/index" style="width: 100%;">
                            <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Client</th>
                                <th>Expected Delivery Date</th>
                                <th>Actual Delivery Date</th>
                                <th>Salesman</th>
<!--                                <th>Delivery Boy</th>-->
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
    // $('.nav .nav-list').activeSidebar('.product_li');
    $(".order_list_li").active();

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
                { "data": "id" },
                { "data": "client_name" },
                { "data": "expected_delivery_date" },
                { "data": "actual_delivery_date" },
                { "data": "salesman_name" },
                {
                	"data": 'link',
                	"sortable": false,
                	"render": function ( data, type, row, meta ) {
				      return "<a class='' href='<?php echo $this->baseUrl; ?>orders/order_details/"+data.id+"' title='View Invoice'><i class='feather icon-credit-card'></i></a>"+
                          "<a class='' id='order_email' href='<?php echo $this->baseUrl; ?>orders/email_order/"+data.id+"' title='Send Email'><i class='feather icon-mail'></i></a>";
				    }
            	}
            ],
		});

	oTable.on('click','#order_email',function(e){
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
                console.log(arguments);
                $('.theme-loader').fadeOut();
            }
        });
    });
</script>
@endscript