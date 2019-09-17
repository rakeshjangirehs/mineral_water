<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-right" style="padding:0px 0px;">
                                <ul class="list-unstyled card-option">
                                    <li><i class="feather icon-maximize full-card"></i></li>
                                    <li title="Export Excel"><a href="<?php echo $this->baseUrl; ?>payments/payments_list_export"><i class="fa fa-file-excel-o"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>payments/payments_list" style="width:100%;">
                                    <thead>
                                    <tr>
                                        <th>Client Name</th>
                                        <th>Payment Mode</th>
                                        <th>Paid Amount</th>
                                        <th>Payment Date</th>
                                        <th>Client Email</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <p class="text-custom">To post payment of a client, navigate to <a href="<?php echo $this->baseUrl;?>clients" target="_blank"><u>Client List</u></a>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script type="text/javascript">

    // to active the sidebar
    $(".payment_list_li").active();

	var table = $("#dynamic-table");
	var oTable = table
		.DataTable({
			"processing": true,
			"serverSide": true,
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			"ajax":{
                "url": table.data('url'),
                "dataType": "json",
                'cache': false,
                "type": "POST",
            },
            "order": [
                [ 3, "desc" ]
            ],
            "columns": [
                { "data": "client_name" },
                { "data": "payment_mode" },
                { "data": "paid_amount" },
                { "data": "payment_date" },
                { "data": "client_email" },
                {
                	"data": null,
                	"sortable": false,
                	"render": function ( data, type, row, meta ) {
				      return "<a class='' href='<?php echo $this->baseUrl; ?>payments/view_payment/"+data.id+"' title='View Payment'><i class='feather icon-eye'></i></a>" +
                              "<a class='send_reciept' href='<?php echo $this->baseUrl; ?>payments/email_reciept/"+data.id+"' title='Send Reciept to Client'><i class='feather icon-mail'></i></a>"+
                            "<a class='text-danger delete_payment' href='<?php echo $this->baseUrl; ?>payments/delete_payment/"+data.id+"' title='Delete Payment'><i class='feather icon-trash-2'></i></a>";
				    }
            	}
            ],
		}).on('click','.send_reciept',function(e){
            e.preventDefault();

            $("#flash_parent").children().not("#inactivity_logout").remove();

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
        }).on('click','.delete_payment',function(e){
            e.preventDefault();

            var url = this.getAttribute('href');

            swal(
                {
                    title: "Delete Payment ?",
                    text: "You will not be able to recover this payment!",
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