<?php 
	require_once '../db.php';
	if(isset($_POST['add_to_cart'])){
	$_id = $_POST['id'];
	$quantity = $_POST['quantity'];
	$item = array();
	$item[] = array(
		'id'       => $_id,
		'quantity' => $quantity,
	);

	$domain = ($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false;
	$query = $con->query("SELECT * FROM rest_foods WHERE id = '{$_id}'");
	$product = mysqli_fetch_assoc($query);
	$_SESSION['success_show'] = $product['name']. ' was added to your cart.';
	//check to see if the cart cookie exists
	if($cart_id != ''){
		$cartQ = $con->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
		$cart = mysqli_fetch_assoc($cartQ);
		$previous_items = json_decode($cart['items'],true);
		$item_match = 0;
		$new_items = array();
		foreach ($previous_items as $pitem){
			if($item[0]['id'] == $pitem['id'] ){
				$pitem['quantity'] = $pitem['quantity'] + $item[0]['quantity'];
				$item_match = 1;
			}
			$new_items[]= $pitem;
		}
		if($item_match != 1){
			$new_items = array_merge($item,$previous_items);
		}
		$items_json = json_encode($new_items);
		$cart_expire = date("Y-m-d H:i:s",strtotime("+30 days"));
		$con->query("UPDATE cart SET items = '{$items_json}', expire_date = '{$cart_expire}' WHERE id = '{$cart_id}'");
		setcookie(CART_COOKIE,'',1,"/",$domain,false);
		setcookie(CART_COOKIE,$cart_id,CART_COOKIE_EXPIRE,'/',$domain,false);
	}else{
		//add the cart to the database and set cookie
		$items_json = json_encode($item);
		$cart_expire = date("Y-m-d H:i:s", strtotime("+30 days"));
		$con->query("INSERT INTO cart (items,expire_date) VALUES('{$items_json}','{$cart_expire}')");
		$cart_id = $con->insert_id;
		setcookie(CART_COOKIE,$cart_id,CART_COOKIE_EXPIRE,'/',$domain,false);
	}
}


if(isset($_POST['updateCart'])){
	$mode = sanitize($_POST['mode']);
	$edit_id = sanitize($_POST['edit_id']);
	$cartQ = $con->query("SELECT * FROM cart WHERE id = '$cart_id'");
	$result = mysqli_fetch_assoc($cartQ);
	$items = json_decode($result['items'],true);
	$updated_items = array();
	$domain = (($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false);
	if($mode == 'addone'){
		foreach ($items as $item){
			if($item['id'] == $edit_id){
				$item['quantity'] = $item['quantity'] + 1;
			}
			$updated_items[] = $item;
		}
	}
	if($mode == 'removeone'){
		foreach ($items as $item){
			if($item['id'] == $edit_id){
				$item['quantity'] = $item['quantity'] - 1;
			}
			if($item['quantity'] > 0){
				$updated_items[] = $item;
			}
		}
	}
	if($mode == 'delete'){
		foreach ($items as $item){
			if($item['id'] == $edit_id){
				$item['quantity'] = $item['quantity'] - $item['quantity'];
			}
			if($item['quantity']  > 0){
				$updated_items[] = $item;
			}
		}
	}
	if(!empty($updated_items)){
		$json_updated = json_encode($updated_items);
		$con->query("UPDATE cart SET items = '{$json_updated}' WHERE id = '{$cart_id}' ");
		$_SESSION['success_flash'] = 'Your shopping cart has been updated!';
	}
	if(empty($updated_items)){
		$con->query("DELETE FROM cart WHERE id = '{$cart_id}'");
		setcookie(CART_COOKIE,'',1,"/",$domain,false);
	}
}


?>
	