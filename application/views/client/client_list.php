<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    &nbsp;
                    <div class="card-header-right" style="padding:0px 0px;">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-maximize full-card"></i></li>
                            <li title="Export Excel"><a href="<?php echo $this->baseUrl; ?>clients/client_export"><i class="fa fa-file-excel-o"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-block">
                    <div class="dt-responsive table-responsive">
                        <table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>clients/index" style="width:100%;">
                            <thead>
                            <tr>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Credit Limit</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>ZIP Code</th>
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
    // $('.nav .nav-list').activeSidebar('.cilent_list_li');
    $(".cilent_list_li").active();
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
                { 
                    "data": "first_name",
                    "render": function(data, type, row, meta){
                        console.log(row);
                        return "<a class='' href='<?php echo $this->baseUrl; ?>payments/index/"+row.id+"' title='Make Payment'>"+row.first_name+"</a>";
                    }
                },
                { "data": "last_name" },
                { "data": "credit_limit" },
                { "data": "email" },
                { "data": "address" },
                { "data": "zip_code" },
                {
                	"data": 'link',
                	"sortable": false,
                	"render": function ( data, type, row, meta ) {
				      return "<a class='' href='<?php echo $this->baseUrl; ?>clients/add_update/"+data.id+"' title='Edit Client'><i class='feather icon-edit'></i></a>" +
                          "&nbsp;<a class='' href='<?php echo $this->baseUrl; ?>clients/contacts/"+data.id+"' title='Client Contacts'><i class='feather icon-phone-call'></i></a>" +
                          "&nbsp;<a class=' ' href='<?php echo $this->baseUrl; ?>clients/add_location/"+data.id+"' title='Client Location'><i class='feather icon-map-pin'></i></a>";
				    }
            	}
            ],
		});
</script>
@endscript