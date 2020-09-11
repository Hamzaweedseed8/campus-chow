<?php 
	require '../db.php';
	$message = sanitize($_POST['message']);
	$name = sanitize($_POST['name']);
	$email = sanitize($_POST['email']);
	$subject = sanitize($_POST['subject']);

	$sql = $con->query("INSERT INTO mails (email,phone,full_name,message) VALUES('$email','$subject','$name','$message')");
	if($sql){
		echo "mail has been sent";
	}

?>