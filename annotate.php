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
	<title>Annotation</title>
	<meta charset="utf-8">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 

	<link rel="stylesheet" href="jquery.mobile-1.2.0.css" />
	<link rel="stylesheet" href="style.css" />
	<link rel="stylesheet" href="fbstyle.css" />
	<link rel="apple-touch-icon" href="icons/icon2.png" />
	<link rel="apple-touch-startup-image" href="images/logo.png">
	
	

	<?php

include("config.php");
$query = "SELECT * FROM art WHERE id = '$_GET[id]'";
$result = mysql_query($query);
if($result!=false){
	$row = mysql_fetch_assoc($result);
?>
	<script src="jquery-1.8.2.min.js"></script>
	<script src="jquery.mobile-1.2.0.js"></script>
	<script type="text/javascript" src="drawing_canvas.js"></script>
	<script src='spectrum.js'></script>
	<script src="auth.js"></script>
	<link rel='stylesheet' href='spectrum.css' />
	
	
	<style type="text/css" media="screen">
    	.drawingCanvas{ display:block; background-size: 100%;}
		table, td, tr {
			margin:0;
			padding:0;
			border-collapse:collapse;
		}

  	</style>

	
</head>
<body>
	
	


	<div data-role="page">
		<div data-role="header">
			<h1 style="font-family: Andale Mono; font-size: 18px;">motif</h1>
			<a href="javascript:history.go(-1)" id="goback" data-icon="custom">Back</a>
			<div style="position: absolute; right: 0px; top: 0; margin: 11px;">
     			<div class="show_when_not_connected">
        			<a onclick="promptLogin()" class="login-button"> 
       					<span>Login</span>
      				</a>
    			</div>
      		</div>
		</div><!-- /header -->

			<div data-role="content" id = "container">
				
			
				
					<div data-role="controlgroup" data-type="horizontal" class="art-buttons">
						<a href="./art.php?id=<?php echo $row["id"]?>" id="art" data-icon="custom" data-role="button" data-theme="a">Art</a></li>
						<a href="./comments.php?id=<?php echo $row["id"]?>" id="comments" data-icon="custom" data-role="button" data-theme="a">Comments</a>
						<a href="./annotate.php?id=<?php echo $row["id"]?>" id="annotate" data-icon="custom" data-role="button" data-theme="a">Annotate</a>
					</div><!-- /controlgroup -->
					<table style = "width:600px;">
						<tr>
							<td style>
							<canvas class="drawingCanvas"></canvas>
							<td>
						<td style = "padding:2px;background-color:#E0E0E0;vertical-align;text-align: center;"">	
								<p></p>
								<div><img src = "icons/undo.png" width = "50px" onclick = "undo()"></div>
								<div><canvas class="extralarge" height = "60px" width = "70px"  onclick = "changeSize(50)"></canvas></div>
							<div ><canvas class="large" height = "50px" width = "70px"  onclick = "changeSize(20)"></canvas></div>
								<div><canvas style = "background-color:#B0B0B0;" class="medium" height = "40px" width = "70px"  onclick = "changeSize(10)" ></canvas></div>
								<div><canvas class="small" height = "30px" width = "70px" onclick = "changeSize(3)"></canvas></li>
								<div style = "text-align: center;"><input type='color' name='color' class = "colorPicker" onchange = "changeColor()"/></div>
							</div>
							



						</td>
					</tr>
					<tr>
						<td style = "background-color:#B0B0B0;padding:7px">
							<textarea class="commentBox" cols="100" rows="100">
							</textarea>
							</td>
							<td></td>
							<td style = "width:70px;background-color:#B0B0B0;vertical-align:center;">	
								<img src = "icons/post.png" style="width:60px;height:60px" onclick="save()">
						</td>
						</tr>
				</table>

					<?php
				}
				?>

				<script type="text/javascript"> 
				$(document).bind('pageinit', function() {
					<?php

					echo "prepareCanvas('".$row["image_source"]."', ".$row["id"].")";

					?>
				});
				</script>
				
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
			<li><a href="./home.php" id="home" data-icon="custom">Home</a></li>
			<li><a href="./art.php" id="art" data-icon="custom">Random Art</a></li>
			<li><a href="./favorites.php" id="favorites" data-icon="custom" >Favorites</a></li>
			<li><a href="./help.php" id="help" data-icon="custom">Help</a></li>
		</ul>

		</div><!-- /navbar -->
	</div><!-- /footer -->

</div><!-- /page -->

</body>

</html>