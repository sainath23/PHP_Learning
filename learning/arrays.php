<?php
	echo "<h1>Simple array:</h1>";
	$students = array("Sainath", "Shahid", "Saurabh", "Pratik");
	
	print_r($students);
	foreach ($students as $name) {
		echo "<br>".$name;
	}
	
	for ($i=0; $i<count($students); $i++)
		echo "<br>".$students[$i]."<br>";
	
	echo "<br><br><hr><br><h1>Associative array:</h1>";
	
	$percentage = array("Sainath" => 84.61, "Shahid" => 87, "Saurabh" => 81.21, "Pratik" => 80);
	print_r($percentage);
	
	foreach ($percentage as $name => $per) {
		echo "<br>".$name." => ".$per;
	}
	
	echo "<br><br><hr><br><h1>Multidimensional array:</h1>";
	
	$marks = array("Sainath" => array("Marathi" => 70, "English" => 80, "Science" => 90), 
					"Shahid" => array("Marathi" => 70, "English" => 80, "Science" => 90),
					"Saurabh" => array("Marathi" => 70, "English" => 80, "Science" => 90), 
					"Pratik" => array("Marathi" => 70, "English" => 80, "Science" => 90));
	
	print_r($marks);
	echo "<br>";
	foreach ($marks as $name => $arr) {
		foreach ($arr as $subject => $mark) {
			echo "<br>".$name." => ".$subject." => ".$mark;
		}
	}
	
	$json = json_encode($marks, JSON_PRETTY_PRINT);
	$json1 = json_encode($percentage);
	//header('content-type: text/javascript');
	echo "<br/>".$json;
	echo "<br/>".$json1;
	echo "<br/>";
	$jsondecode = json_decode($json, true);
	echo $jsondecode['Sainath']['Marathi']."<br>";
	foreach ($jsondecode as $name => $arr) {
		foreach ($arr as $subject => $mark) {
			echo "<br>".$name." => ".$subject." => ".$mark;
		}
	}
	echo "<br><br><hr><br>";
	$output = "";
	foreach ($jsondecode['Sainath'] as $employee) {
		$output .= "Name: ".$employee."<br />";
		$output .= "Marathi: ".$jsondecode['Sainath']['Marathi']."<br />";
		$output .= "English: ".$jsondecode['Sainath']['English']."<br />";
		$output .= "Science: ".$jsondecode['Sainath']['Science']."<br />";
		$output .= "<br />";
	}
	echo $output;
	
	