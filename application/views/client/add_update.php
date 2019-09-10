<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <form data-action="<?php echo $this->baseUrl; ?>users/add_update/<?php echo $id; ?>" id="tagFrm" method="post">
                <div class="card">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label for="first_name" class="control-label">First Name:</label>
                                    <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo (isset($_POST['first_name']))? set_value('first_name') : $user_data['first_name']; ?>"/>
                                    <span class="messages"><?php echo form_error('first_name');?></span>
                                </div>
                                <div class="form-group">
                                    <label for="last_name" class="control-label">Last Name:</label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo (isset($_POST['last_name']))? set_value('last_name') : $user_data['last_name']; ?>"/>
                                    <span class="messages"><?php echo form_error('last_name');?></span>
                                </div>
                                <div class="form-group">
                                    <label for="address" class="control-label">Address:</label>
                                    <textarea name="address" id="address" rows="7" class="form-control"><?php echo (isset($_POST['address']))? set_value('address') : $user_data['address']; ?></textarea>
                                    <span class="messages"><?php echo form_error('address');?></span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label for="credit_limit" class="control-label">Credit Limit:</label>
                                    <input type="text" name="credit_limit" id="credit_limit" class="form-control" value="<?php echo (isset($_POST['credit_limit']))? set_value('credit_limit') : $user_data['credit_limit']; ?>" />
                                    <span class="messages"><?php echo form_error('credit_limit');?></span>
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="control-label">Phone:</label>
                                    <input type="text" name="phone" id="phone" class="form-control" value="<?php echo (isset($_POST['phone']))? set_value('phone') : $user_data['phone']; ?>" />
                                    <span class="messages"><?php echo form_error('phone');?></span>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="control-label">Email:</label>
                                    <input type="email" name="email" id="email" class="form-control" value="<?php echo (isset($_POST['email']))? set_value('email') : $user_data['email']; ?>" />
                                    <span class="messages"><?php echo form_error('email');?></span>
                                </div>
                                <div class="form-group">
                                    <label for="zip_code_id" class="control-label">ZIP Code:</label>
                                    <select class="form-control select2" name="zip_code_id" id="zip_code_id" data-placeholder="Choose ZIP Code">
                                        <option value=""></option>
                                        <?php
                                        if(!empty($zip_codes)):
                                            foreach($zip_codes as $zip_code):
                                                $selected = ($user_data['zip_code_id'] == $zip_code['id']) ? 'selected' : '';
                                                ?>
                                                <option value="<?php echo $zip_code['id']; ?>" <?php echo $selected; ?>><?php echo $zip_code['zip_code']; ?></option>
                                            <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </select>
                                    <span class="messages"><?php echo form_error('zip_code_id');?></span>
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
</script>
@endscript