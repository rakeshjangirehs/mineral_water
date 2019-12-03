<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    &nbsp;
                    <div class="card-header-right" style="padding:0px 0px;">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-maximize full-card"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="card-block">
                    <div class="row m-b-30">
                        <div class="col-sm-12">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs md-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#pending_orders_tab" role="tab">Pending Orders</a>
                                    <div class="slide"></div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#ontheway_orders_tab" role="tab">Out For Delivery</a>
                                    <div class="slide"></div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#completed_orders_tab" role="tab">Completed</a>
                                    <div class="slide"></div>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content card-block" id="table_patent">
                                <div class="tab-pane active" id="pending_orders_tab" role="tabpanel">
                                    <div class="dt-responsive table-responsive">
                                        <table id="pending_orders" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>orders/index/pending" style="width: 100%;">
                                            <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Status</th>
                                                <th>Client</th>
                                                <th>C Delivery Dt</th>
                                                <th>Order Amount</th>
                                                <th>Effective Amount</th>
                                                <th>Salesman</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="ontheway_orders_tab" role="tabpanel">
                                    <div class="dt-responsive table-responsive">
                                        <table id="ontheway_orders" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>orders/index/ontheway" style="width: 100%;">
                                            <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Client</th>
                                                <th>C Delivery Dt</th>
                                                <th>Order Amount</th>
                                                <th>Effective Amount</th>
                                                <th>Expected Delivery Date</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="completed_orders_tab" role="tabpanel">
                                    <div class="dt-responsive table-responsive">
                                        <table id="completed_orders" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>orders/index/completed" style="width: 100%;">
                                            <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Client</th>
                                                <th>C Delivery Dt</th>
                                                <th>Order Amount</th>
                                                <th>Effective Amount</th>
                                                <th>Expected Delivery Date</th>
                                                <th>Actual Delivery Date</th>
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
    </div>
</div>
<!-- Modal static-->
<div class="modal fade" id="delivery_boy_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form method="post" action="<?php echo $this->baseUrl; ?>orders/update_delivery_boy">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add/Update Delivery Boy</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="order_id" id="order_id"/>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <select class="form-control" data-placeholder="Choose Delivery Boy" id="delivery_boy" name="delivery_boy">
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="expected_delivery_date" name="expected_delivery_date">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary waves-effect waves-light ">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

