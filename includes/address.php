<?php 
	require_once '../db.php';
	$name = sanitize($_POST['full_name']);
	$email = sanitize($_POST['email']);
	$hostel = sanitize($_POST['hostel']);
	$phone = sanitize($_POST['phone']);
	$location = sanitize($_POST['location']);
	$errors = array();
	$required = array(
		'full_name' =>'Full Name',
		'email' 	=>'Email',
		'phone' 	=>'Phone Number',
		'hostel' 	=>'Hostel',
		'location' 	=>'Location',
	);


	//check if all required fields are filled out
	foreach($required as $f => $d){
		if(empty($_POST[$f]) || $_POST[$f] == ''){
			$errors[] = $d.' is required.';
		}
	}
 
 	// check if valid email Address
 	if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
 		$errors[] = 'Please enter a valid Email';
 	}



	if(!empty($errors)){
		echo display_errors($errors);
	}else{
		echo 'passed';
	}





	?>