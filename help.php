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
		<h1 style="font-family: Andale Mono; font-size: 18px;">motif</h1>
		<a href="javascript:history.go(-1)" id="goback" data-icon="custom" rel = "external">Back</a>
		<div style="position: absolute; right: 0px; top: 0; margin: 11px;">
     		<div class="show_when_not_connected">
        		<a onclick="promptLogin()" class="login-button"> 
       				<span>Login</span>
      			</a>
    		</div>
      	</div>
	</div><!-- /header -->
	
	<div data-role="content">
		<h1><center>mo·tif /mōˈtēf/</center></h1>
		<p><center>(noun): a distinctive feature or dominant idea in an artistic composition.</center></p>
		
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

				<div class="show_when_connected">
					<div style="position: absolute; right: 0px; top: 0; margin: 11px;">
						<a class="login-button" onclick="logout()">
							<span>Logout</span>
						</a>
						<?php
							$facebook->destroySession();
						?>
					</div>
				</div>

	</div><!-- /content -->

	<div data-role="footer" data-id="samebar" class="menubar" data-position="fixed" data-tap-toggle="false">
		<div data-role="navbar" class="menubar" data-grid="c">
			<ul>
				<li><a href="./home.php" id="home" data-icon="custom" rel="external">Home</a></li>
				<li><a href="./art.php" id="art" data-icon="custom" rel="external">Random Art</a></li>
				<li><a href="./favorites.php" id="favorites" data-icon="custom" rel="external">Favorites</a></li>
				<li><a onclick = "window.location.reload()" id="help" data-icon="custom" rel="external">Help</a></li>
			</ul>
		</div><!-- /navbar -->
	</div><!-- /footer -->


</div><!-- /page -->
<script src="auth.js"></script>
</body>
</html>