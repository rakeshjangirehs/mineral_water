<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    &nbsp;
                    <div class="card-header-right" style="padding:0px 0px;">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-maximize full-card"></i></li>
                            <!-- <li title="Export Excel"><a href="<?php //echo $this->baseUrl; ?>clients/client_export"><i class="fa fa-file-excel-o"></i></a></li> -->
                        </ul>
                    </div>
                </div>
                <div class="card-block">
                    <div class="dt-responsive table-responsive">
                        <table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>schemes/index" style="width:100%;">
                            <thead>
                            <tr>
                                <th>Scheme Name</th>
                                <th>Type</th>
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
    $(".scheme_list_li").active();

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
                { "data": "name" },
                { "data": "type" },
                {
                	"data": 'link',
                	"sortable": false,
                	"render": function ( data, type, row, meta ) {
                      return "<a class='' href='<?php echo $this->baseUrl; ?>schemes/add_update/"+data.id+"' title='Edit Scheme'><i class='feather icon-edit'></i></a>" +
                          "<a class='text-danger' id='delete_client' href='<?php echo $this->baseUrl; ?>schemes/delete/"+data.id+"' title='Delete Scheme'><i class='feather icon-trash-2'></i></a>";
				    }
            	}
            ],
		}).on('click','#delete_client',function(e){
            e.preventDefault();

            var url = this.getAttribute('href');

            swal(
                {
                    title: "Delete Scheme ?",
                    text: "You will not be able to recover this Scheme!",
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