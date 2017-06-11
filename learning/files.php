<?php
	$filename = "test.csv";
	//$filePtr = fopen($filename, "r") or print_r(error_get_last());
	//$input = ", Hello world!";
	//$fileSize = filesize($filename);
	//echo fread($filePtr, $fileSize);
	//$fileWrite = fwrite($filePtr, $input);
	
	$csv = file_get_contents($filename);
	//$input = file_put_contents($filename, "\nvinod, 20", FILE_APPEND);
	echo $csv."<br>";
	
	
	print_r(str_getcsv($csv, "\n"));
	echo "<br>";
	$array = array_map("str_getcsv", explode("\n", $csv));
	$json = json_encode($array);
	print_r($json);
	//echo "<br />".json_decode($json);
	//fclose($filePtr);