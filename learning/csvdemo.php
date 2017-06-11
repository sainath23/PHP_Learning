<?php


if(isset($_POST['upload'])) {
	$con = mysqli_connect("localhost", "root", "root", "csvtest") or
	die("Failed to connect MySQL");
	$csvfile = $_FILES['csvfile']['tmp_name'];
	$handle = fopen($csvfile, "r");
	
	while(($csvfileOpen = fgetcsv($handle, 1000, ",")) !== false) {
		$name = $csvfileOpen[0];
		$age = $csvfileOpen[1];
		$location = $csvfileOpen[2];
		$salary = $csvfileOpen[3];
		$query = "INSERT INTO employee(name, age, location, salary) VALUES('$name', $age, '$location', $salary)";
		
		$sql = mysqli_query($con, $query) or die(print_r(error_get_last()));
		
		
	}
	if ($sql) {
		echo "<h2>File uploaded successfully!</h2>";
	}
	else {
		echo "Failed";
	}
	
}
mysqli_close($con);

?>

<html>
<head>
<title>Upload CSV</title>
</head>
<body>
	<div>
	<form action="csvdemo.php" method="post" enctype="multipart/form-data">
		<input type="file" name="csvfile" /><br/>
		<input type="submit" name="upload" value="Upload" />	
	</form>	
	</div>
</body>
</html>
