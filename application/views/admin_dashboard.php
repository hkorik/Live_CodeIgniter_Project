	<div id="admin_dashboard">
		<h3 class="float_left">Manage Users</h3>
		<a class="btn blue btn-default float_right" href="/CodeIgniter_Project/users/new">Add new</a>
		<table class="table table-striped table-bordered">
			<thead class="dark_grey">
				<th>ID</th>
				<th>Name</th>
				<th>Email</th>
				<th>Created At</th>
				<th>User Level</th>
				<th>Actions</th>
			</thead>
			<tbody>
				<?php

					foreach ($user_rows as $row) 
					{
						echo "<tr>";

							echo "<td>{$row['id']}</td>";
							echo "<td><a href='/CodeIgniter_Project/users/show/{$row['id']}'>{$row['first_name']} {$row['last_name']}</a></td>";
							echo "<td>{$row['email']}</td>";
							echo "<td>{$row['created_at_date']}</td>";
							if($row['user_level'] != '9')
							{
								$row['user_level'] = 'normal';
								echo "<td>{$row['user_level']}</td>";
							}
							else
							{
								$row['user_level'] = 'admin';
								echo "<td>{$row['user_level']}</td>";
							}
							echo "<td class='last_td'>
									<form class='float_left' action='/CodeIgniter_Project/users/edit/{$row['id']}' method='post'>
										<input type='hidden' name='email' value='{$row['email']}'/>
										<input class='btn btn-success' type='submit' value='Edit' />
									</form>
									<form class='delete' action='/CodeIgniter_Project/user/delete_user' method='post'>
										<input type='hidden' name='email' value='{$row['email']}'/>
										<input type='hidden' name='name' value='{$row['first_name']} {$row['last_name']}' />
										<input class='btn btn-danger' type='submit' value='Delete' />
									</form>
								  </td>";
						echo "</tr>";
					}


				?>
					
			</tbody>
		</table>
	</div>
</body>
</html>