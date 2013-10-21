		<div id="edit_profile" class="float_left">	
			<h2>Edit Profile</h2>
			<div id="success_message"><p id='info_success_message'></p></div>
			<form id="edit_profile_info_form" action="/CodeIgniter_Project/user/process_edit_profile_info" method="post">
			  <fieldset class="border">
			  	<legend>Edit Information</legend>
			    <div class="form-group field_block_text">
  			      <p class="prev_message" id='messages_register_error'></p>
			      <label for="email">Email address:</label>
			      <p class="prev_message" id='messages_email'></p>
			      <input type="text" class="form-control" name="email" id="email" placeholder="Enter email">
			    </div>
		        <div class="form-group">
			      <label for="first_name">First Name:</label>
			      <p class="prev_message" id='messages_first_name'></p>
			      <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter First Name">
			    </div>
		        <div class="form-group">
			      <label for="last_name">Last Name:</label>
			      <p class="prev_message" id='messages_last_name'></p>
			      <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Enter Last Name">
			    </div>
			    <input class="btn green btn-default float_right" type="submit" value="Save">
			  </fieldset>
			</form>
		</div>
		<div id="edit_profile_pw" class="float_right">
			<div id="success_message"><p id='pw_success_message'></p></div>
			<form id="edit_profile_pw_form" action="/CodeIgniter_Project/user/process_edit_profile_pw" method="post">
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
			      <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Enter Confirm password">
			    </div>
			    <input class="btn green btn-default float_right" type="submit" value="Update Password">
			  </fieldset>
			</form>
		</div>
		<div id="description" class="clear">
			<div id="success_message"><p id='description_success_message'></p></div>
			<form id="edit_profile_description_form" action="/CodeIgniter_Project/user/process_edit_profile_description" method="post">
			  <fieldset class="border">
			  	<legend>Edit Description</legend>
			  	<div class="">
					<p class="prev_message" id='messages_description'></p>
					<textarea class="float_right" name="description" id="description_text" rows=4 cols=130></textarea>
				</div>
					<input class="clear float_right btn green btn-default" type="submit" value="Save" id="description_button"/>
			  </fieldset>
			</form>
		</div>
	</div>
</body>
</html>