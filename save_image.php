<?php
include("config.php");
    
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

	$query = "INSERT INTO comments VALUES (".$commentId.",1,".$id.",'".$msg."','".$name."',NULL,0);";
	$result = mysql_query($query);

	
