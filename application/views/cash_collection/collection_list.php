<style>
    .submitable{
        display:none;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 16px;
        font-size: 13px;
    }
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="page-body">
            <div class="card">                        
                <div class="card-block">
                    <div class="row">
                        <div class="col-sm-12">
                            <form method="post" action="<?php echo $this->baseUrl; ?>cashcollection" id="tagFrm" autocomplete="off">
                                <div class="row">
                                    <div class="col-sm-12 col-md-5">
                                        <select class="form-control select2" style="width:100%" data-placeholder="Choose User" id="salesman" name="salesman">
                                            <option></option>
                                            <?php foreach($users as $k=>$user){
                                                $selected = ($user['id'] == $user_id) ? 'selected' : '';
                                                echo "<option value='{$user['id']}' {$selected}>{$user['first_name']} {$user['last_name']} - ({$user['role_name']})</option>";
                                            }?>
                                        </select>
                                        <span class="messages"><?php echo form_error('salesman');?></span>
                                    </div>                                    
                                    <div class="col-sm-12 col-md-2 submitable" style="text-align:center;padding: 5px;">
                                        Balance : <span id="pending_amount"></span>
                                    </div>
                                    <div class="col-sm-12 col-md-3 submitable">
                                        <input type="hidden" name="pending_amount_hidden" id="pending_amount_hidden" value=""/>
                                        <input type="text" class="form-control" placeholder="Amount to clear" name="amount_clearing" id="amount_clearing" value="<?php echo set_value('amount_clearing');?>"/>
                                        <span class="messages"><?php echo form_error('amount_clearing');?></span>
                                    </div>
                                    <div class="col-sm-12 col-md-2 submitable">
                                        <button type="submit" class="btn btn-sm btn-primary">Clear Balance</button>
                                    </div>
                                </div>
                            </form>
                        </div>                   
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <h4 class="sub-title">Collection From Client
                                <span class="text-success m-t-20" id="total_client_collection"></span>
                            </h4>
                            <div class="dt-responsive table-responsive">
                                <table id="client_collection_table" class="table table-striped table-bordered table-hover" style="width:100%;">
                                    <thead>
                                    <tr>
                                        <th>Client Name</th>
                                        <th>Order Id</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <h4 class="sub-title">Cash Recieved from User
                                <span class="text-success m-t-20" id="total_user_collection"></span>
                            </h4>
                            <div class="dt-responsive table-responsive">
                                <table id="user_collection_table" class="table table-striped table-bordered table-hover" style="width:100%;">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
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
</div>

@script
<script type="text/javascript">
    // to active the sidebar
    // $('.nav .nav-list').activeSidebar('.vehicle_li');
    $(".cash_collection_li").active();


    var $salesman = $("#salesman");
    var $pending_amount = $("#pending_amount");
    var $pending_amount_hidden = $("#pending_amount_hidden");
    var $amount_clearing = $("#amount_clearing");

    var $user_collection_table = $("#user_collection_table");
    var $client_collection_table = $("#client_collection_table");
    
    var $total_client_collection = $("#total_client_collection");
    var $total_user_collection = $("#total_user_collection");
    var $submitable = $(".submitable");

    var client_collection_tbl = $client_collection_table.DataTable();
    var user_collection_tbl = $user_collection_table.DataTable().on('click','.remove_collection',function(e){

        e.preventDefault();

            var url = this.getAttribute('href');

            swal(
                {
                    title: "Delete Collection Entry ?",
                    // text: "You will not be able to recover this brand!",
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

    var validator = $("#tagFrm").validate({
        // debug:true,
        rules   : 	{
                        "salesman"		:	{
                            required:true,
                        },
                        "amount_clearing"		:	{
                            required:true,
                            // digits:true,
                            // number:true,
                            regex:/^(\d*\.)?\d+$/
                        },
                    },
        messages:{
            amount_clearing		:	{                
                regex			:	"This Field can only contain positive numbers."
            },
        },
        errorElement: "p",
        errorClass:"text-danger error",
        errorPlacement: function ( error, element ) {
            element.after(error);
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    $salesman.change(function(e){   
        
        var $this = $(this);
        var salesman_id = $this.val();
        client_collection_tbl.rows().remove();
        user_collection_tbl.rows().remove();

        if(salesman_id){
            $.ajax({
                "url"       :   "<?php echo $this->baseUrl; ?>cashcollection",
                "method":   "post",
                "dataType": "json",
                "data"  :   {
                    "salesman_id"    :   salesman_id
                },
                "success":  function(data){
                    
                    var total_client_payments = 0;
                    var total_user_payments = 0;

                    if(data.client_payments){

                        $.each(data.client_payments,function(i,dt){
                            
                            client_collection_tbl.row.add([
                                dt.client_name,
                                dt.order_id,
                                dt.delivey_date,
                                dt.amount,
                            ]);

                            var amount = parseFloat(dt.amount) || 0;
                            total_client_payments += amount;
                        });                        

                        client_collection_tbl.draw();

                        if(total_client_payments){
                            $total_client_collection.text("( Total : "+total_client_payments+" )");
                        }else{
                            $total_client_collection.text("");
                        }
                    }

                    if(data.user_payments){

                        $.each(data.user_payments,function(i,dt){
                            
                            user_collection_tbl.row.add([
                                dt.collection_date,
                                dt.amount,
                                "<a class='text-danger remove_collection' href='<?php echo $this->baseUrl; ?>cashcollection/delete/"+dt.id+"/"+dt.user_id+"' title='Remove Entry'><i class='feather icon-trash-2'></i></a>",
                            ]);

                            var amount = parseFloat(dt.amount) || 0;
                            total_user_payments += amount;
                        });                        

                        user_collection_tbl.draw();

                        if(total_client_payments){
                            $total_user_collection.text("( Total : "+total_user_payments+" )");
                        }else{
                            $total_user_collection.text("");
                        }
                    }

                    var balance = total_client_payments-total_user_payments;
                    $pending_amount.text(balance);
                    if(balance >= 0){
                        $pending_amount.removeClass('text-danger').addClass('text-success');
                    }else{
                        $pending_amount.removeClass('text-success').addClass('text-danger');
                    }
                    $pending_amount_hidden.val(balance);
                    if(balance){
                        $submitable.show();
                    }

                }
            });
        }else{
            client_collection_tbl.draw();
            user_collection_tbl.draw();
            $total_client_collection.text("");
            $total_user_collection.text("");
            $pending_amount.text("");
            $pending_amount_hidden.val("");
            $submitable.hide();
        }

    }).trigger('change');
    
</script>
@endscript