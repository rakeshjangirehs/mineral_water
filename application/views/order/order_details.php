<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
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
                            <h6 class="m-0"><?php echo $order['order_client']['first_name'] .' '. $order['order_client']['last_name'];?></h6>
                            <p class="m-0 m-t-10"><?php echo $order['order_client']['address'];?></p>
                            <p class="m-0"><?php echo $order['order_client']['phone'];?></p>
                            <p><?php echo $order['order_client']['email'];?></p>
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
                                    <th>Id :</th>
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
                                <table class="table  invoice-detail-table">
                                    <thead>
                                    <tr class="thead-default">
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Amount</th>
                                        <th>Total</th>
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
                                    }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-responsive invoice-table invoice-total">
                                <tbody>
                                <tr>
                                    <th>Sub Total :</th>
                                    <td>$4725.00</td>
                                </tr>
                                <tr>
                                    <th>Taxes (10%) :</th>
                                    <td>$57.00</td>
                                </tr>
                                <tr>
                                    <th>Discount (5%) :</th>
                                    <td>$45.00</td>
                                </tr>
                                <tr class="text-info">
                                    <td>
                                        <hr>
                                        <h5 class="text-primary">Total :</h5>
                                    </td>
                                    <td>
                                        <hr>
                                        <h5 class="text-primary">$4827.00</h5>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <h6>Terms And Condition :</h6>
                            <p>lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor </p>
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
    $(".order_list_li").active();
</script>
@endscript