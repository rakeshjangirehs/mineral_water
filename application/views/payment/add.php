<style>
    .details{
        position: absolute;
        left: 200px;
    }
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="page-body">
            <form data-action="<?php echo $this->baseUrl; ?>users/add_update/<?php //echo $id; ?>" id="tagFrm" method="post">
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
                        <div class="row">
                            <div class="col-sm-12 col-md-6">

                                <div class="form-group row">
                                    <label for="payment_mode" class="col-form-label col-md-4">Paymont Mode:</label>
                                    <div class="col-sm-8">
                                        <select name="payment_mode" id="payment_mode" class="form-control">
                                            <option value="">Choose Payment Mode</option>
                                            <option value="cash">Cash</option>
                                            <option value="cheque">Cheque</option>
                                            <option value="cc">Credit Card</option>
                                        </select>
                                        <span class="messages"><?php echo form_error('payment_mode');?></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="amount" class="col-form-label col-md-4">Amount:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="amount" id="amount" class="form-control"/>
                                        <span class="messages"><?php echo form_error('amount');?></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="check_no" class="col-form-label col-md-4">Check No:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="check_no" id="check_no" class="form-control"/>
                                        <span class="messages"><?php echo form_error('check_no');?></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="transection_no" class="col-form-label col-md-4">Transection No:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="transection_no" id="transection_no" class="form-control"/>
                                        <span class="messages"><?php echo form_error('transection_no');?></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="check_date" class="col-form-label col-md-4">Check Date:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="check_date" id="check_date" class="form-control"/>
                                        <span class="messages"><?php echo form_error('check_date');?></span>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="p-20    z-depth-0">
                                    <div class="text-center p-b-10 f-16 f-w-900" style="border-bottom: 2px solid #bbbbbd;">
                                        Client Details
                                    </div>
                                    <div class="m-r-10">
                                        <div class="m-t-10">
                                            Name : <span class="details"><?php echo $client_detail['first_name'].' '.$client_detail['last_name']; ?></span>
                                        </div>
                                        <div class="m-t-10">
                                            Contact No. : <span class="details"><?php echo $client_detail['phone']; ?></span>
                                        </div>
                                        <div class="m-t-10">
                                            Credit Limit : <span class="details"><?php echo $client_detail['credit_limit']; ?></span>
                                        </div>
                                        <div class="m-t-10">
                                            Used Credit Limit : <span class="details"><?php echo $client_detail['credit_limit']; ?></span>
                                        </div>
                                        <div class="m-t-10">
                                            Available Credit Limit : <span class="details"><?php echo $client_detail['credit_limit']; ?></span>
                                        </div>
                                        <div class="m-t-10">
                                            Address : <span class="details"><?php echo $client_detail['address']; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="dt-responsive table-responsive m-t-50">
                                    <table id="dynamic-table" class="table table-bordered" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Payable Amount</th>
                                                <th>Amount To be Paid</th>
                                                <th>Amount</th>
                                                <th>Credit Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if(!empty($invoice_list)){
                                                foreach($invoice_list as $invoice){
                                                    $payable_amount=number_format($invoice['payable_amount'],2);
                                                    $pending_amount = number_format(($invoice['payable_amount'] - $invoice['paid_amount']), 2);
                                                    echo "<tr>
                                                                <th scope='row'>{$invoice['order_id']}</th>
                                                                <td>{$payable_amount}</td>
                                                                <td>{$pending_amount}</td>
                                                                <td><input type='text'/></td>
                                                                <td><input type='text'/></td>
                                                            </tr>";
                                                }
                                            }else{
                                                echo "<th colspan='4'>No invoice found.</th>";
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
                            <button type="submit" class="btn btn-sm btn-primary">Make Payment</button>
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
</script>
@endscript