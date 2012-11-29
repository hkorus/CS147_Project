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
	<title>Art</title>
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
	<script src="drawing_canvas.js"></script>
	
	<script src="favorite.js"></script>
	
	<script src="auth.js"></script>
	


</head>
<body>
	
	<script type = "text/javascript" >
	function send_favorite(id){
		if(<?php echo $fb_user ?>) {
			var button = $(".fav_button:last")[0]
			var src =button.src;
			if(src.indexOf('icons/folio-grey-small.png')!=-1){				
				button.src = 'icons/folio-grey-red-small.png';
				var request = new XMLHttpRequest();
				request.open('POST', 'mark_favorite.php', false);
				request.setRequestHeader("Content-type", "application/upload")
				request.send(id); // because of "false" above, will block until the request is done
			}else {
				button.src = 'icons/folio-grey-small.png';
				var request = new XMLHttpRequest();
				request.open('POST', 'undo_favorite.php', false);
				request.setRequestHeader("Content-type", "application/upload")
				request.send(id); // because of "false" above, will block until the request is done
			}
		                // and status is available. Not recommended, however it works for simple cases.
		} else {
			alert("Please login to add art to Favorites");
		}
		
	};
	</script>
	<?php include("config.php");
	$id = $_GET["id"];
	$prev = $_GET["prev"];
		
	$query = "SELECT * FROM art";

	if($id != NULL){
		$query = "SELECT * FROM art where id = ".$id;
		
	}
	$result = mysql_query($query);
	$numRows = mysql_num_rows($result);
	
	$selectedRow = rand(0, $numRows-1);
	while($prev!=NULL && $selectedRow==intval($prev)){
		$selectedRow = rand(0, $numRows-1);
	}
	while ($row = mysql_fetch_assoc($result)) {
		if($selectedRow == 0){
	?>

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
    				//</div>
    				echo "</div>";
				}
    		?>
		
			<h1 style="font-family: Courier; font-size: 18px;">motif</h1>

	</div><!-- /header -->
			
	<div data-role="content">
		<table><tr><td>
		<div data-role="controlgroup" data-type="horizontal" class="art-buttons">
			<a  id="art" data-icon="custom" data-role="button" data-theme="a" rel="external" style = "background:#B0B0B0">Art</a></li>
			<a  href="./comments.php?id=<?php echo $row["id"]?>" id="comments" data-icon="custom" data-role="button" data-theme="a" rel="external">View Comments</a>
			
			<a href="./annotate.php?id=<?php echo $row["id"]?>" id="annotate" data-icon="custom" data-role="button"  data-theme="a" rel="external">Annotate</a>
		</div><!-- /controlgroup -->
		</td>
		<td style = "text-align:right;width:50px">
			<table style = "text-align:center"><tr><td>
			<?php 
				$id = $row["id"];
				if($fb_user){ 
					echo "<img class = 'fav_button' src= '";
					$query = "SELECT * FROM fave_art where user_id = ".$fb_user." and art_id = ".$id;
					$result = mysql_query($query);
					$numRows = mysql_num_rows($result);
					if($numRows == 0){
						echo "icons/folio-grey-small.png";
					}else {
						echo "icons/folio-grey-red-small.png";
					} 
					echo "'  onclick = 'send_favorite(".$row['id'].")'>";
			
				}else {echo "<img class = 'fav_button' src= 'icons/folio-grey-small.png' onclick = 'send_favorite(".$row['id'].")'>";}
			
			?>
			</td></tr>
			<tr><td>Favorite!</td></tr>
			</table>
			
			</td></tr></table>
			
		
			<p style="font-family: Courier; font-size: 16px;"><b><?php echo $row["title"]; ?> </b> 
					(<?php echo $row["year"]; ?>)	
					- 
 				  <?php	echo $row["artist"]; ?></p>
			
			<?php
			   	echo "<img src='".$row["image_source"]."' alt = 'Image not found' width ='99%'>";
			?>
			
			
			
			<?php
			 
			 	}
				$selectedRow--;
			}
			?>
			
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
	
	<?php
	if($numRows > 1 ){
		$rand = $numRows;
	}else{
		$query = "SELECT COUNT(*) AS 'num' FROM art";
		$result = mysql_query($query);
		$row = mysql_fetch_assoc($result);
		$rand = $row["num"];
	}

	?>
	
	<script type = "text/javascript">
		function refresh(){
			var num = Math.floor(Math.random() * <?php echo $rand ?>) + 1;
			window.location="art.php?id="+num+"&prev=<?php echo $id?>";
		}
	</script>

	<div data-role="footer" data-id="samebar" class="menubar" data-position="fixed" data-tap-toggle="false">
		<div data-role="navbar" class="menubar" data-grid="c">
		<ul>
			<li><a href="./home.php" id="home" data-icon="custom" rel="external">Home</a></li>
			<li><a onclick = "refresh()" id="art" data-icon="custom" rel="external">Random Art</a></li>
			<li><a href="./favorites.php" id="favorites" data-icon="custom" rel = "external">My Folio</a></li>
			<li><a href="./help.php" id="help" data-icon="custom" rel="external">Help</a></li>
		</ul>
		</div><!-- /navbar -->
	</div><!-- /footer -->
	
</div><!-- /page -->

</body>

</html>