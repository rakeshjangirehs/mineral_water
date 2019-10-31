<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <form action="<?php echo $this->baseUrl; ?>clients/update_price/<?php echo $id; ?>" id="tagFrm" method="post" autocomplete="off">
                <div class="card">
                    <div class="card-header">
                        &nbsp;
                        <div class="card-header-right" style="padding:0px 0px;">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-maximize full-card"></i></li>
                                <li title="Export Excel"><a href="<?php echo $this->baseUrl."clients/client_price_export/".$id; ?>"><i class="fa fa-file-excel-o"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="dt-responsive table-responsive">
                            <table id="dynamic-table" class="table table-striped table-bordered table-hover" style="width:100%;">
                                <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Cost Price</th>
                                    <th>Sale Price</th>
                                    <th>Client Price</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($product_list as $k=>$product){
                                        echo "<tr>
                                            <td>{$product['product_name']}</td>
                                            <td>{$product['cost_price']}</td>
                                            <td>{$product['sale_price']}</td>
                                            <td data-order='{$product['client_price']}'>
                                                <input type='hidden' name='product[{$k}][id]' value='{$product['client_product_price_id']}'/>
                                                <input type='hidden' name='product[{$k}][old_price]' value='{$product['client_price']}'/>
                                                <input type='text' class='form-control' style='width:50%;' name='product[{$k}][sale_price]' value='{$product['client_price']}'/></td>
                                        </tr>";
                                    }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-right">
                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                            <a class="btn btn-sm btn-default" href="<?php echo $this->baseUrl; ?>clients/">Cancel</a>
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
    // $('.nav .nav-list').activeSidebar('.cilent_list_li');
    $(".cilent_list_li").active();
	var table = $("#dynamic-table");
	var oTable = table.DataTable();
</script>
@endscript