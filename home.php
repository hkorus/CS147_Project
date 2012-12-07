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
	<title>Home</title>
	<meta charset="utf-8">
	<meta name="apple-mobile-web-app-capable" content="yes">
 	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 

	<link rel="stylesheet" href="jquery.mobile-1.2.0.css" />
	<link rel="stylesheet" href="style.css" />
	<link rel="stylesheet" href="fbstyle.css" />
	<link rel="apple-touch-icon" href="icons/icon2.png" />
	<link rel="apple-touch-startup-image" href="images/logo.png">
	<style type="text/css">
		a:link {
			COLOR: #000000; 
			text-decoration: none;
		}
		a:visited {  
			COLOR: BLACK; 
		}
		a:hover {
			COLOR: grey;
		}
	</style>
	
	<script src="jquery-1.8.2.min.js"></script>
	<script src="jquery.mobile-1.2.0.js"></script>
	<script src="auth.js"></script>
	
	<script type = "text/javascript">
		function search(){
			var term = $(".term:last")[0].value;
			var request = new XMLHttpRequest();
			request.open('POST', 'search.php', false);
			request.setRequestHeader("Content-type", "application/upload")
			request.send(term); // because of "false" above, will block until the request is done
			// and status is available. Not recommended, however it works for simple cases.
			if(request.status == 200){
				
				var html = "";
				var results = $(".results:last")[0];
				results.style.border = "1px solid #ccc";
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
					html+= "<a href= 'art.php?id="+id+"' rel='external'><div style = 'background:#D8D8D8'>"+info+"<br/></div></a>";
					
					text = text.substring(loc+1);
					loc = text.indexOf("|")
				}
				if(html == "") html = " No results!"
				results.innerHTML = html;
			}
		}
	</script>
	<script type = "text/javascript">
		function isEnter(){
			if(event.keyCode == 13){
			        search();
			    }	
		}
		
	</script>
	  
</head>
<body>
	
	<div data-role="page" id="homepage">
		<div data-role="header">
			<h1 style="font-family: Courier; font-size: 18px;">motif</h1>
			
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
	
		<div data-role="content">
			<br/><br/>
			<p style="text-align:center"><img src="images/logo_crop.png"></p>
			<p style="font-family: Courier; font-size: 18px; text-align: center;">discover art, draw your commentary</p>
			<br/>
			<p style="font-size: 14px; overflow:auto; text-align: center;">Art demands participation. Motif lets you participate. <br/> 
			Find art through search and random discovery. Learn from the insight, ideas, <br/> and reactions of peers as you read their comments and annotations. Through <br> annotation, you can add your own perspective and share what you notice. <br/> Go on! Peruse. Interact.</p>
			<br>
			
			<div class="search" style="width:100%;margin-left:auto; margin-right:auto;">
   				<table style = "text-align:center;margin-left:auto; margin-right:auto"><tr><td>
						<input type="text" id = "term" name="term" class = "term" onkeyup = "isEnter()" style="width:400px;"/></td><td>	
							<input type="submit" name="submit" value="Search!" onclick = "search()"/></td></tr>
					</table>
					<div class = "results" style="width:500px;height:120px;font:14px Courier; overflow:auto;margin-left:auto; margin-right:auto">

					</div>
			</div><!-- /search -->
			
			
			<div id="fb-root"></div>
			
			<script>
  				(function() {
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
		
		<div data-role="footer" data-id="samebar" class="menubar" data-position="fixed" data-tap-toggle="false">
			<div data-role="navbar" class="menubar" data-grid="c">
		
				<ul>
					<li><a onclick = "window.location.reload()" id="home" data-icon="custom" rel="external">Home</a></li>
					<li><a href="./art.php" id="art" data-icon="custom" rel="external">Random Art</a></li>
					<li><a href="./favorites.php" id="favorites" data-icon="custom" rel="external">My Folio</a></li>
					<li><a href="./help.php" id="help" data-icon="custom" rel="external">Help</a></li>
				</ul>
			</div><!-- /navbar -->
		</div><!-- /footer -->
	
	</div><!-- /page -->

</body>

</html>
