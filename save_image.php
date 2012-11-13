<?php
include("config.php");

	require './facebook.php';
	$facebook = new Facebook(array(
		'appId'  => '291103611004949',
  		'secret' => '226db60e672abf202f1424b1084fc38e',
      	'cookie' => true));
    $fb_user = $facebook->getUser();
    
	$imageData=$GLOBALS['HTTP_RAW_POST_DATA'];
	$msg = substr($imageData, 0, strpos($imageData, "&"));
	$imageData = substr($imageData, strpos($imageData, "&")+1);
	$id = substr($imageData, 0, strpos($imageData, "&"));
	$imageData = substr($imageData, strpos($imageData, "&")+1);

	
	$filteredData=substr($imageData, strpos($imageData, ",")+1);
	$unencodedData=base64_decode($filteredData);
	
   // Save file.  This example uses a hard coded filename for testing,
	$name = "images/img_".microtime(1).".png";
	$commentId = rand();
	$fp = fopen($name, 'w');
   fwrite( $fp, $unencodedData);
   fclose( $fp );
	$msg = mysql_real_escape_string($msg);
	$query = "INSERT INTO comments VALUES (".$commentId.",".$fb_user.",".$id.",'".$msg."','".$name."',NULL,0);";
	$result = mysql_query($query);

	
