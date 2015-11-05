
<html>
<head>
<title><?php echo $app_title;?></title>
<?php common_view_imports();?>
<script type="text/javascript" src="view/js/jquery-ui.min.js"></script>
<link rel="stylesheet" href="view/css/jquery-ui.min.css">
</head>
<body>
	<div class="w3-row">
<?php side_navigation_panel('New Notice')?>
<div style="height: 30px"></div>
		<div class="w3-card-8" style="margin: 0px 30px 0px 330px;">
			<div class="w3-container w3-teal">
				<h2>New Notice</h2>
			</div>
			<form class="w3-container">
				<div class="w3-row">
					<div class="w3-group w3-col m3">
						<label class="w3-label"><b>Notice priority</b></label> 
						<select id="priority" class="w3-select w3-section">
							<option value="1">Normal</option>
							<option value="2">Important</option>
						</select>
					</div>
					<div class="w3-group w3-col m1"></div>
					<div class="w3-group w3-col m3">
						<label class="w3-label"><b>Channel</b></label> 
						<select id="channel" class="w3-select w3-section">
						<?php 
							$channels = $data['channels'];
							foreach($channels as $ch){
								echo "<option value='$ch[id]'>$ch[name]</option>";
							}
						?>
							<option value="0">All channels</option>
						</select>
					</div>
					<div class="w3-group w3-col m1"></div>
					<div class="w3-group w3-col m3">
						<label class="w3-label"><b>Expiry Date</b></label> 
						<input class="w3-input" type="text" id="date" name="date"/>
					</div>
				</div>
				<div class="w3-group">
					<input class="w3-input" id="subject" type="text"> <label class="w3-label">Subject</label>
				</div>
				<div class="w3-group">
					<textarea id="content" class="w3-input"></textarea>
					<label class="w3-label">Content</label>
				</div>


				<a id="publish" class="w3-btn w3-teal w3-margin-bottom">Publish</a>
			</form>
		</div>
	</div>
	<script type="text/javascript">
	$("#date").datepicker({dateFormat: 'dd/mm/yy'});
	$("#publish").click(function(){
		priority = $("#priority").val();
		date = $("#date").val();
		arr = date.split('/');
		date = arr[2]+"-"+arr[1]+"-"+arr[0];
		channel = $("#channel").val();
		subject = $("#subject").val();
		content = $("#content").val();

		error="";
		if(priority == null){
			error+="* Please specify priority.\n";
		}
		if(date == ""){
			error+="* Please specify expiry date.\n";
		}
		if(subject == ""){
			error+="* Please enter subject.\n";
		}

		if(error!=""){
			alert(error);
			return;
		}

		if(confirm("Do you want to publish this notice?")==false)
            return;
		
		$.ajax({
            url: 'index.php?opt=publish',
            dataType: 'text',
            type: 'post',
            data: 'subject='+subject+'&content='+content+'&channel='+channel+'&date='+date+'&priority='+priority,
            success: function( data, textStatus, jQxhr ){
				if(data=="success"){
					window.location.assign("index.php");
				}
				else{
					alert(data);
				}
            },
            error: function( jqXhr, textStatus, errorThrown ){
                alert(errorThrown);
            }
        });
	});
	
	</script>
</body>
</html>