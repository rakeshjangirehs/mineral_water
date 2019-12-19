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
                                    <li title="Export Excel"><a href="<?php echo $this->baseUrl; ?>zipcodes/zip_export"><i class="fa fa-file-excel-o"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>zipcodes/index" style="width:100%;">
                                    <thead>
                                    <tr>
                                        <th>Zipcode</th>
                                        <th>Area</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Groups</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
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
                    <form data-action="<?php echo $this->baseUrl; ?>zipcodes/save" id="deptFrm" method="post">
                        <div class="card">
                            <div class="card-header">
                                <h5 id="form_title">Add ZIP Code</h5>
                            </div>
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="zipcode" class="control-label">Zip Code:</label>
                                            <input type="text" name="zipcode" id="zipcode" class="form-control"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="area" class="control-label">Area:</label>
                                            <input type="text" name="area" id="area" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="zip_code_group" class="control-label">ZIP Code Groups:</label>
                                            <select class="form-control select2 multiple" name="zip_code_group[]" id="zip_code_group" data-placeholder="Choose ZIP Code Groups" multiple>
                                                <option value=""></option>
                                                <?php
                                                if(!empty($zip_code_groups)):
                                                    foreach($zip_code_groups as $key=>$zip_code_group):
                                                        ?>
                                                        <option value="<?php echo $key; ?>"><?php echo $zip_code_group; ?></option>
                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                            <span class="messages"><?php echo form_error('zip_code_group[]');?></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="state_id" class="control-label">State:</label>
                                            <select class="form-control select2" name="state_id" id="state_id" data-placeholder="Choose State">
                                                <option value=""></option>
                                                <?php
                                                    foreach($states as $state){
                                                        echo "<option value='{$state['id']}'>{$state['name']}</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="city_id" class="control-label">City:</label>
                                            <select class="form-control select2" name="city_id" id="city_id" data-placeholder="Choose City">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <input type="hidden" name="zipcode_id" id="zip_id"/>
                                    <button type="submit" class="btn btn-sm btn-primary" id="submit_button">Add</button>
                                    <button type="button" class="btn btn-sm btn-default" onclick="reset_form();">Reset</button>
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
    $(".zipcode_li").active();

    var $submit_button = $("#submit_button");
    var $form_title = $("#form_title");
	var deptFrm = $("#deptFrm");
	var table = $("#dynamic-table");
	var zipcode = $("#zipcode");
	var zip_id = $("#zip_id");

    var $state_id = $("#state_id");
    var $city_id = $("#city_id");
    var $area = $("#area");
    var temp_city_id = '';

    // for integer validation
    zipcode.forceInt();

    var zip_code_id = "";
    
    var validator = deptFrm.validate({
        rules		: 	{
                            "zipcode"		:	{
                                required:true,
                                digits:true,
                                minlength:6,
                                maxlength:6,
                                remote:	function(){
                                    return "<?php echo $this->baseUrl.'zipcodes/check_unique_ajax'; ?>"+"?table=zip_codes&fieldsToCompare=zip_code&fieldName=zipcode&id="+zip_code_id
                                }
                            },
                            "area"		:	{
                                required:true,
                                maxlength: 300
                            },
                            "state_id"		:	{
                                required:true,
                                digits:true
                            },
                            "zip_code_group[]"		:	{
                                required:true,
                            },
                            "city_id"		:	{
                                required:true,
                                digits:true
                            },
                        },
        messages	:	{
                zipcode		:	{
                        remote			:	"ZipCode already Exists"
                    },
        },

        errorElement: "p",
        errorClass:"text-danger error",
        errorPlacement: function ( error, element ) {
            $(element).closest(".form-group").append(error);
        },
        submitHandler: function(form) {
            
            var $form = $(form);
            var data = $form.serialize();
            $.ajax({
                url: $form.data('action'),
                method: 'post',
                dataType: 'json',
                data: data,
                success: function(data){
                    reset_form();
                    window.location.reload();
                }
            });
        }
    });

	var oTable = table
		.DataTable({
			"processing": true,
			"serverSide": true,
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			"ajax":{
                "url": table.data('url'),
                "dataType": "json",
                'cache': false,
                "type": "POST",
            },
            "columns": [
                { "data": "zip_code" },
                { "data": "area" },
                { "data": "city_name" },
                { "data": "state_name" },
                { "data": "zip_code_groups" },
                {
                	"data": null,
                	"sortable": false,
                	"render": function ( data, type, row, meta ) {
				      return "<a class='green zip_edit' href='#' data-id='"+data.id+"' data-name='"+data.zip_code+"' data-state_id='"+data.state_id+"' data-city_id='"+data.city_id+"' data-area='"+data.area+"' data-zip_code_group_ids='"+data.zip_code_group_ids+"' title='Edit ZIP Code'><i class='feather icon-edit'></i></a>";
				    }
            	}
            ],
		})
		.on('click', '.zip_edit',function(e){

            e.preventDefault();
            
			var $this = $(this);
			reset_form();

            zip_code_id = $this.data('id');
			$form_title.text("Update ZIP Code");
            $submit_button.text("Update");
            $parent_tr = $(this).closest('tr').addClass('active_row');

			zipcode.val($this.data('name'));
			zip_id.val($this.data('id'));
            $area.val($this.data('area'));

            var zIds = ""+$this.data('zip_code_group_ids');
            if(zIds){
                // console.log(zIds.split(","));
                $("#zip_code_group").val(zIds.split(",")).change();
            }else{
                $("#zip_code_group").val([]).change();
            }

            var state_id = $this.data('state_id') || '';
            temp_city_id = $this.data('city_id') || '';
            // console.log('temp_city_id : ',temp_city_id);
            $state_id.val(state_id).trigger('change');

		});

	function reset_form(){
        $("#zip_code_group").val([]).change();
        zip_code_id = "";
        validator.resetForm();
		deptFrm.trigger("reset");
		zip_id.val("");
        $form_title.text("Add ZIP Code");
        $submit_button.text("Add");
        temp_city_id = '';
        
        table.find('tbody').find('tr').removeClass('active_row');
        $city_id.children().not(':first').remove();
        $state_id.val(null).trigger('change');
	}
    
    $state_id.on('change',function(e){
        var state_id = this.value;

        $city_id.children().not(':first').remove();

        if(state_id){
            fetch("<?php echo $this->baseUrl;?>zipcodes/get_cities",{
                headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/x-www-form-urlencoded'
                },
                method: "POST",
                body: "state_id="+state_id
            })
            .then(response=>{
                return response.json();
            })
            .then(data=>{
                var str = "";
                // console.log(data);
                $.each(data,function(i,v){
                    let selected = (temp_city_id == v.id) ? 'selected' : '';
                    // console.log('temp_city_id : ',temp_city_id);
                    str += "<option value='"+v.id+"' "+selected+">"+v.name+"</option>";
                })
                $city_id.append(str);
            })
            .catch(err=>{
                console.log(err);
            });
        }
    });

</script>
@endscript