<?php
	$string1 = "Sainath Parkar";
	$String2 = "Hello world";
	
	echo strlen($string1);
	echo "<br/>".strtoupper($string1);
	echo "<br/>".strtolower($string1);
	echo "<br/>".crypt($string1);
	echo "<br/>".md5($string1);
	echo "<br/>".str_shuffle($string1);
	echo "<br/>".strpos($string1, "Par");
	echo "<br/>".strrev($string1);
	echo "<br/>".substr_compare($string1, $String1, 0);