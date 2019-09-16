<style>
    .details{
        position: absolute;
        left: 190px;
    }
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="page-body">
            <form data-action="<?php echo $this->baseUrl; ?>users/add_update/<?php //echo $id; ?>" id="post_payment_form" method="post">
                <input type="hidden" name="client_id" value="<?php echo $client_detail['id']; ?>"/>
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-right" style="padding:0px 0px;">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-maximize full-card"></i></li>
                                <!--<li title="Export Excel"><a href="<?php //echo $this->baseUrl; ?>vehicles/vehicle_export"><i class="fa fa-file-excel-o"></i></a></li>-->
                            </ul>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="row m-t-20">
                            <div class="col-sm-12 col-md-6">

                                <div class="form-group row">
                                    <label for="payment_mode" class="col-form-label col-md-4">Paymont Mode:</label>
                                    <div class="col-sm-8">
                                        <select name="payment_mode" id="payment_mode" class="form-control">
                                            <option value="" disabled>Choose Payment Mode</option>
                                            <option value="Cash">Cash</option>
                                            <option value="Cheque">Cheque</option>
                                            <option value="Credit Card">Credit Card</option>
                                        </select>
                                        <span class="messages"><?php echo form_error('payment_mode');?></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="paid_amount" class="col-form-label col-md-4">Paid Amount:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="paid_amount" id="paid_amount" class="form-control"/>
                                        <span class="messages"><?php echo form_error('paid_amount');?></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="check_no" class="col-form-label col-md-4">Cheque No:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="check_no" id="check_no" class="form-control" readonly/>
                                        <span class="messages"><?php echo form_error('check_no');?></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="check_date" class="col-form-label col-md-4">Cheque Date:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="check_date" id="dropper-default" class="form-control" readonly/>
                                        <span class="messages"><?php echo form_error('check_date');?></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="transection_no" class="col-form-label col-md-4">Transaction No:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="transection_no" id="transection_no" class="form-control" readonly/>
                                        <span class="messages"><?php echo form_error('transection_no');?></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-md-4">Credit Balance:</label>
                                    <div class="col-sm-8">
                                        <input type="hidden" name="original_credit_balance" id="original_credit_balance" value="<?php echo $client_detail['credit_balance']; ?>"/>
                                        <input type="hidden" name="credit_balance" id="credit_balance" value="<?php echo $client_detail['credit_balance']; ?>"/>
                                        <label for="" class="col-form-label" id="credit_balance_lbl"><?php echo $client_detail['credit_balance']; ?></label>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="p-20 well well-sm">
                                    <div class="text-center p-b-10 f-16 f-w-900" style="border-bottom: 2px solid #bbbbbd;">
                                        Client Details
                                    </div>
                                    <div class="m-r-10">
                                        <ul>
                                            <li class="p-t-10">
                                                <i class="icofont icofont-double-right text-success"></i> Name : <span class="details f-w-900"><?php echo $client_detail['first_name'].' '.$client_detail['last_name']; ?></span>
                                            </li>
                                            <li class="p-t-10">
                                                <i class="icofont icofont-double-right text-success"></i> Contact No. : <span class="details"><?php echo $client_detail['phone']; ?></span>
                                            </li>
                                            <li class="p-t-10">
                                                <i class="icofont icofont-double-right text-success"></i> Credit Limit : <span class="details"><?php echo $client_detail['credit_limit']; ?></span>
                                            </li>
                                            <li class="p-t-10">
                                                <i class="icofont icofont-double-right text-success"></i> Address : <span class="details"><?php echo $client_detail['address']; ?></span>
                                            </li>
                                            <li class="p-t-10" style="font-weight: 800;">
                                                <i class="icofont icofont-double-right text-success"></i> Amount Due : <span class="details" id="total_amount_due">NIL</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="dt-responsive table-responsive m-t-50">
                                    <table id="" class="table table-bordered" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Payable Amount</th>
                                                <th>Outstanding Amount</th>
                                                <th>Amount Used</th>
                                                <th>Credit Balance Used</th>
                                            </tr>
                                        </thead>
                                        <tbody id="payments">
                                        <?php
                                            if(!empty($invoice_list)){
                                                foreach($invoice_list as $k=>$invoice){
                                                    $payable_amount = number_format($invoice['payable_amount'],2);
                                                    $pending_amount = $invoice['payable_amount'] - $invoice['paid_amount'];//number_format(($invoice['payable_amount'] - $invoice['paid_amount']), 2);
                                                    echo "<tr>
                                                                <th>
                                                                    <a title='View Order' href='{$this->baseUrl}orders/order_details/{$invoice['id']}' target='_blank'>{$invoice['id']}</a>
                                                                    <input type='hidden' name='payments[{$invoice['id']}][order_id]' value='{$invoice['id']}'/>
                                                                    <input type='hidden' name='payments[{$invoice['id']}][payable_amount]' value='{$invoice['payable_amount']}'/>
                                                                </th>
                                                                <td>{$invoice['payable_amount']}</td>
                                                                <td class='to_be_paid_amound'>{$pending_amount}</td>
                                                                <td><input type='hidden' name='payments[{$invoice['id']}][amount_used]' class='amount_used'/><span class='amount_used_lbl'></span></td>
                                                                <td><input type='hidden' name='payments[{$invoice['id']}][credit_used]' class='credit_used'/><span class='credit_used_lbl'></span></td>
                                                            </tr>";
                                                }
                                            }else{
                                                echo "<tr><th colspan='5' class='text-center text-danger'>No invoice found.</th></tr>";
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-right">
                            <?php if(!empty($invoice_list)):?>
                                <button type="submit" id="submit_button" class="btn btn-sm btn-primary" style="display:none;">Make Payment</button>
                            <?php endif;?>
                            <a class="btn btn-sm btn-default" href="<?php echo $this->baseUrl; ?>clients/">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@script
<script type="text/javascript">
	// to active the sidebar
    $('.cilent_list_li').active();

    var $check_no = $("#check_no");
    var $transection_no = $("#transection_no");
    var $check_date = $("#dropper-default");

    $check_date.dateDropper({
        dropWidth: 200,
        dropPrimaryColor: "#1abc9c", 
        dropBorder: "1px solid #1abc9c",
        format: "d/m/Y",
    });

    var pending_amount = 0;
    $("#payments tr").each(function (e) {
        var $tr = $(this);
        var to_be_paid = parseFloat($tr.find('.to_be_paid_amound').text()) || 0;
        pending_amount += to_be_paid;
    });

    if(pending_amount > 0){
        $("#total_amount_due").text(pending_amount);
    }

    $("#payment_mode").on('change',function(e){

        var value = this.value;

        $check_no.attr('readonly','readonly').val('');
        $transection_no.attr('readonly','readonly').val('');
        $check_date.attr('readonly','readonly').val('');

        switch(value){
            case 'Cheque':
                $check_no.removeAttr('readonly');
                $check_date.removeAttr('readonly');
                break;
            case 'Credit Card':
                $transection_no.removeAttr('readonly');
                break;
        }
    });

    var $submit_button = $("#submit_button");
    var $paid_amount = $("#paid_amount");
    var $payment = $("#payments");
    var $original_credit_balance = $("#original_credit_balance");
    var $credit_balance = $("#credit_balance");
    var $credit_balance_lbl = $("#credit_balance_lbl");

    /* Fill paid amount automatically when amount is filled */
    $paid_amount.on('change',function(e){

        var original_credit_balance = parseFloat($original_credit_balance.val()) || 0;
        console.log("Original Credit Balance:",original_credit_balance);

        var paid_amount = parseFloat($paid_amount.val()) || 0;
        console.log("Paid Amount Entered: ",paid_amount);

        // paid_amount = paid_amount+original_credit_balance;
        // console.log("Amount Effective: ",paid_amount);

        $("#payments tr").each(function(e){

            var amount_to_be_paid = parseFloat($(".to_be_paid_amound",this).text()) || 0;

            console.log("Current amount in hand: ",paid_amount);
            console.log("Current Credit Balance in hand: ",original_credit_balance);
            console.log("Pending Amount: ",amount_to_be_paid);

            if(original_credit_balance>0){

                if(original_credit_balance >= amount_to_be_paid){
                    $(".credit_used",this).val(amount_to_be_paid);
                    $(".credit_used_lbl",this).text(amount_to_be_paid);
                    original_credit_balance = parseFloat((original_credit_balance-amount_to_be_paid).toFixed(2)) || 0;
                    amount_to_be_paid = 0;
                }else{
                    $(".credit_used",this).val(original_credit_balance);
                    $(".credit_used_lbl",this).text(original_credit_balance);
                    amount_to_be_paid = parseFloat((amount_to_be_paid-original_credit_balance).toFixed(2)) || 0;
                    original_credit_balance =0;
                }
                console.log("Credit Balance used, Pending amount to be paid: ",amount_to_be_paid);
                console.log("Credit Balance after use : ",original_credit_balance);
            }

            if(amount_to_be_paid>0){
                if(paid_amount > 0){
                    if(paid_amount >= amount_to_be_paid){
                        $(".amount_used",this).val(amount_to_be_paid);
                        $(".amount_used_lbl",this).text(amount_to_be_paid);

                        paid_amount = parseFloat((paid_amount-amount_to_be_paid).toFixed(2)) || 0;
                        console.log("Amoun after use: ",paid_amount);
                    }else{
                        console.log("Pending paid_amount is > amount in hand. Amount in hand : ",paid_amount," Pending amount:",amount_to_be_paid);
                        $(".amount_used",this).val(paid_amount);
                        $(".amount_used_lbl",this).text(paid_amount);
                        paid_amount =0;
                    }
                }else{
                    $(".amount_used",this).val('');
                    $(".amount_used_lbl",this).text('');
                }
            }
        });

        if(paid_amount>0 || original_credit_balance>0){
            var new_credit_balance = parseFloat(paid_amount+original_credit_balance) || 0;
            new_credit_balance = new_credit_balance.toFixed(2);

            $credit_balance.val(new_credit_balance);
            $credit_balance_lbl.text(new_credit_balance);
        }else{
            $credit_balance.val(0.00);
            $credit_balance_lbl.text(0.00);
        }
    }).on('keyup',function(e){
        console.log("Paid Amount Blur & Value Length: ",this.value.length);

        if(this.value.length ==0){
            console.log("Hiding Submit Button");
            $submit_button.hide();
        }else{
            console.log("Showing Submit Button");
            console.log($submit_button);
            $submit_button.show();
        }
    });

    /* Don't allow paid amount > pending amount
    $payment.on('change','.amount_used',function(e){

        var value = parseFloat(this.value) || 0;
        var amount_to_be_paid = parseFloat($(this).closest('tr').find('.to_be_paid_amound').text()) || 0;
        if(value>amount_to_be_paid){

        }
    });*/


    $("#post_payment_form").on('submit',function(e){


        var original_credit_balance = parseFloat($original_credit_balance.val()) || 0;
        var credit_balance = parseFloat($credit_balance.val()) || 0;
        var amount = parseFloat($paid_amount.val()) || 0;

        var total_amount_used = 0;
        var total_crdit_balance_used = 0;

        $("#payments tr").each(function(e){
            var amount_used = parseFloat($(".amount_used",this).val()) || 0;
            var credit_used = parseFloat($(".credit_used",this).val()) || 0;
            console.log("Amount Used: ",amount_used," Credit Balance Used: ",credit_used);
            total_amount_used = total_amount_used + amount_used;
            total_crdit_balance_used = total_crdit_balance_used + credit_used;
        });

        console.log("Amount: ",amount," Credit Balance: ",original_credit_balance);
        console.log("Total Amount Used: ",total_amount_used," Total Credit Balance Used: ",total_crdit_balance_used);

        if(total_amount_used > amount){
            swal("Amount Exceeded!", "Amount Fractions can't exceed paid amount.");
            e.preventDefault();
        }

        if(total_crdit_balance_used > original_credit_balance){
            swal("Credit Used Exceeded!", "Credit Used Fractions can't exceed credit balance.");
            e.preventDefault();
        }
    });

</script>
@endscript