@script
<script type="text/javascript">
	
    $(function(){
        // to active the sidebar
        $(".order_list_li").active();

        $delivery_boy_modal = $("#delivery_boy_modal");
        $delivery_boy = $("#delivery_boy");
        $order_id = $("#order_id");

        $delivery_boy.select2({
            allowClear:true,
            dropdownParent:$delivery_boy_modal
        });

        $("#expected_delivery_date").datepicker({
            format		:	"yyyy-mm-dd",
            autoclose	:	true,
            todayBtn	:	"linked",
            // clearBtn	:	true,
            // endDate		: 	moment().format("YYYY-MM-DD"),
            // maxViewMode : 	2
            //orientation: "bottom left"
        })

        $("#pending_orders").DataTable({
            "processing": true,
            "serverSide": true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "ajax":{
                "url": $("#pending_orders").data('url'),
                "dataType": "json",
                "type": "POST",
            },
            "order": [
                [ 0, "desc" ]
            ],
            "columns": [
                { "data": "id" },
                { "data": "order_status" },
                { "data": "client_name" },
                { "data": "expected_delivery_date" },
                { "data": "payable_amount" },
                { "data": "effective_price" },
                { "data": "salesman_name" },
                {
                    "data": 'link',
                    "sortable": false,
                    "render": function ( data, type, row, meta ) {
                        if(row.need_admin_approval==1 && row.order_status=='Approval Required'){
                            return "<a class='' href='<?php echo $this->baseUrl; ?>orders/order_prodcuts/"+data.id+"' title='Admin Approval Required'><i class='fa fa-check'></i></a>";
                        }else{
                            return "";
                        }
                    }
                }
            ],
            "createdRow": function ( row, data, index ) {}
        });
        
        $("#ontheway_orders").DataTable({
            "processing": true,
            "serverSide": true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "ajax":{
                "url": $("#ontheway_orders").data('url'),
                "dataType": "json",
                "type": "POST",
            },
            "order": [
                [ 0, "desc" ]
            ],
            "columns": [
                { "data": "id" },
                { "data": "client_name" },
                { "data": "expected_delivery_date" },
                { "data": "payable_amount" },
                { "data": "effective_price" },
                { "data": "expected_delivey_datetime" }
            ],
            "createdRow": function ( row, data, index ) {}
        });
        
        $("#completed_orders").DataTable({
            "processing": true,
            "serverSide": true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "ajax":{
                "url": $("#completed_orders").data('url'),
                "dataType": "json",
                "type": "POST",
            },
            "order": [
                [ 0, "desc" ]
            ],
            "columns": [
                { "data": "id" },
                { "data": "client_name" },
                { "data": "expected_delivery_date" },
                { "data": "payable_amount" },
                { "data": "effective_price" },
                { "data": "expected_delivey_datetime" },
                { "data": "actual_delivey_datetime" },
                {
                    "data": 'link',
                    "sortable": false,
                    "render": function ( data, type, row, meta ) {
                    return "<a class='' href='<?php echo $this->baseUrl; ?>orders/order_details/"+data.id+"' title='View Invoice'><i class='feather icon-credit-card'></i></a>"+
                        "<a class='order_email' href='<?php echo $this->baseUrl; ?>orders/email_order/"+data.id+"' title='Send Invoice to Client'><i class='feather icon-mail'></i></a>";
                    }
                }
            ],
            "createdRow": function ( row, data, index ) {}
        });


        $(".table").each((i,el)=>{
            var table = $(el);
        });

        //jugad
        $('a[data-toggle="tab"]').on( 'click', function (e) {            
            $(".tab-pane","#table_patent").not($(this).attr('href')).removeClass('active');
        } );

        $("#table_patent").on('click','.order_email',function(e){

            e.preventDefault();

            $("#flash_parent").children().not("#inactivity_logout").remove();

            $('.theme-loader').fadeIn();

            $.ajax({
                url: this.getAttribute('href'),
                method: 'GET',
                dataType: 'json',
                // data: {},
                success: function(data){

                    if(data.success){
                        $("#flash_parent").append("<div class='row align-items-end m-t-5'>\n" +
                            "        <div class='col-sm-12'>\n" +
                            "            <div class='alert alert-success background-success' style='margin-bottom:5px;'>\n" +
                            "                <button type='button' class='close' data-dismiss='alert' aria-label='Close' style='margin-top: 2px;'>\n" +
                            "                    <i class='feather icon-x text-white'></i>\n" +
                            "                </button>\n" +
                            data.message +
                            "            </div>\n" +
                            "        </div>\n" +
                            "    </div>");
                    }else{
                        $("#flash_parent").append("<div class='row align-items-end m-t-5'>\n" +
                            "        <div class='col-sm-12'>\n" +
                            "            <div class='alert alert-warning background-warning' style='margin-bottom:5px;'>\n" +
                            "                <button type='button' class='close' data-dismiss='alert' aria-label='Close' style='margin-top: 2px;'>\n" +
                            "                    <i class='feather icon-x text-white'></i>\n" +
                            "                </button>\n" +
                            data.message +
                            "            </div>\n" +
                            "        </div>\n" +
                            "    </div>");
                    }
                },
                error	: function(xmlhttprequest,textStatus,error){
                    // console.log(xmlhttprequest.responseText);
                },
                complete: function(xmlhttprequest,textStatus ){
                    $('.theme-loader').fadeOut();
                }
            });
        }).on('click','.allocate_delivery_boy',function(e) {

            e.preventDefault();
            var $this = $(this);
            var order_id = $this.data('order_id');
            var delivery_boy_id = $this.data('delivery_boy_id');
            var expected_delivery_date = $this.data('expected_delivery_date');

            $("#expected_delivery_date").val(expected_delivery_date);
            $delivery_boy.children().not(":first").remove();
            // console.log(order_id,delivery_boy_id);
            // console.log(expected_delivery_date);

            $.ajax({
                url: '<?php echo $this->baseUrl; ?>orders/get_deliveryboy_by_order_id',
                method: 'POST',
                dataType: 'json',
                data: {'order_id':order_id},
                success: function(data){
                    var optStr = "";

                    // console.log(data);
                    $.each(data,function(i,delivery_boy){
                        var selected = (delivery_boy_id == delivery_boy.id) ? "selected" : "";
                        optStr += "<option value='"+delivery_boy.id+"' "+selected+">"+delivery_boy.first_name+" "+delivery_boy.last_name+"</option>";
                    });
                    $delivery_boy.append(optStr);
                    $order_id.val(order_id);
                    $delivery_boy_modal.modal('show');
                },
                error	: function(xmlhttprequest,textStatus,error){
                    // console.log(xmlhttprequest.responseText);
                    $("#flash_parent").append("<div class='row align-items-end m-t-5'>\n" +
                        "        <div class='col-sm-12'>\n" +
                        "            <div class='alert alert-warning background-warning' style='margin-bottom:5px;'>\n" +
                        "                <button type='button' class='close' data-dismiss='alert' aria-label='Close' style='margin-top: 2px;'>\n" +
                        "                    <i class='feather icon-x text-white'></i>\n" +
                        "                </button>\n" +
                        "Unable to fetch data" +
                        "            </div>\n" +
                        "        </div>\n" +
                        "    </div>");

                },
                complete: function(xmlhttprequest,textStatus ){
                    // $('.theme-loader').fadeOut();
                }
            });

            // $delivery_boy.val(delivery_boy_id).trigger('change');
        });

        // $delivery_boy_modal.on('hidden.bs.modal',function(e){
        //     $delivery_boy.val('').trigger('change');
        //     $order_id.val('');
        // });
    });
</script>
@endscript