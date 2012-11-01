<!DOCTYPE html>
<head>
	<title>Annotation Page</title>
	<meta charset="utf-8">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 

	<link rel="stylesheet" href="jquery.mobile-1.2.0.css" />
	<link rel="stylesheet" href="style.css" />
	<link rel="apple-touch-icon" href="appicon.png" />
	<link rel="apple-touch-startup-image" href="startup.png">

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
	<style type="text/css" media="screen">
    	#canvas{ display:block; border:1px solid black;background-size: 100%;}

  	</style>
	
</head>
<body>


	<div data-role="page">
		<div data-role="header" data-id="samebar" class="headermenu" data-position="fixed" data-tap-toggle="false">
		<h1>Motif</h1>

	</div><!-- /header -->

			<div data-role="content">
				
					<div data-role="controlgroup" data-type="horizontal" class="art-buttons">
						<a href="./art.php?id=<?php echo $row["id"]?>" id="art" data-icon="custom" data-role="button" data-theme="a">Art</a></li>
						<a href="./comments.php" id="comments" data-icon="custom" data-role="button" data-theme="a">Comments</a>
						<a href="./annotate.php" id="annotate" data-icon="custom" data-role="button" data-theme="a">Annotate</a>
					</div><!-- /controlgroup -->
					<table style = "width:100%;border-collapse:collapse;">
						<tr>
							<td style  = "width:100%;">
							<canvas id="canvas"></canvas>
							<td>
						<td style = "width:70px;background-color:#E0E0E0;vertical-align:top;">	
								<p></p>
								<div  style = "text-align: center;"><img src = "icons/undo.png" width = "50px" onclick = "undo()"></div>
								<div><canvas id="extralarge" height = "60px" width = "70px"  onclick = "changeSize(50)"></canvas></div>
							<div><canvas id="large" height = "50px" width = "70px"  onclick = "changeSize(20)"></canvas></div>
								<div><canvas id="medium" height = "40px" width = "70px"  onclick = "changeSize(10)"></canvas></div>
								<div><canvas id="small" height = "30px" width = "70px" onclick = "changeSize(3)"></canvas></li>
							</div>
							



						</td>
					</tr>
				</table>

					<?php
				echo "<p>".$row["title"]."</p>";
				}
				?>

				<script type="text/javascript"> 
				$(document).ready(function() {
					<?php
					
					echo "prepareCanvas('".$row["image_url"]."')";

					?>
				});
				</script>
			</div><!-- /content -->

	<div data-role="footer" data-id="samebar" class="menubar" data-position="fixed" data-tap-toggle="false">
		<div data-role="navbar" class="menubar">
					<ul>
			<li><a href="./art.php" id="art" data-icon="custom">Random Art</a></li>
			<li><a href="./favorites.php" id="favorites" data-icon="custom">Favorites</a></li>
			<li><a href="./help.php" id="help" data-icon="custom">Help</a></li>
		</ul>

		</div><!-- /navbar -->
	</div><!-- /footer -->

</div><!-- /page -->
</body>

</html>