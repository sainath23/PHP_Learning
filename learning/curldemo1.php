<?php
	$ch = curl_init();
	
	$search_string = "2016 PC Video Games";
	$url = "https://www.amazon.com/s/field-keywords=$search_string";
	
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	//https://images-na.ssl-images-amazon.com/images/I/51f3qNxqXeL._AC_US218_.jpg
	
	$output = curl_exec($ch);
	
	preg_match_all("!https://images-na.ssl-images-amazon.com/images/I/[^\s]*?._AC_US218_.jpg!", $output, $matches);
	
	print_r($matches);
	//$images = array_values(array_unique($matches[0]));
	
	/*)for($i=0; $i<count($images); $i++) {
		echo "<div style='float: left; margin: 10 0 0 0;'>";
		echo "<img src='.$images[$i].'><br />";
		echo "</div>";
	}*/
	
	curl_close($ch);