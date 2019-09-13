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

        .company-name{
            font-size:19px;
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
                <span class="company-name"><?php echo $this->system_setting['system_name'];?></span><br/>
                <span class="secondary">
                    <span>123 6th St. Melbourne, FL 32904 West Chicago, IL 60185</span><br/>
                    <span>test@test.com</span><br/>
                    <span>+91 9166650505</span><br/>
                </span>
            </td>
            <td class="vt tc muted primary">
                PAYMENT RECIEPT
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
                    <?php echo "{$order['client_name']} <div class='mini-seprator'>&nbsp;</div>";?>
                    <?php echo ($order['address']) ? "{$order['address']} <div class='mini-seprator'>&nbsp;</div>" : '';?>
                    <?php echo ($order['phone']) ? "{$order['phone']} <div class='mini-seprator'>&nbsp;</div>" : '';?>
                    <?php echo ($order['email']) ? "{$order['email']} <div class='mini-seprator'>&nbsp;</div>" : '';?>
                </div>
            </td>
            <td class="vt" style="width:30%;">
                <div class="primary muted">PAYMENT INFORMATION :</div>
                <div class="seprator">&nbsp;</div>
                <div class="secondary">
                    <?php echo ($order['created_at']) ? "Date : " . date('d-M-Y',strtotime($order['created_at'])) ."<div class='mini-seprator'>&nbsp;</div>" : "";?>
                    <?php echo ($order['payment_mode']) ? "Mode : " . $order['payment_mode'] ."<div class='mini-seprator'>&nbsp;</div>" : "";?>
                    <?php echo ($order['check_no']) ? "Cheque No. : " . $order['check_no'] ."<div class='mini-seprator'>&nbsp;</div>" : "";?>
                    <?php echo ($order['check_date']) ? "Cheque Date : " . date('d-M-Y',strtotime($order['check_date'])) ."<div class='mini-seprator'>&nbsp;</div>" : "";?>
                    <?php echo ($order['transection_no']) ? "Transection No. : " . $order['transection_no'] ."<div class='mini-seprator'>&nbsp;</div>" : "";?>

                </div>
            </td>
            <td class="vt" style="width:30%;">
                <div class="primary muted">&nbsp;</div>
                <div class="seprator">&nbsp;</div>
                <div class="secondary">
                    <?php echo ($order['paid_amount']) ? "Amount Paid : " . $order['paid_amount'] ."<div class='mini-seprator'>&nbsp;</div>" : "";?>
                    <?php echo ($order['previous_credit_balance']) ? "Old Credit Balance : " . $order['previous_credit_balance'] ."<div class='mini-seprator'>&nbsp;</div>" : "";?>
                    <?php echo ($order['new_credit_balance']) ? "New Credit Balance : " . $order['new_credit_balance'] ."<div class='mini-seprator'>&nbsp;</div>" : "";?>
                </div>
            </td>
        </tr>
    </table>

    <div class="seprator">&nbsp;</div>
    <div class="seprator">&nbsp;</div>
    <div class="seprator">&nbsp;</div>

    <table class="particulars">
        <thead>
            <tr>
                <th>Order Id</th>
                <th>Billable Amount</th>
                <th>Amount Used</th>
                <th>Credit Balance Used</th>
            </tr>
        </thead>
        <tbody>
        <?php if(isset($order['invoices'])){
            foreach($order['invoices'] as $k=>$invoices){
                $sr = ++$k;
                echo "<tr>
                            <td class='bb'>{$invoices['order_id']}</td>                                                    
                            <td class='tc bb'>{$invoices['payable_amount']}</td>
                            <td class='tc bb'>{$invoices['amount_used']}</td>
                            <td class='tc bb'>{$invoices['credit_used']}</td>
                        </tr>";
            }

            echo "<tr><td colspan='4'>&nbsp;</td></tr>
                    <tr>
                        <td colspan='2'></td>
                        <td class='tc bb amount_td'>5000.00</td>
                        <td class='tc bb amount_td'>500.00</td>
                    </tr>";
        }?>
        </tbody>
    </table>
    <div style="position: absolute;text-align: justify;left:50px;right:50px;bottom: 20px;background-color: #e2e2e2;padding: 6px;border-radius: 5px;">
        <p class="secondary muted" style="margin:0px;">Terms And Condition :</p>
        <p class="muted" style="font-size: 10px;margin:0px;padding-left:10px;">lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor</p>
    </div>
</body>
</html>
