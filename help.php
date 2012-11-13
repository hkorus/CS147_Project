<?php
	require './facebook.php';
	$facebook = new Facebook(array(
		'appId'  => '291103611004949',
  		'secret' => '226db60e672abf202f1424b1084fc38e',
      	'cookie' => true));
      	
    $fb_user = $facebook->getUser();
?>

<!DOCTYPE html>
<head>
	<title>Help</title>
	<meta charset="utf-8">
	<meta name="apple-mobile-web-app-capable" content="yes">
 	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 

	<link rel="stylesheet" href="jquery.mobile-1.2.0.css" />
	<link rel="stylesheet" href="style.css" />
	<link rel="stylesheet" href="fbstyle.css" />
	<link rel="apple-touch-icon" href="icons/icon2.png" />
	<link rel="apple-touch-startup-image" href="images/logo.png">
	
	<script src="jquery-1.8.2.min.js"></script>
	<script src="jquery.mobile-1.2.0.js"></script>
	
</head>
<body>

<div data-role="page">

	<div data-role="header">
		<h1 style="font-family: Courier; font-size: 18px;">motif</h1>
		<a href="javascript:history.go(-1)" id="goback" data-icon="custom" rel = "external">Back</a>

			<?php
				if(!$fb_user){
					echo "<div style='position: absolute; right: 0px; top: 0; margin: 11px;'>";
     				//<div class="show_when_not_connected">
        			echo "<a onclick='promptLogin()' class='login-button'>"; 
       				echo "<span>Login</span>";
      				echo "</a>";
    				//</div>
    				echo "</div>";
				}
    		?>
	</div><!-- /header -->
	
	<div data-role="content">
		<h1 style="font-family: Courier; font-size: 25px;"><center>mo·tif /mōˈtēf/</center></h1>
		<h2><center>(noun): a distinctive feature or dominant idea in an artistic composition.</center></h2>
		<br>
		<h3><center>Home</center></h3>
		<p><center>Search for art by artist name in the search text field.
		<br> Not sure what you want to view? Try clicking for Random Art.</center></p>
		<br>
		<h3><center>Favorites</center></h3>
		<p><center>Login and keep track of artwork that interests you on your favorites page.
		<br>Add art to your favorites by clicking the heart icon when on the art viewing page.</center></p>
		<br>
		<h3><center>Art and Random Art</center></h3>
		<p><center>View art! Art that you searched for or art selected randomly.</center></p>
		<br>
		<h3><center>Comments</h3>
		<p><center>Read other viewers' comments and annotations on a particular piece.
		<br>You can upvote or down vote their comments by clicking the arrows to the left of the comment.</center><p>
		<br>
		<h3><center>Annotate</center></h3>
		<p><center>Markup the artwork by choosing a style-tip and color on the right.
		<br>Draw your commentary, highlight details, add, enhance, deface, have fun.</center></p>
		
		<div id="fb-root"></div>
		<script>
			$(document).bind('pageinit', function() {
    				var e = document.createElement('script'); e.async = true;
       				e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
        			document.getElementById('fb-root').appendChild(e);
       		}());
		</script>
  	
		<script>
    		window.fbAsyncInit = function() {
     			FB.init({ appId: '291103611004949',
      				status: true,
      				cookie: true,
      				xfbml: true,
     				oauth: true});
 
      			FB.getLoginStatus(handleStatusChange)
    		};
  		</script>

			<?php
				if($fb_user) {
					echo "<div style='position: absolute; right: 0px; top: 0; margin: 11px;'>";
					echo "<a class='login-button' onclick='logout()'>";
					echo "<span>Logout</span>";
					echo "</a>";
					$facebook->destroySession();
					echo "</div>";
				}
			?>

	</div><!-- /content -->

	<div data-role="footer" data-id="samebar" class="menubar" data-position="fixed" data-tap-toggle="false">
		<div data-role="navbar" class="menubar" data-grid="c">
			<ul>
				<li><a href="./home.php" id="home" data-icon="custom" rel="external">Home</a></li>
				<li><a href="./art.php" id="art" data-icon="custom" rel="external">Random Art</a></li>
				<li><a href="./favorites.php" id="favorites" data-icon="custom" rel="external">My Folio</a></li>
				<li><a onclick = "window.location.reload()" id="help" data-icon="custom" rel="external">Help</a></li>
			</ul>
		</div><!-- /navbar -->
	</div><!-- /footer -->


</div><!-- /page -->
<script src="auth.js"></script>
</body>
</html>