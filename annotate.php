<!DOCTYPE html>
<head>
	<title>Annotation</title>
	<meta charset="utf-8">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 

	<link rel="stylesheet" href="jquery.mobile-1.2.0.css" />
	<link rel="stylesheet" href="style.css" />
	<link rel="apple-touch-icon" href="icons/icon2.png" />
	<link rel="apple-touch-startup-image" href="images/logo.png">
	

	<?php

include("config.php");
$query = "SELECT * FROM art WHERE id = '$_GET[id]'";
$result = mysql_query($query);
if($result!=false){
	$row = mysql_fetch_assoc($result);
?>
	<script src="jquery-1.8.2.min.js"></script>
	<script src="jquery.mobile-1.2.0.js"></script>
	<script type="text/javascript" src="drawing_canvas.js"></script>
	<script src='spectrum.js'></script>
	<link rel='stylesheet' href='spectrum.css' />
	
	<style type="text/css" media="screen">
    	#canvas{ display:block; background-size: 100%;}
		table, td, tr {
			margin:0;
			padding:0;
			border-collapse:collapse;
		}

  	</style>

	
</head>
<body>
	
	


	<div data-role="page">
		<div data-role="header">
			<h1 style="font-family: Andale Mono; font-size: 18px;">motif</h1>
			<a href="javascript:history.go(-1)" id="goback" data-icon="custom">Back</a>
		</div><!-- /header -->

			<div data-role="content" id = "container">
				
			
				
					<div data-role="controlgroup" data-type="horizontal" class="art-buttons">
						<a href="./art.php?id=<?php echo $row["id"]?>" id="art" data-icon="custom" data-role="button" data-theme="a" rel="external">Art</a></li>
						<a href="./comments.php?id=<?php echo $row["id"]?>" id="comments" data-icon="custom" data-role="button" data-theme="a" rel="external">Comments</a>
						<a href="./annotate.php?id=<?php echo $row["id"]?>" id="annotate" data-icon="custom" data-role="button" data-theme="a" rel="external">Annotate</a>
					</div><!-- /controlgroup -->
					<table style = "width:100%;">
						<tr>
							<td style  = "width:100%;">
							<canvas id="canvas"></canvas>
							<td>
						<td style = "padding:2px;background-color:#E0E0E0;vertical-align;text-align: center;"">	
								<p></p>
								<div><img src = "icons/undo.png" width = "50px" onclick = "undo()"></div>
								<div><canvas id="extralarge" height = "60px" width = "70px"  onclick = "changeSize(50)"></canvas></div>
							<div ><canvas id="large" height = "50px" width = "70px"  onclick = "changeSize(20)"></canvas></div>
								<div><canvas style = "background-color:#B0B0B0;" id="medium" height = "40px" width = "70px"  onclick = "changeSize(10)" ></canvas></div>
								<div><canvas id="small" height = "30px" width = "70px" onclick = "changeSize(3)"></canvas></li>
								<div style = "text-align: center;"><input type='color' name='color' id = "colorPicker" onchange = "changeColor()"/></div>
							</div>
							



						</td>
					</tr>
					<tr>
						<td style = "width:100%;background-color:#B0B0B0;padding:7px"">
							<textarea id="commentBox" cols="100" rows="100">
							</textarea>
							</td>
							<td></td>
							<td style = "width:70px;background-color:#B0B0B0;vertical-align:center;">	
								<img src = "icons/post.png" style="width:60px;height:60px" onclick="save()">
						</td>
						</tr>
				</table>

					<?php
				}
				?>

				<script type="text/javascript"> 
				$(document).bind('pageinit', function() {
					
					<?php
					echo "prepareCanvas('".$row["image_url"]."', ".$row["id"].")";

					?>
				});
				</script>
			</div><!-- /content -->

	<div data-role="footer" data-id="samebar" class="menubar" data-position="fixed" data-tap-toggle="false">

		<div data-role="navbar" class="menubar" data-grid="c">
		<ul>
			<li><a href="./home.php" id="home" data-icon="custom">Home</a></li>
			<li><a href="./art.php" id="art" data-icon="custom" rel="external">Random Art</a></li>
			<li><a href="./favorites.php" id="favorites" data-icon="custom" rel="external">Favorites</a></li>
			<li><a href="./help.php" id="help" data-icon="custom" rel="external">Help</a></li>
		</ul>

		</div><!-- /navbar -->
	</div><!-- /footer -->

</div><!-- /page -->
</body>

</html>