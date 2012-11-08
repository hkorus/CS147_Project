<!DOCTYPE html>
<head>
	<title>Comments</title>
	<meta charset="utf-8">
	<meta name="apple-mobile-web-app-capable" content="yes">
 	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 

	<link rel="stylesheet" href="jquery.mobile-1.2.0.css" />
	<link rel="stylesheet" href="style.css" />
	<link rel="apple-touch-icon" href="icons/icon2.png" />
	<link rel="apple-touch-startup-image" href="images/logo.png">
	
	<script src="jquery-1.8.2.min.js"></script>
	<script src="jquery.mobile-1.2.0.js"></script>
	
</head>
<body>
	
<div data-role="page">

	<div data-role="header">
			
			<?php
				
				include("config.php");
				$query = "SELECT * FROM comments, art WHERE art_id = id and art_id = ".$_GET['id']." ORDER BY rating DESC";
				$result = mysql_query($query);
				
			?>				
				
			<h1 style="font-family: Andale Mono; font-size: 18px;">motif</h1>
		
	</div><!-- /header -->
	
	<script type = "text/javascript">
		function send_rating(comment, amount){
			var request = new XMLHttpRequest();
			request.open('POST', 'rate_image.php', false);
			request.setRequestHeader("Content-type", "application/upload")
			request.send(comment+"&"+amount); // because of "false" above, will block until the request is done
			                // and status is available. Not recommended, however it works for simple cases.
			if (request.status === 200) {
			  alert("Rated!")
			}
		}
	</script>

	
	<div data-role="content">
		
		<div data-role="controlgroup" data-type="horizontal" class="art-buttons">
			<a href="./art.php?id=<?php echo $_GET["id"]?>" id="art" data-icon="custom" data-role="button" data-theme="a" rel="external">Art</a></li>
			<a href="./comments.php?id=<?php echo $_GET["id"]?>" id="comments" data-icon="custom" data-role="button" data-theme="a" rel="external">Comments</a>
			<a href="./annotate.php?id=<?php echo $_GET["id"]?>" id="annotate" data-icon="custom" data-role="button" data-theme="a" rel="external">Annotate</a>
		</div><!-- /controlgroup -->
		
		<p>
			<table style = "text-align:center">
				<tr>
					
					<td><b>Rating</b></td>
					<td><b>Annotation</b></td>
					<td><b>Comment</b></td>
					
				</tr>	
				
				<?php
						
						if(mysql_num_rows($result)>0){	
							while($row = mysql_fetch_assoc($result)) {
								echo "<tr><td>";

						?> 
						<table>
						<tr><td style="padding-left:15px;"><img src = "icons/up_arrow.png" width = "20px" onclick = "send_rating(<?php echo $row["comment_id"] ?>, 1)"></td></tr>
						<tr><td style="padding-left:15px; font-size:18px;"><?php echo $row["rating"]; ?></td></tr>
						<tr><td style="padding-left:15px;"><img src = "icons/down_arrow.png" width = "20px" onclick = "send_rating(<?php echo $row["comment_id"] ?>,-1)"></td></tr>
						</table>

					</td>
					<td style = "width:150px; text-align:center">
						<?php

							echo "<canvas id = '".$row["comment_id"]."' width = '100%'></canvas>
							";
							
							echo "<script type = 'text/javascript'>"."
										$(document).ready(function() {"."
										canvas = document.getElementById('".$row["comment_id"]."');"."
										context = canvas.getContext('2d');"."
										img = new Image();"."
										img.src = '".$row["annotation"]."';"."
										
										backgroundImg = new Image();"."
										backgroundImg.src = '".$row["image_url"]."';"."
										context.drawImage(backgroundImg, 0, 0, canvas.width, canvas.height)"."
										context.drawImage(img, 0, 0, canvas.width, canvas.height)".
									"});";


								echo "</script>";
						?> 

					</td>
					<td style = "width:200px"> 
						<?php
							echo $row["comment"];
						
						?> 
					
					</td>
					<td style = "width:80px;">
						<a href = "show_comment.php?id=<?php echo $row["comment_id"] ?>"> View </a>
					</td>
				</tr>	
				<?php } } else {?>
				
			</table>
			<?php 
			echo "<br/>";
			echo "<div style = 'padding-left:15px;font-size:15px'>No comments yet!</div>"; }?>
		</p>
		
	
		
		
		
		
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