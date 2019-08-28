<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <form data-action="<?php echo $this->baseUrl; ?>users/add_update/<?php echo $id; ?>" id="tagFrm" method="post">
                <div class="card">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label for="equipment_id">First Name:</label>
                                    <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $user_data['first_name']; ?>" required />
                                </div>
                                <div class="form-group">
                                    <label for="equipment_id">Last Name:</label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo $user_data['last_name']; ?>" required />
                                </div>
                                <div class="form-group">
                                    <label for="equipment_id">phone:</label>
                                    <input type="text" name="phone" id="phone" class="form-control" value="<?php echo $user_data['phone']; ?>" required />
                                </div>

                                <div class="form-group">
                                    <label for="role">Role:</label>
                                    <select class="form-control" name="role" id="role">
                                        <option value=""></option>
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
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label for="equipment_id">Username:</label>
                                    <input type="text" name="username" id="username" class="form-control" value="<?php echo $user_data['username']; ?>" required />
                                </div>
                                <div class="form-group">
                                    <label for="equipment_id">Email:</label>
                                    <input type="email" name="email" id="email" class="form-control" value="<?php echo $user_data['email']; ?>" required />
                                </div>
                                <div class="form-group">
                                    <label for="equipment_id">Password:</label>
                                    <input type="password" name="password" id="password" class="form-control" value="" <?php echo (!$id) ? 'required' : ''; ?> />
                                </div>
                                <div class="form-group">
                                    <label for="role">ZIP Code Groups:</label>
                                    <select class="form-control" name="zip_code_group[]" id="zip_code_group" multiple>
                                        <option value="">Choose ZIP Code Groups</option>
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
                                    <label for="role">ZIP Codes:</label>
                                    <select class="form-control" name="zip_codes[]" id="zip_codes" multiple>
                                        <option value="">Choose ZIP Codes</option>
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