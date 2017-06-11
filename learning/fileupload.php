<html>
<head>
<title>Upload Image</title>
</head>
<body>
	<form action="act_upload.php" method="post" enctype="multipart/form-data">
	<div>
		<input type="file" name="image" />
		<br />
		<textarea rows="5" cols="50" name="info" placeholder="Enter image information..." ></textarea>
		<br />
		<input type="submit" name="upload" value="Upload" />
		<input type="reset" name="reset" value="Reset" />
	</div>
	</form>
	<br />
	<?php 
		if($_GET['msg']) {
			$msg = $_GET['msg'];
			if($msg == 1) {
				echo "Your image have been uploaded!";
			}
			else {
				echo "Something is wrong!";
			}
		}
	?>
</body>
</html>