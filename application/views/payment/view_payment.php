<style>
    .details{
        position: absolute;
        left: 170px;
    }
    .details-left{
        position: absolute;
        left: 220px;
    }
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="page-body">
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
                                <div class="p-20 well well-sm">
                                    <div class="text-center p-b-10 f-16 f-w-900" style="border-bottom: 2px solid #bbbbbd;">
                                        Payment Details
                                    </div>
                                    <div class="m-r-10">
                                        <ul>
                                            <li class="p-t-10">
                                                <i class="icofont icofont-double-right text-success"></i> Paymont Mode : <span class="details-left f-w-900"><?php echo $payment_data['payment_mode']; ?></span>
                                            </li>
                                            <li class="p-t-10">
                                                <i class="icofont icofont-double-right text-success"></i> Paid Amount : <span class="details-left"><?php echo $payment_data['paid_amount']; ?></span>
                                            </li>
                                            <li class="p-t-10">
                                                <i class="icofont icofont-double-right text-success"></i> Credit Balance Used : <span class="details-left"><?php echo $payment_data['credit_balance_used']; ?></span>
                                            </li>
                                            <li class="p-t-10">
                                                <i class="icofont icofont-double-right text-success"></i> Cheque No. : <span class="details-left"><?php echo $payment_data['check_no']; ?></span>
                                            </li>
                                            <li class="p-t-10">
                                                <i class="icofont icofont-double-right text-success"></i> Cheque Date. : <span class="details-left"><?php echo $payment_data['check_date']; ?></span>
                                            </li>
                                            <li class="p-t-10">
                                                <i class="icofont icofont-double-right text-success"></i> Transection No. : <span class="details-left"><?php echo $payment_data['transection_no']; ?></span>
                                            </li>

                                        </ul>
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
                                                <i class="icofont icofont-double-right text-success"></i> Name : <span class="details f-w-900"><?php echo $payment_data['client_name']; ?></span>
                                            </li>
                                            <li class="p-t-10">
                                                <i class="icofont icofont-double-right text-success"></i> Contact No. : <span class="details"><?php echo "{$payment_data['contact_person_name_1']} ({$payment_data['contact_person_1_phone_1']})"; ?></span>
                                            </li>
                                            <li class="p-t-10">
                                                <i class="icofont icofont-double-right text-success"></i> Credit Limit : <span class="details"><?php echo $payment_data['credit_limit']; ?></span>
                                            </li>
                                            <li class="p-t-10">
                                                <i class="icofont icofont-double-right text-success"></i> Address : <span class="details"><?php echo $payment_data['address']; ?></span>
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
                                                <th>Order Amount</th>
                                                <th>Outstanding Amount</th>
                                                <th>Paid Amount</th>
                                                <th>Credit Balance Used</th>
                                            </tr>
                                        </thead>
                                        <tbody id="payments">
                                        <?php
                                            if(!empty($payment_data['invoices'])){
                                                foreach($payment_data['invoices'] as $k=>$invoice){
                                                    $payable_amount = number_format($invoice['payable_amount'],2);
                                                    $pending_amount = $invoice['payable_amount'] - $invoice['previously_paid'];
                                                    echo "<tr>
                                                                <th><a title='View Order' href='{$this->baseUrl}orders/order_details/{$invoice['order_id']}' target='_blank'>{$invoice['order_id']}</a></th>
                                                                <td>{$invoice['payable_amount']}</td>
                                                                <td>{$pending_amount}</td>
                                                                <td>{$invoice['amount_used']}</td>
                                                                <td>{$invoice['credit_used']}</td>
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
                </div>
            <div class="row text-center">
                <div class="col-sm-12 invoice-btn-group text-center">
                    <button type="button" id="print_button" class="btn btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light m-r-20">Print</button>
                    <button type="button" id="back_button" class="btn btn-danger waves-effect m-b-10 btn-sm waves-light">Back</button>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script type="text/javascript">
	
	// to active the sidebar
    $('.payment_list_li').active();

    $("#print_button").click(function(e){
        window.open('<?php echo $this->baseUrl."payments/print_payment_invoice/{$id}"; ?>');
    });

    $("#back_button").click(function(e){
        window.location.href = '<?php echo $this->baseUrl."payments/payments_list"; ?>';
    });

</script>
@endscript