<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $title ?></title>
	<link rel="stylesheet" type="text/css" href="/CodeIgniter_Project/assets/css/styles.css" />
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/css/bootstrap.min.css" />
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/js/bootstrap.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript">
    	$(document).ready(function(){
    		
    		$('.delete').submit(function(){
    			var name = $(this).find('input[name="name"]').val();
    			var delete_confirm = confirm("Are you sure you would like to delete " + name + " from the system?");
    			if(delete_confirm == true)
				{
				  // continue with the delete
				}
				else
				{
					return false; //cancel delete function
				}
			});

			$('#edit_profile_info_form').submit(function(){
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
						if(data.info_message)
						{
							$('#info_success_message').html(data.info_message);
						}
					},					
					"json"		
				);
				return false;
			});

			$('#edit_profile_pw_form').submit(function(){
				$.post(	
					$(this).attr('action'),
					$(this).serialize(),
					function(data){
						$('.prev_message').parent('div').removeClass('field_block');
						$('.prev_message').html('');
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
						if(data.pw_message)
						{
							$('#pw_success_message').html(data.pw_message);
						}
					},					
					"json"		
				);
				return false;
			});	

			$('#edit_profile_description_form').submit(function(){
				$.post(	
					$(this).attr('action'),
					$(this).serialize(),
					function(data){
						$('.prev_message').parent('div').removeClass('description_field_block');
						$('.prev_message').html('');
						if(data.description)
						{
							$('#messages_description').parent('div').addClass('description_field_block');
							$('#messages_description').html(data.description);
						}
						if(data.description_message)
						{
							$('#description_success_message').html(data.description_message);
						}
					},					
					"json"		
				);
				return false;
			});

			$('#edit_user_info_form').submit(function(){
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
						if(data.info_message)
						{
							$('#info_success_message').html(data.info_message);
						}
					},					
					"json"		
				);
				return false;
			});

			$('#edit_user_pw_form').submit(function(){
				$.post(	
					$(this).attr('action'),
					$(this).serialize(),
					function(data){
						$('.prev_message').parent('div').removeClass('field_block');
						$('.prev_message').html('');
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
						if(data.pw_message)
						{
							$('#pw_success_message').html(data.pw_message);
						}
					},					
					"json"		
				);
				return false;
			});

		    $('#new_user_form').submit(function(){
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
						if(data.message)
						{
							$('#new_user_success_message').html(data.message);
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
		  <a class="navbar-brand" href="<?php echo $dashboard_link ?>">Dashboard</a>
		  <a href="/CodeIgniter_Project/users/edit" class="navbar-brand">Profile</a>
		  <a href="/CodeIgniter_Project/user/log_off" class="navbar-brand pull-right">Log off</a>
		</div>