<?php
	include("config.php");

	$term = $_POST['term'];
	
   $sql = mysql_query("SELECT * FROM art WHERE title LIKE '%$term%' OR artist LIKE '%$term%' ");
     
   	while ($row = mysql_fetch_array($sql)){
       	echo $row['title'];
    	echo ' ('.$row['year'];.') '
    	echo ' - '.$row['artist'];
    	echo '<br/><br/>';
    }
    
  ?>