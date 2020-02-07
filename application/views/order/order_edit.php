<style>
     #expected_delivery_date,#payment_schedule_date{
        height: 38px;
    }
    #add_product{
        position: fixed;
        bottom: 131px;
        right: 19px;
        background-color: #00a9ac;
        color: #fff;
        padding: 9px 14px;
        border-radius: 50%;
    }

    /* Select2 outside table */
    .select2-container--default .select2-selection--single .select2-selection__rendered{
        line-height: 20px;
        font-size: 13px;
    }
    .select2-container--default .select2-selection--single{
        border-radius: inherit;
    }

    /* Select2 in table */
    table .select2-container--default .select2-selection--single .select2-selection__rendered{
        line-height: 13px;
        font-size: 13px;
    }
    table .select2-container--default .select2-selection--single{
        border-radius: inherit;
    }
    table .product_quantity, table .product_new_price{
        line-height: 24px;
        padding: 1px 5px;
    }

    .card-header h5 i{
        margin-right: 9px;
        font-size: 17px;
    }
</style>
<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <form data-action="<?php echo $this->baseUrl; ?>orders/order_edit/<?php echo $id; ?>" id="order_approve_form" method="post">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="feather icon-user-check"></i><mark>Client Name :</mark><?php echo $order_client['client_name'];?></h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-maximize full-card"></i></li>
                            </ul>
                        </div>
                    </div>                
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="role" class="control-label">Priority:</label>
                                    <select class="form-control" name="priority" id="priority">
                                        <option value="">Select Client</option>
                                        <?php
                                            foreach(["Low","Medium","High","Urgent"] as $priority):
                                                $selected = ($order_edit['priority'] == $priority) ? 'selected' : '';
                                        ?>
                                                <option value="<?php echo $priority; ?>" <?php echo $selected; ?>><?php echo $priority; ?></option>
                                        <?php
                                            endforeach;
                                        ?>
                                    </select>
                                    <span class="messages"><?php echo form_error('priority');?></span>
                                </div>
                                <div class="form-group">
                                    <label for="role" class="control-label">Preffered Payment Mode:</label>
                                    <select class="form-control" name="payment_mode" id="payment_mode">
                                        <option value="">Select Address</option>
                                        <?php
                                        foreach(['Cash','G-Pay','Bank Transfer','Cheque'] as $payment_mode):
                                                $selected = ($order_edit['payment_mode'] == $payment_mode) ? 'selected' : '';
                                        ?>
                                            <option value="<?php echo $payment_mode; ?>" <?php echo $selected; ?>><?php echo $payment_mode; ?></option>
                                        <?php
                                            endforeach;
                                        ?>
                                    </select>
                                    <span class="messages"><?php echo form_error('payment_mode');?></span>
                                </div>
                                <?php if(isset($applied_scheme)):?>
                                <div class="form-group">
                                    <label for="role" class="control-label">Applied Scheme:</label>
                                    <label for="role" class="control-label"><a class="text-purple" href="<?php echo $this->baseUrl; ?>schemes/add_update/<?php echo $applied_scheme['id']; ?>" target="_blank"><?php echo $applied_scheme['name'];?></a></label>
                                </div>
                                <?php endif;?>

                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="role" class="control-label">Shipping Address:</label>
                                    <select class="form-control" name="delivery_address_id" id="delivery_address_id">
                                        <option value="">Select Address</option>
                                        <?php
                                        if(!empty($client_delivery_addresses)):
                                            foreach($client_delivery_addresses as $address):
                                                $selected = ($order_edit['delivery_address_id'] == $address['id']) ? 'selected' : '';
                                                ?>
                                                <option value="<?php echo $address['id']; ?>" title='<?php echo $address['address'];?>' <?php echo $selected; ?>><?php echo $address['title'] . ' - ' . $address['zip_code']; ?></option>
                                            <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </select>
                                    <span class="messages"><?php echo form_error('delivery_address_id');?></span>
                                </div>
                                <div class="form-group">
                                    <label for="role" class="control-label">Expected Delivery Date:</label>
                                    <input type="text" name="expected_delivery_date" id="expected_delivery_date" class="form-control" value="<?php echo (isset($_POST['expected_delivery_date']))? set_value('expected_delivery_date') : $order_edit['expected_delivery_date']; ?>" />
                                    <span class="messages"><?php echo form_error('expected_delivery_date');?></span>
                                </div>
                                <div class="form-group">
                                    <label for="role" class="control-label">Preferred Payment Date:</label>
                                    <input type="text" name="payment_schedule_date" id="payment_schedule_date" class="form-control" value="<?php echo (isset($_POST['payment_schedule_date']))? set_value('payment_schedule_date') : $order_edit['payment_schedule_date']; ?>" />
                                    <span class="messages"><?php echo form_error('payment_schedule_date');?></span>
                                </div>
                                

                            </div>
                        </div>
                        <hr/>
                        <a href="javascript:void(0)" id="add_product" title="Add Product"><i class="fa fa-plus"></i></a>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table  invoice-detail-table">
                                        <thead>
                                        <tr class="thead-default">
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="order_products_parent">
                                        <?php if($order_items){
                                            foreach($order_items as $k=>$order_item){

                                                $select_options = "";
                                                foreach($products as $product){
                                                    $sale_price = ($product['client_sale_price']) ? $product['client_sale_price'] : $product['sale_price'];
                                                    $selected = ($product['id'] == $order_item['product_id']) ? 'selected' : '';
                                                    $select_options .= "<option value='{$product['id']}' 
                                                                                data-client_price='{$sale_price}'
                                                                                {$selected}>{$product['product_name']}</option>";
                                                }
                                                $random_id = mt_rand(0,1000).mt_rand(100,999).strtotime(date('Y-m-d'));
                                                echo "<tr>
                                                        <td>
                                                            <select class='form-control product_select' name='order_item[{$k}][product_id]' id='($random_id)' data-placeholder='Choose Product' style='width:100%'>
                                                                <option value=''></option>
                                                                {$select_options}
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type='text' class='product_quantity' name='order_item[{$k}][quantity]' value='{$order_item['quantity']}'/>
                                                        <td>
                                                            <input type='hidden' class='product_old_price' name='order_item[{$k}][old_price]' value='{$order_item['effective_price']}'/>
                                                            <input type='text' class='product_new_price' name='order_item[{$k}][new_price]' value='{$order_item['effective_price']}'/>
                                                        </td>
                                                        <td>
                                                            <a class='text-danger remove_product' title='Remove Product' data-product_id='{$order_item['product_id']}'><i class='feather icon-trash-2'></i></a>
                                                        </td>
                                                    </tr>";
                                            }
                                        }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- <hr/>
                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="role" class="control-label">Choose Scheme:</label>
                                    <select class="form-control" name="client_id" id="client_id">
                                        <option value="">Select Scheme</option>                                        
                                    </select>
                                    <span class="messages"></span>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-sm-12 invoice-btn-group text-center">                        
                        <input type="hidden" name="product_to_remove" id="product_to_remove" value=""/>
                        <input type="hidden" name="scheme" id="scheme" value=""/>
                        <button type="submit" name="" value="" class="btn btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light m-r-20">Update</button>
                        <a href="<?php echo $this->baseUrl; ?>orders/" class="btn btn-default waves-effect m-b-10 btn-sm waves-light">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="my_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Choose Scheme :</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-sm-12">
                    <div class="form-group">
                        <select class="form-control" name="scheme_id" id="scheme_id">
                            <option value="">Choose Scheme</option>
                            <option value="a">a</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group text-right">
                        <button type="button" id="scheme_submit" name="" value="" class="btn btn-primary btn-print-invoice btn-sm waves-effect waves-light">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script type="text/template" id="template">
    <tr>
        <td>
            <?php $random_id = mt_rand(0,1000).mt_rand(100,999).strtotime(date('Y-m-d'));?>
            <select class='form-control product_select' name='' id='<?php echo $random_id;?>' data-placeholder='Choose Product' style='width:100%'>
                <option value=''></option>
                <?php
                    foreach($products as $product){
                        $sale_price = ($product['client_sale_price']) ? $product['client_sale_price'] : $product['sale_price'];
                        echo "<option value='{$product['id']}' 
                                data-client_price='{$sale_price}'>
                                {$product['product_name']}
                                </option>";
                    }
                ?>
            </select>
        </td>
        <td>
            <input type='text' class='product_quantity' name='' value=''/>
        <td>
            <input type='hidden' class='product_old_price' name='' value=''/>
            <input type='text' class='product_new_price' name='' value=''/>
        </td>
        <td>
            <a class='text-danger remove_product' title='Remove Product' data-product_id='{$order_item['product_id']}'><i class='feather icon-trash-2'></i></a>
        </td>
    </tr>
