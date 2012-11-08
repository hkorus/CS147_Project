<!DOCTYPE html>
<head>
	<title>Comments</title>
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
		$query = "SELECT * FROM comments, art WHERE art_id = id and art_id = ".$_GET['id']." ORDER BY rating DESC";
		$result = mysql_query($query);

		?>				

		<h1 style="font-family: Andale Mono; font-size: 18px;">motif</h1>

	</div><!-- /header -->

	<script type = "text/javascript">
	function send_rating(comment, amount){

		var up = document.getElementById("up-"+comment);
		var down = document.getElementById("down-"+comment);

		if(amount > 0){
			up.src = "icons/selected_up_arrow.png"
		}else{
			down.src = "icons/selected_down_arrow.png"
		}
		up.onclick = "";
		down.onclick = "";
		var num = document.getElementById("number-"+comment);
		num.innerHTML = ""+(parseInt(num.innerHTML)+amount)

		var request = new XMLHttpRequest();
		request.open('POST', 'rate_image.php', false);
		request.setRequestHeader("Content-type", "application/upload")
		request.send(comment+"&"+amount); // because of "false" above, will block until the request is done
		// and status is available. Not recommended, however it works for simple cases.

	}
	</script>


	<div data-role="content">

		<div data-role="controlgroup" data-type="horizontal" class="art-buttons">
			<a href="./art.php?id=<?php echo $_GET["id"]?>" id="art" data-icon="custom" data-role="button" data-theme="a" rel="external">Art</a></li>
			<a href="./comments.php?id=<?php echo $_GET["id"]?>" id="comments" data-icon="custom" data-role="button" data-theme="a" rel="external">Comments</a>
			<a href="./annotate.php?id=<?php echo $_GET["id"]?>" id="annotate" data-icon="custom" data-role="button" data-theme="a" rel="external">Annotate</a>
		</div><!-- /controlgroup -->
		<p></p>
		<table style = "text-align:center">
			<tr>

				<td><b>Rating</b></td>
				<td><b>Annotation</b></td>
				<td><b>Comment</b></td>

			</tr>	

			<?php
		$arr = array();
		$image = "";
		if(mysql_num_rows($result)>0){	
			while($row = mysql_fetch_assoc($result)) {
				$image = $row['image_source'];
				echo "<tr><td>";

				?> 
				<table ><tr >
					<td style="padding-left:15px;"><img id = "up-<?php echo $row["comment_id"] ?>" src = "icons/up_arrow.png" width = "20px" onclick = "send_rating(<?php echo $row["comment_id"] ?>, 1)"></td></tr>

					<tr><td id = "number-<?php echo $row["comment_id"] ?>" style="padding-left:15px;"><?php echo $row["rating"]; ?></td></tr>

					<tr><td style="padding-left:15px;"><img id = "down-<?php echo $row["comment_id"] ?>" src = "icons/down_arrow.png" width = "20px" onclick = "send_rating(<?php echo $row["comment_id"] ?>,-1)"></td></tr>
					</table>

				</td>
				<td style = "width:150px; text-align:center">
					<?php

				echo "<canvas id = 'canvas-".$row["comment_id"]."' width = '100%'></canvas>
					";
				array_push($arr, $row["comment_id"]);
				array_push($arr, $row["annotation"]);

				?>


			</td>
			<td style = "width:200px"> 
				<?php
			echo $row["comment"];

			?> 

		</td>
		<td style = "width:80px;">
			<a href = "show_comment.php?id=<?php echo $row["comment_id"] ?>"> View </a>
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
		var backgroundImg = new Image();
		var ready = 0;

		function createCanvases(){
			ready++;
			
			if(ready == ((array.length/2)+1)){
				for(var j = 0; j<canvasList.length; j+=2){
					newCanvas = canvasList[j];
					newImg = canvasList[j+1];

					context = newCanvas.getContext('2d');
					newCanvas.width = 200;
					newCanvas.height = yscale(newCanvas.width, newImg)
					context.drawImage(backgroundImg, 0, 0, newCanvas.width, newCanvas.height);
					context.drawImage(newImg, 0, 0,  newCanvas.width, newCanvas.height);
				}
			}
		}


		$(document).bind('pageinit', function() {

			array = new Array(<?php 
				for ($i=0; $i< count($arr); $i+=2)
				{
					echo "'".$arr[$i]."','".$arr[$i+1]."'";
					if($i!= count($arr)-2){
						echo ",";
					}
				}

				?>);

				backgroundImg.src = <?php echo "'".$image."'"; ?>;

				backgroundImg.onload = createCanvases;
				backgroundImg.onerror = createCanvases;
				backgroundImg.onabort = createCanvases;
				
				
				
				for (var i=0;i<array.length;i+=2)
				{ 
					newCanvas = document.getElementById("canvas-"+array[i]);
					canvasList.push(newCanvas);

					newImg = new Image();
					newImg.src = array[i+1];
					canvasList.push(newImg);
					newImg.onload = createCanvases;
					newImg.onerror = createCanvases;
					newImg.onabort = createCanvases;


				}


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
					</div>
				</div>


</div><!-- /content -->


<div data-role="footer" data-id="samebar" class="menubar" data-position="fixed" data-tap-toggle="false">

	<div data-role="navbar" class="menubar" data-grid="c">
		<ul>
			<li><a href="./home.php" id="home" data-icon="custom">Home</a></li>
			<li><a href="./art.php" id="art" data-icon="custom" rel="external">Random Art</a></li>
			<li><a href="./favorites.php" id="favorites" data-icon="custom" rel="external">Favorites</a></li>
			<li><a href="./help.php" id="help" data-icon="custom" rel="external">Help</a></li>
		</ul>
	</div><!-- /navbar -->
</div><!-- /footer -->


</div><!-- /page -->
<script src="auth.js"></script>
</body>

</html>