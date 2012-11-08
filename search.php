<?php
	include("config.php");

	$term=$GLOBALS['HTTP_RAW_POST_DATA'];
	
   $sql = mysql_query("SELECT * FROM art WHERE title LIKE '%".$term."%' OR artist LIKE '%".$term."%' ");
   	while ($row = mysql_fetch_array($sql)){
		echo $row['id']."&";
       	echo $row['title'];
    	echo ' ('.$row['year'].') ';
    	echo ' - '.$row['artist'];
		echo '|';
    }
    
  ?>