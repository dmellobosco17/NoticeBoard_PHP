<html>
<head>
<title><?php echo $app_title;?></title>
<?php common_view_imports();?>
</head>
<body>
	<div class="w3-row">
<?php side_navigation_panel('Manage Users')?>
<div style="height: 30px"></div>
		<div class="w3-card-8" style="margin: 0px 30px 0px 330px;">
			<div class="w3-container w3-teal">
				<h2>Manage Users</h2>
			</div>
			<a href='index.php?opt=add_user' class="w3-btn w3-teal w3-margin-bottom w3-margin-top w3-margin-left">New User</a>
			<table class="w3-table w3-striped w3-bordered w3-border w3-large">
				<tr class="w3-blue">
					<th>User ID</th>
					<th>User Name</th>
					<th>Role</th>
					<th>Channels</th>
					<th>Published Notices</th>
					<th>Action</th>
				</tr>
				<?php
				global $data;
				$users = $data ['users'];
				
				foreach ( $users as $u ) {
					?>
					
				<tr>
					<td><?php echo $u['id']?></td>
					<td><?php echo $u['username']?></td>
					<td><?php echo $u['type']?></td>
					<td><?php echo $u['channel']?></td>
					<td><?php echo $u['published_notices']?></td>
					<td><a>[DELETE] </a><a> [EDIT]</a></td>
				</tr>
					
					<?php
				}
				?>
			</table>
		</div>
	</div>
</body>
</html>