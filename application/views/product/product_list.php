<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    &nbsp;
                    <div class="card-header-right" style="padding:0px 0px;">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-maximize full-card"></i></li>
                            <li title="Export Excel"><a href="<?php echo $this->baseUrl; ?>products/product_export"><i class="fa fa-file-excel-o"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-block">
                    <div class="dt-responsive table-responsive">
                        <table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>products/index" style="width: 100%;">
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product Code</th>
                                <th>Product Name</th>
                                <th>Brand</th>
                                <th>Weight (Kg)</th>
                                <th>Cost Price</th>
                                <th>Sale Price</th>
                                <th>Manage Stock</th>
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
    $(".product_list_li").active();

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
                [ 1, "desc" ]
            ],
            "columns": [
                {
                    "data": "image_url",
                    "sortable": false,
                    "render":function ( data, type, row, meta ) {
                        return (row.image_url) ? "<img src='"+row.image_url+"' class='img_small' alt='Product Image' style='height: 25px;'/>" : '';
                    }
                },
                { "data": "product_code" },
                { "data": "product_name" },
                { "data": "brand_name" },
                { "data": "weight" },
                { "data": "cost_price" },
                { "data": "sale_price" },
                { "data": "manage_stock" },
                {
                	"data": 'link',
                	"sortable": false,
                	"render": function ( data, type, row, meta ) {
				      return "<a class='orange' href='<?php echo $this->baseUrl; ?>products/add_update/"+data.id+"' title='Edit Product'><i class='feather icon-edit'></i></a>" +
                             "<a class='text-danger delete_product' href='<?php echo $this->baseUrl; ?>products/delete/"+data.id+"' title='Delete Product'><i class='feather icon-trash-2'></i></a>";
				    }
            	}
            ],
		}).on('click','.delete_product',function(e){
            e.preventDefault();

            var url = this.getAttribute('href');

            swal(
                {
                    title: "Delete Product ?",
                    text: "You will not be able to recover this product!",
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
        }).on('mouseover','.img_small',function (e) {
            // $(this).css({'height':'100px'});
        }).on('mouseout','.img_small',function (e) {
            // $(this).css({'height':'25px'});
        });
</script>
@endscript