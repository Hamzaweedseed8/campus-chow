<?php 
	session_start();
	$con = mysqli_connect('localhost','root','','campus_chow') or die(mysqli_error($conn));
	define('BASEURL', $_SERVER['DOCUMENT_ROOT']. '/campus_chow/');

	function sanitize($dirty){
		return htmlentities($dirty,ENT_QUOTES, "UTF-8");
	}

	if(isset($_SESSION['id'])){
		$id = $_SESSION['id'];
		$query= $con->query("SELECT * FROM rest_admins WHERE id = '$id'");
		$user_data = mysqli_fetch_assoc($query);
		$user_id = $user_data['id'];
		$user_permission = $user_data['permission'];
		$restaurant_name = $user_data['restaurant_name'];
	}
	define('CART_COOKIE', '1234567890abcdefghijkl');
	define('CART_COOKIE_EXPIRE', time() + (86400 *30));

	$cart_id = '';
 	if(isset($_COOKIE[CART_COOKIE])){
 		$cart_id= $_COOKIE[CART_COOKIE];
 	}

	if(isset($_SESSION['success_flash'])){
 		echo '<div class="bg-success"><p class="text-center" style="color:#fff;font-size:20px;">'.$_SESSION['success_flash'].'</p></div>' ;
 		unset($_SESSION['success_flash']);
 	}

 	if(isset($_SESSION['success_show'])){
 		echo '<div class="bg-success"><p class="text-center" style="color:#fff;font-size:20px;">'.$_SESSION['success_show'].'</p></div>' ;
 		unset($_SESSION['success_show']);
 	}

 	if(isset($_SESSION['error_flash'])){
 		echo '<div class="bg-danger"><p class="text-center" style="color:#fff;font-size:20px;">'.$_SESSION['error_flash'].'</p></div>' ;
 		unset($_SESSION['error_flash']);
 	}

 	function display_errors($errors){
		$display = '<ul class="bg-danger">';
		foreach($errors as $error){
			$display .= '<li class="text-center" style="color:#fff;">'.$error.'</li>';
		}
		$display .= '</ul>';
		return $display;
	}

	function pretty_date($date){
		return date("M d, Y h:i A",strtotime($date));
	}
?>