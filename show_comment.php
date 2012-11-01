<!DOCTYPE html>
<head>
	<title>Comment Page</title>
	<meta charset="utf-8">
	<meta name="apple-mobile-web-app-capable" content="yes">
 	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 

	<link rel="stylesheet" href="jquery.mobile-1.2.0.css" />
	<link rel="stylesheet" href="style.css" />
	<link rel="apple-touch-icon" href="appicon.png" />
	<link rel="apple-touch-startup-image" href="startup.png">

	<script src="jquery-1.8.2.min.js"></script>
	<script src="jquery.mobile-1.2.0.js"></script>
	

	

</head>
<body>

<div data-role="page">

	<div data-role="header" data-id="samebar" class="headermenu" data-position="fixed" data-tap-toggle="false">
				<?php

				include("config.php");
				$id = $_GET["id"];
				$query = "SELECT * FROM comments where comment_id = ".$id;
				
				$result = mysql_query($query);
				$row = mysql_fetch_assoc($result);
				
				$artQuery = "SELECT * FROM art where id = ".$row["art_id"];
				
				$artResult = mysql_query($artQuery);
				$artPiece = mysql_fetch_assoc($artResult);

						?>
			<h1>Motif</h1>

	</div><!-- /header -->
			
	<div data-role="content">

		<div data-role="controlgroup" data-type="horizontal" class="art-buttons">
			<a href="./art.php?id=<?php echo $row["art_id"]?>" id="art" data-icon="custom" data-role="button" data-theme="a" rel="external">Art</a></li>
			<a href="./comments.php?id=<?php echo $row["art_id"]?>" id="comments" data-icon="custom" data-role="button" data-theme="a" rel="external">Comments</a>
			<a href="./annotate.php?id=<?php echo $row["art_id"]?>" id="annotate" data-icon="custom" data-role="button" rel="external" data-theme="a">Annotate</a>
		</div><!-- /controlgroup -->
		
			<canvas id="canvas"></canvas>
			
		
			<?php
					echo "<p>".$row["comment"]."</p>";
					
			?>
	</div><!-- /content -->
	
	<?php

		$query = "SELECT COUNT(*) AS 'num' FROM art";
		$result = mysql_query($query);
		$newRow = mysql_fetch_assoc($result);
		$rand = $newRow["num"];
	

	?>
	
	<script type = "text/javascript">
		function refresh(){
			var num = Math.floor(Math.random() * <?php echo $rand ?>) + 1;
			window.location="http://stanford.edu/~lcuth/cgi-bin/CS147_Project/art.php?id="+num;
		}
	</script>
	
	<script type = "text/javascript">
		$(document).ready(function() {
			canvas = document.getElementById('canvas');
			context = canvas.getContext("2d");
			img = new Image();
			img.src = <?php echo "'".$row["annotation"]."'" ?>;
			canvas.width = img.width;
			canvas.height = img.height;
			
			backgroundImg = new Image();
			backgroundImg.src = <?php echo "'".$artPiece["image_url"]."'" ?>;
			context.drawImage(backgroundImg, 0, 0, canvas.width, canvas.height)

			context.drawImage(img, 0, 0)
		});

	
	</script>

	<div data-role="footer" data-id="samebar" class="menubar" data-position="fixed" data-tap-toggle="false">
		<div data-role="navbar" class="menubar">
					<ul>

			<li><a onclick = "refresh()" id="art" data-icon="custom">Random Art</a></li>
			<li><a href="./favorites.php" id="favorites" data-icon="custom" rel="external">Favorites</a></li>
			<li><a href="./help.php" id="help" data-icon="custom" rel="external">Help</a></li>
		</ul>
		</div><!-- /navbar -->
	</div><!-- /footer -->
	
</div><!-- /page -->
</body>

</html>