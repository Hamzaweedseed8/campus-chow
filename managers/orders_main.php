<?php 
    require '../db.php';
    if (!isset($_SESSION['id'])) {
        header("Location: login.php");
    }
    include 'includes/head.php';
    include 'includes/sidebar.php';
    include 'includes/navbar.php';
if($user_permission == 1){
    if(isset($_GET['complete']) && $_GET['complete'] == 1){
        $cart_id = sanitize((int)$_GET['cart_id']);
        // $date = date("Y-m-d H:i:s");
        // $con->query("UPDATE cart SET delivered = 1 WHERE id = '{$cart_id}'");
        $con->query("UPDATE transactions SET status = 1 WHERE cart_id = '{$cart_id}'");
        $_SESSION['success_flash'] = 'The Order Has Been Completed';
        echo "<script>window.location = 'orders.php';</script>";
    }

    
    if(isset($_GET['txn_id'])){
        $cart_id = sanitize((int)$_GET['txn_id']);
        $sql = $con->query("SELECT * FROM send WHERE cart_id = '$cart_id' AND seen = 0");
        
        

    
 ?>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header ">
                            <h4 class="card-title"></h4>
                        </div>
                        <div class="card-body table-full-width table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <th>No.</th>
                                    <th>Food Name</th>
                                    <th>Quantity</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no = 1;
                                    while($sendROW = mysqli_fetch_assoc($sql)){
                                        $txnQuery = $con->query("SELECT * FROM transactions WHERE cart_id = '{$cart_id}'");
                                        $txn = mysqli_fetch_assoc($txnQuery);

                                        $p_id = $sendROW['product_id'];
                                        $cartQ = $con->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
                                        $cart = mysqli_fetch_assoc($cartQ);
                                        $items = json_decode($cart['items'],true);
                                        $products = array();
                                        $ids = $sendROW['product_id'];
                                        $productQ = $con->query("
                                            SELECT * FROM rest_foods WHERE id IN ({$ids}) ");
                                        while($p = mysqli_fetch_assoc($productQ)){
                                            foreach ($items as $item) {
                                                if($item['id'] == $p['id']){
                                                    $x = $item;
                                                    continue;
                                                }
                                            }
                                            $products[] = array_merge($x,$p);
                                        }
                                  foreach ($products as $row){ ?>
                                    <tr>
                                        <td><?=$no;?></td>
                                        <td><?=$row['name'];?></td>
                                        <td><?=$row['quantity'];?></td>
                                        <th><a href="orders_main.php?send=<?=$row['id'];?>&cart_id=<?=$cart_id;?>" class="btn btn-info btn-sm">send</a></th>
                                    </tr>
                                <?php 
                                $no++;
                            }
                        }
                        ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="pull-right">
                            <a href="orders.php" class="btn  btn-danger">Cancel</a>
                            <a href="orders_main.php?complete=1&cart_id=<?=$cart_id;?>"  class="btn btn-success" >Complete Order</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
<?php } 
    if(isset($_GET['send']) && isset($_GET['cart_id'])){
        $_id = sanitize((int)$_GET['send']);
        $cart_id = sanitize((int)$_GET['cart_id']);
        $con->query("UPDATE send SET seen = 1 WHERE product_id = '$_id' AND cart_id = '$cart_id'");
        // header('Location: orders.php');
        echo "<script>window.location = 'orders.php';</script>";
    }
}else{
    if(isset($_GET['complete'])  && isset($_GET['cart_id'])){
            $cart_id = sanitize((int)$_GET['cart_id']);
            $food_id = sanitize((int)$_GET['complete']);
            $date = date("Y-m-d H:i:s");
            $con->query("UPDATE send SET done = 1 WHERE product_id = '{$food_id}'");
            $con->query("UPDATE cart SET delivered = 1 WHERE id = '{$cart_id}'");
            $con->query("UPDATE transactions SET delivered_date = '$date' WHERE cart_id = '{$cart_id}'");
            $_SESSION['success_flash'] = 'The Order Has Been Completed';
            // header('Location: orders.php');
            echo "<script>window.location = 'orders.php';</script>";
        }
    if(isset($_GET['txn_id'])){
        $txn_id = sanitize((int)$_GET['txn_id']);
        $food_id = sanitize((int)$_GET['complete']);
        $txnQuery = $con->query("SELECT * FROM transactions WHERE id = '{$txn_id}'");
        $txn = mysqli_fetch_assoc($txnQuery);
        ?>
        <div class="content">
        <div class="container-fluid">
<div class="col-md-6">
                    <div class="card ">
                        <div class="card-body ">
                            <address>
                                <p><?=$txn['full_name'];?></p>
                                <p><?=$txn['email'];?></p>
                                <p>0<?=$txn['phone'];?></p>
                                <p><?=$txn['hostel'];?></p>
                            </address>
                        </div>
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="pull-right">
                            <a href="orders.php" class="btn  btn-danger">Cancel</a>
                            <a href="orders_main.php?complete=<?=$food_id;?>&cart_id=<?=$txn['cart_id'];?>"  class="btn btn-success" >Complete Order</a>
                    </div>
                </div>
            </div>
        </div>
               
            
        <?php
    }
}
include 'includes/footer.php'; ?>
<script type="text/javascript">
    $(document).ready(function() {
       $('.navbar-brand').html("Orders");
       $('title').html("Campus Chow | Orders");
       $('li.orders').addClass("active")
    });
</script>

</body>
</html>