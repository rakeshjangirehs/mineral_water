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
                                                <input type="text" name="expected_delivey_datetime" id="expected_delivey_datetime" class="form-control" value="<?php echo $delivery_data['expected_delivey_datetime']; ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-4 col-lg-3">
                                                    <label for="zip_code_group" class="block">ZIP Code Groups <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-md-8 col-lg-9">
                                                    <select class="form-control multiple" name="zip_code_group[]" id="zip_code_group" data-placeholder="Choose ZIP Code Groups" data-url="<?php echo $this->baseUrl; ?>orders/get_orders_by_zip_code_group" multiple>
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
                                        </fieldset>
                                        <h3> Order Selection </h3>
                                        <fieldset>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="dt-responsive table-responsive">
                                                        <table id="dynamic-table" class="table table-striped table-bordered table-hover" style="width:100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Order No.</th>
                                                                    <th>Client Name</th>
                                                                    <th>Expected Delivery Date</th>
                                                                    <th>ZIP Code</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="order_body"></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <h3> Transport Details </h3>
                                        <fieldset>
                                            <div class="row" id="config_parent">
                                                
                                            </div>
                                        </fieldset>
                                        <h3> Pickup Location </h3>
                                        <fieldset>
                                                                                     
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
        
        config_template = $("#config_template").html();
        var form = $("#example-advanced-form");//.show();

        form.steps({
            headerTag: "h3",
            bodyTag: "fieldset",
            transitionEffect: "slideLeft",
            // enableContentCache:false,
            // autoFocus:true,
            // titleTemplate: "<span class='number'>#index#.</span> #title#",

            onInit:function(event, currentIndex) {

                // console.log("onInit",event,currentIndex);                
                initialization();

            },

                       
            onStepChanging: function(event, currentIndex, newIndex) {

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
                if(currentIndex == 1){
                    
                    if($("#order_body").find(".order_id_chk:checked").length == 0){
                        swal("Can't Process", "Atleaset one order must be selected.", "info");
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
            },
            onFinishing: function(event, currentIndex) {

                form.validate().settings.ignore = ":disabled";
                return form.valid();
            },*/
            onFinished: function(event, currentIndex) {
                alert("Submitted!");
                form.submit();
            }
        }).validate({
            debug:true,
            errorPlacement: function errorPlacement(error, element) {
                console.log(element);
                element.before(error);
            },
            highlight: function(element, errorClass) {
                // console.log(element,errorClass)
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
                expected_delivey_datetime: {
                    required: true
                },
                "zip_code_group[]": {
                    required: true
                },
                "vehicles[]": {
                    required: true
                },
                "delivery_boys[]": {
                    required: true
                },
                "drivers[]": {
                    required: true
                },
            }
            
        });
        

        function initialization(){
            
            var $order_body = $("#order_body");
            $config_parent = $("#config_parent");
   
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

            //Get Orders When zip_code_group changes
            $("#zip_code_group").on('change',function(e){
                var $this = $(this);
                var url = $this.data('url');        
                var zip_code_group_ids = $this.val();
                
                $order_body.empty();

                if(zip_code_group_ids.length != 0){
                    $.ajax({
                        "url"   :   url,
                        "method":   "post",
                        "dataType": "json",
                        "data"  :   {
                            "zip_code_group_ids"    :   zip_code_group_ids
                        },
                        "success":  function(data){
                            // console.log(data);
                            var trs = [];
                            
                            if(data){
                                $.each(data,function(i,arr){
                                    
                                    var checked = '';//($.inArray(arr.id,selected_orders) != -1) ? 'checked' : '';
                                    
                                    var str = `<tr>
                                                    <td>
                                                        <div class='checkbox-fade fade-in-primary'>
                                                            <label>
                                                                <input type='checkbox' name='orders[]' class='order_id_chk' value='${arr.id}' ${checked}>
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
                                    // selected_orders = [];
                                });
                                
                                $order_body.append(trs);
                            }
                        }
                    });
                }

            }).trigger('change');

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
                    $element.attr('id',Math.floor(Math.random()*1000) + (new Date).getTime());
                    // setTimeout(()=>{
                    //     // https://jqueryvalidation.org/rules/
                    //     $element.rules("add",{
                    //         required: true
                    //     });
                    //     console.log($element,$element.rules())
                    // },0);

                    $element.select2({
                        allowClear:true,
                        dropdownParent: $element.parent()
                    });
                });
            }
        }
    });
</script>

<script type="text/template" id="config_template">
    <div class="col-sm-12 col-md-4 config_col">
        <div class="well well-sm">
            <div class="remove_config_parent">
                <div class="pull-right">                                        
                    <a class="add_config" title="Add New" href="#">
                        <i class="feather icon-plus"></i>
                    </a>|
                    <a class="remove_config" title="Remove" href="#">
                        <i class="feather icon-x"></i>
                    </a>
                </div>
            </div>
            <div class="form-group">
                <label for="vehicles" class="control-label">Vehicle:</label>
                <select class="form-control select2" name="vehicles[]" data-placeholder="Vehicle">
                    <option value=""></option>
                    <?php
                        foreach($vehicles as $key=>$vehicle){
                            echo "<option value='{$vehicle['id']}'>{$vehicle['name']} ({$vehicle['number']}) Cap:{$vehicle['capacity_in_ton']} Tons</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="delivery_boys" class="control-label">Delivery Boy:</label>
                <select class="form-control select2" name="delivery_boys[]" data-placeholder="Delivery Boy">
                    <option value=""></option>
                    <?php
                        foreach($delivery_boys as $key=>$delivery_boy){
                            echo "<option value='{$delivery_boy['id']}'>{$delivery_boy['first_name']} {$delivery_boy['last_name']}</option>";
                        }
                    ?>
                </select>
            </div> 
            <div class="form-group">
                <label for="drivers" class="control-label">Driver:</label>
                <select class="form-control select2" name="drivers[]" data-placeholder="Choose Driver">
                    <option value=""></option>
                    <?php
                        foreach($drivers as $key=>$driver){
                            echo "<option value='{$driver['id']}'>{$driver['first_name']} {$driver['last_name']}</option>";
                        }
                    ?>
                </select>
            </div>                                
        </div>
    </div>
</script>
@endscript