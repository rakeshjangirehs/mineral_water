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
                                    <input type="text" name="expected_delivey_datetime" id="expected_delivey_datetime" class="form-control" value="<?php echo (isset($_POST['expected_delivey_datetime']))? set_value('expected_delivey_datetime') : $delivery_data['expected_delivey_datetime']; ?>"/>
                                    <span class="messages"><?php echo form_error('expected_delivey_datetime');?></span>
                                </div>                                
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label for="zip_code_group" class="control-label">ZIP Code Groups:</label>
                                    
                                    <select class="form-control select2 multiple" name="zip_code_group[]" id="zip_code_group" data-placeholder="Choose ZIP Code Groups" data-url="<?php echo $this->baseUrl; ?>orders/get_orders_by_zip_code_group" multiple>
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
                        <div class="row">
                            <div class="col-sm-12">
                            <div class="dt-responsive table-responsive">
                                <table id="dynamic-table" class="table table-striped table-bordered table-hover" style="width:100%;">
                                    <thead>
                                        <tr>                                            
                                            <th>Vehicle</th>
                                            <th>Driver</th>
                                            <th>Delivery Boy</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="config_body"></tbody>
                                </table>
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
	// to active the sidebar
    // $('.nav .nav-list').activeSidebar('.add_user_li');
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
                                                        <input type='checkbox' name='orders[]' value='${arr.id}' ${checked}>
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
</script>
@endscript