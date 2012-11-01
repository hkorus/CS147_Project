<?php
include("config.php");

	$imageData=$GLOBALS['HTTP_RAW_POST_DATA'];
	$query = "INSERT INTO fave_art VALUES (1,".$imageData.",NULL);";
	$result = mysql_query($query);

	
