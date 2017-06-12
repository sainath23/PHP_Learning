<?php
	
	//Curl initialization using curl handler variable
	//$ch = curl_init();
	
	//Setting up URL
	//$URL = "http://www.yahoo.com;
	
	//Setting up curl options
	//curl_setopt($ch, CURLOPT_URL,  "http://www.google.com");
	//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	//storing curl output
	//$output = curl_exec($ch);
	
	//check for output error
	//if($output === FALSE) {
	//	echo "CURL ERROR".curl_error($ch);
	//}
	
	
	//closing curl
	//curl_close($ch);
	
	//echo $output;
	
	$handle = curl_init();
	
	$url = "http://www.google.com";
	
	// Set the url
	curl_setopt($handle, CURLOPT_URL, $url);
	// Set the result output to be a string.
	curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$output = curl_exec($handle);
	
	curl_close($handle);
	
	echo $output;