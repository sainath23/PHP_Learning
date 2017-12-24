<?php

$ftp_server = "myontology";
$username = "u541976";
$password = "";
$ftp_conn = ftp_connect($ftp_server, 21) or die("Could not connect to $ftp_server");
$login = ftp_login($ftp_conn, $username, $password);
if($login) {
	echo "Connected to $ftp_server!";
}
else {
	echo "Failed to login!";
	exit;
}
echo "<pre>";
print_r(glob("uploads/*"));
//exit;
$local_dir = "uploads";
//print_r(glob("$local_dir/*"));
//exit;
//echo ftp_pwd($ftp_conn); exit;

/*if(!@ftp_chdir($ftp_conn, substr($local_dir, strpos($local_dir, "/")+1))){
	echo substr($local_dir, strpos($local_dir, "/")+1);
	$new_dir = substr($local_dir, strpos($local_dir, "/")+1);
	ftp_mkdir($ftp_conn, $new_dir);
	ftp_chdir($ftp_conn, $new_dir);
	echo "<br>success";
} 
else {
	echo "fail";
}*/
echo ftp_cdup($ftp_conn);
echo "<br>";
echo ftp_pwd($ftp_conn);
//exit;
upload_to_ftp($ftp_conn, $local_dir);


function upload_to_ftp($ftp_conn, $local_dir) {
	echo ftp_pwd($ftp_conn);
	
	foreach(glob("$local_dir/*") as $filename) {
		if(@ftp_put($ftp_conn, basename($filename), $filename, FTP_ASCII)) {
			echo "<br>success. Uploaded $filename";
		}
		elseif(is_dir($filename)) {
			echo "<br>in elseif. $filename";
			echo "<pre>";
			print_r(glob("$filename/*"));
			if(!@ftp_chdir($ftp_conn, substr($filename, strpos($filename, "/")+1))){
				echo substr($filename, strpos($filename, "/")+1);
				$new_dir = substr($filename, strpos($filename, "/")+1);
				ftp_mkdir($ftp_conn, $new_dir);
				ftp_chdir($ftp_conn, $new_dir);
				echo "<br>$new_dir changed success";
			} 
			upload_to_ftp($ftp_conn, $filename);
		}
		else {
			echo "<br>Failed to upload $filename.";
			exit;
		}
	}
}


ftp_close($ftp_conn);
echo "<br><br>Closed ftp!";