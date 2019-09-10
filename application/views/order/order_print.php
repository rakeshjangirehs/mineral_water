<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .logo{
            width:70px;
        }
        table{
            width:100%;
        }
        .seprator{
            font-size:5px;
        }
        .mini-seprator{
            font-size:4px;
        }

        .primary{
            font-size:13px;
        }
        .secondary{
            font-size: 12px;
        }
        .muted{
            color:gray;
        }
        .vt{
            vertical-align: top;
        }

        .particulars thead tr th{
            font-size:13px;
        }

        .bb{
            border-bottom: 1px solid rgb(233, 236, 239);
        }
        .particulars tbody tr td{
            font-size:12px;
        }
        .particulars thead tr th {
            font-weight: bolder;
            padding: 5px;
            border-bottom: 1px solid #ccc;
            background-color: rgb(233, 236, 239);
        }

        .amount_td{
            color:#01a9ac;
            /*font-size:13px!important;*/
            font-weight: bold;
        }

        .tc{
            text-align: center;
            padding:5px 0px;
        }
        .tr{
            text-align: right;
            padding:5px 0px;
        }

    </style>
</head>
<body>
    <table>
        <tr>
            <td style="width:12%;"><img src="<?php echo base_url(); ?>files\assets\images\logo.png" class="logo"></td>
            <td>
                <span style="font-size: 19px;"><?php echo $this->system_setting['system_name'];?></span><br/>
                <span class="secondary">
                    <span>123 6th St. Melbourne, FL 32904 West Chicago, IL 60185</span><br/>
                    <span>test@test.com</span><br/>
                    <span>+91 9166650505</span><br/>
                </span>
            </td>
        </tr>
    </table>
    <hr/>
    <table>
        <tr>
            <td class="vt" style="width:40%;">
                <div class="primary muted">CLIENT INFORMATION :</div>
                <div class="seprator">&nbsp;</div>
                <div class="secondary">
                    <?php echo "{$order['order_client']['first_name']} {$order['order_client']['last_name']} <div class='mini-seprator'>&nbsp;</div>";?>
                    <?php echo ($order['order_client']['address']) ? "{$order['order_client']['address']} <div class='mini-seprator'>&nbsp;</div>" : '';?>
                    <?php echo ($order['order_client']['phone']) ? "{$order['order_client']['phone']} <div class='mini-seprator'>&nbsp;</div>" : '';?>
                    <?php echo ($order['order_client']['email']) ? "{$order['order_client']['email']} <div class='mini-seprator'>&nbsp;</div>" : '';?>
                </div>
            </td>
            <td class="vt" style="width:30%;">
                <div class="primary muted">ORDER INFORMATION :</div>
                <div class="seprator">&nbsp;</div>
                <div class="secondary">
                    <?php echo ($order['created_at']) ? "Date : " . date('d-M-Y',strtotime($order['created_at'])) ."<div class='mini-seprator'>&nbsp;</div>" : "";?>
                    <?php if(empty($order['actual_delivery_date'])):?>
                        <?php echo "Status : Pending <div class='mini-seprator'>&nbsp;</div>";?>
                    <?php else:?>
                        <?php echo "Status : Delivered <div class='mini-seprator'>&nbsp;</div>";?>
                    <?php endif;?>
                    <?php echo ($order['order_client']['id']) ? "Order ID: {$order['order_client']['id']} <div class='mini-seprator'>&nbsp;</div>" : '';?>
                </div>
            </td>
            <td class="vt" style="width:30%;">
                <div class="primary muted amount_td">Total Due :<?php echo $order['payable_amount'];?></div>
            </td>
        </tr>
    </table>

    <div class="seprator">&nbsp;</div>
    <div class="seprator">&nbsp;</div>
    <div class="seprator">&nbsp;</div>

    <table class="particulars">
        <thead>
            <tr>
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
                            <td class='bb'>
                                {$product['product_name']} - {$product['product_code']}
                            </td>                                                    
                            <td class='tc bb'>{$product['quantity']}</td>
                            <td class='tc bb'>{$product['effective_price']}</td>
                            <td class='tr bb'>{$product_price}</td>
                        </tr>";
            }

            echo "<tr><td colspan='4'>&nbsp;</td></tr>
                    <tr><td colspan='2'>&nbsp;</td><td class='tr'>Subtotal:</td><td class='tr'>5000.00</td></tr>
                    <tr><td colspan='2'>&nbsp;</td><td class='tr'>Taxes (10%):</td><td class='tr'>57.00</td></tr>
                    <tr><td colspan='2'>&nbsp;</td><td class='tr bb'>Discount (5%):</td><td class='tr bb'>45.00</td></tr>
                    <tr><td colspan='2'>&nbsp;</td><td class='tr bb amount_td'><Total></Total>Total:</td><td class='tr bb amount_td'>5000</td></tr>";
        }?>
        </tbody>
    </table>
    <div style="position: absolute;text-align: justify;left:50px;right:50px;bottom: 20px;background-color: #e2e2e2;padding: 6px;border-radius: 5px;">
        <p class="secondary muted" style="margin:0px;">Terms And Condition :</p>
        <p class="muted" style="font-size: 10px;margin:0px;padding-left:10px;">lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor</p>
    </div>
</body>
</html>
