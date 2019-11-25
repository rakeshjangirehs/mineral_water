<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <form data-action="<?php echo $this->baseUrl; ?>orders/order_prodcuts/<?php echo $id; ?>" id="order_approve_form" method="post">
                <div class="card">                
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
                                <h6 class="text-uppercase text-primary">Order Value :
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
                                            <th>Default Price</th>
                                            <th>Client Price</th>
                                            <th>Revised Price</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="order_products_parent">
                                        <?php if(isset($order['order_items'])){
                                            foreach($order['order_items'] as $k=>$order_item){
                                                
                                                $class = ($order_item['actual_price'] != $order_item['effective_price']) ? "approval_row" : "";
                                                
                                                echo "<tr class='{$class}'>
                                                        <td>{$order_item['product_name']}</td>
                                                        <td>{$order_item['quantity']}</td>
                                                        <td>{$order_item['original_sale_price']}</td>
                                                        <td>{$order_item['actual_price']}</td>
                                                        <td>
                                                            <input type='hidden'name='order_item[{$k}][product_id]' value='{$order_item['product_id']}'/>
                                                            <input type='hidden'name='order_item[{$k}][actual_price]' value='{$order_item['actual_price']}'/>
                                                            <input type='hidden'name='order_item[{$k}][quantity]' value='{$order_item['quantity']}'/>
                                                            <input type='hidden'name='order_item[{$k}][effective_price_old]' value='{$order_item['effective_price']}'/>
                                                            <input type='text' class='' name='order_item[{$k}][effective_price]' value='{$order_item['effective_price']}'/>
                                                        </td>
                                                        <td>
                                                            <a class='remove_product' title='Remove Product' data-product_id='{$order_item['product_id']}'><i class='feather icon-trash-2'></i></a>
                                                        </td>
                                                    </tr>";
                                            }
                                        }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-sm-12 invoice-btn-group text-center">
                        
                        <input type="hidden" name="product_to_remove" id="product_to_remove" value=""/>
                        <input type="hidden" name="client_id" value="<?php echo $order['order_client']['id'];?>"/>

                        <button type="submit" name="action" value="accept" class="btn btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light m-r-20">Update & Accept</button>
                        <button type="submit" name="action" value="reject" class="btn btn-danger waves-effect m-b-10 btn-sm waves-light">Update & Reject</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@script
<script type="text/javascript">
	// to active the sidebar
    $(".order_list_li").active();

    var product_to_remove = [];
    var $order_products_parent = $("#order_products_parent");
    var $order_approve_form = $("#order_approve_form");
    var $product_to_remove_el = $("#product_to_remove");
    

    $(".remove_product").click(function(e){

        var $this = $(this);

        if($order_products_parent.children().length > 1){
            swal(
                {
                    title: "Remove Product ?",
                    // text: "You will not be able to recover this user!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No"
                },
                function(isConfirm) {
                    if (isConfirm) {
                        $this.closest('tr').fadeOut(function(){
                            var product_id = $this.data('product_id');
                            product_to_remove.push(product_id);
                            this.remove();
                        });
                    }
                }
            );
        }else{
            swal("Can't Deleted", "You can't remove all products from an order.", "error");
        }
    });

    $order_approve_form.on('submit',function(e){
        $product_to_remove_el.val(product_to_remove.join(","));
    });



</script>
@endscript