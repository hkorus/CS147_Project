<!DOCTYPE html>
<head>
	<title>Home Page</title>
	<meta charset="utf-8">
	<meta name="apple-mobile-web-app-capable" content="yes">
 	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 

	<link rel="stylesheet" href="jquery.mobile-1.2.0.css" />
	<link rel="stylesheet" href="style.css" />
	<link rel="apple-touch-icon" href="appicon.png" />
	<link rel="apple-touch-startup-image" href="startup.png">
	
	<script src="jquery-1.8.2.min.js"></script>
	<script src="jquery.mobile-1.2.0.js"></script>
	
	<script>
    	window.fbAsyncInit = function() {
      		FB.init({ appId: '291103611004949',
      		status: true,
      		cookie: true,
      		xfbml: true,
      		oauth: true});
 
      		FB.Event.subscribe('auth.statusChange', handleStatusChange);	
    	};
  	</script>
  	
  <script>
  	function handleStatusChange(response) {
     document.body.className = response.authResponse ? 'connected' : 'not_connected';
    
     if (response.authResponse) {
       console.log(response);
       updateUserInfo(response);
     }
   	}
   </script>
   
   <div id="login">
     <p><button onClick="loginUser();">Login</button></p>
   </div>
   <div id="logout">
     <div id="user-info"></div>
     <p><button  onClick="FB.logout();">Logout</button></p>
   </div>
   
  <script>
    function loginUser() {    
      FB.login(function(response) { }, {scope:'email'});  	
    }
  </script>
  
</head>
<body>
	
<div data-role="page">
	<div data-role="header">
		<h1>Motif</h1>
		
	</div><!-- /header -->
	
	<div data-role="content">

		<p>HOMIE PAGE</p>
	</div><!-- /content -->
		
	<div data-role="footer" data-id="samebar" class="menubar" data-position="fixed" data-tap-toggle="false">
		<div data-role="navbar" class="menubar" data-grid="c">
		
		<ul>
			<li><a href="./art.php" id="art" data-icon="custom">Art</a></li>
			<li><a href="./favorites.php" id="favorites" data-icon="custom">Favorites</a></li>
			<li><a href="./help.php" id="help" data-icon="custom">Help</a></li>
		</ul>
		</div><!-- /navbar -->
	</div><!-- /footer -->
	
</div><!-- /page -->

</body>

</html>