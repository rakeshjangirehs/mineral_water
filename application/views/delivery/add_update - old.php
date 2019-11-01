<style>
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
</style>
<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <form data-action="<?php echo $this->baseUrl; ?>delivery/add_update/<?php echo $delivery_id; ?>" id="tagFrm" method="post">
                <div class="card">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label for="expected_delivey_datetime" class="control-label">Expected Delivery Date:</label>
                                    <input type="text" name="expected_delivey_datetime" id="expected_delivey_datetime" class="form-control" value="<?php echo (isset($_POST['expected_delivey_datetime']))? set_value('expected_delivey_datetime') : $delivery_data['expected_delivey_datetime']; ?>" required/>
                                    <span class="messages"><?php echo form_error('expected_delivey_datetime');?></span>
                                </div>                                
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label for="zip_code_group" class="control-label">ZIP Code Groups:</label>
                                    
                                    <select class="form-control select2 multiple" name="zip_code_group[]" id="zip_code_group" data-placeholder="Choose ZIP Code Groups" data-url="<?php echo $this->baseUrl; ?>orders/get_orders_by_zip_code_group" multiple required>
                                        <option value=""></option>
                                        <?php                                            
                                            if(!empty($zip_code_groups)){
                                                foreach($zip_code_groups as $key=>$zip_code_group){
                                                    $check = (isset($is_post)) ? $_POST['zip_code_group'] : $delivery_routes;
                                                    $selected = (in_array($key,$check)) ? 'selected' : '';
                                                    echo "<option value='{$key}' {$selected}>{$zip_code_group}</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                    <span class="messages"><?php echo form_error('zip_code_group[]');?></span>
                                </div>
                            </div>
                        </div>
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
                        <div class="row" id="config_parent">
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
                                        <select class="form-control select2" name="vehicles[]" id="drivers" data-placeholder="Vehicle" required>
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
                                        <select class="form-control select2" name="delivery_boys[]" id="drivers" data-placeholder="Delivery Boy" required>
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
                                        <select class="form-control select2" name="drivers[]" id="drivers" data-placeholder="Choose Driver" required>
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
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-right">                                            
                            <button type="submit" class="btn btn-sm btn-primary"><?php echo ($delivery_id) ? "Update" : "Create";?></button>
                            <a class="btn btn-sm btn-default" href="<?php echo $this->baseUrl; ?>delivery">Cancel</a>
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
        $(".add_update_delivery_li").active();
        $("#expected_delivey_datetime").datepicker({
            format		:	"yyyy-mm-dd",
            autoclose	:	true,
            todayBtn	:	"linked",
            // clearBtn	:	true,
            // endDate		: 	moment().format("YYYY-MM-DD"),
            // maxViewMode : 	2
            //orientation: "bottom left"
        })


        $order_body = $("#order_body");
        $config_parent = $("#config_parent");
        config_template = $("#config_template").html();
        
        //To track already selected order, eg. when form validation fails.
        var selected_orders = JSON.parse('<?php echo (isset($is_post))  ? ( (isset($_POST['orders'])) ? json_encode($_POST['orders']) : json_encode([]) ) : json_encode([]);?>');

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
                                
                                var checked = ($.inArray(arr.id,selected_orders) != -1) ? 'checked' : '';
                                
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
                                selected_orders = [];
                            });
                            $order_body.append(trs);
                        }
                    }
                });
            }

        }).trigger('change');

        $config_parent.on('click','.add_config',function(e){
            e.preventDefault();
            $config_parent.append(config_template);
            $config_parent.children().last().find('.select2').select2({allowClear:true});
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
                <select class="form-control select2" name="vehicles[]" id="drivers" data-placeholder="Vehicle" required>
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
                <select class="form-control select2" name="delivery_boys[]" id="drivers" data-placeholder="Delivery Boy" required>
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
                <select class="form-control select2" name="drivers[]" id="drivers" data-placeholder="Choose Driver" required>
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