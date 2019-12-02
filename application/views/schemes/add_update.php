<style>
    .without_padding{
        padding: 0px;
        background: #fff;
        border: none;
        border-radius: 0px;
    }
    #free_product_qty{
        /* line-height: 2.05; */
        height: 32px;
    }
    
    .orange-color{
        background-color:#e6973d!important;

        /* For UI Glitch */
        border-right: solid 1px #c38034 !important;
        border-radius: 0px;
    }

    .inline_input{
        border: none;
        border-bottom: 1px dotted #827373;
        width: 150px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered{
        line-height: 14px;
    }

    .select2-container--default .select2-selection--single{
        border-radius: 0px;        
    }

    .w-100{
        width:90px!important;
        height: 32px;
        border-color: #aaaaaa;   
        border-left: none;     
    }

    .add_product, .remove_product{
        font-size: 13px;
    }

    #order_value-error, #gift_mode-error, #discount_mode-error, #discount_value-error, #match_mode-error{
        display: inline-block!important;
    }
</style>
<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <form data-action="<?php echo $this->baseUrl; ?>schemes/add_update/<?php echo $id; ?>" id="tagFrm" method="post" autocomplete="off">
                <div class="card">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="name" class="control-label">Scheme Name:</label>
                                    <input type="text" name="name" id="name" class="form-control" value="<?php echo $scheme_data['name']; ?>"/>
                                </div>                                
                                <div class="form-group">
                                    <label for="end_date" class="control-label">Effective Date:</label>
                                    <div class="input-group">
                                        <input type="text" name="start_date" id="start_date" class="form-control" value="<?php echo $scheme_data['start_date']; ?>" placeholder="From..."/>                                        
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="text" name="end_date" id="end_date" class="form-control" value="<?php echo $scheme_data['end_date']; ?>" placeholder="To..."/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="type" class="control-label">Scheme Type:</label>
                                    <select name="type" id="type" class="form-control">
                                        <option value=''>Choose Scheme Type</option>
                                        <option value='price_scheme' <?php echo ($scheme_data['type'] == 'price_scheme') ? 'selected' : ''; ?>>Price Scheme</option>
                                        <option value='product_order_scheme' <?php echo ($scheme_data['type'] == 'product_order_scheme') ? 'selected' : ''; ?>>Product Scheme</option>
                                    </select>
                                </div>                                
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="description" class="control-label">Description:</label>
                                    <textarea name="description" id="description" class="form-control" style="height:201px;"><?php echo $scheme_data['description']; ?></textarea>
                                </div>                                
                            </div>                            
                        </div>
                        <hr/>
                        
                        <div class="row" id="price_scheme">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="order_value" class="control-label"><b>Rule :</b></label>
                                    <label class="control-label">If order value is grater then or equal to :
                                        <input type="text" name="order_value" id="order_value" class="inline_input" value="<?php echo $scheme_data['order_value']; ?>" placeholder="Amount"/>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div id="product_order_scheme">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="order_value" class="control-label"><b>Rule :</b></label>
                                        <label class="control-label">If order contains 
                                            <select name="match_mode" id="match_mode" class="inline_input">
                                                <option value=''>---</option>
                                                <option value='all' <?php echo ($scheme_data['match_mode'] == 'all') ? 'selected' : ''; ?>>all</option>
                                                <option value='any' <?php echo ($scheme_data['match_mode'] == 'any') ? 'selected' : ''; ?>>any</option>
                                            </select>
                                         product from following :</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Container for conditional products -->
                            <div class="row" id="product_order_parent">
                                <?php foreach($scheme_data['scheme_products'] as $k=>$scheme_product):?>
                                    <div class='col-sm-12 col-md-6 offset-md-6 product_order'>
                                        <div class='form-group'>
                                            <div class='input-group'>
                                                <select class='form-control products' data-placeholder='Choose Product' id="<?php echo mt_rand(0,20).strtotime(date('Y-m-d'));?>" name="products[<?php echo $k;?>][product_id]" style='width:100%;'>
                                                    <option value=''></option>
                                                    <?php foreach($products as $product){
                                                        $selected = ($product['id']==$scheme_product['product_id']) ? 'selected' : '';
                                                        echo "<option value='{$product['id']}' {$selected}>{$product['product_name']}</option>";
                                                    }?>
                                                </select>
                                                <input type='text' class='form-control w-100 qty' value="<?php echo $scheme_product['quantity'];?>" placeholder='Quantity' id="<?php echo mt_rand(0,20).strtotime(date('Y-m-d'));?>" name="products[<?php echo $k;?>][qty]"/>
                                                <span class='input-group-addon add_product' title='Add'><i class='feather icon-plus'></i></span>
                                                <span class='input-group-addon orange-color remove_product' title='Remove'><i class='feather icon-minus'></i></span>
                                            </div>                                        
                                        </div>
                                    </div>
                                <?php endforeach;?>
                            </div>
                            <hr/>
                        </div>

                        
                        <div class="row" id="then_row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="gift_mode" class="control-label"><b>Then :</b></label>
                                    <label for="gift_mode" class="control-label">the order will be eligible for this scheme and 
                                        <select name="gift_mode" id="gift_mode" class="inline_input">
                                            <option value=''>---</option>
                                            <option value='cash_benifit' <?php echo ($scheme_data['gift_mode'] == 'cash_benifit') ? 'selected' : ''; ?>>cash benefit</option>
                                            <option value='free_product' <?php echo ($scheme_data['gift_mode'] == 'free_product') ? 'selected' : ''; ?>>free product</option>
                                        </select>
                                        will be given, as described below.
                                    </label>                                    
                                </div>
                            </div>
                        </div>

                        <div class="row" id="cash_benifit">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="discount_mode" class="control-label"><b>Cash Discount : </b></label>
                                    <label for="discount_mode" class="control-label">
                                        <select name="discount_mode" id="discount_mode" class="inline_input">
                                            <option value=''>---</option>
                                            <option value='amount' <?php echo ($scheme_data['discount_mode'] == 'amount') ? 'selected' : ''; ?>>Rs.</option>
                                            <option value='percentage' <?php echo ($scheme_data['discount_mode'] == 'percentage') ? 'selected' : ''; ?>>%</option>
                                        </select>
                                        <input type="text" name="discount_value" id="discount_value" class="inline_input" value="<?php echo $scheme_data['discount_value']; ?>" placeholder=""/>
                                        <span id="discount_mode_slug"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div id="free_product">
                            <hr/>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="discount_mode" class="control-label">Product : </label>
                                        <select name="free_product_id" id="free_product_id" class="form-control" style="width:100%;" data-placeholder="Choose Product">
                                            <option value=''></option>
                                            <?php foreach($products as $product){
                                                $selected = ($scheme_data['free_product_id'] == $product['id']) ? 'selected' : '';
                                                echo "<option value='{$product['id']}' {$selected}>{$product['product_name']}</option>";
                                            }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="discount_mode" class="control-label">Quantity : </label>
                                        <input type="text" name="free_product_qty" id="free_product_qty" class="form-control" placeholder="Free Quantity" value="<?php echo $scheme_data['free_product_qty'];?>"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="card-footer">
                        <div class="text-right">
                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                            <a class="btn btn-sm btn-default" href="<?php echo $this->baseUrl; ?>schemes/">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@script
