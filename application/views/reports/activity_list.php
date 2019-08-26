<div class="row">
	<div class="col-sm-12">
		<div class="panel-group">
		  	<div class="panel panel-primary">
			    <div class="panel-heading">
			    	Equipment List
			    	<span class="pull-right"><a class="btn btn-info btn-sm" style="margin-top: -8px;" href="<?php echo $this->baseUrl; ?>reports/activity_export">Export</a></span>
			    </div>
			    <div class="panel-body">
			    	<table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>reports/routine_activity">
			    		<thead>
							<tr>
								<th>Plant</th>
								<th>Equipment</th>
								<th>Tag No</th>
								<th>Equipment Use</th>
								<th>Activity</th>
								<th>Created By</th>
								<th>Created At</th>
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

@script
<script type="text/javascript">
	// to active the sidebar
    $('.nav .nav-list').activeSidebar('.reports_activity_li');

	var table = $("#dynamic-table");
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
                { "data": "plant_name" },
                { "data": "equipment_name" },
                { "data": "tag_no" },
                { "data": "equipment_use" },
                { "data": "comment" },
                { "data": "first_name" },
                { "data": "created_at" },
            ],
		});
</script>
@endscript