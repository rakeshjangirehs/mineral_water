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
                                    <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo (isset($_POST['last_name']))? set_value('last_name') : $user_data['last_name']; ?>" />
                                    <span class="messages"><?php echo form_error('last_name');?></span>
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="control-label">phone:</label>
                                    <input type="text" name="phone" id="phone" class="form-control" value="<?php echo (isset($_POST['phone']))? set_value('phone') : $user_data['phone']; ?>" />
                                    <span class="messages"><?php echo form_error('phone');?></span>
                                </div>

                                <div class="form-group">
                                    <label for="role" class="control-label">Role:</label>
                                    <select class="form-control" name="role" id="role">
                                        <option value="">Select Role</option>
                                        <?php
                                        if(!empty($roles)):
                                            foreach($roles as $role):
                                                $selected = ($user_data['role_id'] == $role['id']) ? 'selected' : '';
                                                ?>
                                                <option value="<?php echo $role['id']; ?>" <?php echo $selected; ?>><?php echo $role['role_name']; ?></option>
                                            <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </select>
                                    <span class="messages"><?php echo form_error('role');?></span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label for="username" class="control-label">Username:</label>
                                    <input type="text" name="username" id="username" class="form-control" value="<?php echo (isset($_POST['username']))? set_value('username') : $user_data['username']; ?>"  />
                                    <span class="messages"><?php echo form_error('username');?></span>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="control-label">Email:</label>
                                    <input type="email" name="email" id="email" class="form-control" value="<?php echo (isset($_POST['email']))? set_value('email') : $user_data['email']; ?>"  />
                                    <span class="messages"><?php echo form_error('email');?></span>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="control-label">Password:</label>
                                    <input type="password" name="password" id="password" class="form-control" value="" <?php //echo (!$id) ? 'required' : ''; ?> />
                                    <span class="messages"><?php echo form_error('password');?></span>
                                </div>
                                <div class="form-group">
                                    <label for="zip_code_group" class="control-label">ZIP Code Groups:</label>
                                    <select class="form-control select2 multiple" name="zip_code_group[]" id="zip_code_group" data-placeholder="Choose ZIP Code Groups" multiple>
                                        <option value=""></option>
                                        <?php
                                        if(!empty($zip_code_groups)):
                                            foreach($zip_code_groups as $key=>$zip_code_group):
                                                $selected = (in_array($key,explode(',',$user_data['user_zip_code_groups']))) ? 'selected' : '';
                                                ?>
                                                <option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $zip_code_group; ?></option>
                                            <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="zip_codes" class="control-label">ZIP Codes:</label>
                                    <select class="form-control select2 multiple" name="zip_codes[]" id="zip_codes" data-placeholder="Choose ZIP Codes" multiple>
                                        <option value=""></option>
                                        <?php
                                        if(!empty($zip_codes)):
                                            foreach($zip_codes as $key=>$zip_code):
                                                $selected = (in_array($key,explode(',',$user_data['user_zip_codes']))) ? 'selected' : '';
                                                ?>
                                                <option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $zip_code; ?></option>
                                            <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </select>
                                    <span class="messages"><?php echo form_error('zip_codes');?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-right">
                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                            <a class="btn btn-sm btn-default" href="<?php echo $this->baseUrl; ?>users/">Cancel</a>
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
    // $('.nav .nav-list').activeSidebar('.add_user_li');
    $(".add_user_li").active();
</script>
@endscript