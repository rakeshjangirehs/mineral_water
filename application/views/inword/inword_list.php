<div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-right" style="padding:0px 0px;">
                                <ul class="list-unstyled card-option">
                                    <li><i class="feather icon-maximize full-card"></i></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>inwordcontroller/index" style="width:100%;" data-order="[[2,&quot;desc&quot;]]">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Warehouse</th>
                                        <th>Product</th>
                                        <th>Type</th>
                                        <th>Quantity</th>
                                        <th>User Name</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <form action="<?php echo $this->baseUrl; ?>inwordcontroller/index/<?php echo $zipcode_group_id; ?>" id="tagFrm" method="post" autocomplete="off">
                        <div class="card">
                            <div class="card-header">
                                <h5><?php echo $form_title; ?> <a href="<?php echo $this->baseUrl; ?>inwordcontroller/bulk_inword/" class="btn btn-primary btn-sm" style="position: absolute;top: 18px;right: 22px;">Bulk Inward</a></h5>
                            </div>
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-sm-12 ">
                                        <div class="form-group">
                                            <label for="date" class="control-label">Date:</label>
                                            <input type="text" name="date" id="date" class="form-control" value="<?php echo (isset($_POST['date']))? set_value('date') : $group_details['date']; ?>"  />
                                            <span class="messages"><?php echo form_error('date');?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="warehouse_id" class="control-label">Warehouse:</label>
                                            <select class="form-control select2" name="warehouse_id" id="warehouse_id" data-placeholder="Choose Warehouse">
                                                <option value=""></option>
                                                <?php
                                                    foreach($warehouses as $warehouse){
                                                        $check = (isset($_POST['warehouse_id']))? set_value('warehouse_id') : $group_details['warehouse_id'];
                                                        $selected = ($warehouse['id'] == $check) ? 'selected' : '';
                                                        echo "<option value='{$warehouse['id']}' {$selected}>{$warehouse['name']}</option>";
                                                    }
                                                ?>
                                            </select>     
                                            <span class="messages"><?php echo form_error('warehouse_id');?></span>                               
                                        </div>
                                        <div class="form-group">
                                            <label for="product_id" class="control-label">Product:</label>
                                            <select class="form-control select2" name="product_id" id="product_id" data-placeholder="Choose Product">
                                                <option value=""></option>
                                                <?php
                                                    foreach($products as $product){
                                                        $check = (isset($_POST['product_id']))? set_value('product_id') : $group_details['product_id'];
                                                        $selected = ($product['id'] == $check) ? 'selected' : '';
                                                        echo "<option value='{$product['id']}' {$selected}>{$product['product_name']}</option>";
                                                    }
                                                ?>
                                            </select>     
                                            <span class="messages"><?php echo form_error('product_id');?></span>                               
                                        </div>
                                        <div class="form-group">
                                            <label for="type" class="control-label">Type:</label>
                                            <select class="form-control select2" name="type" id="type" data-placeholder="Type">
                                                <option value=""></option>
                                                <?php
                                                    foreach(["Inward","Outward"] as $val){
                                                        $check = (isset($_POST['type']))? set_value('type') : $group_details['type'];
                                                        $selected = ($val == $check) ? 'selected' : '';
                                                        echo "<option value='{$val}' {$selected}>{$val}</option>";
                                                    }
                                                ?>
                                            </select>
                                            <span class="messages"><?php echo form_error('type');?></span>                      
                                        </div>  
                                        <div class="form-group">
                                            <label for="quantity" class="control-label">Quantity:</label>
                                            <input type="text" name="quantity" id="quantity" class="form-control" value="<?php echo (isset($_POST['quantity']))? set_value('quantity') : $group_details['quantity']; ?>"  />
                                            <span class="messages"><?php echo form_error('quantity');?></span>
                                        </div>                                      
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <button type="submit" class="btn btn-sm btn-primary"><?php echo ($zipcode_group_id) ? "Update" : "Add";?></button>
                                    <a class="btn btn-sm btn-default" href="<?php echo $this->baseUrl.'inwordcontroller/index'; ?>">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script type="text/javascript">
    // to active the sidebar
    // $('.nav .nav-list').activeSidebar('.zipcodegroup_li');
    $(".inword_li").active();

    var zipcodegroup_id = <?php echo ($zipcode_group_id) ? $zipcode_group_id : "null";?>;
    var table = $("#dynamic-table");

    $("#date").datepicker({
        format		:	"yyyy-mm-dd",
        autoclose	:	true,
        todayBtn	:	"linked",
        // clearBtn	:	true,
        // endDate		: 	moment().format("YYYY-MM-DD"),
        // maxViewMode : 	2
        //orientation: "bottom left"
    });


    var validator = $("#tagFrm").validate({
        rules   : 	{
                        "date"		:	{
                            required:true,
                        },
                        "product_id"		:	{
                            required:true
                        },
                        "type"		:	{
                            required:true
                        },
                        "quantity"		:	{
                            required:true
                        },
                    },
        errorElement: "p",
        errorClass:"text-danger error",
        errorPlacement: function ( error, element ) {
            $(element).closest(".form-group").append(error);
        },
    });

    var oTable = table
        .DataTable({
            "processing": true,
            "serverSide": true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "ajax":{
                "url": table.data('url'),
                "dataType": "json",
                "type": "POST",
            },
            "columns": [
                { "data": "date" },
                { "data": "warehouse_name" },
                { "data": "product_name" },
                { "data": "type" },
                { "data": "quantity" },
                { "data": "acted_by" },
                {
                    "data": 'link',
                    "orderable" : false,
                    "render": function ( data, type, row, meta ) {
                        return "<a class='' href='<?php echo $this->baseUrl; ?>inwordcontroller/index/"+data.id+"' title='Edit Entry'><i class='feather icon-edit'></i></a>";
                    }
                }
            ],
            "createdRow": function ( row, data, index ) {
                if(zipcodegroup_id == data.id){
                    $(row).addClass('active_row');
                }
            }
        });
</script>
@endscript