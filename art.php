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

</head>
<body>
	
<div data-role="page">
	<div data-role="header">
		<h1>Art</h1>
		
	</div><!-- /header -->
	
	<div data-role="content">
		<p>Art Page</p>

	<div data-role="footer" data-id="samebar" data-position="fixed" data-tap-toggle="false">
		<div data-role="navbar" data-grid="c">
					<ul>
			<li><a href="./annotate.php" id="draw" data-icon="custom">Annotate</a></li>
			<li><a href="./comments.php" id="comment" data-icon="custom">Comments</a></li>
			<li><a href="./favorites.php" id="favorites" data-icon="custom">Favorites</a></li>
			<li><a href="./help.php" id="help" data-icon="custom">Help</a></li>
		</ul>
		</div><!-- /navbar -->
	</div><!-- /footer -->
	
</div><!-- /page -->
</body>

</html>