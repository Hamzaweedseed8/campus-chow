<?php 
	require '../db.php';
	unset($_SESSION['id']);
	header("Location: login.php");
?>