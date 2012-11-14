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
	<script src="isotope-master/jquery.isotope.min.js"></script>
	
	<script src="jquery.mobile-1.2.0.js"></script>
	<script src="auth.js"></script>
	
	<script>
		function deleteComment(id){
			if(<?php echo $fb_user ?>) {
				var confirmDelete = confirm("Are you sure you want to delete this comment?");
				if (confirmDelete) {
					var request = new XMLHttpRequest();
					request.open('POST', 'delete_comment.php', false);
					request.setRequestHeader("Content-type", "application/upload")
					request.send(id); // because of "false" above, will block until the request is done
					window.location.reload();
				}
			}
		}
	</script>

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
				$query = "SELECT * FROM comments where user_id = ".$fb_user." ORDER BY rating DESC";
				
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

		<table>
			<tr>
				<td>
					<div>
						<p style='margin-left:10px;font-family: Courier, san-serif; font-size: 20px;'><a href="./favorites.php" rel="external" style = 'text-decoration:none;font-weight:normal;color:#000000'>Favorites</a></p>
					</div>
				</td>
				<td width = '40px'></td>
				<td> 
					<p style='margin-left:10px;font-family: Courier, san-serif; font-size: 30px;text-decoration:underline;font-weight:bold;'>My Comments</p>
					</td>
			</tr>
		</table>
		<table class="bottomBorder" style="text-align:center; width:100%;" id = "commentTable">
			 
			<?php
		$arr = array();
		if(mysql_num_rows($result)>0){	
			
			echo "<tr>";
			echo "<th>Manage</th>";
			echo "<th>Rating</th>";
			echo "<th>Title, Year, Artist</th>";
			echo "<th>Annotation</th>";
			echo "<th>Comment</th>";
			echo "<th>Check it out!</th>";
			echo "</tr>";

			while($row = mysql_fetch_assoc($result)) {
				
				$artQuery = "SELECT * FROM art where id = ".$row["art_id"];
				
				$artResult = mysql_query($artQuery);
				$artPiece = mysql_fetch_assoc($artResult);
				
				echo "<tr>";
				?>

				<td style="border-collapse:collapse; border-bottom:1px dotted black; padding-left:15px; padding-right:15px; font-size:18px; font-weight:bold; width:10%;"> <a data-role="button" data-theme="a" style="float:right; margin:0px;" onclick=<?php echo "deleteComment(".$row["comment_id"].")"?>>delete</a></td>
				<td style="border-collapse:collapse; border-bottom:1px dotted black; padding-left:15px; padding-right:15px; font-size:18px; font-weight:bold; width:10%;"> <?php echo $row["rating"]; ?></td>
				
				       <td style="border-collapse:collapse; border-bottom:1px dotted black; font-size:15px; width:20%;"> 
				 		
				     <?php 
				        echo "<b>";
				        echo $artPiece["title"]."</b> <br>(". $artPiece["year"].") <br> ".$artPiece["artist"];
				        ?>
				       </td>
				
				<td style="border-collapse:collapse; border-bottom:1px dotted black;padding:5px;">
					<?php

				echo "<canvas onclick = 'see_comment(".$row["comment_id"].")' class = 'canvas-".$row["comment_id"]."' width = '25%'></canvas>";
				array_push($arr, $row["comment_id"]);
				
					echo "<img class = 'background-".$row["comment_id"]."' src = '".$artPiece["image_source"]."' style = 'display:none' ></img>";
					echo "<img class = 'image-".$row["comment_id"]."' src = '".$row["annotation"]."' style = 'display:none' ></img>";

				?>


			</td>
			<td style = "width:40%; border-collapse:collapse; border-bottom:1px dotted black;padding:5px;"> 
				<?php
			echo $row["comment"];

			?> 

		</td>
		<td style = "width:30%; border-collapse:collapse; border-bottom:1px dotted black;padding:5px;"> 
			<a href = "show_comment.php?id=<?php echo $row["comment_id"] ?>" rel="external"> <img src = "icons/side_arrow.png" width = "50" height = "50" ></img> </a>
		</td>
	</tr>	
	<?php } } else {?>

	</table>
	<?php 
	if($fb_user) {
	
		echo "<br/>";
		echo "<div style = 'padding-left:15px;font-size:15px'>No comments yet!</div>"; 
	}
		}?>


<script type = 'text/javascript'>

		function yscale(width, img){
			var ratio = width/img.width;
			return ratio * img.height;
		}

	
			
			$( function(){
				var $container = $('#commentTable');
				array = new Array(<?php 
					for ($i=0; $i< count($arr); $i++)
					{
						echo "'".$arr[$i]."'";
						if($i!= count($arr)-1){
							echo ",";
						}
					}

					?>);
				$container.imagesLoaded( function(){	
				
					
					for (var i=0;i<array.length;i++){
						var newCanvas = $(".canvas-"+array[i]+':last')[0]
						var backgroundImg = $(".background-"+array[i]+':last')[0]
						var img = $(".image-"+array[i]+':last')[0]
												
						context = newCanvas.getContext('2d');
						newCanvas.width = 300;
						newCanvas.height = yscale(newCanvas.width, img)
						
						context.drawImage(backgroundImg, 0, 0, newCanvas.width, newCanvas.height);
						context.drawImage(img, 0, 0,  newCanvas.width, newCanvas.height);
						
						
						
					}
					});		

				
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