<?php
include("config.php");

	$imageData=$GLOBALS['HTTP_RAW_POST_DATA'];
	$id = substr($imageData, 0, strpos($imageData, "&"));
	$change = substr($imageData, strpos($imageData, "&")+1);

	$query = "UPDATE comments SET rating = rating + ".$change." WHERE comment_id = ".$id;
	
	$result = mysql_query($query);

	
