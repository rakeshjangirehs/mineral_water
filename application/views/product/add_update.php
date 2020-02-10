<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <form class="form-horizontal" method="post" action="<?php echo $this->baseUrl; ?>products/add_update/<?php echo $id; ?>" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="product_name">Product Name</label>
                                    <input type="text" name="product_name" id="product_name" class="form-control" value="<?php echo (isset($_POST['product_name'])) ? $_POST['product_name'] : $products['product_name']; ?>" />
                                    <span class="messages"><?php echo form_error('product_name');?></span>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="product_code">Product Code</label>
                                    <input type="text" name="product_code" id="product_code" class="form-control" value="<?php echo (isset($_POST['product_code'])) ? $_POST['product_code'] : $products['product_code']; ?>" />
                                    <span class="messages"><?php echo form_error('product_code');?></span>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="weight">Weight (Kg)</label>
                                    <input type="text" name="weight" id="weight" class="form-control" value="<?php echo (isset($_POST['weight'])) ? $_POST['weight'] : $products['weight']; ?>" />
                                    <span class="messages"><?php echo form_error('weight');?></span>
                                </div>


                                <div class="form-group">
                                    <label class="control-label" for="cost_price">Cost Price</label>
                                    <input type="text" name="cost_price" id="cost_price" class="form-control" value="<?php echo (isset($_POST['cost_price'])) ? $_POST['cost_price'] : $products['cost_price']; ?>" />
                                    <span class="messages"><?php echo form_error('cost_price');?></span>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="sale_price">Sale Price</label>
                                    <input type="text" name="sale_price" id="sale_price" class="form-control" value="<?php echo (isset($_POST['sale_price'])) ? $_POST['sale_price'] : $products['sale_price']; ?>" />
                                    <span class="messages"><?php echo form_error('sale_price');?></span>
                                </div>
                                <div class="form-group" style="display:none;">
                                    <div class='checkbox-fade fade-in-primary'>
                                        <label>
                                            <input type='checkbox' name='manage_stock_needed' class='' value='1' <?php echo (isset($_POST['manage_stock_needed']) && $_POST['manage_stock_needed']==1) ? 'checked' : ( ($products['manage_stock_needed']==1) ? 'checked' : '' ); ?>>
                                            <span class='cr'>
                                                <i class='cr-icon icofont icofont-ui-check txt-primary'></i>
                                            </span> Manage Stock?
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-md-6">

                                <div class="form-group">
                                    <label class="control-label" for="dimension">Brand</label>
                                    <select class="form-control select2" name="brand_id" id="brand_id" data-placeholder="Choose Brand">
                                        <option value=""></option>
                                        <?php
                                            foreach($brands as $brand){
                                                $check = (isset($_POST['brand_id']))? set_value('brand_id') : $products['brand_id'];
                                                $selected = ($brand['id'] == $check) ? 'selected' : '';
                                                echo "<option value='{$brand['id']}' {$selected}>{$brand['brand_name']}</option>";
                                            }
                                        ?>
                                    </select>
                                    <span class="messages"><?php echo form_error('brand_id');?></span>
                                </div>
                                <div class="form-group" style="display:none;">
                                    <label class="control-label" for="dimension">Dimension</label>
                                    <input type="text" name="dimension" id="dimension" class="form-control" value="<?php echo (isset($_POST['dimension'])) ? $_POST['dimension'] : $products['dimension']; ?>" />
                                    <span class="messages"><?php echo form_error('dimension');?></span>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="product_image">Product Image</label>
                                    <input type="file" class="form-control" id="id-input-file-2" name="product_image" />
                                    <span class="messages"><?php echo form_error('product_image');?></span>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="description">Description</label>
                                    <textarea class="form-control" cols="50" rows="5" name="description"><?php echo (isset($_POST['description'])) ? $_POST['description'] : $products['description']; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <div class="thumbnail">
                                        <div class="thumb">
                                            <a href="<?php echo $products['image_url'];?>" data-lightbox="5" data-title="My caption 5">
                                                <img src="<?php echo $products['image_url'];?>" alt="" class="img-fluid img-thumbnail">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-right">
                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                            <a class="btn btn-sm btn-default" href="<?php echo $this->baseUrl; ?>products/">Cancel</a>
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
    $('.add_product_li').active();
    $('#id-input-file-1 , #id-input-file-2').ace_file_input({
		no_file:'No File ...',
		btn_choose:'Choose',
		btn_change:'Change',
		droppable:false,
		onchange:null,
		thumbnail:false //| true | large
		// whitelist:'gif|png|jpg|jpeg'
		//blacklist:'exe|php'
		//onchange:''
		//
	});

</script>
@endscript