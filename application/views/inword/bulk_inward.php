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
    .form-group{
        margin-bottom: 0px!important;
    }

    .table td{
        vertical-align: inherit;
    }
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <form data-action="<?php echo $this->baseUrl; ?>inwordcontroller/bulk_inword" id="tagFrm" method="post" autocomplete="off">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-header-right" style="padding:0px 0px;">
                                    <ul class="list-unstyled card-option">
                                        <li title="Add New Row"><a id="add_row"><i class="feather icon-plus"></i></a></li>
                                        <li><i class="feather icon-maximize full-card"></i></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-block">
                                <div class="row m-b-30">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="warehouse_id" class="control-label">Warehouse:</label>
                                            <select class="form-control select2" name="warehouse_id" id="warehouse_id" data-placeholder="Choose Warehouse">
                                                <option value=""></option>
                                                <?php
                                                    foreach($warehouses as $warehouse){
                                                        echo "<option value='{$warehouse['id']}'>{$warehouse['name']}</option>";
                                                    }
                                                ?>
                                            </select>     
                                            <span class="messages"><?php echo form_error('warehouse_id');?></span>                               
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="date" class="control-label">Date:</label>
                                            <input type="text" name="date" id="date" class="form-control" value=""/>
                                            <span class="messages"><?php echo form_error('date');?></span>                        
                                        </div>
                                    </div>
                                </div>
                                <div class="dt-responsive table-responsive">
                                    <table id="dynamic-table" class="table table-striped table-bordered table-hover" style="width:100%;">
                                        <thead>
                                        <tr>
                                            <th style="width:60%;">Product</th>
                                            <th style="width:20%;">Quantity</th>
                                            <th style="width:20%;">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="table_body"></tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                    <a class="btn btn-sm btn-default" href="<?php echo $this->baseUrl; ?>inwordcontroller/">Cancel</a>
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

    $(function(){

        var $table_body = $("#table_body");
        var config_template = $("#config_template").html();
        var index = $table_body.children().length;

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
            debug:true,
            rules   : 	{
                            "date"		:	{
                                required:true,
                            },
                            "warehouse_id"		:	{
                                required:true
                            },
                        },
            errorElement: "p",
            errorClass:"text-danger error",
            errorPlacement: function ( error, element ) {
                
                if(element.hasClass("product_id") || element.hasClass("quantity")){
                    element.closest("td").append(error);
                }else{
                    element.closest(".form-group").append(error);
                }
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

        $("#add_row").click(function(e){
            e.preventDefault();
            appendRow();
        });

        $table_body.on('click','.remove_row',function(e){
            e.preventDefault();

            var $this = $(this);
            if($table_body.children().length > 1){
                $this.closest('tr').remove();
            }else{
                swal("Can't Remove", "Atlease one product must be present.", "warning");
            }
        });

        function appendRow(){
            
            $table_body.append(config_template);
            $table_body.children().last().each(function(i,element){
                
                var $element = $(element);
                var product_id  = $element.find('.product_id');
                var quantity = $element.find('.quantity');

                product_id.attr('name',"products["+index+"][product_id]");
                product_id.attr('id',Math.floor(Math.random()*1000) + (new Date).getTime());
                product_id.rules("add",{required: true});
                product_id.select2({
                    allowClear:true,
                    dropdownParent: $element.parent()
                });

                quantity.attr('name',"products["+index+"][quantity]");
                quantity.attr('id',Math.floor(Math.random()*1000) + (new Date).getTime());
                quantity.rules("add",{required: true});

                index++;

                // if($element.hasClass("vehicles") || $element.hasClass("drivers")){
                //     setTimeout(()=>{
                //         // https://jqueryvalidation.org/rules/
                //         $element.rules("add",{
                //             required: true
                //         });
                //         // console.log($element,$element.rules())
                //     },0);
                // }

                

            });
        }
        
        if($table_body.children().length == 0){
            appendRow();
        }
    });
</script>

<script type="text/template" id="config_template">
    <tr>
        <td>
            <div class="form-group">
                <select class="form-control select2 product_id" name="product_id[]" data-placeholder="Choose Product">
                    <option value=""></option>
                    <?php
                        foreach($products as $product){
                            echo "<option value='{$product['id']}'>{$product['product_name']}</option>";
                        }
                    ?>
                </select>
            </div>
        </td>
        <td>
            <input type="text" name="quantity[]" class="form-control quantity" value=""/>
        </td>
        <td>
            <a class='text-danger remove_row' href='#' title='Remove this row.'><i class='feather icon-trash-2'></i></a>
        </td>
    </tr>
</script>
@endscript