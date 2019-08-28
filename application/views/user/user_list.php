<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-header-right" style="padding:0px 0px;">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-maximize full-card"></i></li>
                            <li title="Export Excel"><a href="<?php echo $this->baseUrl; ?>users/user_export" ><i class="fa fa-file-excel-o"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-block">
                    <div class="dt-responsive table-responsive">
                        <table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>users/index" style="width:100%;">
                            <thead>
                            <tr>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>ZIP Codes</th>
                                <th>ZIP Code Groups</th>
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
    $(".user_list_li").active();

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
                { "data": "first_name" },
                { "data": "last_name" },
                { "data": "username" },
                { "data": "email" },
                { "data": "phone" },
                { "data": "role_name" },
                {
                    "data": "user_zip_codes",
                    orderable:false,
                    "render": function ( data, type, row, meta ) {
                        if(data !== null && data.length > 20){
                            return data.substring(0,20) + "...";
                        }else{
                            return data;
                        }
                    }
                },
                {
                    "data": "user_zip_code_groups",
                    orderable:false,
                    "render": function ( data, type, row, meta ) {

                        if(data !== null && data.length > 20){
                            return data.substring(0,20) + "...";
                        }else{
                            return data;
                        }
                    }
                },
                {
                	"data": 'link',
                    orderable:false,
                    "sortable": false,
                	"render": function ( data, type, row, meta ) {
				      return "<a class='' href='<?php echo $this->baseUrl; ?>users/add_update/"+data.id+"' title='Edit User'><i class='feather icon-edit'></i></a>";
				    }
            	}
            ],
		});
</script>
@endscript