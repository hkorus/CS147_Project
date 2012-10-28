<!DOCTYPE html>
<head>
	<title>Home Page</title>
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
	
	<div data-role="header">
		<h1>Art</h1>
	</div>
	
	<div data-role="content">	
	<p>HOMIE PAGE</p>

	<p>Gimme dat <a href = "./art.html"> art</a>!</p>
	<p>I already found art I like. Take me to the  <a href = "./favorites.html"> favorites</a>! </p>

	<p>I want some <a href = "./help.html"> help</a></p>
	</div>

	<div data-role="footer" data-id="samebar" class="menu" data-position="fixed" data-tap-toggle="false">
		<div data-role="navbar" class="menu" data-grid="c">
		
		<ul>
			<li><a href="art.html" id="refresh" data-icon="custom">Refresh</a></li>
			<li><a href="home.php" id="search" data-icon="custom" class="ui-btn-active">Search</a></li>
			<li><a href="favorites.html" id="favorites" data-icon="custom">Favorites</a></li>
			<li><a href="comments.html" id="comment" data-icon="custom">Comments</a></li>
			<li><a href="annotate.html" id="draw" data-icon="custom">Draw</a></li>
			<li><a href="help.html" id="help" data-icon="custom">Help</a></li>
			<li><a href="home.php" id="logout" data-icon="custom">Logout</a></li>

		</ul>
		</div>
	</div>
</div>

</body>

</html>