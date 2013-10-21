		<div class="outside_form">	
			<h2>Sign in</h2>
			<form id="signin_form" action="/CodeIgniter_Project/user/process_signin" method="post">
			  <fieldset>
			    <div class="form-group field_block_text">
			      <p class="prev_message" id='messages_signin_error'></p>
			      <label for="email">Email address:</label>
			      <p class="prev_message" id='messages_email'></p>
			      <input type="text" class="form-control" name="email" id="email" placeholder="Enter email">
			    </div>
			    <div class="form-group">
			      <label for="password">Password:</label>
			       <p class="prev_message" id='messages_password'></p>
			      <input type="password" class="form-control" name="password" id="password" placeholder="Password">
			    </div>
			    <input class="btn green btn-default float_right" type="submit" value="Sign In">
			  </fieldset>
			</form>
			<a class="float_right" href="/CodeIgniter_Project/register">Don't have an account? Register.</a>
		</div>	
	</div>
</body>
</html>