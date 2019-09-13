<style>
    .details{
        position: absolute;
        left: 200px;
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

                                <div class="form-group row">
                                    <label for="payment_mode" class="col-form-label col-md-6">Paymont Mode:</label>
                                    <div class="col-md-6">
                                        <label for="" class="col-form-label"><?php echo $payment_data['payment_mode']; ?></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="paid_amount" class="col-form-label col-md-6">Paid Amount:</label>
                                    <div class="col-md-6">
                                        <label for="" class="col-form-label"><?php echo $payment_data['paid_amount']; ?></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="check_no" class="col-form-label col-md-6">Check No:</label>
                                    <div class="col-md-6">
                                        <label for="" class="col-form-label"><?php echo $payment_data['check_no']; ?></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="check_date" class="col-form-label col-md-6">Check Date:</label>
                                    <div class="col-md-6">
                                        <label for="" class="col-form-label"><?php echo $payment_data['check_date']; ?></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="transection_no" class="col-form-label col-md-6">Transection No:</label>
                                    <div class="col-md-6">
                                        <label for="" class="col-form-label"><?php echo $payment_data['transection_no']; ?></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-md-6">Credit Balance (Before posting):</label>
                                    <div class="col-sm-6">
                                        <label for="" class="col-form-label"><?php echo $payment_data['previous_credit_balance']; ?></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-md-6">Credit Balance (Aftter posting):</label>
                                    <div class="col-sm-6">
                                        <label for="" class="col-form-label"><?php echo $payment_data['new_credit_balance']; ?></label>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="p-20 z-depth-0">
                                    <div class="text-center p-b-10 f-16 f-w-900" style="border-bottom: 2px solid #bbbbbd;">
                                        Client Details
                                    </div>
                                    <div class="m-r-10">
                                        <div class="m-t-10">
                                            Name : <span class="details f-w-900"><?php echo $payment_data['client_name']; ?></span>
                                        </div>
                                        <div class="m-t-10">
                                            Contact No. : <span class="details"><?php echo $payment_data['phone']; ?></span>
                                        </div>
                                        <div class="m-t-10">
                                            Credit Limit : <span class="details"><?php echo $payment_data['credit_limit']; ?></span>
                                        </div>
                                        <div class="m-t-10">
<<<<<<< HEAD:application/views/payment/add.php
                                            Used Credit Limit : <span class="details"><?php echo $client_detail['payment_due']; ?></span>
                                        </div>
                                        <div class="m-t-10">
                                            Available Credit Limit : <span class="details"><?php echo $client_detail['available_credit']; ?></span>
                                        </div>
                                        <div class="m-t-10">
                                            Address : <span class="details"><?php echo $client_detail['address']; ?></span>
=======
                                            Address : <span class="details"><?php echo $payment_data['address']; ?></span>
>>>>>>> 2806817c49b5194ab0a4b23ee114592e2a508ae3:application/views/payment/view_payment.php
                                        </div>
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
                                                <th>Amount Used</th>
                                                <th>Credit Balance Used</th>
                                            </tr>
                                        </thead>
                                        <tbody id="payments">
                                        <?php
                                            if(!empty($payment_data['invoices'])){
                                                foreach($payment_data['invoices'] as $k=>$invoice){
                                                    $payable_amount = number_format($invoice['payable_amount'],2);
                                                    echo "<tr>
<<<<<<< HEAD:application/views/payment/add.php
                                                                <th scope='row'>{$invoice['order_id']}</th>
                                                                <td>{$payable_amount}</td>
                                                                <td>{$pending_amount}</td>
                                                                <td><input type='text' name='paid_amount[]'/></td>
                                                                <td><input type='text' name='credit_amount[]'/></td>
=======
                                                                <th scope='row'>{$invoice['id']}</th>
                                                                <td>{$invoice['payable_amount']}</td>
                                                                <td>{$invoice['amount_used']}</td>
                                                                <td>{$invoice['credit_used']}</td>
>>>>>>> 2806817c49b5194ab0a4b23ee114592e2a508ae3:application/views/payment/view_payment.php
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
                            <a class="btn btn-sm btn-default" href="<?php echo $this->baseUrl; ?>payments/payments_list">Back</a>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>

@script
<script type="text/javascript">
	
	// to active the sidebar
    $('.payment_list_li').active();
	
</script>
@endscript