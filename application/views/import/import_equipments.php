<div class="row">
	<div class="col-sm-6">
		<div class="panel-group">
		  	<div class="panel panel-primary">
			    <div class="panel-heading"><?php echo $page_title; ?> </div>
			    <div class="panel-body">
			    	<form data-action="<?php echo $this->baseUrl; ?>imports/import_equipments" id="eqTypeFrm" method="post" enctype="multipart/form-data">
			    		<div class="form-group">
					    	<label for="dept_name">Import:</label>
					    	<input type="file" name="import_equipment" id="import_equipment" required />
					  	</div>
					  	<button type="submit" class="btn btn-default">Save</button>
					  	<button type="button" class="btn btn-danger" onclick="reset_form();">Reset</button>

					  	<div class="space-4"></div>
					  	<span class="pull-right"><a download href="<?php echo $this->assetsUrl; ?>assets/uploads/samples/equipments.xlsx">Download Sample</a></span>
					</form>
			    </div>
			</div>
		</div>
	</div>
</div>

@script
<script type="text/javascript">
	// to active the sidebar
    $('.nav .nav-list').activeSidebar('.equipment_import_li');

    function reset_form(){
    	$("#import_equipment").val('');
    }
</script>
@endscript