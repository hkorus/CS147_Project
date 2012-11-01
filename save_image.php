<?php
	$imageData=$GLOBALS['HTTP_RAW_POST_DATA'];
	$filteredData=substr($imageData, strpos($imageData, ",")+1);
	$unencodedData=base64_decode($filteredData);
	
   // Save file.  This example uses a hard coded filename for testing,

	$fp = fopen("images/img_".microtime(1).".png", 'w');
   fwrite( $fp, $unencodedData);
   fclose( $fp );
