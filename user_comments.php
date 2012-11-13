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
	<title>My Comments</title>
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
	<script src="drawing_canvas.js"></script>
	
	<script src="jquery.mobile-1.2.0.js"></script>
	<script src="auth.js"></script>

</head>
<body>

	<div data-role="page">

		<div data-role="header">
			<a href="javascript:history.go(-1)" id="goback" data-icon="custom">Back</a>
			<div style="position: absolute; right: 0px; top: 0; margin: 11px;">
     			<div class="show_when_not_connected">
        			<a onclick="promptLogin()" class="login-button"> 
       					<span>Login</span>
      				</a>
    			</div>
      		</div>
			
			<?php

		include("config.php");
				$id = $_GET["id"];
				$query = "SELECT * FROM comments where user_id = ".$fb_user;
				
				$result = mysql_query($query);				
				

		?>
						

		<h1 style="font-family: Courier; font-size: 18px;">motif</h1>

	</div><!-- /header -->

	<script type = "text/javascript">
	function send_rating(comment, amount){

		var up = $(".up-"+comment+':last')[0]
		var down = $(".down-"+comment+':last')[0]

		if(amount > 0){
			up.src = "icons/selected_up_arrow.png"
		}else{
			down.src = "icons/selected_down_arrow.png"
		}
		up.onclick = "";
		down.onclick = "";
		var num = $(".number-"+comment+':last')[0]
		num.innerHTML = ""+(parseInt(num.innerHTML)+amount)

		var request = new XMLHttpRequest();
		request.open('POST', 'rate_image.php', false);
		request.setRequestHeader("Content-type", "application/upload")
		request.send(comment+"&"+amount); // because of "false" above, will block until the request is done
		// and status is available. Not recommended, however it works for simple cases.

	}
	
	function see_comment(commentId){
		window.location="./show_comment?id="+commentId;
	}
	</script>


	<div data-role="content">

		<p style='margin-left:10px;font-family: Courier, san-serif; font-size: 25px;'>My Comments</p>
		<table class="bottomBorder" style="text-align:center; width:100%;">
		
			<?php
		$arr = array();
		if(mysql_num_rows($result)>0){	
			
			while($row = mysql_fetch_assoc($result)) {
				
				$artQuery = "SELECT * FROM art where id = ".$row["art_id"];
				
				$artResult = mysql_query($artQuery);
				$artPiece = mysql_fetch_assoc($artResult);
				
				echo "<tr>";
				?>
				
				<td style="border-collapse:collapse; border-bottom:1px dotted black;padding:5px;">
					<?php

				echo "<canvas onclick = 'see_comment(".$row["comment_id"].")' class = 'canvas-".$row["comment_id"]."' width = '30%'></canvas>";
				array_push($arr, $row["comment_id"]);
				array_push($arr, $row["annotation"]);
				array_push($arr, $artPiece["image_source"]);

				?>


			</td>
			<td style = "width:40%; border-collapse:collapse; border-bottom:1px dotted black;padding:5px;"> 
				<?php
			echo $row["comment"];

			?> 

		</td>
		<td style = "width:10%; border-collapse:collapse; border-bottom:1px dotted black;padding:5px;">
			<a href = "show_comment.php?id=<?php echo $row["comment_id"] ?>" rel="external"> <img src = "icons/side_arrow.png" width = "50" height = "50" ></img> </a>
		</td>
	</tr>	
	<?php } } else {?>

	</table>
	<?php 
echo "<br/>";
echo "<div style = 'padding-left:15px;font-size:15px'>No comments yet!</div>"; }?>


<script type = 'text/javascript'>

		function yscale(width, img){
			var ratio = width/img.width;
			return ratio * img.height;
		}

		var canvasList = new Array();
		var ready = 0;

		function createCanvases(){
			ready++;
			if(ready > array.length/3){
				
				
				for(var j = 0; j<canvasList.length; j+=3){
					newCanvas = canvasList[j];
					newImg = canvasList[j+1];
					backgroundImg = canvasList[j+2];

					context = newCanvas.getContext('2d');
					newCanvas.width = 200;
					newCanvas.height = yscale(newCanvas.width, newImg)

					context.drawImage(backgroundImg, 0, 0, newCanvas.width, newCanvas.height);
					context.drawImage(newImg, 0, 0,  newCanvas.width, newCanvas.height);
				}
				ready = 0;
			}
			
		}


		$(document).bind('pageinit', function() {
			array = new Array(<?php 
				for ($i=0; $i< count($arr); $i+=3)
				{
					echo "'".$arr[$i]."','".$arr[$i+1]."','".$arr[$i+2]."'";
					if($i!= count($arr)-3){
						echo ",";
					}
				}

				?>);
							
				for (var i=0;i<array.length;i+=3)
				{ 
					newCanvas = $(".canvas-"+array[i]+':last')[0]
					
					canvasList.push(newCanvas);

					newImg = new Image();
					newImg.src = array[i+1];
					canvasList.push(newImg);
					newImg.onload = createCanvases;
					newImg.onerror = createCanvases;
					newImg.onabort = createCanvases;
				
					backgroundImg = new Image();
					backgroundImg.src = array[i+2];	
					canvasList.push(backgroundImg);
					backgroundImg.onload = createCanvases;
					backgroundImg.onerror = createCanvases;
					backgroundImg.onabort = createCanvases;
				}

				
			});


	</script>

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


			
			<?php
				if(!$fb_user) {
					echo "<p style='margin-left:25px;font-family: Courier; font-size: 15px;'>Please login to view your comments!</p>";
				}
			?>


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
			<li><a href="./help.php" id="help" data-icon="custom" rel="external" >Help</a></li>
		</ul>
	</div><!-- /navbar -->
</div><!-- /footer -->


</div><!-- /page -->

</body>

</html>