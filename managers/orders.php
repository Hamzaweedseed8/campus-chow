<?php 
	require_once '../db.php';
	if (!isset($_SESSION['id'])) {
        header("Location: login.php");
    }
include 'includes/head.php';
    include 'includes/sidebar.php';
    include 'includes/navbar.php';
    if($user_permission == 1){
  $sql = $con->query("SELECT t.id, t.cart_id, t.full_name,t.description, t.grand_total, t.txn_date, c.items, c.paid, c.delivered
    FROM transactions t
    LEFT JOIN cart c ON t.cart_id = c.id
    WHERE c.paid = 1 AND t.status = 0
    ORDER BY t.txn_date");
?>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card strpied-tabled-with-hover">
            <div class="card-header ">
              <h4 class="card-title">Order List</h4>
              <p class="card-category pull-right"><a href="success_orders.php" class="btn btn-info">succesful order</a></p>
            </div>
            <div class="card-body table-full-width table-responsive">
              <table class="table table-hover table-striped">
                <thead>
                  <th></th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Total</th>
                  <th>Date</th>
                  <th></th>
                </thead>
                <tbody>
                  <?php      
                  $no = 1; 
                  while ($row = mysqli_fetch_assoc($sql)) { 
                    ?>
                    <tr>
                      <td><?=$no;?></td>
                      <td><?=$row['full_name'];?></td>
                      <td><?=$row['description'];?></td>
                      <td>GH&cent<?=$row['grand_total'];?></td>
                      <td><?=pretty_date($row['txn_date']);?></td>
                      <td><a href="orders_main.php?txn_id=<?=$row['cart_id'];?>" class="btn btn-sm btn-primary">details</a></td>
                    </tr>
                  <?php
                          $no++;
                          }
                  ?>        
                </tbody>
              </table>
	 		      </div>
	 	      </div>
	      </div>
      </div>
    </div>
  </div>
<?php }else{
  $sql = $con->query("SELECT * FROM send WHERE rest_id = '$user_id' AND done = 0"); 
  

  ?>
    <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card strpied-tabled-with-hover">
            <div class="card-header ">
              <h4 class="card-title">Order List</h4>
              <p class="card-category pull-right"><a href="success_orders.php" class="btn btn-info">succesful order</a></p>
            </div>
            <div class="card-body table-full-width table-responsive">
              <table class="table table-hover table-striped">
                <thead>
                  <th></th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Total</th>
                  <th>Date</th>
                  <th></th>
                </thead>
                <tbody>
                  <?php  

                  $no = 1; 
                  while ($userROW = mysqli_fetch_assoc($sql)){
                    $cart_id = $userROW['cart_id'];
                    $txnsql = $con->query("SELECT * FROM transactions WHERE cart_id = '$cart_id'");
                    $txnrow = mysqli_fetch_assoc($txnsql);

                    $food_id = $userROW['product_id'];
                    $foodsql = $con->query("SELECT * FROM rest_foods WHERE id = '$food_id'");    
                  while ($row = mysqli_fetch_assoc($foodsql)) { 
                    ?>
                    <tr>
                      <td><?=$no;?></td>
                      <td><?=$row['name'];?></td>
                      <td><?=$row['price'];?></td>
                      <td><?=$txnrow['full_name'];?></td>
                      <td><?=$txnrow['hostel'];?></td>
                      <td><?=pretty_date($txnrow['txn_date']);?></td>
                      <td><a href="orders_main.php?txn_id=<?=$txnrow['id'];?>&complete=<?=$food_id;?>" class="btn btn-sm btn-primary">delivery details</a></td>
                    </tr>
                  <?php
                          
                          }
                          $no++;
                        }

                  ?>        
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php 
}include 'includes/footer.php'; ?>
<script type="text/javascript">
  $(document).ready(function() {

      $('.navbar-brand').html("Orders");
       $('title').html("Campus Chow | Orders");
       $('li.orders').addClass("active")
     });
</script>