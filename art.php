<!DOCTYPE html>
<head>
	<title>Art Page</title>
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
	<script>
    $(function() {
        $( "#tabs" ).tabs();
    });
    </script>

</head>
<body>
	
<div data-role="page">
	<div data-role="header" data-id="samebar" class="headermenu" data-position="fixed" data-tap-toggle="false">
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
			<h1>Motif</h1>
		

	</div><!-- /header -->
			
	<div data-role="content">
		<div data-role="controlgroup" data-type="horizontal" class="art-buttons">
			<a href="./art.php" id="art" data-icon="custom" data-role="button" data-theme="a">Art</a></li>
			<a href="./comments.php" id="comments" data-icon="custom" data-role="button" data-theme="a">Comments</a>
			<a href="./annotate.php" id="annotate" data-icon="custom" data-role="button" data-theme="a">Annotate</a>
		</div><!-- /controlgroup -->
		
			<?php
			    	echo "<img src='".$row["image_url"]."' alt = 'Image not found' width ='99%'>";
					echo "<p>".$row["title"]."</p>";
			
				}
				$selectedRow--;
			}
			?>
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