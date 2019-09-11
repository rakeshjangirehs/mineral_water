<div class="page-body">
    <!-- Default Styling table start -->
    <div class="card">
        <div class="card-header">
            <!--<h5><?php echo (!empty($invoice_list)) ? $invoice_list[0]['client_name'] : ''; ?></h5>-->
        </div>
        <div class="card-block">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Amount</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="amount" id="amount" placeholder="Amount">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Type</label>
                        <div class="col-sm-9">
                            <select name="payment_type" id="payment_type" class="form-control select2" data-placeholder="Choose payment type...">
                                <option value=""></option>
                                <option value="cash">Cash</option>
                                <option value="cheque">Cheque</option>
                                <option value="cc">Credit Card</option>
                                <option value="cash_credit">Cash / Credit Balance</option>
                                <option value="cheque_credit">Check / Credit Balance</option>
                                <option value="credit_credit">Credit Card / Credit Balance</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Check No</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="check_no" id="check_no" placeholder="Check No">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Check Date</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="check_date" id="check_date" placeholder="Check Date">
                        </div>
                    </div>
                </div>
                <div class="col-md-6" style="background: #ccc; border-radius: 5px;">
                    <div class="form-group row">
                        <label class="col-sm-4">Client</label>
                        <div class="col-sm-8">
                            <span><?php echo $client_detail['first_name'].' '.$client_detail['last_name']; ?></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4">Phone</label>
                        <div class="col-sm-8">
                            <span><?php echo $client_detail['phone']; ?></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4">Address</label>
                        <div class="col-sm-8">
                            <span><?php echo $client_detail['address']; ?></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4">Credit Limit</label>
                        <div class="col-sm-8">
                            <span><?php echo $client_detail['credit_limit']; ?></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4">Used Credit Limit</label>
                        <div class="col-sm-8">
                            <span><?php echo $client_detail['credit_limit']; ?></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4">Available Credit Limit</label>
                        <div class="col-sm-8">
                            <span><?php echo $client_detail['credit_limit']; ?></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table">
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
                            if(!empty($invoice_list)):
                                foreach($invoice_list as $invoice):
                        ?>
                        <tr>
                            <th scope="row"><?php echo $invoice['order_id']; ?></th>
                            <td><?php echo number_format($invoice['payable_amount'],2); ?></td>
                            <td><?php echo number_format(($invoice['payable_amount'] - $invoice['paid_amount']), 2); ?></td>
                            <td><input type="text" /></td>
                            <td><input type="text" /></td>
                        </tr>
                        <?php
                                endforeach;
                            else:
                        ?>
                        <th colspan="4">No invoice found.</th> 
                        <?php
                            endif;
                        ?>
                    </tbody>
                </table>
            </div>            
        </div>
    </div>
    <div class="pull-right">                    
        <button type="submit" class="btn btn-sm btn-primary m-b-0">Make Payment</button>
    </div>
    <!-- Default Styling table start -->
</div>

@script
<script type="text/javascript">
	// to active the sidebar
    $('.cilent_list_li').active();
</script>
@endscript