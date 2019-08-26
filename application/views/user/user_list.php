<div class="row">
	<div class="col-sm-12">
		<div class="panel-group">
		  	<div class="panel panel-primary">
			    <div class="panel-heading">
			    	<?php echo $page_title; ?>
			    	<span class="pull-right"><a class="btn btn-success btn-minier" style="margin-top: -8px;" href="<?php echo $this->baseUrl; ?>users/user_export">
                            <i class="ace-icon fa fa-file-excel-o bigger-110"></i>
                            Export
                    </a></span>
			    </div>
			    <div class="panel-body">
			    	<table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>users/index">
			    		<thead>
							<tr>
								<th>Firstname</th>
								<th>Lastname</th>
								<th>Username</th>
								<th>Email</th>
								<th>Phone</th>
								<th>Role</th>
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

<!-- Float Button-->
<div class="float_btn_parent">
    <a class="btn btn-warning btn-sm" title="Add Equipment Tag" href="<?php echo $this->baseUrl.'users/add_update';?>">
        <i class="fa fa-plus"></i>
    </a>
</div>

@script
<script type="text/javascript">
	// to active the sidebar
    $('.nav .nav-list').activeSidebar('.user_list_li');

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
                	"data": 'link',
                	"render": function ( data, type, row, meta ) {
				      return "<a class='plant_edit' href='<?php echo $this->baseUrl; ?>users/add_update/"+data.id+"' title='Edit User'><i class='ace-icon fa fa-pencil-square-o bigger-130'></i></a>";
				    }
            	}
            ],
		});
</script>
@endscript