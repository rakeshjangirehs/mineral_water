<style>
    .invoice_type{
        position: absolute;
        right: 65px;
        top: 33px;
        font-weight: 700;
    }
    
    .table.scheme-block td, .table.scheme-block th {
        padding: .10rem;
        vertical-align: top;
        border-top: none;
    }

    .scheme-block td.w1{
        width:80%;
    }
    .scheme-block td.w2{
        width:20%;
    }
</style>
<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <span class="invoice_type f-18">ORDER INVOICE</span>
                <div class="row invoice-contact">
                    <div class="col-md-8">
                        <div class="invoice-box row">
                            <div class="col-sm-12">
                                <table class="table table-responsive invoice-table table-borderless">
                                    <tbody>
                                    <tr>
                                        <td><img src="<?php echo base_url(); ?>files\assets\images\logo.png" class="img-80" alt=""></td>
                                        <td style="padding-left:20px;">
                                            <span><?php echo $this->system_setting['system_name'];?></span><br/>
                                            <span>123 6th St. Melbourne, FL 32904 West Chicago, IL 60185</span><br/>
                                            <span>test@test.com</span><br/>
                                            <span>+91 9166650505</span><br/>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                    </div>
                </div>
                <div class="card-block">
                    <div class="row invoive-info">
                        <div class="col-md-4 col-xs-12 invoice-client-info">
                            <h6>Client Information :</h6>
                            <h6 class="m-0"><?php echo $order['order_client']['client_name'];?></h6>
                            <p class="m-0 m-t-10">GST No. : <?php echo $order['order_client']['gst_no'];?></p>
                            <p class="m-0 m-t-10"><?php echo $order['order_client']['contact_person_name_1'];?></p>
                            <p class="m-0 m-t-10"><?php echo $order['order_client']['contact_person_1_phone_1'];?></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <h6>Order Information :</h6>
                            <table class="table table-responsive invoice-table invoice-order table-borderless">
                                <tbody>
                                <tr>
                                    <th>Date :</th>
                                    <td><?php echo date('d-M-Y',strtotime($order['created_at']));?></td>
                                </tr>
                                <tr>
                                    <th>Status :</th>
                                    <td>
                                        <?php if(empty($order['actual_delivery_date'])):?>
                                            <span class="label label-warning">Pending</span>
                                        <?php else:?>
                                            <span class="label label-success">Delivered</span>
                                        <?php endif;?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Order Id :</th>
                                    <td>
                                        <?php echo $order['id'];?>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4 col-sm-6">
<!--                            <h6 class="m-b-20">Invoice Number <span>#12398521473</span></h6>-->
                            <h6 class="text-uppercase text-primary">Total Due :
                                <span><?php echo $order['payable_amount'];?></span>
                            </h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table invoice-detail-table">
                                    <thead>
                                    <tr class="thead-default">
                                        <th style='width:70%;'>Product</th>
                                        <th style='width:10%;'>Quantity</th>
                                        <th style='width:10%;'>Amount</th>
                                        <th style='width:10%;'>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(isset($order['order_items'])){
                                        foreach($order['order_items'] as $k=>$product){
                                            $sr = ++$k;
                                            $product_price = $product['quantity'] * $product['effective_price'];
                                            echo "<tr>
                                                    <td>
                                                        <h6>{$product['product_name']} - {$product['product_code']}</h6>
                                                        <p>{$product['description']}</p>
                                                    </td>                                                    
                                                    <td>{$product['quantity']}</td>
                                                    <td>{$product['effective_price']}</td>
                                                    <td>{$product_price}</td>
                                                </tr>";
                                        }
                                        
                                        if($order['scheme_id']){
                                            if($order['gift_mode'] == 'cash_benifit'){

                                                $dis_type = ($order['discount_mode']=='percentage') ? "Discount ({$order['discount_value']}%) :" : "Discount(Rs.) :";

                                                echo "<tr style='font-weight: 800;'><td></td><td></td><td>Total : </td><td>{$order['payable_amount']}</td></tr>";
                                                echo "<tr style='font-weight: 800;'>
                                                    <td>
                                                        Scheme
                                                        <br/>
                                                        <p style='font-weight: 200;'>{$order['scheme_name']}</p>
                                                        {$order['free_product']['product_name']}
                                                    </td>
                                                    <td></td>
                                                    <td>{$dis_type}</td>
                                                    <td>{$order['computed_disc']}</td>
                                                </tr>";
                                                echo "<tr style='font-weight: 800;'><td></td><td></td><td>Total : </td><td>{$order['effective_amount']}</td></tr>";
                                            }else if($order['free_product']){
                                                echo "<tr style='font-weight: 800;'>
                                                    <td>
                                                        Scheme
                                                        <br/>
                                                        <p style='font-weight: 200;'>{$order['scheme_name']}</p>
                                                    </td>
                                                    <td>{$order['free_product_qty']}</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                </tr>";
                                                echo "<tr style='font-weight: 800;'><td></td><td></td><td>Total : </td><td>{$order['payable_amount']}</td></tr>";

                                            }
                                        }else{
                                            echo "<tr style='font-weight: 800;'><td></td><td></td><td>Total : </td><td>{$order['payable_amount']}</td></tr>";
                                        }

                                        
                                    }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <?php if($order['order_status'] == 'Delivered'):?>
                    <div class="row">
                        <div class="col-sm-12">
                            <h6>Terms And Condition :</h6>
                            <p>lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor </p>
                        </div>
                    </div>
                    <?php endif;?>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-sm-12 invoice-btn-group text-center">
                    <?php if($order['order_status'] == 'Delivered'):?>
                    <button type="button" id="print_button" class="btn btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light m-r-20">Print</button>
                    <?php endif;?>
                    <button type="button" id="back_button" class="btn btn-danger waves-effect m-b-10 btn-sm waves-light">Back</button>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script type="text/javascript">
	// to active the sidebar
    $(".order_list_li").active();
    $("#print_button").click(function(e){
        window.open('<?php echo $this->baseUrl."orders/print_invoice/{$id}"; ?>');
    });

    $("#back_button").click(function(e){
        window.location.href = '<?php echo $this->baseUrl."orders/"; ?>';
    });

</script>
@endscript