		<div id="edit_info" class="float_left">	
			<h2>Edit user <?php if(!empty($edit_users_info->id)){ echo $edit_users_info->id; } ?></h2>
			<div id="success_message"><p id='info_success_message'></p></div>
			<div id="success_message"><p id='pw_success_message'></p></div>			
			<form id="edit_user_info_form" action="/CodeIgniter_Project/user/process_edit_user_info" method="post">
			  <input type="hidden" name="id" value="<?php if(!empty($edit_users_info->id)){ echo $edit_users_info->id; } ?>">
			  <fieldset class="border">
			  	<legend>Edit Information</legend>
			    <div class="form-group field_block_text">
			      <p class="prev_message" id='messages_register_error'></p>
			      <label for="email">Email address:</label>
			      <p class="prev_message" id='messages_email'></p>
			      <input type="text" class="form-control" name="email" id="email" placeholder="<?php if(!empty($edit_users_info->email)){ echo $edit_users_info->email; } ?>">
			    </div>
		        <div class="form-group">
			      <label for="first_name">First Name:</label>
			      <p class="prev_message" id='messages_first_name'></p>
			      <input type="text" class="form-control" name="first_name" id="first_name" placeholder="<?php if(!empty($edit_users_info->first_name)){ echo $edit_users_info->first_name; } ?>">
			    </div>
		        <div class="form-group">
			      <label for="last_name">Last Name:</label>
			      <p class="prev_message" id='messages_last_name'></p>
			      <input type="text" class="form-control" name="last_name" id="last_name" placeholder="<?php if(!empty($edit_users_info->last_name)){ echo $edit_users_info->last_name; } ?>">
			    </div>
			    <div class="form-group">
			     	User Level:
			        <select name="user_level" class="form-control">
					  <option>Normal</option>
					  <option>Admin</option>
					</select>
			    </div>
			    <input class="btn green btn-default float_right" type="submit" value="Save">
			  </fieldset>
			</form>
		</div>
		<div id="edit_user_pw" class="float_right">
			<a class="btn blue btn-default float_right" href="<?php echo $dashboard_link ?>">Return to Dashboard</a>
			<form id="edit_user_pw_form" action="/CodeIgniter_Project/user/process_edit_user_pw" method="post">
			  <input type="hidden" name="id" value="<?php if(!empty($edit_users_info->id)){ echo $edit_users_info->id; } ?>">
			  <fieldset class="border float_right">
			  	<legend>Change Password</legend>
			    <div class="form-group">
			      <label for="password">Password:</label>
			      <p class="prev_message" id='messages_password'></p>
			      <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
			    </div>
		        <div class="form-group">
			      <label for="confirm_password">Confirm Password:</label>
			      <p class="prev_message" id='messages_confirm_password'></p>
			      <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
			    </div>
			    <input class="btn green btn-default float_right" type="submit" value="Update Password">
			  </fieldset>
			</form>
		</div>
	</div>
</body>
</html>