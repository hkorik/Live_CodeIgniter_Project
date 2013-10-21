		<div id="user_profile">
			<h3><?php if(!empty($user_profile_info)){ echo $user_profile_info->first_name, " ", $user_profile_info->last_name; } ?></h3>
			<ul>
				<li>Registered at: <?php  if(!empty($user_profile_info->created_at_date)){ echo $user_profile_info->created_at_date; } ?></li>
				<li>User ID: <?php  if(!empty($user_profile_info)){ echo $user_profile_info->id; } ?></li>
				<li>Email address: <?php  if(!empty($user_profile_info)){ echo $user_profile_info->email; } ?></li>
				<li>Description: <?php  if(!empty($user_profile_info)){ echo $user_profile_info->description; } ?></li>
			</ul>		
			<!-- post message -->
			<form action="/CodeIgniter_Project/user/post_message" method="post">
				<h3>Leave a message for <?php if(!empty($user_profile_info)){ echo $user_profile_info->first_name; } ?></h3>
				<input type="hidden" name="user_id" value="<?php  if(!empty($logged_user_id)){ echo $logged_user_id; } ?>" />
				<input type="hidden" name="profile_user_id" value="<?php  if(!empty($user_profile_info)){ echo $user_profile_info->id; } ?>" />
				<textarea name="message" id="message" rows=3 cols=140></textarea>
				<input class="btn green btn-default float_right" type="submit" value="Post" id="message_button"/>
			</form>
			<!-- display message -->
			<div class="clear"></div>
				<?php
					if(!empty($html))
					{
						echo $html;
					}
				?>
		</div>
	</div>
</body>
</html>