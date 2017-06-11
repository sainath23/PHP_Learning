<?php
	$jsonData = file_get_contents("myjson.json");
	
	$decoded_json = json_decode($jsonData, true);
	
	//echo $decoded_json['employee'][1]['salary'];
	
	echo "<h2>Employee data:</h2>";
	
	$output = "";
	
	foreach ($decoded_json['employee'] as $employee) {
		$output .= "ID: ".$employee['empid']."<br />";
		$output .= "Name: ".$employee['name']."<br />";
		$output .= "Email: ".$employee['email']."<br />";
		$output .= "Salary: ".$employee['salary']."<br />";
		$output .= "<br />";
	}
	echo $output;
	