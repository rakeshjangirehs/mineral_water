<div class="row">
	<div class="col-sm-6">
		<div class="panel-group">
		  	<div class="panel panel-primary">
			    <div class="panel-heading">Department </div>
			    <div class="panel-body">
			    	<?php if(validation_errors()) : ?>
			    	<div class="alert alert-block alert-danger">
						<button type="button" class="close" data-dismiss="alert">
							<i class="ace-icon fa fa-times"></i>
						</button>
						<?php echo validation_errors(); ?>				
					</div>
					<?php endif; ?>
			    	<form data-action="<?php echo $this->baseUrl; ?>equipment_tags/add_update/<?php echo $id; ?>" id="tagFrm" method="post" data-generateQr="<?php echo $this->baseUrl; ?>equipment_tags/generate_qr">
			    		<div class="form-group">
					    	<label for="equipment_id">Equipment:</label>
					    	<?php 
					    		$optionEq = array(""=>"");
					    		if(!empty($equipments)):
					    			foreach($equipments as $equipment):
					    				$optionEq[$equipment['id']] = $equipment['name'];
				    				endforeach;
				    			endif;
				    			echo form_dropdown('equipment_id', $optionEq, (isset($_POST['equipment_id'])) ? set_value('equipment_id') : $equipment_tags['equipment_id'], 'id="equipment_id" class="form-control" data-placeholder="Choose equipment..."');
					    	?>
					  	</div>
					  	<div class="form-group">
					    	<label for="plant_id">Plant:</label>
					    	<?php 
					    		$optionPlant = array(""=>"");
					    		if(!empty($plants)):
					    			foreach($plants as $plant):
					    				$optionPlant[$plant['id']] = $plant['name'];
				    				endforeach;
				    			endif;
				    			echo form_dropdown('plant_id', $optionPlant, (isset($_POST['plant_id'])) ? set_value('plant_id') : $equipment_tags['plant_id'], 'id="plant_id" class="form-control" data-placeholder="Choose plant..."');
					    	?>
					  	</div>
					  	<div class="form-group">
					    	<label for="tag_no">Tag No:</label>
					    	<?php echo form_input($tag_no); ?>
					  	</div>
					  	<div class="form-group">
					    	<label for="description">Use Of Equipment:</label>
					    	<?php echo form_textarea($equipment_use); ?>
					  	</div>
					  	<button type="submit" class="btn btn-default">Save</button>
					  	<a class="btn btn-danger" href="<?php echo $this->baseUrl; ?>equipment_tags/">Cancel</a>
					</form>
			    </div>
			</div>
		</div>
	</div>
</div>

@script
<script type="text/javascript">
	// to active the sidebar
    $('.nav .nav-list').activeSidebar('.equipment_tag_li');
    var tagNo = $("#tag_no");
    var equipment = $("#equipment_id");
    var plant = $("#plant_id");
    var tagFrm = $("#tagFrm");
    var description = $("#description");

    /*$(tagNo).add($(equipment)).add($(plant).add(description)).on('change', function(){
    	__generate();
    });*/

    /*function __generate(){
    	var equipmentVal = $.trim($("option:selected", equipment).text());
    	var plantVal = $.trim($("option:selected", plant).text());
    	var tagNoVal = tagNo.val();
    	if( equipmentVal != '' && plantVal != '' && tagNoVal != '' ){
			$.ajax({
				url: "<?php echo $this->baseUrl; ?>equipment_tags/generate_tag_qr",
				type: 'post',
				data: {"equipment": equipmentVal, "plant": plantVal, "tag_no": tagNoVal, "equipment_use": description.val()},
				success: function(result){
					var image = new Image();
					image.src = 'data:image/png;base64,'+result;
					image.width = '250';
					$("#qr_image").html(image);
				}
			});
    	}else{
    		return false;
    	}
    }*/
</script>
@endscript