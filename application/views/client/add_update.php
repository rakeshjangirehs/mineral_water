<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <form data-action="<?php echo $this->baseUrl; ?>users/add_update/<?php echo $id; ?>" id="tagFrm" method="post">
                <div class="card">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label for="client_name" class="control-label">Company Name:</label>
                                    <input type="text" name="client_name" id="client_name" class="form-control" value="<?php echo (isset($_POST['client_name']))? set_value('client_name') : $user_data['client_name']; ?>"/>
                                    <span class="messages"><?php echo form_error('client_name');?></span>
                                </div>
                                <div class="form-group">
                                    <label for="gst_no" class="control-label">GST No.:</label>
                                    <input type="text" name="gst_no" id="gst_no" class="form-control" value="<?php echo (isset($_POST['gst_no']))? set_value('gst_no') : $user_data['gst_no']; ?>"/>
                                    <span class="messages"><?php echo form_error('gst_no');?></span>
                                </div>
                                <div class="form-group">
                                    <label for="credit_limit" class="control-label">Credit Limit:</label>
                                    <input type="text" name="credit_limit" id="credit_limit" class="form-control" value="<?php echo (isset($_POST['credit_limit']))? set_value('credit_limit') : $user_data['credit_limit']; ?>" />
                                    <span class="messages"><?php echo form_error('credit_limit');?></span>
                                </div>
                                <div class="form-group">
                                    <label for="address" class="control-label">Billing Address:</label>
                                    <textarea name="address" id="address" rows="7" class="form-control"><?php echo (isset($_POST['address']))? set_value('address') : $user_data['address']; ?></textarea>
                                    <span class="messages"><?php echo form_error('address');?></span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label for="category_id" class="control-label">Category:</label>
                                    <select class="form-control select2" name="category_id" id="category_id" data-placeholder="Choose Category">
                                        <option value=""></option>
                                        <?php
                                            foreach($client_categories as $category){
                                                $check = (isset($_POST['category_id']))? set_value('category_id') : $user_data['category_id'];
                                                $selected = ($category['id'] == $check) ? 'selected' : '';
                                                if($selected || (!$selected && $category['is_deleted']==0)){
                                                    echo "<option value='{$category['id']}' {$selected}>{$category['name']}</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                    <span class="messages"><?php echo form_error('category_id');?></span>                                    
                                </div>
                                <div class="form-group">
                                    <label for="state_id" class="control-label">State:</label>
                                    <select class="form-control select2" name="state_id" id="state_id" data-placeholder="Choose State">
                                        <option value=""></option>
                                        <?php
                                            foreach($states as $state){
                                                $check = (isset($_POST['state_id']))? set_value('state_id') : $user_data['state_id'];
                                                $selected = ($state['id'] == $check) ? 'selected' : '';                                                
                                                echo "<option value='{$state['id']}' {$selected}>{$state['name']}</option>";
                                            }
                                        ?>
                                    </select>   
                                    <span class="messages"><?php echo form_error('state_id');?></span>                                 
                                </div>
                                <div class="form-group">
                                    <label for="city_id" class="control-label">City:</label>
                                    <select class="form-control select2" name="city_id" id="city_id" data-placeholder="Choose City">
                                        <option value=""></option>
                                        <?php
                                            foreach($cities as $city){
                                                $check = (isset($_POST['city_id']))? set_value('city_id') : $user_data['city_id'];
                                                $selected = ($city['id'] == $check) ? 'selected' : '';
                                                echo "<option value='{$city['id']}' {$selected}>{$city['name']}</option>";
                                            }
                                        ?>
                                    </select>    
                                    <span class="messages"><?php echo form_error('city_id');?></span>                                
                                </div>
                                <div class="form-group">
                                    <label for="zip_code" class="control-label">Zip Code:</label>
                                    <select class="form-control select2" name="zip_code_id" id="zip_code_id" data-placeholder="Choose ZIP Code">
                                        <option value=""></option>
                                        <?php
                                        if(!empty($all_zipcodes)):
                                            foreach($all_zipcodes as $zip_codes_id=>$zip_code):
                                                $check = (isset($_POST['zip_code_id']))? set_value('zip_code_id') : $user_data['zip_code_id'];
                                                
                                                $selected = ($zip_codes_id == $check) ? 'selected' : '';
                                                ?>
                                                <option value="<?php echo $zip_codes_id; ?>" <?php echo $selected; ?>><?php echo $zip_code; ?></option>
                                            <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </select>
                                    <span class="messages"><?php echo form_error('zip_code_id');?></span>                                
                                </div>
                            </div>
                            
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label for="contact_person_name_1" class="control-label">Contact Person 1:</label>
                                    <input type="text" name="contact_person_name_1" id="contact_person_name_1" class="form-control" value="<?php echo (isset($_POST['contact_person_name_1']))? set_value('contact_person_name_1') : $user_data['contact_person_name_1']; ?>" placeholder="Contact Person Name"/>
                                    <span class="messages"><?php echo form_error('contact_person_name_1');?></span>
                                </div>
                                <div class="form-group">
                                    <label for="contact_person_1_phone_1" class="control-label">Phone 1:</label>
                                    <input type="text" name="contact_person_1_phone_1" id="contact_person_1_phone_1" class="form-control" value="<?php echo (isset($_POST['contact_person_1_phone_1']))? set_value('contact_person_1_phone_1') : $user_data['contact_person_1_phone_1']; ?>"/>
                                    <span class="messages"><?php echo form_error('contact_person_1_phone_1');?></span>
                                </div>
                                <div class="form-group">
                                    <label for="contact_person_1_phone_2" class="control-label">Phone 2:</label>
                                    <input type="text" name="contact_person_1_phone_2" id="contact_person_1_phone_2" class="form-control" value="<?php echo (isset($_POST['contact_person_1_phone_2']))? set_value('contact_person_1_phone_2') : $user_data['contact_person_1_phone_2']; ?>"/>
                                    <span class="messages"><?php echo form_error('contact_person_1_phone_2');?></span>
                                </div>
                                <div class="form-group">
                                    <label for="contact_person_1_email" class="control-label">Email:</label>
                                    <input type="email" name="contact_person_1_email" id="contact_person_1_email" class="form-control" value="<?php echo (isset($_POST['contact_person_1_email']))? set_value('contact_person_1_email') : $user_data['contact_person_1_email']; ?>"/>
                                    <span class="messages"><?php echo form_error('contact_person_1_email');?></span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label for="contact_person_name_2" class="control-label">Contact Person 2:</label>
                                    <input type="text" name="contact_person_name_2" id="contact_person_name_2" class="form-control" value="<?php echo (isset($_POST['contact_person_name_2']))? set_value('contact_person_name_2') : $user_data['contact_person_name_2']; ?>"  placeholder="Contact Person Name"/>
                                    <span class="messages"><?php echo form_error('contact_person_name_2');?></span>
                                </div>
                                <div class="form-group">
                                    <label for="contact_person_2_phone_1" class="control-label">Phone 1:</label>
                                    <input type="text" name="contact_person_2_phone_1" id="contact_person_2_phone_1" class="form-control" value="<?php echo (isset($_POST['contact_person_2_phone_1']))? set_value('contact_person_2_phone_1') : $user_data['contact_person_2_phone_1']; ?>"/>
                                    <span class="messages"><?php echo form_error('contact_person_2_phone_1');?></span>
                                </div>
                                <div class="form-group">
                                    <label for="contact_person_2_phone_2" class="control-label">Phone 2:</label>
                                    <input type="text" name="contact_person_2_phone_2" id="contact_person_2_phone_2" class="form-control" value="<?php echo (isset($_POST['contact_person_2_phone_2']))? set_value('contact_person_2_phone_2') : $user_data['contact_person_2_phone_2']; ?>"/>
                                    <span class="messages"><?php echo form_error('contact_person_2_phone_2');?></span>
                                </div>
                                <div class="form-group">
                                    <label for="contact_person_2_email" class="control-label">Email:</label>
                                    <input type="email" name="contact_person_2_email" id="contact_person_2_email" class="form-control" value="<?php echo (isset($_POST['contact_person_2_email']))? set_value('contact_person_2_email') : $user_data['contact_person_2_email']; ?>"/>
                                    <span class="messages"><?php echo form_error('contact_person_2_email');?></span>
                                </div>
                            </div>
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
    // $('.nav .nav-list').activeSidebar('.add_client_li');
    $(".add_cilent_li").active();


    $(function(){
        
        var $state_id = $("#state_id");
        var $city_id = $("#city_id");
        var $zip_code = $("#zip_code_id");

        //Client Side Validation

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
    });
</script>
@endscript