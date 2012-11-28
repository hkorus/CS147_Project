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

	<script type="text/javascript" src="drawing_canvas.js"></script>
	<script src="favorite.js"></script>


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
	<script src='spectrum.js'></script>
	<script src="auth.js"></script>
	<link rel='stylesheet' href='spectrum.css' />


	<style type="text/css" media="screen">
	.drawingCanvas{ display:block; background-size: 100%;}
	table, td, tr {
		margin:0px;
		padding:0px;
		border-collapse:collapse;
	}

	</style>


</head>
<body>



<script type = "text/javascript">
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
function saveComment(){
	if(<?php echo $fb_user?>){
		save();
		window.location = "./comments?id=<?php echo $row['id']?>";
	}else {
		alert("You must be logged in to comment!");
	}
};

function clearComment(element) {
	element.value = '';

}

</script>

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

<div data-role="content" id = "container">


	<table><tr><td>

		<div data-role="controlgroup" data-type="horizontal" class="art-buttons">
			<a href="./art.php?id=<?php echo $row["id"]?>" id="art" data-icon="custom" data-role="button" data-theme="a" rel="external">Art</a></li>
			<a href="./comments.php?id=<?php echo $row["id"]?>" id="comments" data-icon="custom" data-role="button" data-theme="a" rel="external">View Comments</a>
			<a  id="annotate" data-icon="custom" data-role="button" data-theme="a" rel="external" style = "background:#B0B0B0">Annotate</a>
		</div><!-- /controlgroup -->

	</td>
	<td style = "text-align:right;width:50px">

		<?php 

	if($fb_user){ 
		echo "<img class = 'fav_button' src= '";
		$id = $row["id"];
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
	</td></tr></table>
	<table style = "width:99%;border-collapse:collapse;">
		<tr>
			<td>
				<canvas class="drawingCanvas"></canvas>
			</td>
			<td style = "background-color:#E0E0E0;vertical-align;text-align: center;">	
				<p></p>
				<div style = 'padding-bottom:10px'>Undo</div>
				<div><img src = "icons/undo.png" width = "50px" onclick = "undo()"></div>
				<div style = 'padding-bottom:10px;padding-top:10px'>Brush Size</div>
				
				<div><canvas class="extralarge" height = "60px" width = "70px"  onclick = "changeSize(50)"></canvas></div>
				<div ><canvas class="large" height = "50px" width = "70px"  onclick = "changeSize(20)"></canvas></div>
				<div><canvas style = "background-color:#B0B0B0;" class="medium" height = "40px" width = "70px"  onclick = "changeSize(10)" ></canvas></div>
				<div><canvas class="small" height = "30px" width = "70px" onclick = "changeSize(3)"></canvas></div>
				<div style = 'padding-bottom:10px;padding-top:10px'>Color</div>
				
					<div style = "text-align: center;"><input name='color' class = "colorPicker" id = 'colorPicker' onchange = "changeColor()"/></div>
				</div>




			</td>
		</tr>
		<tr>
			<td style = "background-color:#B0B0B0;padding:7px">

				<textarea class="commentBox" cols="100" rows="100" onclick = "clearComment(this)">Type comments here!</textarea>
			</td>
			<td style = "width:70px;background-color:#B0B0B0;vertical-align:center;text-align:center">	
				<img src = "icons/post-to-motif.png" style="width:60px;height:60px" onclick="saveComment()">
			</td>
		</tr>
	</table>

	<?php
}
?>

<script type="text/javascript"> 
$(document).bind('pageinit', function() {
	//alert( document.URL );

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
			<li><a href="./art.php?prev=<?php echo $_GET['id']?>" id="art" data-icon="custom" rel="external">Random Art</a></li>
			<li><a href="./favorites.php" id="favorites" data-icon="custom" rel="external">My Folio</a></li>
			<li><a href="./help.php" id="help" data-icon="custom" rel="external">Help</a></li>
		</ul>

	</div><!-- /navbar -->
</div><!-- /footer -->

</div><!-- /page -->

</body>

</html>