</script>

<script type="text/javascript">
	// to active the sidebar
    $(".order_list_li").active();

    var product_to_remove = [];
    var $order_products_parent = $("#order_products_parent");
    var $order_approve_form = $("#order_approve_form");
    var $product_to_remove_el = $("#product_to_remove");
    var $form_scheme = $("#scheme");    
    
    var template = $("#template").html();
    var index = $order_products_parent.children().length;

    // Modal
    var $my_modal = $("#my_modal");
    var $scheme_id = $("#scheme_id");
    var $scheme_submit = $("#scheme_submit");
    var scheme_submitted = false;

    $scheme_submit.click(function(e){
        var $this = $(this);
        var scheme = $scheme_id.val();
        scheme_submitted = true;
        if(scheme) {
            $form_scheme.val(scheme);
        }
        $my_modal.modal('hide');
        $("#order_approve_form").trigger('submit');
    });   
    
    var validator = $("#order_approve_form").validate({
        rules   : 	{
                        "client_id"		:	{
                            required:true,
                        },
                        "delivery_address_id"		:	{
                            required:true,
                        },
                        "priority"		:	{
                            required:true,
                        },
                        "expected_delivery_date"		:	{
                            required:true,
                        },
                        "payment_mode"		:	{
                            required:true,
                        },
                        "payment_schedule_date"		:	{
                            required:true,
                        },
                    },
        messages	:	{
            /* email		:	{                
                remote			:	"Email already Exists"
            }, */
        },
        errorElement: "p",
        errorClass:"text-danger error",
        errorPlacement: function errorPlacement(error, element) {
            // console.log(element);
            // element.before(error);
            // $(element).closest("[class|='col']").append(error);
            if($(element).hasClass('select2-hidden-accessible')){
                $(element).next().after(error);
            }else{
                $(element).after(error);
            }
        },
        highlight: function(element, errorClass) {
            // console.log(element,errorClass)
            // console.log($(element).hasClass('select2-hidden-accessible'));
            if($(element).hasClass('select2-hidden-accessible')){
                $(element).next().find('.select2-selection').addClass(errorClass);
            }else{
                $(element).addClass(errorClass);
            }
        },
        unhighlight: function(element, errorClass, validClass) {
            if($(element).hasClass('select2-hidden-accessible')){
                $(element).next().find('.select2-selection').removeClass(errorClass);
            }else{
                $(element).removeClass(errorClass);
            }
        },
        submitHandler : function(form) {
            // Store removed products in hidden form field after before submit
            $product_to_remove_el.val(product_to_remove.join(","));
            $scheme_id.children().not(':first').remove();

            if(!scheme_submitted) {

                $.ajax({
                    "url"   :   "<?php echo base_url()?>index.php/orders/get_applicable_scheme",
                    "method":   "post",
                    "dataType": "json",
                    "data": $('form').serialize(),
                    "success":  function(response){  

                        // console.log(response);return;

                        if(response.status && response.schemes.length>0) {
                            
                            var scheme_opt = "";
                            
                            $.each(response.schemes,function(i,scheme){
                                // console.log(scheme);
                                scheme_opt += "<option value='"+scheme.id+"'>"+scheme.name+"</option>";
                            });

                            $scheme_id.append(scheme_opt);
                            $my_modal.modal('show');
                        } else {
                            scheme_submitted = true;                            
                            form.submit();
                        }
                    },
                    error: function (jqXHR, exception) {
                        scheme_submitted = true;
                        form.submit();
                    }
                });
            } else {
                // console.log('sch');
                form.submit();
            }
        }
    });

    $("#expected_delivery_date, #payment_schedule_date").datepicker({
        format		:	"yyyy-mm-dd",
        autoclose	:	true,
        todayBtn	:	"linked",
        // clearBtn	:	true,
        // endDate		: 	moment().format("YYYY-MM-DD"),
        // maxViewMode : 	2
        orientation: "bottom left"
    });
    
    $("#add_product").on('click',function(e){
        append_template();
    });


    $order_products_parent.on('click',".remove_product", function(e){

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
    }).on('change',".product_select", function(e){
        
        var $this = $(this);
        var $parent = $this.closest('tr');
        var $selected_product = $this.val();
        // console.log($selected_product);

        if($selected_product) {

            var $selected_option = $this.find("option:selected");
            var $client_price = $selected_option.data('client_price');

            $.each($order_products_parent.find(".product_select").not($this),function(i,el){

                var $el = $(el);
                
                if($el.val() == $selected_product) {
                    $this.val(null).trigger('change');
                    swal("", "You have already added "+$selected_option.text()+" in your order, You can simply modify quantity of the same product.", "");
                    return;
                }
            });

            $parent.find(".product_quantity").val('').end()
                    .find(".product_old_price").val($client_price).end()
                    .find(".product_new_price").val($client_price).end();

        } else {

            $parent.find(".product_quantity").val('').end()
                    .find(".product_old_price").val('').end()
                    .find(".product_new_price").val('').end();

        }
    });

    // Append single order item if there is no order item present on page load (edge case)
    if($order_products_parent.children().length == 0){
        append_template();
    }

    // Add new order item row
    function append_template() {
        
        $order_products_parent.append(template);
        // console.log(template);
        var $last_tr = $order_products_parent.children().last();
        
        var product_select = $last_tr.find('.product_select');
        var product_quantity = $last_tr.find('.product_quantity');
        var product_old_price = $last_tr.find('.product_old_price');
        var product_new_price = $last_tr.find('.product_new_price');

        // Set name attribute
        product_select.attr('name',"order_item["+index+"][product_id]");
        product_quantity.attr('name',"order_item["+index+"][quantity]");
        product_old_price.attr('name',"order_item["+index+"][old_price]");
        product_new_price.attr('name',"order_item["+index+"][new_price]");

        // Add Validation
        setTimeout(()=>{
            // https://jqueryvalidation.org/rules/
            product_select.rules("add",{
                required: true
            });
            // console.log($element,$element.rules())
        },0);
        setTimeout(()=>{
            // https://jqueryvalidation.org/rules/
            product_quantity.rules("add",{
                required: true,
                digits: true,
            });
            // console.log($element,$element.rules())
        },0);
        setTimeout(()=>{
            // https://jqueryvalidation.org/rules/
            product_new_price.rules("add",{
                required: true,
                number: true,
            });
            // console.log($element,$element.rules())
        },0);

        // Initialize Select2
        product_select.select2({
            allowClear:true,
            dropdownParent: product_select.parent()
        });

        index++;
    }

    // Add initial validation to existing order items
    $order_products_parent.children().find('.product_select,.product_quantity,.product_new_price').each(function(i,element){
                
        var $element = $(element);
        // console.log($element);

        if($element.hasClass("product_quantity")) {
            setTimeout(()=>{
                // https://jqueryvalidation.org/rules/
                $element.rules("add",{
                    required: true,
                    digits: true,
                });
                // console.log($element,$element.rules())
            },0);
        } else if($element.hasClass("product_new_price")) {
            setTimeout(()=>{
                // https://jqueryvalidation.org/rules/
                $element.rules("add",{
                    required: true,
                    number: true,
                });
                // console.log($element,$element.rules())
            },0);
        } else {
            setTimeout(()=>{
                // https://jqueryvalidation.org/rules/
                $element.rules("add",{
                    required: true,
                });
                // console.log($element,$element.rules())
            },0);
        }

        if($element.hasClass("product_select")){
            $element.select2({
                allowClear:true,
                dropdownParent: $element.parent()
            });
        }

    });

</script>
@endscript