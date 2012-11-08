<?php
include("config.php");
	require './facebook.php';
	$facebook = new Facebook(array(
		'appId'  => '291103611004949',
  		'secret' => '226db60e672abf202f1424b1084fc38e',
      	'cookie' => true));
      	
    $fb_user = $facebook->getUser();
    
	$imageData=$GLOBALS['HTTP_RAW_POST_DATA'];
	//$query = "INSERT INTO fave_art VALUES (1,".$imageData.",NULL);";
	$query = "INSERT INTO fave_art VALUES (".$fb_user.",".$imageData.",NULL);";
	$result = mysql_query($query);

	
