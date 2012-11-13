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
	<script src="drawing_canvas.js"></script>
	<script src="isotope-master/jquery.isotope.min.js"></script>
	
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
		$query = "SELECT * FROM comments, art WHERE art_id = id and art_id = ".$_GET['id']." ORDER BY rating DESC";
		$result = mysql_query($query);

		?>				

		<h1 style="font-family: Courier; font-size: 18px;">motif</h1>

	</div><!-- /header -->

	<script type = "text/javascript">
	function send_rating(comment, amount, rowNum){

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
		if(amount > 0){
			if(rowNum  == 0) return;
			var table = document.getElementById("commentTable");
			var prevRow = table.rows[rowNum-1];
			var innerTable = prevRow.firstChild.firstChild.nextSibling;
			var prevVal = innerTable.rows[1].firstChild.innerHTML;
			var curRow = table.rows[rowNum];
			if(num.innerHTML > prevVal){
				var parent = curRow.parentNode;
				var prevParent = prevRow.parentNode;
				parent.removeChild(curRow);
				prevParent.removeChild(prevRow);
				//prevParent.appendChild(prevRow);
				//parent.appendChild(curRow);
				//alert("hey")
			}
		}
	       	

	}
	</script>


	<div data-role="content">

		<div data-role="controlgroup" data-type="horizontal" class="art-buttons">
			<a href="./art.php?id=<?php echo $_GET["id"]?>" id="art" data-icon="custom" data-role="button" data-theme="a" rel="external">Art</a></li>
			<a  id="comments" data-icon="custom" data-role="button" data-theme="a" rel="external" style = "background:#B0B0B0">Comments</a>
			<a href="./annotate.php?id=<?php echo $_GET["id"]?>" id="annotate" data-icon="custom" data-role="button" data-theme="a" rel="external">Annotate</a>
		</div><!-- /controlgroup -->
		<p></p>
		<table id = "commentTable" class="bottomBorder" style="text-align:center; width:100%;height:100%">
			

			<?php
		$arr = array();
		$image = "";
		if(mysql_num_rows($result)>0){	 
			
			echo "<tr>";
			echo "<th>Rate!</th>";
			echo "<th>Annotation</th>";
			echo "<th>Comment</th>";
			echo "<th>Check it out!</th>";
			echo "</tr>";
			
			while($row = mysql_fetch_assoc($result)) {
				
				$rowNum = 1;
				$image = $row['image_source'];
				
						
				echo "<tr id = '".$row["comment_id"]."'><td style='border-collapse:collapse; border-bottom:1px dotted black;padding:5px;'>";


				?>
				<table class="noBorder" style="width:20%"><tr>
					<td style="padding-left:15px; padding-right:15px;"><img class = "up-<?php echo $row["comment_id"] ?>" src = "icons/up_arrow.png" width = "40px" onclick = "send_rating(<?php echo $row["comment_id"] ?>, 1, <?php echo $rowNum ?>)"></td></tr>

					<tr><td class = "number-<?php echo $row["comment_id"] ?>" style="padding-left:15px; padding-right:15px; font-size:18px;"><?php echo $row["rating"]; ?></td></tr>

					<tr><td style="padding-left:15px; padding-right:15px;"><img class = "down-<?php echo $row["comment_id"] ?>" src = "icons/down_arrow.png" width = "40px" onclick = "send_rating(<?php echo $row["comment_id"] ?>,-1, <?php echo $rowNum ?>)"></td></tr>
					</table>

				</td>
				<td style="border-collapse:collapse; border-bottom:1px dotted black;padding:5px;">
					<?php

				echo "<a href = 'show_comment.php?id=".$row["comment_id"]."' rel='external'><canvas class = 'canvas-".$row["comment_id"]."' ></canvas></a>";
				array_push($arr, $row["comment_id"]);
				array_push($arr, $row["annotation"]);
				
				echo "<img class = 'background' src = '".$image."' style = 'display:none' ></img>";
				echo "<img class = 'image-".$row["comment_id"]."' src = '".$row["annotation"]."' style = 'display:none' ></img>";
				
				?>


			</td>
			<td style = "width:40%; border-collapse:collapse; border-bottom:1px dotted black;padding:5px;"> 
				<?php
			echo $row["comment"];
			$rowNum++;
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

	
			
			$( function(){
				var $container = $('#commentTable');
				array = new Array(<?php 
					for ($i=0; $i< count($arr); $i+=2)
					{
						echo "'".$arr[$i]."'";
						if($i!= count($arr)-2){
							echo ",";
						}
					}

					?>);
				$container.imagesLoaded( function(){
					var backgroundImg = $('.background:last')[0]
					
					
					for (var i=0;i<array.length;i++){
						var newCanvas = $(".canvas-"+array[i]+':last')[0]
						
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
			<li><a href="./favorites.php" id="favorites" data-icon="custom" rel="external">My Folio</a></li>
			<li><a href="./help.php" id="help" data-icon="custom" rel="external" >Help</a></li>
		</ul>
	</div><!-- /navbar -->
</div><!-- /footer -->


</div><!-- /page -->

</body>

</html>