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
	<title>Comment</title>
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
	<script src="isotope-master/jquery.isotope.min.js"></script>
	
	<script src = "drawing_canvas.js"></script>
	<script src="auth.js"></script>
	
		<div id="fb-root"></div>
		<script>
			$(document).bind('pageinit', function() {
    				var e = document.createElement('script'); e.async = true;
       				e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
        			document.getElementById("fb-root").appendChild(e);
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
</head>
<body>

<div data-role="page">

	<div data-role="header">
	
		<a href="javascript:history.go(-1)" id="goback" data-icon="custom" rel = "external">Back</a>
	<?php
				if(!$fb_user){
					echo "<div style='position: absolute; right: 0px; top: 0; margin: 11px;'>";
     				//<div class="show_when_not_connected">
        			echo "<a onclick='promptLogin()' class='login-button'>"; 
       				echo "<span>Login</span>";
      				echo "</a>";
    				echo "</div>";
				}
    		?>
				<?php

				include("config.php");
				$id = $_GET["id"];
				$query = "SELECT * FROM comments where comment_id = ".$id;
				
				$result = mysql_query($query);
				$row = mysql_fetch_assoc($result);
				
				$artQuery = "SELECT * FROM art where id = ".$row["art_id"];
				
				$artResult = mysql_query($artQuery);
				$artPiece = mysql_fetch_assoc($artResult);

						?>
			<h1 style="font-family: Courier; font-size: 18px;">motif</h1>

	</div><!-- /header -->
			
	<div data-role="content">

		<div data-role="controlgroup" data-type="horizontal" class="art-buttons">
			<a href="./art.php?id=<?php echo $row["art_id"]?>" id="art" data-icon="custom" data-role="button" data-theme="a" rel="external">Art</a></li>
			<a href="./comments.php?id=<?php echo $row["art_id"]?>" id="comments" data-icon="custom" data-role="button" data-theme="a" rel="external">Comments</a>
			<a href="./annotate.php?id=<?php echo $row["art_id"]?>" id="annotate" data-icon="custom" data-role="button"  data-theme="a" rel="external">Annotate</a>
		</div><!-- /controlgroup -->
			
			<?php
					echo "<p style = 'font-family: Courier; font-size: 18px;'>".$row["comment"]."</p>";
					
			?>
			<canvas class="displayCanvas" ></canvas>
			<div id = "container" style = "display:none">
				<img id = "artPiece" src = <?php echo "'".$artPiece["image_source"]."'" ?> ></img>
				<img id = "annotation" src = <?php echo "'".$row["annotation"]."'" ?> ></img>
			</div>
			
			
		
		
	</div><!-- /content -->
	
	<?php

		$query = "SELECT COUNT(*) AS 'num' FROM art";
		$result = mysql_query($query);
		$newRow = mysql_fetch_assoc($result);
		$rand = $newRow["num"];
	

	?>

	<script type = "text/javascript">
	
	$( function(){
		var $container = $('#container');
		$container.imagesLoaded( function(){
			var backgroundImg = $('#artPiece')[0]
			var img = $('#annotation')[0]
			var canvas = $(".displayCanvas:last")[0];
			canvas.width = img.width;			
			canvas.height = img.height;
			var context = canvas.getContext("2d");	
			context.drawImage(backgroundImg, 0, 0, canvas.width, canvas.height)
			context.drawImage(img, 0, 0, canvas.width, canvas.height)			
				
		});
	});	
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

	<div data-role="footer" data-id="samebar" class="menubar" data-position="fixed" data-tap-toggle="false">
		<div data-role="navbar" class="menubar" data-grid="c">
		<ul>
			<li><a href="./home.php" id="home" data-icon="custom" rel="external">Home</a></li>
			<li><a href = "./art.php" id="art" data-icon="custom" rel="external">Random Art</a></li>
			<li><a href="./favorites.php" id="favorites" data-icon="custom" rel="external">Favorites</a></li>
			<li><a href="./help.php" id="help" data-icon="custom" rel="external">Help</a></li>
		</ul>
		</div><!-- /navbar -->
	</div><!-- /footer -->
	
</div><!-- /page -->
</body>

</html>