<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>clients/client_inventory" style="width:100%;">
                                    <thead>
                                    <tr>
                                        <th>Client</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
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
    </div>
</div>

<div class="modal fade" id="my_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Datils View :<span id="client_name"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="dt-responsive table-responsive">
                    <table id="modal-table" class="table table-striped table-bordered table-hover" style="width:100%;">
                        <thead>
                            <tr>
                                <th>Delivery Date</th>
                                <th>Existing Quantity</th>
                                <th>New Delivered</th>
                                <th>Empty Collected</th>
                                <th>Team</th>
                            </tr>
                        </thead>
                        <tbody id="modal-table-body">
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
    // $('.nav .nav-list').activeSidebar('.zipcodegroup_li');
    $(".client_inventory_li").active();

    var table = $("#dynamic-table");

    var $my_modal = $("#my_modal");
    var $modal_table_body = $("#modal-table-body");
    var $client_name = $("#client_name");
    
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
                { "data": "client_name" },
                { "data": "product_name" },
                { "data": "client_quantity" },
                {
                	"data": 'clinet_id',
                	"sortable": false,
                	"render": function ( clinet_id, type, row, meta ) {
                        return "<a class='view_details' href='<?php echo $this->baseUrl; ?>clients/client_inventory_history/"+clinet_id+"' title='View Details'><i class='feather icon-list'></i></a>";
				    }
            	}
            ]
        }).on('click','.view_details',function(e){

            e.preventDefault();
            var url = this.getAttribute('href');

            // console.log("URL for ajax : ",url);

            $client_name.text('');
            $modal_table_body.empty();

            $.ajax({
                "url"   :   url,
                "method":   "get",
                "dataType": "json",
                "success":  function(response){
                    
                    var $str = "";
                    var client_name = "";
                    
                    if(response.status === true){
                        if(response.payload.length>0){
                            client_name = response.payload[0]['client_name'];
                            $.each(response.payload, function(i,arr){
                                $str += "<tr>\
                                            <td>"+arr.delivey_date+"</td>\
                                            <td>"+arr.existing_quentity+"</td>\
                                            <td>"+arr.new_delivered+"</td>\
                                            <td>"+arr.empty_collected+"</td>\
                                            <td>"+arr.team+"</td>\
                                        </tr>";
                            });
                        }
                    }

                    if($str){
                        $modal_table_body.append($str);
                    }

                    $client_name.text(client_name);

                    $my_modal.modal('show');
                },
                error: function (jqXHR, exception) {
                    swal("Can't Process", "Server Error", "info");
                }
            });
        });
</script>
@endscript