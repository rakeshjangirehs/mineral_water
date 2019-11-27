<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        /* background-color: #e4e4e4;
        border: 1px solid #aaa;
        border-radius: 4px;
        cursor: default;
        float: left; */
        margin-right: 5px!important;
        /* margin-top: 5px!important;
        padding: 0 5px!important; */
    }
    .wizard > .content > .body input.select2-search__field{
		border:none;
	}

    .checkbox-fade label input[type="checkbox"], .checkbox-fade label input[type="radio"] {
        display: none!important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered{
        line-height: 15px;
        font-size: 13px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow b{
        margin-top: -9px;
        margin-left: 7px;
        border-color:#cccccc transparent transparent transparent;
    }

    .remove_config{
        /* position: absolute;
        right: 24px;
        font-size: 16px;
        top: 8px; */
        color: #a09494;
    }

    .remove_config:hover{
        color:#ea1f1f;
    }

    .remove_config_parent{
        margin-bottom:20px;
    }

    .select2-results__option {
        padding: 6px!important;
        /* user-select: none;
        -webkit-user-select: none; */
    }

    .wizard > .content > .body .select2-selection.error{
        background: rgb(251, 227, 228);
        border: 1px solid #fbc2c4;
        color: #8a1f11;
    }

    #config_parent{
        padding: 0px 20px 0px 0px;
    }

    .wizard > .actions{
        padding: 0px 6px 0px 0px;
    }
    .wizard>.actions a[href='#cancel']{
        /* background-color: rgba(0, 0, 0, 0);
        border-color: rgba(0, 0, 0, 0);
        color:rgb(64, 78, 103); */
    }

</style>

<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    &nbsp;
                    <div class="card-header-right" style="padding:0px 0px;">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-maximize full-card"></i></li>
                        </ul>
                    </div>
                </div>            
                <div class="card-block">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="wizard">
                                <section>
                                    <form class="wizard-form" id="example-advanced-form" action="<?php echo $this->baseUrl; ?>delivery/add_update/<?php echo $delivery_id; ?>" method="post" autocomplete="off">
                                        <h3> Delivery Details </h3>
                                        <fieldset>
                                            <div class="form-group row">
                                                <div class="col-md-4 col-lg-3">
                                                    <label for="expected_delivey_datetime" class="block">Expected Delivery Date <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-md-8 col-lg-9">
                                                <input type="text" name="expected_delivey_datetime" id="expected_delivey_datetime" class="form-control" value="<?php echo ($delivery_data['expected_delivey_datetime']) ? date('Y-m-d',strtotime($delivery_data['expected_delivey_datetime'])) : ''; ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-4 col-lg-3">
                                                    <label for="zip_code_group" class="block">Route <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-md-8 col-lg-9">
                                                    <select class="form-control multiple" name="zip_code_group[]" id="zip_code_group" data-placeholder="Choose ZIP Code Groups" data-url="<?php echo $this->baseUrl; ?>delivery/get_orders_by_zip_code_group" multiple>
                                                        <option value=""></option>
                                                        <?php                                            
                                                            if(!empty($zip_code_groups)){
                                                                foreach($zip_code_groups as $key=>$zip_code_group){
                                                                    $selected = (in_array($key,$delivery_routes)) ? 'selected' : '';
                                                                    echo "<option value='{$key}' {$selected}>{$zip_code_group}</option>";
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>  
                                            <div class="form-group row">
                                                <div class="col-md-4 col-lg-3">
                                                    <label for="zip_code_group" class="block">&nbsp;</label>
                                                </div>
                                                <div class="col-md-8 col-lg-9">
                                                    <span class="pull-right" id="order_found_count"></span>
                                                </div>
                                            </div>                                          
                                        </fieldset>                                        
                                        <h3> Transport & Order Details </h3>
                                        <fieldset>
                                            <div id="config_parent">
                                                <?php foreach($delivery_config as $k=>$config):?>
                                                    <div class="well well-lg config_col">
                                                        <div class="pull-right">                                        
                                                            <a class="add_config" title="Add New" href="#">
                                                                <i class="feather icon-plus"></i>
                                                            </a>|
                                                            <a class="remove_config" title="Remove" href="#">
                                                                <i class="feather icon-x"></i>
                                                            </a>
                                                        </div>
                                                        <div class="row m-t-25">
                                                            <div class="col-sm-12 col-md-4">
                                                                <div class="form-group">
                                                                    <label for="vehicles" class="control-label">Vehicle:</label>
                                                                    <select class="form-control vehicles" name="deliveries[<?php echo $k;?>][vehicles]" id="<?php echo mt_rand(0,20).strtotime(date('Y-m-d'));?>" data-placeholder="Vehicle" data-index="<?php echo $k;?>">
                                                                        <option value=""></option>
                                                                        <?php
                                                                            foreach($vehicles as $key=>$vehicle){
                                                                                $selected = ($vehicle['id'] == $config['vehicle_id']) ? "selected" : "";
                                                                                echo "<option value='{$vehicle['id']}' data-capacity='{$vehicle['capacity_in_ton']}' {$selected}>{$vehicle['name']} ({$vehicle['number']}) Cap:{$vehicle['capacity_in_ton']} KG</option>";
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-4">
                                                                <div class="form-group">
                                                                    <label for="drivers" class="control-label">Driver:</label>
                                                                    <select class="form-control drivers" name="deliveries[<?php echo $k;?>][drivers]" id="<?php echo mt_rand(0,20).strtotime(date('Y-m-d'));?>" data-placeholder="Choose Driver" data-index="<?php echo $k;?>">
                                                                        <option value=""></option>
                                                                        <?php
                                                                            foreach($drivers as $key=>$driver){
                                                                                $selected = ($driver['id'] == $config['driver_id']) ? "selected" : "";
                                                                                echo "<option value='{$driver['id']}' {$selected}>{$driver['first_name']} {$driver['last_name']}</option>";
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-4">
                                                                <div class="form-group">
                                                                    <label for="delivery_boys" class="control-label">Delivery Boy:</label>
                                                                    <select class="form-control delivery_boys" name="deliveries[<?php echo $k;?>][delivery_boys]" id="<?php echo mt_rand(0,20).strtotime(date('Y-m-d'));?>" data-placeholder="Delivery Boy" data-index="<?php echo $k;?>">
                                                                        <option value=""></option>
                                                                        <?php
                                                                            foreach($delivery_boys as $key=>$delivery_boy){
                                                                                $selected = ($delivery_boy['id'] == $config['delivery_boy_id']) ? "selected" : "";
                                                                                echo "<option value='{$delivery_boy['id']}' {$selected}>{$delivery_boy['first_name']} {$delivery_boy['last_name']}</option>";
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>                                                         
                                                            </div>
                                                        </div>
                                                        <!--rakesh-->
                                                        <h3 class="m-t-10"> Order Selection 
                                                        <span class="pull-right f-14 m-t-10">
                                                            (Total Order Weight / Vehicle Capacity) ::
                                                            <span class="order_weight_parent">
                                                                <span class="order_weight"></span>/
                                                                <span class="vehicle_capacity"></span>        
                                                            </span>
                                                        </span>
                                                        </h3>
                                                        <hr/>
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="dt-responsive table-responsive">
                                                                    <table class="table table-striped table-bordered table-hover" style="width:100%;">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>Order No.</th>
                                                                                <th>Client Name</th>
                                                                                <th>Expected Delivery Date</th>
                                                                                <th>ZIP Code</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="order_body">
                                                                            <?php foreach($config_orders as $ko=>$order){
                                                                                $checked = (in_array($order['id'],$config['selected_orders'])) ? "checked": "";
                                                                                echo "<tr>
                                                                                        <td>
                                                                                            <div class='checkbox-fade fade-in-primary'>
                                                                                                <label>
                                                                                                    <input type='checkbox' name='deliveries[{$k}][orders][]' class='order_id_chk' value='{$order['id']}' data-order_weight='{$order['order_weight']}' {$checked}>
                                                                                                    <span class='cr'>
                                                                                                        <i class='cr-icon icofont icofont-ui-check txt-primary'></i>
                                                                                                    </span>
                                                                                                </label>
                                                                                            </div>    
                                                                                        </td>
                                                                                        <td>{$order['id']}</td>
                                                                                        <td>{$order['client_name']}</td>
                                                                                        <td>{$order['expected_delivery_date']}</td>
                                                                                        <td>{$order['zip_code']}</td>
                                                                                    </tr>";
                                                                            }?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach;?>
                                            </div>
                                        </fieldset>
                                        <h3> Pickup Location </h3>
                                        <fieldset>
                                            <div class="form-group row">
                                                <div class="col-md-4 col-lg-3">
                                                    <label for="pickup_location" class="block">Pickup Location</label>
                                                </div>
                                                <div class="col-md-8 col-lg-9">
                                                    <div class="form-radio">
                                                        <div class="radio radio-inline">
                                                            <label>
                                                                <input type="radio" name="pickup_location" id="pickup_location_1" value="Office" <?php echo ($delivery_data['pickup_location']=='Office') ? "checked" : "";?>>
                                                                <i class="helper"></i>Office
                                                            </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <label>
                                                                <input type="radio" name="pickup_location" id="pickup_location_2" value="Warehouse" <?php echo ($delivery_data['pickup_location']=='Warehouse') ? "checked" : "";?>>
                                                                <i class="helper"></i>Warehouse
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-4 col-lg-3">
                                                    <label for="warehouse" class="block">Warehouse</label>
                                                </div>
                                                <div class="col-md-8 col-lg-9">
                                                    <select class="form-control" name="warehouse" data-placeholder="Warehouse">
                                                        <option value=""></option>
                                                        <?php
                                                            foreach($warehouses as $key=>$warehouse){
                                                                $selected = ($warehouse['id']==$delivery_data['warehouse']) ? "selected" : "";
                                                                echo "<option value='{$warehouse['id']}' {$selected}>{$warehouse['name']}</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </fieldset>                               
                                    </form>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Setps Ref ::
    https://github.com/rstaib/jquery-steps/wiki
    http://www.jquery-steps.com/GettingStarted
-->

@script
<script type="text/javascript">
    $(function(){
        
        // http://www.codeboss.in/web-funda/2009/05/27/jquery-validation-for-array-of-input-elements/
        // Keep in mind it needs unique id too.
        $.extend( $.validator.prototype, {
            checkForm: function () {
                this.prepareForm();
                for (var i = 0, elements = (this.currentElements = this.elements()); elements[i]; i++) {
                    if (this.findByName(elements[i].name).length != undefined && this.findByName(elements[i].name).length > 1) {
                        for (var cnt = 0; cnt < this.findByName(elements[i].name).length; cnt++) {
                            this.check(this.findByName(elements[i].name)[cnt]);
                        }
                    } else {
                        this.check(elements[i]);
                    }
                }
                return this.valid();
            }
        });

        // to active the sidebar
        $(".add_update_delivery_li").active();
        
        var config_template = $("#config_template").html();
                
        <?php 
        $str = "";
        foreach($config_orders as $ko=>$order){
            
            $str .= "<tr>
                    <td>
                        <div class='checkbox-fade fade-in-primary'>
                            <label>
                                <input type='checkbox' name='deliveries[{$k}][orders][]' class='order_id_chk' value='{$order['id']}' data-order_weight='{$order['order_weight']}'>
                                <span class='cr'>
                                    <i class='cr-icon icofont icofont-ui-check txt-primary'></i>
                                </span>
                            </label>
                        </div>    
                    </td>
                    <td>{$order['id']}</td>
                    <td>{$order['client_name']}</td>
                    <td>{$order['expected_delivery_date']}</td>
                    <td>{$order['zip_code']}</td>
                </tr>";
        }

        ?>
        var orders = `<?php echo $str;?>`;

        var form = $("#example-advanced-form");//.show();

        form.steps({
            headerTag: "h3",
            bodyTag: "fieldset",
            transitionEffect: "slideLeft",
            enableAllSteps:true,
            enableCancelButton:true,
            // stepsOrientation:1,  //vertical
            // enableContentCache:false,
            autoFocus:true,
            // titleTemplate: "<span class='number'>#index#.</span> #title#",

            onInit:function(event, currentIndex) {

                // console.log("onInit",event,currentIndex);                
                initialization();
                // console.log("Init");

            },

            onCanceled : function (event) {
                window.location.href = "<?php echo $this->baseUrl;?>/delivery";
            },

                       
            onStepChanging: function(event, currentIndex, newIndex) {
                
                // console.log("onStepChanging");
                // console.log(currentIndex, newIndex);

                // Allways allow previous action even if the current form is not valid!
                if (currentIndex > newIndex) {
                    return true;
                }
                // Specific validation 
                // if (newIndex === 3 && Number($("#age-2").val()) < 18) {
                //     return false;
                // }

                // Needed in some cases if the user went back (clean up)
                if (currentIndex < newIndex) {
                    // To remove error styles
                    // form.find(".body:eq(" + newIndex + ") label.error").remove();
                    // form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
                
                }

                // form.validate().settings.ignore = ":disabled,:hidden";      
                
                //Validate if order is selected
                if(form.valid() && currentIndex == 1){

                    var all_ok = true;

                    $(".order_body").each(function(i,v){
                        var $this = $(this);
                        // console.log($(this));
                        if($this.find(".order_id_chk:checked").length == 0){
                            all_ok = false;
                        }
                    });

                    if(!all_ok){
                        swal("Can't Process", "Atleaset one order must be selected in each block.", "info");
                        return false;
                    }

                    $("#config_parent").find('.order_weight_parent').each(function(i,v){
                        var order_weight = parseInt($(v).find('.order_weight').text()) || 0;
                        var vehicle_capacity = parseInt($(v).find('.vehicle_capacity').text()) || 0;
                        if(order_weight>vehicle_capacity){
                            all_ok = false;
                        }
                    });

                    if(!all_ok){
                        swal("Can't Process", "Order Weight can't exceed Vehicle capacity.", "info");
                        return false;
                    }
                }

                

                return form.valid();
            },
            /*
            onStepChanged: function(event, currentIndex, priorIndex) {

                // Used to skip the "Warning" step if the user is old enough.
                if (currentIndex === 2 && Number($("#age-2").val()) >= 18) {
                    form.steps("next");
                }
                // Used to skip the "Warning" step if the user is old enough and wants to the previous step.
                if (currentIndex === 2 && priorIndex === 3) {
                    form.steps("previous");
                }
            },*/
            onFinishing: function(event, currentIndex) {

                // console.log("onFinishing");
                // form.validate().settings.ignore = ":disabled";
                return form.valid();
            },
            onFinished: function(event, currentIndex) {
                // console.log("onFinished");
                // alert("Submitted!");
                form.submit();
            }
        }).validate({
            // debug:true,
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
            rules: {
                "expected_delivey_datetime": {
                    required: true
                },
                "zip_code_group[]": {
                    required: true
                },
                // "vehicles[]": {
                //     required: true
                // },
                // "delivery_boys[]": {
                //     required: true
                // },
                // "drivers[]": {
                //     required: true
                // },
                // "pickup_location[]": {
                //     required: true
                // },
                "warehouse": {
                    required: {
                        depends : function(element){
                            // console.log("depends el : ",element);
                            if($("[name='pickup_location']:checked").length!=0){
                                return ($("[name='pickup_location']:checked").val() == "Warehouse");
                            }else{
                                return false;
                            }
                        }
                    }
                },
            }
            
        });
        

        function initialization(){
                        
            var $config_parent = $("#config_parent");
            var index = $config_parent.children().length;
   
            // Make Scrollable
            // http://rocha.la/jQuery-slimScroll
            $('#config_parent').slimScroll({
                height: '450px'
            });

            // Initialize Date Picker
            $("#expected_delivey_datetime").datepicker({
                format		:	"yyyy-mm-dd",
                autoclose	:	true,
                todayBtn	:	"linked",
                // clearBtn	:	true,
                // endDate		: 	moment().format("YYYY-MM-DD"),
                // maxViewMode : 	2
                //orientation: "bottom left"
            });

            // Initialize Select2
            $("#zip_code_group").select2({
                dropdownParent: $('#zip_code_group').parent()
            });
            $("[name=warehouse]").select2({
                allowClear:true,
                dropdownParent: $('[name=warehouse]').parent()
            });

            $("[name='pickup_location']").on('change',function(e){
                // console.log("check pickup_location : ",this.value == 'warehouse');
                var $this = $(this);
                if(this.value == 'Warehouse'){
                    $this.closest('.form-group').next().show();
                    // $("[name=warehouse]").next(".select2-container").show();                    
                }else{
                    // $("[name=warehouse]").next(".select2-container").hide();    
                    $this.closest('.form-group').next().hide();
                    if($("[name=warehouse]").val()){
                        $("[name=warehouse]").val(null).trigger('change');
                    }                
                }
            });

            $("[name='pickup_location']:checked").trigger('change');

            // console.log($("#config_parent"));
            $("#config_parent").on('change',".vehicles",function(e){
                
                var $this = $(this);
                var vehicle_cap = $this.find("option:selected").data('capacity') || 0;
                $this.closest(".config_col").find(".vehicle_capacity").text(vehicle_cap);

                var weight_sum = $this.closest('.config_col').find('.order_id_chk:checked').map(function(i,v){
                    var return_val =  $(v).data('order_weight') || 0;
                    return return_val;
                })
                .toArray()
                .reduce(function(carry,val){
                    return carry+val;
                },0);

                // console.log("vehicles change : ",weight_sum,vehicle_cap,weight_sum > vehicle_cap);
                var parentClass = (weight_sum > vehicle_cap) ? 'text-danger' : 'text-success';
                $this.closest(".config_col").find(".order_weight").parent().removeClass('text-danger text-success').addClass(parentClass);
                

            }).on('change',".order_id_chk",function(e){

                var $this = $(this);
                
                var weight_sum = $this.closest('.order_body').find('.order_id_chk:checked').map(function(i,v){
                    // console.log($(v),$(v).data('order_weight'));
                    var return_val =  $(v).data('order_weight') || 0;
                    return return_val;
                })
                .toArray()
                .reduce(function(carry,val){
                    return carry+val;
                },0);
                // console.log(weight_sum);
                var vehicle_cap = $this.closest(".config_col").find(".vehicles").find("option:selected");
                vehicle_cap = vehicle_cap.data('capacity') || 0;
                var parentClass = (weight_sum > vehicle_cap) ? 'text-danger' : 'text-success';
                // console.log("order_id_chk change : ",weight_sum,vehicle_cap,weight_sum > vehicle_cap);
                $this.closest(".config_col").find(".order_weight").parent().removeClass('text-danger text-success').addClass(parentClass).end().text(weight_sum);

            });            
            
            $('.config_col').each(function(i,config_col){
                $(config_col).find('.order_id_chk').first().trigger('change');
                setTimeout(() => {
                    $(config_col).find('.vehicles').trigger('change');
                });
            });

            var selected_orders = JSON.parse('<?php echo json_encode($selected_orders);?>');
            // console.log(selected_orders);
            //Get Orders When zip_code_group changes
            $("#zip_code_group").on('change',function(e){

                var $this = $(this);
                var url = $this.data('url');        
                var zip_code_group_ids = $this.val();
                var $order_found_count = $("#order_found_count");
                
                var $order_body = $(".order_body");
                // console.log("orders : ",$order_body);                
                $order_body.each(function(i,v){
                    $(v).empty();
                });

                $order_found_count.removeClass('text-success text-warning');

                if(zip_code_group_ids.length != 0){
                    $.ajax({
                        "url"   :   url,
                        "method":   "post",
                        "dataType": "json",
                        "data"  :   {
                            "zip_code_group_ids"    :   zip_code_group_ids,
                            "selected_orders"       :   selected_orders
                        },
                        "success":  function(data){
                            // console.log(data);
                            var trs = [];
                            
                            if(data && data.length>0){
                                $.each(data,function(i,arr){
                                    
                                    var checked = '';//($.inArray(arr.id,selected_orders) != -1) ? 'checked' : '';
                                    
                                    var str = `<tr>
                                                    <td>
                                                        <div class='checkbox-fade fade-in-primary'>
                                                            <label>
                                                                <input type='checkbox' name='orders[]' class='order_id_chk' value='${arr.id}' data-order_weight='${arr.order_weight}' ${checked}>
                                                                <span class='cr'>
                                                                    <i class='cr-icon icofont icofont-ui-check txt-primary'></i>
                                                                </span>
                                                            </label>
                                                        </div>    
                                                    </td>
                                                    <td>${arr.id}</td>
                                                    <td>${arr.client_name}</td>
                                                    <td>${arr.expected_delivery_date}</td>
                                                    <td>${arr.zip_code}</td>
                                                </tr>`;
                                    trs.push(str);
                                    $order_found_count.text(data.length + " orders found.");
                                    $order_found_count.addClass("text-success");
                                    // selected_orders = [];
                                });
                                
                                orders = trs.join("");
                                $order_body.each(function(i,v){
                                    // console.log("order body : ",$order_body, " index : ",$(v).closest(".config_col").find(".vehicles").data('index'));
                                    
                                    $(v).append(orders).find('.order_id_chk').each(function(i,el){
                                        var $el = $(el);
                                        // console.log("ELS : ",$el);
                                        // console.log("order id changed : ",$el.closest(".config_col").find(".vehicles").data('index'));
                                        var parent_index = $el.closest(".config_col").find(".vehicles").data('index');
                                        // console.log("parent_index : ",parent_index);
                                        $el.attr('name',"deliveries["+parent_index+"][orders][]");
                                    });
                                });
                                
                            }else{
                                $order_found_count.text("No Orders found.");
                                $order_found_count.addClass("text-warning");
                                orders = "";
                            }
                        }
                    });
                }else{
                    $order_found_count.text("");
                    orders = "";
                    // $order_found_count.addClass("text-warning");
                }

            });

            $config_parent.on('click','.add_config',function(e){

                e.preventDefault();
                append_config();                

            }).on('click','.remove_config',function(e){

                e.preventDefault();
                var $this = $(this);

                if($config_parent.children().length > 1){
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
                                    $this.closest('.config_col').fadeOut(function(){
                                this.remove();
                            });
                            }
                        }
                    );
                }else{
                    swal("Can't Deleted", "Unable to delete.", "error");
                }
            });

            if($config_parent.children().length == 0){
                append_config();
            }

            function append_config(){
                
                $config_parent.append(config_template);
                
                $config_parent.children().last().find('.select2').each(function(i,element){
                
                    var $element = $(element);

                    $element.attr('name',"deliveries["+index+"]["+$element.attr('name')+"]");                    
                    $element.data('index',index);                    

                    $element.attr('id',Math.floor(Math.random()*1000) + (new Date).getTime());

                    if($element.hasClass("vehicles") || $element.hasClass("drivers")){
                        setTimeout(()=>{
                            // https://jqueryvalidation.org/rules/
                            $element.rules("add",{
                                required: true
                            });
                            // console.log($element,$element.rules())
                        },0);
                    }

                    $element.select2({
                        allowClear:true,
                        dropdownParent: $element.parent()
                    });

                }).end().find('.order_body').append(orders).end().find('.order_id_chk').each(function(i,el){
                    var $el = $(el);
                    // console.log("order id changed : ",$el.closest(".config_col").find(".vehicles").data('index'));
                    // var parent_index = $el.closest(".config_col").find(".vehicles").data('index');
                    $el.attr('name',"deliveries["+index+"][orders][]");
                });
                index++;
            }

            $config_parent.children().find('.vehicles,.drivers,.delivery_boys').each(function(i,element){
                
                var $element = $(element);
                // console.log("IN : ",$element);
                // $element.attr('name',"deliveries["+index+"]["+$element.attr('name')+"]");                    
                // $element.data('index',index);                    

                // $element.attr('id',Math.floor(Math.random()*1000) + (new Date).getTime());

                if($element.hasClass("vehicles") || $element.hasClass("drivers")){
                    setTimeout(()=>{
                        // https://jqueryvalidation.org/rules/
                        $element.rules("add",{
                            required: true
                        });
                        // console.log($element,$element.rules())
                    },0);
                }

                $element.select2({
                    allowClear:true,
                    dropdownParent: $element.parent()
                });

            })
        }
    });
</script>

<script type="text/template" id="config_template">
    <div class="well well-lg config_col">
        <div class="pull-right">                                        
            <a class="add_config" title="Add New" href="#">
                <i class="feather icon-plus"></i>
            </a>|
            <a class="remove_config" title="Remove" href="#">
                <i class="feather icon-x"></i>
            </a>
        </div>
        <div class="row m-t-25">
            <div class="col-sm-12 col-md-4">
                <div class="form-group">
                    <label for="vehicles" class="control-label">Vehicle:</label>
                    <select class="form-control select2 vehicles" name="vehicles" data-placeholder="Vehicle">
                        <option value=""></option>
                        <?php
                            foreach($vehicles as $key=>$vehicle){
                                echo "<option value='{$vehicle['id']}' data-capacity='{$vehicle['capacity_in_ton']}'>{$vehicle['name']} ({$vehicle['number']}) Cap:{$vehicle['capacity_in_ton']} KG</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="form-group">
                    <label for="drivers" class="control-label">Driver:</label>
                    <select class="form-control select2 drivers" name="drivers" data-placeholder="Choose Driver">
                        <option value=""></option>
                        <?php
                            foreach($drivers as $key=>$driver){
                                echo "<option value='{$driver['id']}'>{$driver['first_name']} {$driver['last_name']}</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="form-group">
                    <label for="delivery_boys" class="control-label">Delivery Boy:</label>
                    <select class="form-control select2 delivery_boys" name="delivery_boys" data-placeholder="Delivery Boy">
                        <option value=""></option>
                        <?php
                            foreach($delivery_boys as $key=>$delivery_boy){
                                echo "<option value='{$delivery_boy['id']}'>{$delivery_boy['first_name']} {$delivery_boy['last_name']}</option>";
                            }
                        ?>
                    </select>
                </div>                                                         
            </div>
        </div>
        <h3 class="m-t-10"> Order Selection 
        <span class="pull-right f-14 m-t-10">
            (Total Order Weight / Vehicle Capacity) ::
            <span class="order_weight_parent">
                <span class="order_weight"></span>/
                <span class="vehicle_capacity"></span>        
            </span>
        </span>
        </h3>
        <hr/>
        <div class="row">
            <div class="col-sm-12">
                <div class="dt-responsive table-responsive">
                    <table class="table table-striped table-bordered table-hover" style="width:100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order No.</th>
                                <th>Client Name</th>
                                <th>Expected Delivery Date</th>
                                <th>ZIP Code</th>
                            </tr>
                        </thead>
                        <tbody class="order_body"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</script>
@endscript