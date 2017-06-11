<?php 
	if (isset($_POST['download'])) {
		$con = mysqli_connect("localhost", "root", "root", "csvtest") or
		die("Failed to connect MySQL");
		
		$filename = "uploads/".strtotime("now").".csv";
		$handle = fopen($filename, "w") or die(print_r(error_get_last()));
		
		$sql = mysqli_query($con, "SELECT * FROM employee");
		$num_row = mysqli_num_rows($sql);
		
		//echo $row['name']."<br>";
		if($num_row >= 1) {
			$row = mysqli_fetch_assoc($sql);
			$separator = "";
			$comma = "";
			
			foreach ($row as $name => $value) {
				$separator .= $comma.''.str_replace('', "", $name);
				$comma = ",";
			}
			$separator .= "\n";
			//echo $separator;
			fputs($handle, $separator);
			
			mysqli_data_seek($sql, 0);
			
			while($row = mysqli_fetch_assoc($sql)) {
				$separator = "";
				$comma = "";
			
				foreach ($row as $name => $value) {
					$separator .= $comma.''.str_replace('', "", $value);
					$comma = ",";
				}
				$separator .= "\n";
				//echo $separator;
				fputs($handle, $separator);
			}
			fclose($handle);
		}
		mysqli_close($con);
	}

?>
<html>
<head>
<title>Download CSV</title>
</head>

<body>
	<form action="downloadcsv.php" method="post">
	<input type="submit" name="download" value="Download" />
	</form>
</body>

</html>