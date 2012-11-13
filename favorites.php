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
	<title>Favorites</title>
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
	
	<script src="isotope-master/jquery.isotope.min.js"></script>
	<script src="auth.js"></script>
	
	
	<script>	
		$( function(){
			var $container = $('#container');
  			
  			$container.imagesLoaded( function(){
	
    			$container.isotope({
    				itemSelector : '.image',
    				sortAscending : false,
    				sortBy : 'time_stamp',
    				masonryHorizontal: {
    					columnWidth: 240,
    				},
    				getSortData : {
    					time_stamp : function ( $elem ) {
      					return $elem.find('.time_stamp').text();
    					},
    					art_id : function ( $elem ) {
    						return parseInt( $elem.find('.art_id').text(), 10 );
    					},
    					title : function ( $elem ) {
    						return $elem.find('.title').text();
    					},
    					artist_display_name : function ( $elem ) {
    						return $elem.find('.artist_display_name').text();
    					},
    					artist_sort_name : function ( $elem ) {
    						return $elem.find('.artist_sort_name').text();
    					}
    				}
    			});
  			});
		});
	</script>
			<div class="fb-root"></div>
		
		<script>
			$(document).bind('pageinit', function() {
    				var e = document.createElement('script'); e.async = true;
       				e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
        			$(".fb-root:last")[0].appendChild(e);
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

	<!--<script>
	$(document).ready( function() {
        	var $container = $('#container');
        	$container.isotope({ 
        		itemSelector : '.image',
    			masonryHorizontal: {
    				columnWidth: 240
    			}
    		});
        });
	</script>-->
	
//	<script>
//		$('#sort-by-id').click(function(){
//  			// get href attribute, minus the '#'
//  			//var sortName = $(this).attr('href').slice(1);
//  			$('#container').isotope({ sortBy : 'art_id' });
//  			return false;
//		});
//	</script>
	<script>
		function sortByArtId() {
  			$('#container').isotope({ 
  				sortBy : 'art_id',
  				sortAscending : true
  			});
		}
	</script>
	<script>
		function sortByTime() {
  			$('#container').isotope({ 
  				sortBy : 'time_stamp',
  				sortAscending : false
  			 });
		}
	</script>
	<script>
		function sortByTitle() {
  			$('#container').isotope({ 
  				sortBy : 'title',
  				sortAscending : true
  			 });
		}
	</script>
	<script>
		function sortByArtist() {
  			$('#container').isotope({ 
  				sortBy : 'artist_sort_name',
  				sortAscending : true
  			 });
		}
	</script>
	
		
</head>
<body>
	
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
    				echo "</div>";
				}
    		?>
      	
	
	</div><!-- /header -->

	<div data-role="content">
		
		<div>
		<p style='margin-left:10px;font-family: Courier, san-serif; font-size: 25px;'>Favorites</p>
		</div>
		<table>
			<tr>
				<td><div data-role="controlgroup" data-type="horizontal">
  					<a href="#time_stamp" onclick="sortByTime()" data-role="button" data-theme="a">Sort by Date Added</a>
 					<a href="#title" onclick="sortByTitle()" data-role="button" data-theme="a">Sort by Title</a>
 					<a href="#artist" onclick="sortByArtist()" data-role="button" data-theme="a">Sort by Artist</a>	
				</div></td>
				<td> <a href="./user_comments.php" rel="external" data-role="button" data-theme="a" style="float:right; margin:0px;">My Comments</a></td>	
			</tr>
		</table>
			<div id="container">
					<?php
						include("config.php");
						if ($fb_user) {
							
							$query = "SELECT * FROM art, fave_art where id = art_id and user_id =".$fb_user;
							//$query = "SELECT * FROM art, fave_art where id = art_id";
							$result = mysql_query($query);
							while ($row = mysql_fetch_assoc($result)) {
								//echo "<div class='image'><a href='./art.php?id=".$row['art_id']."'><img width='100' src='".$row['image_source']."'></a></div>";
								$query2 = "SELECT * FROM art where id = ".$row['art_id'];
								$result2 = mysql_query($query2);
								$row2 = mysql_fetch_assoc($result2);

								$datetime = strtotime($row['time_stamp']);
								$date = date("m/d/y", $datetime);
								
								echo "<div class='image' style='background: black; margin: 12px 12px 12px 12px; padding: 3px 3px 3px 3px; display: inline-block;'><a href='./art.php?id=".$row['art_id']."' rel='external'><img width='100' src='".$row['image_url']."'></a>";
								echo "<div class='time_stamp' style='display:none'>".$row['time_stamp']."</div>";
								echo "<div class='art_id' style='display:none'>".$row['art_id']."</div>";
								echo "<div class='artist_sort_name' style='display:none'>".$row2['artist_last_name'].$row2['artist_first_name']."</div>";
								echo "<div class='title' style = 'color: white; font-size: larger; width:100px;overflow:auto;'><center>".$row2['title']."</center></div>";
								echo "<div class='artist_display_name' style = 'color: white; width:100px;overflow:auto;'><center>".$row2['artist']."</center></div>";
								echo "</div>";
							} 
						}
					?>
			</div><!-- /container -->
				
			<?php
				if(!$fb_user) {
					echo "<p style='margin-left:25px;font-family: Courier; font-size: 15px;'>Please login to view favorites!</p>";
				}
			?>
			
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
			<li><a href="./home.php" id="home" data-icon="custom" rel = "external">Home</a></li>
			<li><a href="./art.php" id="art" data-icon="custom" rel = "external">Random Art</a></li>
			<li><a onclick = "window.location.reload()" id="favorites" data-icon="custom" rel = "external">My Folio</a></li>
			<li><a href="./help.php" id="help" data-icon="custom" rel = "external">Help</a></li>
		</ul>
		</div><!-- /navbar -->
	</div><!-- /footer -->
	
</div><!-- /page -->
</body>

</html>