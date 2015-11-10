<?php 
if (! defined ( 'INDEX' )) {
	die("Attempt to hack !!!");
}
?>
<head>
<title><?php echo $app_title;?></title>
<?php common_view_imports();?>
</head>
<body>
	<div class="w3-row">
<?php side_navigation_panel('Manage Channels')?>
<div style="height: 30px"></div>
		<div class="w3-card-8" style="margin: 0px 30px 0px 330px;">
			<div class="w3-container w3-teal">
				<h2>Manage Channels</h2>
			</div>
			<a href='index.php?opt=add_channel' class="w3-btn w3-teal w3-margin-bottom w3-margin-top w3-margin-left">New Channel</a>
			<table class="w3-table w3-striped w3-bordered w3-border w3-large">
				<tr class="w3-blue">
					<th>ID</th>
					<th>Name</th>
					<th>Description</th>
					<th style="text-align: center">Notices</th>
					<th style="text-align: center">Subscribers</th>
					<th>Action</th>
				</tr>
				<?php
				global $data;
				$channels = $data ['channels'];
				
				foreach ( $channels as $ch ) {
					?>
					
				<tr>
					<td><?php echo $ch['id']?></td>
					<td><?php echo $ch['name']?></td>
					<td><?php echo $ch['description']?></td>
					<td style="text-align: center"><?php echo $ch['published_notices']?></td>
					<td style="text-align: center"><?php echo $ch['subs']?></td>
					<td><a href="index.php?opt=edit_user&id=<?php echo $ch['id']?>"><img src="view/img/edit.svg" title="Edit user"/></a><a href="#" onclick="removeChannel(<?php echo $ch['id'].",'".$ch['name']?>')"><img src="view/img/remove.svg" title="Remove user"/></a></td>
				</tr>
					
					<?php
				}
				?>
			</table>
		</div>
	</div>
	<script type="text/javascript">
		function removeChannel(id,name){
			if(confirm("Do you want to delete channel \""+name+"\"")){
				if(confirm("Are you sure?")){
					$.ajax({
		                url: 'index.php?opt=remove_channel',
		                dataType: 'text',
		                type: 'post',
		                data: 'id='+id,
		                success: function( data, textStatus, jQxhr ){
		                    if(data == 'success'){
			                    alert("Channel removed successfuly");
			                    window.location.assign("index.php?opt=manage_channels");
		                    }
		                },
		                error: function( jqXhr, textStatus, errorThrown ){
		                    $("#output").html( errorThrown );
		                }
		            });
				}
			}
		}
	</script>
</body>
</html>