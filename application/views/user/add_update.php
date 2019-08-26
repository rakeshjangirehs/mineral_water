<div class="row">
	<form data-action="<?php echo $this->baseUrl; ?>users/add_update/<?php echo $id; ?>" id="tagFrm" method="post">
	<div class="col-sm-6">
		<div class="panel-group">
		  	<div class="panel panel-primary">
			    <div class="panel-heading"><?php echo $page_title; ?> </div>
			    <div class="panel-body">
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
				    					$selected = ($user_data['user_type_id'] == $role['id']) ? 'selected' : '';
    						?>
    						<option value="<?php echo $role['id']; ?>" <?php echo $selected; ?>><?php echo $role['name']; ?></option>
    						<?php
				    				endforeach;
				    			endif;
				    		?>
				    	</select>
				  	</div>
				  	<div class="form-group">
				  		<label for="reporing_to">Reprting To:</label>
				  		<select class="form-control" name="reporting_to" id="reporting_to">
				    		<option value=""></option>
				    		<?php 
				    			if(!empty($reporting_users)):
				    				foreach($reporting_users as $reporting_user):
				    					$selected = ($user_data['reporting_to'] == $reporting_user['id']) ? 'selected' : '';
    						?>
    						<option value="<?php echo $reporting_user['id']; ?>" <?php echo $selected; ?>><?php echo $reporting_user['first_name']; ?></option>
    						<?php
				    				endforeach;
				    			endif;
				    		?>
				    	</select>
				  	</div>
			    </div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="panel-group">
		  	<div class="panel panel-primary">
			    <div class="panel-heading"><?php echo ""; ?> </div>
			    <div class="panel-body">
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
			    </div>
			</div>
		</div>
	</div>
  	<a class="btn btn-danger pull-right" href="<?php echo $this->baseUrl; ?>users/">Cancel</a>
	<button type="submit" class="btn btn-default pull-right">Save</button>
	</form>
</div>
@script
<script type="text/javascript">
	// to active the sidebar
    $('.nav .nav-list').activeSidebar('.add_user_li');
</script>
@endscript