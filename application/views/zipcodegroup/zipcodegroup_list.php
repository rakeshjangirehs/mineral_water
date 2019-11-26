<div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>zipcodegroups/index" style="width:100%;">
                                    <thead>
                                    <tr>
                                        <th>ZIP Code Group</th>
                                        <th>ZIP Codes</th>
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
                    <form action="<?php echo $this->baseUrl; ?>zipcodegroups/index/<?php echo $zipcode_group_id; ?>" id="tagFrm" method="post">
                        <div class="card">
                            <div class="card-header">
                                <h5><?php echo $form_title; ?></h5>
                            </div>
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-sm-12 ">
                                        <div class="form-group">
                                            <label for="group_name" class="control-label">Group Name:</label>
                                            <input type="text" name="group_name" id="group_name" class="form-control" value="<?php echo (isset($_POST['group_name']))? set_value('group_name') : $group_details['group_name']; ?>"  />
                                            <span class="messages"><?php echo form_error('group_name');?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="state_id" class="control-label">State:
                                                <span class="messages"><?php echo form_error('state_id');?></span>
                                            </label>
                                            <select class="form-control select2" name="state_id" id="state_id" data-placeholder="Choose State">
                                                <option value=""></option>
                                                <?php
                                                    foreach($states as $state){
                                                        $check = (isset($_POST['state_id']))? set_value('state_id') : $group_details['state_id'];
                                                        $selected = ($state['id'] == $check) ? 'selected' : '';
                                                        echo "<option value='{$state['id']}' {$selected}>{$state['name']}</option>";
                                                    }
                                                ?>
                                            </select>                                    
                                        </div>
                                        <div class="form-group">
                                            <label for="city_id" class="control-label">City:
                                                <span class="messages"><?php echo form_error('city_id');?></span>
                                            </label>
                                            <select class="form-control select2" name="city_id" id="city_id" data-placeholder="Choose City">
                                                <option value=""></option>
                                                <?php
                                                    foreach($cities as $city){
                                                        $check = (isset($_POST['city_id']))? set_value('city_id') : $group_details['city_id'];
                                                        $selected = ($city['id'] == $check) ? 'selected' : '';
                                                        echo "<option value='{$city['id']}' {$selected}>{$city['name']}</option>";
                                                    }
                                                ?>
                                            </select>                                    
                                        </div>
                                        <div class="form-group">
                                            <label for="zip_code" class="control-label">Zip Codes:</label>                                            
                                            <select class="form-control select2 multiple" name="zip_code[]" id="zip_code" multiple="multiple" data-placeholder="Choose ZIP Codes">
                                                <option value=""></option>
                                                <?php
                                                if(!empty($all_zipcodes)):
                                                    foreach($all_zipcodes as $zip_codes_id=>$zip_code):
                                                        $selected = (in_array($zip_codes_id,$group_zip_codes)) ? 'selected' : '';
                                                        ?>
                                                        <option value="<?php echo $zip_codes_id; ?>" <?php echo $selected; ?>><?php echo $zip_code; ?></option>
                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                            <span class="messages"><?php echo form_error('zip_code[]');?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <button type="submit" class="btn btn-sm btn-primary"><?php echo ($zipcode_group_id) ? "Update" : "Add";?></button>
                                    <a class="btn btn-sm btn-default" href="<?php echo $this->baseUrl.'zipcodegroups/index'; ?>">Cancel</a>
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
    $(".zipcodegroup_li").active();

    var zipcodegroup_id = <?php echo ($zipcode_group_id) ? $zipcode_group_id : "null";?>;
    var table = $("#dynamic-table");
    
    var $state_id = $("#state_id");
    var $city_id = $("#city_id");
    var $zip_code = $("#zip_code");

    var validator = $("#tagFrm").validate({
        rules   : 	{
                        "group_name"		:	{
                            required:true,
                            maxlength: 200
                        },
                        "zip_code[]"		:	{
                            required:true
                        },
                    },
        errorElement: "p",
        errorClass:"text-danger error",
        errorPlacement: function ( error, element ) {
            $(element).closest(".form-group").append(error);
        },
    });

    $state_id.on('change',function(e){
        var state_id = this.value;
        get_zipcodes(state_id);

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
                console.log(data);
                $.each(data,function(i,v){
                    str += "<option value='"+v.id+"'>"+v.name+"</option>";
                })
                $city_id.append(str);
            })
            .catch(err=>{
                console.log(err);
            });
        }

    });

    $city_id.on('change',function(e){
        var state_id = $state_id.val();
        var city_id = this.value;
        get_zipcodes(state_id,city_id);
    });

    function get_zipcodes(state_id,city_id){

        var formData = new FormData();

        if(state_id){
            formData.append('state_id', state_id);
        }

        if(city_id){
            formData.append('city_id', city_id);
        }

        $zip_code.children().not(':first').remove();

        fetch("<?php echo $this->baseUrl;?>zipcodes/get_zip_codes",{
            headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/x-www-form-urlencoded'
            },
            method: "POST",
            body: new URLSearchParams(formData)
        })
        .then(response=>{
            // console.log("resp : ",response);
            return response.json();
        })
        .then(data=>{
            var str = "";
            // console.log(data);
            $.each(data,function(i,v){
                str += "<option value='"+i+"'>"+v+"</option>";
            })
            $zip_code.append(str);
        })
        .catch(err=>{
            console.log(err);
        });
    }


    var imgUrl = table.attr('data-imageUrl');
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
                { "data": "group_name" },
                { "data": "zip_codes" },
                {
                    "data": 'link',
                    "orderable" : false,
                    "render": function ( data, type, row, meta ) {
                        return "<a class='' href='<?php echo $this->baseUrl; ?>zipcodegroups/index/"+data.id+"' title='Edit Zip Code Group'><i class='feather icon-edit'></i></a>";
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