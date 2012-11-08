<!DOCTYPE html>
<head>
	<title>Art</title>
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
	<script type="text/javascript" src="drawing_canvas.js"></script>
	
	<script type = "text/javascript">
		function send_favorite(id){
			var request = new XMLHttpRequest();
			request.open('POST', 'mark_favorite.php', false);
			request.setRequestHeader("Content-type", "application/upload")
			request.send(id); // because of "false" above, will block until the request is done
			                // and status is available. Not recommended, however it works for simple cases.
			if (request.status === 200) {
			  alert("Favorited!")
			}
		}
	</script>


</head>
<body>

<div data-role="page">
	<div data-role="header">
			<?php

				include("config.php");
				$id = $_GET["id"];
				$query = "SELECT * FROM art";

				if($id != NULL){
					$query = "SELECT * FROM art where id = ".$id;
				}
				$result = mysql_query($query);
				$numRows = mysql_num_rows($result);
				$selectedRow = rand(0, $numRows-1);
				while ($row = mysql_fetch_assoc($result)) {
					if($selectedRow == 0){

						?>
			<h1 style="font-family: Andale Mono; font-size: 18px;">motif</h1>

	</div><!-- /header -->
			
	<div data-role="content">
		<table><tr><td>
		<div data-role="controlgroup" data-type="horizontal" class="art-buttons">
			<a href="./art.php?id=<?php echo $row["id"]?>" id="art" data-icon="custom" data-role="button" data-theme="a" rel="external">Art</a></li>
			<a href="./comments.php?id=<?php echo $row["id"]?>" id="comments" data-icon="custom" data-role="button" data-theme="a" rel="external">Comments</a>
			<a href="./annotate.php?id=<?php echo $row["id"]?>" id="annotate" data-icon="custom" data-role="button" rel="external" data-theme="a">Annotate</a>
		</div><!-- /controlgroup -->
		</td>
		<td style = "text-align:right;width:50px"><img src= "icons/heart.png" width = "30" height = "30" onclick = "send_favorite(<?php echo $row["id"]?>)">
			</td></tr></table>
		
			<p style="font-family: Andale Mono; font-size: 16px;"><b><?php echo $row["title"]; ?> </b> 
					(<?php echo $row["year"]; ?>)	
					- 
 				  <?php	echo $row["artist"]; ?></p>
			
			<?php
			   	echo "<img src='".$row["image_source"]."' alt = 'Image not found' width ='99%'>";
			?>
			
			
			
			<?php
			 
			 	}
				$selectedRow--;
			}
			?>
			
	</div><!-- /content -->
	
	<?php

	if($numRows > 1 ){
		$rand = $numRows;
	}else{
		$query = "SELECT COUNT(*) AS 'num' FROM art";
		$result = mysql_query($query);
		$row = mysql_fetch_assoc($result);
		$rand = $row["num"];
	}

	?>
	
	<script type = "text/javascript">
		function refresh(){
			var num = Math.floor(Math.random() * <?php echo $rand ?>) + 1;
			window.location="art.php?id="+num;
		}
	</script>

	<div data-role="footer" data-id="samebar" class="menubar" data-position="fixed" data-tap-toggle="false">
		<div data-role="navbar" class="menubar">
					<ul>

			<li><a onclick = "refresh()" id="art" data-icon="custom">Random Art</a></li>
			<li><a href="./favorites.php" id="favorites" data-icon="custom">Favorites</a></li>
			<li><a href="./help.php" id="help" data-icon="custom" rel="external">Help</a></li>
		</ul>
		</div><!-- /navbar -->
	</div><!-- /footer -->
	
</div><!-- /page -->
<script src="auth.js"></script>
</body>

</html>