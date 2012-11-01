<!DOCTYPE html>
<head>
	<title>Favorites Page</title>
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
	<script src="isotope/jquery.isotope.min.js"></script>
	
	
	<script>	
		$( function(){
			var $container = $('#container');
  			
  			$container.imagesLoaded( function(){
    			$container.isotope({
    				itemSelector : '.image',
    				masonryHorizontal: {
    					columnWidth: 240
    				}
    			});
  			});
		});
	</script>
		
</head>
<body>
	
<div data-role="page">
	<div data-role="header">
		<h1>Favorites</h1>
		
	</div><!-- /header -->
	
	<div data-role="content">
		<p>Favorites Page</p>
		
		<div id="container">
		<?php
			include("config.php");
			$query = "SELECT * FROM art";
			$result = mysql_query($query);
			while ($row = mysql_fetch_assoc($result)) {
				echo "<div class='image'><a href='./art.php?id=".$row['id']."'><img width='100' src=".$row['image_url']."></a></div>";
			} 
			?>
		</div><!-- /container -->

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