<script type="text/javascript">
    $(function(){
        
        // to active the sidebar
        $(".add_update_scheme_li").active();

        $("#start_date, #end_date").datepicker({
            format		:	"yyyy-mm-dd",
            autoclose	:	true,
            todayBtn	:	"linked",
            // clearBtn	:	true,
            // endDate		: 	moment().format("YYYY-MM-DD"),
            // maxViewMode : 	2
            //orientation: "bottom left"
        });

        var validator = $("#tagFrm").validate({
            // debug:true,
        rules   : 	{
                        "name"		:	{
                            required:true,
                            maxlength: 200,
                        },
                        "start_date"		:	{
                            required:true,
                        },
                        "end_date"		:	{
                            required:{
                                depends: function(element) {
                                   return ($("#start_date").val()) ? true : false;
                                }
                            },
                        },
                        "type"		:	{
                            required:true,
                        },
                        "order_value"		:	{
                            required:{
                                depends: function(element) {
                                   return ($("#type").val() == 'price_scheme') ? true : false;
                                }
                            },
                            digits:true,
                        },
                        "gift_mode"		:	{
                            required:true,
                        },
                        "discount_mode"		:	{
                            required:{
                                depends: function(element) {
                                   return ($("#gift_mode").val() == 'cash_benifit') ? true : false;
                                }
                            },
                        },
                        "discount_value"		:	{
                            required:{
                                depends: function(element) {
                                   return ($("#discount_mode").val()) ? true : false;
                                }
                            },
                        },
                        "free_product_id"		:	{
                            required:{
                                depends: function(element) {
                                    return ($("#gift_mode").val() == 'free_product') ? true : false;
                                }
                            },
                        },
                        "free_product_qty"		:	{
                            required:{
                                depends: function(element) {
                                    return ($("#gift_mode").val() == 'free_product') ? true : false;
                                }
                            },
                            digits: true
                        },
                        "match_mode"		:	{
                            required:{
                                depends: function(element) {
                                    return ($("#type").val() == 'product_order_scheme') ? true : false;
                                }
                            },
                        },
                    },
        messages	:	{
            start_date		:	{                
                required			:	"Start date is required."
            },
            end_date		:	{                
                required			:	"End date is required."
            },
            discount_mode		:	{                
                required			:	"Discount Type is required."
            },
            discount_value		:	{                
                required			:	"Discount Value is required."
            },
            // username		:	{
            //     remote			:	"Username already Exists",
            // },
            // phone		:	{
            //     remote			:	"Phone already Exists",
            // },
        },
        errorElement: "p",
        errorClass:"text-danger error",
        errorPlacement: function ( error, element ) {

            console.log(element);

            var el_id = element.attr('id');

            // console.log(element,element.hasClass('products'));
            if($.inArray(el_id,['order_value']) != -1){                
                element.after(error);
            }else 
            if($.inArray(el_id,['discount_mode','discount_value','match_mode','gift_mode','order_value']) != -1){                
                $(element).closest("label").append(error);
            }else{
                $(element).closest(".form-group").append(error);
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

        var product_template = $("#product_template").html();
        // console.log(product_template);
        var $product_order_parent = $("#product_order_parent"); // will contains products & quantity
        var index = $product_order_parent.children().length;
        // console.log(index);
        var $type = $("#type");
        var $then_row = $("#then_row");
        var $price_scheme = $("#price_scheme");
        var $product_order_scheme = $("#product_order_scheme");
        var $discount_mode = $("#discount_mode");
        var $discount_value = $("#discount_value");
        var $discount_mode_slug = $('#discount_mode_slug');
        var $cash_benifit = $('#cash_benifit');
        var $free_product = $('#free_product');
        var $free_product_id = $("#free_product_id");
        var $free_product_qty = $("#free_product_qty");
        var $gift_mode = $("#gift_mode");
        var $order_value = $("#order_value");
        var $match_mode = $("#match_mode");

        $free_product_id.select2({
            allowClear:true,
        });

        $discount_mode.change(function(e,clear=true){

            // console.log("discount_mode Changed: ",this.value);

            if(!this.value){
                $discount_value.attr('readonly',true).val('');
                $discount_mode_slug.hide();
            }else{                
                $discount_value.removeAttr('readonly');
                $discount_mode_slug.show();
            }

            $discount_mode_slug.text(this.value=='amount' ? '(Discount in Amount)' : (this.value=='percentage' ? '(Discount in Percentage)' : ''));
        });

        $gift_mode.on('change',function(e,clear=true){

            // console.log("gift_mode Changed : ",this.value);

            if(clear){
                $free_product_id.val('').trigger('change');
                $free_product_qty.val('');
            }

            switch(this.value){
                case 'cash_benifit':
                    $cash_benifit.show();
                    $free_product.hide();                    
                    break;
                case 'free_product':
                    $free_product.show();
                    $cash_benifit.hide(); 
                    $discount_mode.val('');                   
                    break;
                default:
                    $free_product.hide();                    
                    $cash_benifit.hide();  
                    $discount_mode.val('');                  
            }

            $discount_mode.trigger('change',clear);            
        });

        $type.change(function(e,clear=true){
            
            // console.log("Scheme Type Changed : ",this.value,clear);

            if(clear){
                $order_value.val('');
                $match_mode.val('').trigger('change');
                //remove all child products in if block
                $product_order_parent.children().remove();
                $gift_mode.val('');
            }

            switch(this.value){
                case 'price_scheme':
                    $price_scheme.show();
                    $product_order_scheme.hide();
                    $then_row.show();                                                         
                    break;                
                case 'product_order_scheme':
                    $product_order_scheme.show();
                    $price_scheme.hide();
                    $then_row.show();
                    check_childs();
                    break;
                default:
                    $price_scheme.hide();
                    $product_order_scheme.hide();
                    $then_row.hide();
            }

            $gift_mode.trigger('change',clear);

        }).trigger('change',false);

        $product_order_parent.on('click','.add_product',function(e){
            
            e.preventDefault();
            append_child();

        }).on('click','.remove_product',function(e){            
            
            e.preventDefault();

            var $this = $(this);

            if($product_order_parent.children().length > 1){
                swal(
                    {
                        title: "Remove ?",
                        // text: "You will not be able to recover this user!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes",
                        cancelButtonText: "No"
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                                $this.closest('.product_order').fadeOut(function(){
                                this.remove();
                            });
                        }
                    }
                );
            }else{
                swal("Can't Deleted", "Unable to delete.", "error");
            }

        }).on('change','.products',function(e){
          
            var $this = $(this);
            var current_value = this.value;

            // console.log("current_value : ",current_value);
            
            if(current_value){
                $product_order_parent.find('.products').not(this).each(function(i,v){

                    if(current_value==v.value){
                        swal("Already Selected", "This Product is already selected.", "info");
                        $this.val('').trigger('change');
                        return;
                    }
                });
            }
        });

        function check_childs(){
            if($product_order_parent.children().length == 0){
                append_child();
            }
        }

        function append_child(){
            $product_order_parent.append(product_template);
            var $recent = $product_order_parent.find('.product_order').last();
            var $product = $recent.find('.products');
            var $qty = $recent.find('.qty');
            
            $qty.attr('id',Math.floor(Math.random()*1000) + (new Date).getTime()).attr('name',"products["+index+"][qty]");
            $product.attr('id',Math.floor(Math.random()*1000) + (new Date).getTime()).attr('name',"products["+index+"][product_id]");

            $product.select2({
                allowClear:true,
                dropdownParent: $product.parent()
            });

            $product.rules('add',{
                required:{
                    depends: function(element) {
                        return ($("#type").val() == 'product_order_scheme') ? true : false;
                    }
                },
                messages: {
                    required: "Please select Product",
                }
            });
            $qty.rules('add',{
                required:{
                    depends: function(element) {                        
                        return ($(element).closest('.form-group').find('.products').val()) ? true : false;
                    }
                },
                digits:true,
                    min:1,
                    messages: {
                        required: "Please enter quantity",
                        digits: "Please enter only digits.",
                        min: "Quantity must be grater then 1.",
                    }
            });

            index++;
        }

        $product_order_parent.children().each(function(i,element){
            
            $(element).find(".products").each(function(i,product){
                $(product).rules('add',{
                    required:{
                        depends: function(element) {
                            return ($("#type").val() == 'product_order_scheme') ? true : false;
                        }
                    },
                    messages: {
                        required: "Please select Product",
                    }
                });
            }).end().find(".qty").each(function(i,qty){
                $(qty).rules('add',{
                    required:{
                        depends: function(element) {                        
                            return ($(element).closest('.form-group').find('.products').val()) ? true : false;
                        }
                    },
                    digits:true,
                    min:1,
                    messages: {
                        required: "Please enter quantity",
                        digits: "Please enter only digits.",
                        min: "Quantity must be grater then 1.",
                    }
                });
            });
        });

        $product_order_parent.children().find(".products").each(function(i,element){
            var $this = $(this);
            
            $this.select2({
                allowClear:true,
                dropdownParent: $this.parent()
            });

        });

    });
</script>

<script type="text/template" id="product_template">
    <div class="col-sm-12 col-md-6 offset-md-6 product_order">
        <div class="form-group">
            <div class="input-group">
                <select class="form-control products" data-placeholder="Choose Product" style="width:100%;">
                    <option value=''></option>
                    <?php foreach($products as $product){
                        echo "<option value='{$product['id']}'>{$product['product_name']}</option>";
                    }?>
                </select>
                <input type="text" name="" class="form-control w-100 qty" value="" placeholder="Quantity"/>
                <span class="input-group-addon add_product" title="Add"><i class="feather icon-plus"></i></span>
                <span class="input-group-addon orange-color remove_product" title="Remove"><i class="feather icon-minus"></i></span>
            </div>                                        
        </div>
    </div>
</script>
@endscript