<div class="row">
	<div class="col-sm-6">
		<div class="panel-group">
		  	<div class="panel panel-primary">
			    <div class="panel-heading">Zipcode </div>
			    <div class="panel-body">
			    	<form data-action="<?php echo $this->baseUrl; ?>zipcodes/save" id="deptFrm" method="post">
			    		<input type="hidden" name="zipcode_id" id="zip_id"/>
					 	<div class="form-group">
					    	<label for="zipcode">Zipcode:</label>
					    	<input type="text" class="form-control" name="zipcode" id="zipcode" required />
					  	</div>
					  	<button type="submit" class="btn btn-default">Save</button>
					  	<button type="button" class="btn btn-danger" onclick="reset_form();">Reset</button>
					</form>
			    </div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="panel-group">
		  	<div class="panel panel-primary">
			    <div class="panel-heading">
			    	Zipcode List
			    	<span class="pull-right"><a class="btn btn-info btn-sm" style="margin-top: -8px;" href="<?php echo $this->baseUrl; ?>zipcodes/zip_export">Export</a></span>
			    </div>
			    <div class="panel-body">
			    	<table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>zipcodes/index">
			    		<thead>
							<tr>
								<th>Zipcode</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody></tbody>
			    	</table>
			    </div>
			</div>
		</div>
	</div>
</div>

@script
<script type="text/javascript">
	// to active the sidebar
    $('.nav .nav-list').activeSidebar('.zipcode_li');

	var deptFrm = $("#deptFrm");
	var table = $("#dynamic-table");
	var zipcode = $("#zipcode");
	var zip_id = $("#zip_id");

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
            "columns": [
                { "data": "zip_code" },
                {
                	"data": null,
                	"render": function ( data, type, row, meta ) {
				      return "<a class='green zip_edit' href='#' data-id='"+data.id+"' data-name='"+data.zip_code+"'><i class='ace-icon fa fa-pencil bigger-130'></i></a>";
				    }
            	}
            ],
		})
		.on('click', '.zip_edit',function(e){
			e.preventDefault();
			var $this = $(this);
			reset_form();
			zipcode.val($this.data('name'));
			zip_id.val($this.data('id'));
		});

	// submit form event
	deptFrm.on('submit', function(e){
		e.preventDefault();
		var data = $(this).serialize();
		$.ajax({
			url: $(this).data('action'),
			method: 'post',
			dataType: 'json',
			data: data,
			success: function(data){
				reset_form();
				window.location.reload();
			}
		});
	});

	function reset_form(){
		deptFrm.trigger("reset");
		zip_id.val("");
	}
</script>
@endscript