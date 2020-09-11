<?php 
	require 'db.php';
	include 'includes/head.php';
	include 'includes/nav.php';
	if(isset($_POST['confirmOrders'])){

		$full_name = sanitize($_POST['full_name']);
		$email = sanitize($_POST['email']);
		$hos = sanitize($_POST['hostel']);
		$location = sanitize($_POST['location']);
		$hostel = $hos.' - '.$location;
		$phone = sanitize($_POST['phone']);

		$grand_total = sanitize($_POST['grand_total']);
		$cart_id = sanitize($_POST['cart_id']);
		$description = sanitize($_POST['description']);

		$con->query("UPDATE cart SET paid = 1 WHERE id = '{$cart_id}'");
		$con->query("INSERT INTO transactions (cart_id,full_name,email,phone,hostel,description,grand_total) VALUES ('$cart_id','$full_name','$email','$phone','$hostel','$description','$grand_total')");

	    // $con->query("SELECT * FROM transactions WHERE cart_id = '{$cart_id}'");

	    $cartQ = $con->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
	    $result = mysqli_fetch_assoc($cartQ);
	    $items = json_decode($result['items'],true);
		foreach($items as $item){
			$_id = $item['id'];
			$Sql = $con->query("SELECT * FROM rest_foods WHERE id = '$_id'");
			$row = mysqli_fetch_assoc($Sql);
			$rest_id = $row['restaurant_id'];
			$con->query("INSERT INTO send (product_id,rest_id,cart_id) VALUES ('$_id','$rest_id','$cart_id')");
		}

		$domain = ($_SERVER['HTTP_HOST'] != 'localhost')? '.'.$_SERVER['HTTP_HOST']:false;
		setcookie(CART_COOKIE,'',1,"/",$domain,false);
?>
 <!-- breadcam_area_start -->
    <div class="breadcam_area breadcam_bg_1 zigzag_bg_2">
        <div class="breadcam_inner">
            <div class="breadcam_text">
                <h3>Thank You</h3>
            </div>
        </div>
    </div>
    <!-- breadcam_area_end -->
    <!-- order_area_start -->
    <div class="order_area">
        <div class="container">
            <div class="row">
            	<div class="col-md-12">
					<p>You are succesfully been charged &cent<?=$grand_total;?> for your food order.  Additionally your can print this page as reciept.</p>
					<p>Your reciept number is: <strong><?=$cart_id;?></strong></p>
					<p>Your order will be delivered to the address below,</p>
				</div>
				<div class="col-md-12">
					<address>
						<?=$full_name;?><br>
						<?=$email;?><br>
						<?=$phone;?><br>
						<?=$hostel;?><br>
					</address>
				</div>
			</div>
		</div>
	</div>
<?php 

}else{
	header("Location: index.php");
} 


include 'includes/footer.php';
 ?>