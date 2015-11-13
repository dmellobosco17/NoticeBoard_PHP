<?php 
if (! defined ( 'INDEX' )) {
	die("Attempt to hack !!!");
}
?>
<html>
<head>
<title><?php echo $app_title;?></title>
<?php common_view_imports();?>
</head>
<body>
	<div class="w3-row">
<?php side_navigation_panel('Manage Channels');?>
<?php $ch = $data['channel'];?>
<div style="height: 30px"></div>
		<div class="w3-card-8" style="margin: 0px 30px 0px 330px;">
			<div class="w3-container w3-teal">
				<h2>Edit Channel : <?php echo $ch['name'];?></h2>
			</div>
			<form class="w3-container" method="post" enctype="multipart/form-data"
				action="index.php?opt=edit_channel&id=<? echo $ch['id']?>" onsubmit="return validate()">
				<input name="id" id="id" type="hidden" value="<?php echo $ch['id'];?>">
				<input name="act" type="hidden" value="do">
				<div class="w3-row">
					<div class="w3-group w3-col m5">
						<div class="w3-group">
							<input class="w3-input" name="name" id="name" type="text" value="<?php echo $ch['name'];?>">
							<label class="w3-label">Channel Name</label>
						</div>
						<div class="w3-group">
							<input class="w3-input" name="desc" id="desc" type="text" value="<?php echo $ch['description'];?>">
							<label class="w3-label">Description</label>
						</div>
					</div>
					<div class="w3-group w3-col m1">
						<p id="err" style="background-color: pink;">Channel name not availabe, Please choose different name.</p>
					</div>
					<div class="w3-group w3-col m6">
						<img alt="channel_image" src="../channel_imgs/<?php echo $ch['image']."?".rand()?>">
						<input type="file" name="image" id="image">
					</div>
				</div>
				<button id="edit_channel" class="w3-btn w3-teal w3-margin-bottom">Edit Channel</button>
			</form>
		</div>
	</div>
	<script type="text/javascript">
	$("#err").hide();
		$("#name").keyup(function(){
			$.ajax({
                url: 'index.php?opt=live_feed',
                dataType: 'text',
                type: 'post',
                data: 'seed='+$("#name").val()+'&match=exact&procedure_code=new_channel_name',
                success: function( data, textStatus, jQxhr ){
                    if(data != '[]'){
                        $("#err").show();
                        $("#edit_channel").prop('disabled', true);
                    }
                    else{
                    	$("#err").hide();
                    	$("#edit_channel").prop('disabled', false);
                    }
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    $("#output").html( errorThrown );
                }
            });
		});
	
		function validate(){
			var channels = JSON.stringify($("#channel").val());
			
			err="";
			if($("#rname").val()==''){
				err+="Please enter channel name\n";
			}
			if($("#desc").val()==''){
				err+="Please enter description\n";
			}
			if(err=="")
				return confirm("Do you want to submit this data?");
			else
				alert(err);

			return false;
		}
		<?php if($data['log']['image'] != "")
			echo "alert('".$data['log']['image']."');";
			?>
			
	</script>
</body>
</html>