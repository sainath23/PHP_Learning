<?php

	echo "Hello<br>";
	$a = 10;
	$b = 20;
	$c = 30;
	
	function add() {
		GLOBAL $a;
		GLOBAL $b;
		echo $sum = $a + $b;
		//echo "$sum";
	}
	
	function add1($x, $y, $z) {
		echo "$x+$y+$z";
	}
	
	add();
	//add($a, $b, $c);
	