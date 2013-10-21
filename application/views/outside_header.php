<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="keywords" content="user management system, user profile, admin, user database, leave messages, message user, comment, comments," />
	<meta name="description" content="Manage Users: Using this application, admins will be able to manage users add, remove, and edit user's information (email address, first name, last name, etc). Leave messages: Users will be able to leave a message to another user using this application (and comment on messages)." />
	<title><?php echo $title ?></title>
	<link rel="stylesheet" type="text/css" href="/CodeIgniter_Project/assets/css/styles.css" />
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/css/bootstrap.min.css" />
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/js/bootstrap.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){

		    $('#register_form').submit(function(){
				$.post(	
					$(this).attr('action'),
					$(this).serialize(),
					function(data){
						$('.prev_message').parent('div').removeClass('field_block');
						$('.prev_message').html('');
						if(data.register_error)
						{
							$('#messages_register_error').html(data.register_error);
						}
						if(data.email)
						{
							$('#messages_email').parent('div').addClass('field_block');
							$('#messages_email').html(data.email);
						}
						if(data.first_name)
						{
							$('#messages_first_name').parent('div').addClass('field_block');
							$('#messages_first_name').html(data.first_name);
						}
						if(data.last_name)
						{
							$('#messages_last_name').parent('div').addClass('field_block');
							$('#messages_last_name').html(data.last_name);
						}
						if(data.password)
						{
							$('#messages_password').parent('div').addClass('field_block');
							$('#messages_password').html(data.password);
						}
						if(data.confirm_password)
						{
							$('#messages_confirm_password').parent('div').addClass('field_block');
							$('#messages_confirm_password').html(data.confirm_password);
						}
						if(data.link)
						{
							window.location.href = data.link;
						}
					},					
					"json"		
				);
				return false;
			});

			$('#signin_form').submit(function(){
				$.post(	
					$(this).attr('action'),
					$(this).serialize(),
					function(data){
						$('.prev_message').parent('div').removeClass('field_block');
						$('.prev_message').html('');
						if(data.signin_error)
						{
							$('#messages_signin_error').html(data.signin_error);
						}
						if(data.email)
						{
							$('#messages_email').parent('div').addClass('field_block');
							$('#messages_email').html(data.email);
						}
						if(data.password)
						{
							$('#messages_password').parent('div').addClass('field_block');
							$('#messages_password').html(data.password);
						}
						if(data.link)
						{
							window.location.href = data.link;
						}
					},					
					"json"		
				);
				return false;
			});

		});
	</script>	
</head>
<body>
	<div id="wrapper">
		<div class="navbar">
		  <p class="navbar-text float_left">Test App</p>
		  <a href="/CodeIgniter_Project/" class="navbar-brand">Home</a>
		  <a href="/CodeIgniter_Project/signin" class="navbar-brand pull-right">Sign in</a>
		</div>