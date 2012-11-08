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
	<title>Home Page</title>
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
	
	<script type = "text/javascript">
		function search(){
			var term = document.getElementById("term").value;

			var request = new XMLHttpRequest();
			request.open('POST', 'search.php', false);
			request.setRequestHeader("Content-type", "application/upload")
			request.send(term); // because of "false" above, will block until the request is done
			// and status is available. Not recommended, however it works for simple cases.
			if(request.status == 200){
				
				var html = "";
				var results = document.getElementById("results");
				var text = request.responseText;
				var loc = text.indexOf('|');
				while(loc!=-1){
					var one = text.substring(0, loc)
					var andloc = text.indexOf("&");
					if(andloc == -1) {
						break;
					}
					var id = one.substring(0, andloc);
					var info = one.substring(andloc+1);
					html+= "<a href = 'art.php?id="+id+"'>"+info+"</a><br/>";
					
					text = text.substring(loc+1);
					loc = text.indexOf("|")
				}
				results.innerHTML = html;
			}
		}
	</script>
	  
</head>
<body>
	
	<div data-role="page" id="homepage">
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
	
		<div data-role="content">

			<p style="text-align:center"><img src="images/logo_crop.png"></p>
			<p style="font-family: Andale Mono; font-size: 18px; text-align: center;">discover art, draw your commentary</p>
			<br></br>
			
			<div class="search" style="width:75%">
   				<input type="text" name="term" id = "term"/>
					<input type="submit" name="submit" value="Search!" onclick = "search()"/>
					<div id = "results" style="height:120px;border:1px solid #ccc;font:16px/26px Georgia, Garamond, Serif;overflow:auto;">

					</div>
			</div><!-- /search -->
			
			
			<div id="fb-root"></div>
			
			<script>
  				(function() {
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
					<li><a href="./favorites.php" id="favorites" data-icon="custom">Favorites</a></li>
					<li><a href="./help.php" id="help" data-icon="custom">Help</a></li>
				</ul>
			</div><!-- /navbar -->
		</div><!-- /footer -->
	
	</div><!-- /page -->
	
	<script src="auth.js"></script>

</body>

</html>
