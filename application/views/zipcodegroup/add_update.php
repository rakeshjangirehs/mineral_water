<div class="row">
	<form data-action="<?php echo $this->baseUrl; ?>users/add_update/<?php echo $id; ?>" id="tagFrm" method="post">
	<div class="col-xs-12">
		<div class="panel-group">
		  	<div class="panel panel-primary">
                <div class="panel-heading"><?php echo $page_title; ?> </div>
			    <div class="panel-body">
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
                                <label for="equipment_id">Address:</label>
                                <textarea name="address" id="address" class="form-control" required><?php echo $user_data['address']; ?></textarea>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <label for="equipment_id">Credit Limit:</label>
                                <input type="text" name="credit_limit" id="credit_limit" class="form-control" value="<?php echo $user_data['credit_limit']; ?>" required />
                            </div>
                            <div class="form-group">
                                <label for="equipment_id">Email:</label>
                                <input type="email" name="email" id="email" class="form-control" value="<?php echo $user_data['email']; ?>" required />
                            </div>
                            <div class="form-group">
                                <label for="role">ZIP Code:</label>
                                <select class="form-control" name="zip_code_id" id="zip_code_id" data-placeholder="Choose ZIP Code" required>
                                    <option value="">Choose ZIP Code</option>
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
                            </div>
                        </div>
                    </div>

			    </div>
                <div class="panel-footer">
                    <div class="text-right">
                        <button type="submit" class="btn btn-sm btn-primary">Save</button>
                        <a class="btn btn-sm btn-default" href="<?php echo $this->baseUrl; ?>clients/">Cancel</a>
                    </div>
                </div>
			</div>
		</div>
	</div>
	</form>
</div>
@script
<script type="text/javascript">
	// to active the sidebar
    $('.nav .nav-list').activeSidebar('.add_client_li');
</script>
@endscript