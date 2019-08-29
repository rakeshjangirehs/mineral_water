<div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-right" style="padding:0px 0px;">
                                <ul class="list-unstyled card-option">
                                    <li><i class="feather icon-maximize full-card"></i></li>
                                    <li title="Export Excel"><a href="<?php echo $this->baseUrl; ?>zipcodes/zip_export"><i class="fa fa-file-excel-o"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>zipcodes/index" style="width:100%;">
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
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <form data-action="<?php echo $this->baseUrl; ?>zipcodes/save" id="deptFrm" method="post">
                        <div class="card">
                            <div class="card-header">
                                <h5 id="form_title">Add ZIP Code</h5>
                            </div>
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-sm-12 ">
                                        <div class="form-group">
                                            <label for="zipcode">Zip Code:</label>
                                            <input type="text" name="zipcode" id="zipcode" class="form-control" required/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <input type="hidden" name="zipcode_id" id="zip_id"/>
                                    <button type="submit" class="btn btn-sm btn-primary" id="submit_button">Add</button>
                                    <button type="button" class="btn btn-sm btn-default" onclick="reset_form();">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script type="text/javascript">

    // to active the sidebar
    $(".zipcode_li").active();

    var $submit_button = $("#submit_button");
    var $form_title = $("#form_title");
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
                	"sortable": false,
                	"render": function ( data, type, row, meta ) {
				      return "<a class='green zip_edit' href='#' data-id='"+data.id+"' data-name='"+data.zip_code+"' title='Edit ZIP Code'><i class='feather icon-edit'></i></a>";
				    }
            	}
            ],
		})
		.on('click', '.zip_edit',function(e){

			e.preventDefault();
			var $this = $(this);
			reset_form();

			$form_title.text("Update ZIP Code");
            $submit_button.text("Update");
            $parent_tr = $(this).closest('tr').addClass('active_row');

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
        $form_title.text("Add ZIP Code");
        $submit_button.text("Add");

        table.find('tbody').find('tr').removeClass('active_row');
	}
</script>
@endscript