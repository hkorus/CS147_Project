<!DOCTYPE html>
<head>
	<title>Help</title>
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
		<h1 style="font-family: Andale Mono; font-size: 18px;">motif</h1>

	</div><!-- /header -->
	
	<div data-role="content">
		<h1><center>mo·tif /mōˈtēf/</center></h1>
		<p><center>(noun): a distinctive feature or dominant idea in an artistic composition.</center></p>

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