<div class="row">
	<div class="col-sm-12">
		<div class="panel-group">
		  	<div class="panel panel-primary">
			    <div class="panel-heading">
			    	<?php echo $page_title; ?>
			    	<span class="pull-right"><a class="btn btn-success btn-minier" style="margin-top: -8px;" href="<?php echo $this->baseUrl; ?>products/product_export">
                            <i class="ace-icon fa fa-file-excel-o bigger-110"></i>
                            Export
                    </a></span>
			    </div>
			    <div class="panel-body">
			    	<table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>products/index">
			    		<thead>
							<tr>
								<th>Code</th>
								<th>Name</th>
								<th>Weight</th>
								<th>Dimension</th>
								<th>Cost</th>
								<th>Price</th>
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
    <a class="btn btn-warning btn-sm" title="Add Product" href="<?php echo $this->baseUrl.'products/add_update';?>">
        <i class="fa fa-plus"></i>
    </a>
</div>

@script
<script type="text/javascript">
	// to active the sidebar
    $('.nav .nav-list').activeSidebar('.product_li');

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
                { "data": "product_code" },
                { "data": "product_name" },
                { "data": "weight" },
                { "data": "dimension" },
                { "data": "cost_price" },
                { "data": "sale_price" },
                {
                	"data": 'link',
                	"sortable": false,
                	"render": function ( data, type, row, meta ) {
				      return "<a class='orange' href='<?php echo $this->baseUrl; ?>products/add_update/"+data.id+"' title='Update Product'><i class='ace-icon fa fa-pencil-square bigger-130'></i></a>";
				    }
            	}
            ],
		});
</script>
@endscript