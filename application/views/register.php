		<div class="outside_form">	
			<h2>Register</h2>
			<form id="register_form" action="/CodeIgniter_Project/user/process_registration" method="post">
			  <fieldset>
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
			    <div class="form-group">
			      <label for="password">Password:</label>
			      <p class="prev_message" id='messages_password'></p>
			      <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password">
			    </div>
		        <div class="form-group">
			      <label for="confirm_password">Password Confirmation:</label>
			      <p class="prev_message" id='messages_confirm_password'></p>
			      <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Enter Password Confirmation">
			    </div>
			    <input class="btn green btn-default float_right" type="submit" value="Register">
			  </fieldset>
			</form>
			<a class="float_right" href="/CodeIgniter_Project/signin">Already have an account? Login.</a>
		</div>	
	</div>
</body>
</html>