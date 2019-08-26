<div class="row">
	<div class="col-sm-12">
		<form class="form-horizontal" method="post" action="<?php echo $this->baseUrl; ?>products/add_update" enctype="multipart/form-data">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
				    	<label class="col-md-3 control-label" for="product_name">Product Name</label>
				    	<div class="col-md-9">
				    		<input type="text" name="product_name" id="product_name" class="form-control" value="<?php echo (isset($_POST['product_name'])) ? $_POST['product_name'] : $products['product_name']; ?>" />
				    		<?php echo form_error('product_name'); ?>
				    	</div>
				  	</div>

				  	<div class="form-group">
				    	<label class="col-md-3 control-label" for="product_code">Product Code</label>
				    	<div class="col-md-9">
				    		<input type="text" name="product_code" id="product_code" class="form-control" value="<?php echo (isset($_POST['product_code'])) ? $_POST['product_code'] : $products['product_code']; ?>" />
				    		<?php echo form_error('product_code'); ?>
				    	</div>
				  	</div>

				  	<div class="form-group">
				    	<label class="col-md-3 control-label" for="weight">Weight</label>
				    	<div class="col-md-9">
				    		<input type="text" name="weight" id="weight" class="form-control" value="<?php echo (isset($_POST['weight'])) ? $_POST['weight'] : $products['weight']; ?>" />
				    		<?php echo form_error('weight'); ?>
				    	</div>
				  	</div>

				  	<div class="form-group">
				    	<label class="col-md-3 control-label" for="dimension">Dimension</label>
				    	<div class="col-md-9">
				    		<input type="text" name="dimension" id="dimension" class="form-control" value="<?php echo (isset($_POST['dimension'])) ? $_POST['dimension'] : $products['dimension']; ?>" />
				    		<?php echo form_error('dimension'); ?>
				    	</div>
				  	</div>

				  	<div class="form-group">
				    	<label class="col-md-3 control-label" for="cost_price">Cost Price</label>
				    	<div class="col-md-9">
				    		<input type="text" name="cost_price" id="cost_price" class="form-control" value="<?php echo (isset($_POST['cost_price'])) ? $_POST['cost_price'] : $products['cost_price']; ?>" />
				    		<?php echo form_error('cost_price'); ?>
				    	</div>
				  	</div>

				  	<div class="form-group">
				    	<label class="col-md-3 control-label" for="sale_price">Sale Price</label>
				    	<div class="col-md-9">
				    		<input type="text" name="sale_price" id="sale_price" class="form-control" value="<?php echo (isset($_POST['sale_price'])) ? $_POST['sale_price'] : $products['sale_price']; ?>" />
				    		<?php echo form_error('sale_price'); ?>
				    	</div>
				  	</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
				    	<label class="col-md-3 control-label" for="product_image">Product Image</label>
				    	<div class="col-md-9">
				    		<input type="file" id="id-input-file-2" name="product_image" />
				    	</div>
				  	</div>

				  	<div class="form-group">
				  		<label class="col-md-3 control-label" for="description">Description</label>
				  		<div class="col-md-9">
				    		<textarea class="form-control" cols="50" rows="5" name="description"><?php echo (isset($_POST['description'])) ? $_POST['description'] : $products['description']; ?></textarea>
				    	</div>
				  	</div>
				</div>
			</div>
			<input type="submit" value="Submit" />
		</form>
	</div>
</div>

@script
<script type="text/javascript">
	// to active the sidebar
    $('.nav .nav-list').activeSidebar('.product_li');
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