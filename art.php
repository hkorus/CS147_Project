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
				
			<h1>Art</h1>
			<a href="./comments.php" id="comments" data-icon="custom">Comments</a>
			<a href="./annotate.php" id="annotate" data-icon="custom">Annotate</a>
		
	</div><!-- /header -->
	
	<div id="tabs">
    <ul>
        <li><a href="#tabs-art">Art</a></li>
        <li><a href="#tabs-comments">Comments</a></li>
        <li><a href="#tabs-annotate">Annotate</a></li>
    </ul>
    <div id="tabs-art">
        <p>Art page</p>
    </div>
    <div id="tabs-comments">
        <p>Comments Page</p>
    </div>
    <div id="tabs-annotate">
        <p>Annotation Page</p>
    </div>
</div>
	
	<div data-role="content">
		<p>Art Page</p>
	</div><!-- /content -->

	<div data-role="footer" data-id="samebar" class="menubar" data-position="fixed" data-tap-toggle="false">
		<div data-role="navbar" class="menubar" data-grid="c">
					<ul>

			<li><a href="./art.php" id="art" data-icon="custom">Art</a></li>
			<li><a href="./favorites.php" id="favorites" data-icon="custom">Favorites</a></li>
			<li><a href="./help.php" id="help" data-icon="custom">Help</a></li>
		</ul>
		</div><!-- /navbar -->
	</div><!-- /footer -->
	
</div><!-- /page -->
</body>

</html>