	<div id="user_dashboard">
		<h3>All Users</h3>
		<table class="table table-striped table-bordered">
			<thead class="dark_grey">
				<th>ID</th>
				<th>Name</th>
				<th>Email</th>
				<th>Created At</th>
				<th>User Level</th>
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

						echo "</tr>";
					}
				?>
			</tbody>
		</table>
	</div>
</body>
</html>