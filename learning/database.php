<html>
<head>
<title>Database</title>
</head>
<body>
	<table style="margin-left:auto; margin-right:auto; font-size:15px; text-align:center;">
		<tr style="background-color:#ccc;">
			<th style="width:125px;">Name</th>
			<th style="width:125px;">Age</th>
			<th style="width:125px;">Location</th>
			<th style="width:125px;">Salary</th>
		</tr>
		<?php
			$con = mysqli_connect("localhost", "root", "root", "test") or 
					die("Failed to connect MySQL.");
			$query = "select name, age, location, salary from customer";
			$result = mysqli_query($con, $query);
			$color1 = "#ebebeb";
			$color2 = "#ffffff";
			$rowCount = 0;
			
			while($row = mysqli_fetch_array($result)) {
				$rowColor = ($rowCount % 2) ? $color1 : $color2; ?>
						<tr style="background-color:<?php echo $rowColor ?>;">
						<?php echo "<td>".$row['name']."</td>
						<td>".$row['age']."</td>
						<td>".$row['location']."</td>
						<td>".$row['salary']."</td>
						</tr>";
				$rowCount++;
			}
			
			mysqli_close($con);
		?>
	</table>
</body>
</html>