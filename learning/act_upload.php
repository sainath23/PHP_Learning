<?php
	
	
	if(isset($_POST['upload'])) {
		$con = mysqli_connect("localhost", "root", "root", "photos") or
		die("Failed to connect mysql.");
		$targetDir = "uploads/".basename($_FILES['image']['name']);
		$imgName = $_FILES['image']['name'];
		$imgInfo = $_POST['info'];
		$query = "insert into pics(name, info) values('$imgName', '$imgInfo')";
		$queryExe = mysqli_query($con, $query);
		
		if(move_uploaded_file($_FILES['image']['tmp_name'], $targetDir)) {
			header('Location: ../learning/fileupload.php?msg=1');
		}
		else {
			header('Location: ../learning/fileupload.php?msg=2');
		}
	}