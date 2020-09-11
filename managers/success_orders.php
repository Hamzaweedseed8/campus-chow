<?php 
	require_once '../db.php';
	if (!isset($_SESSION['id'])) {
        header("Location: login.php");
    }
include 'includes/head.php';
    include 'includes/sidebar.php';
    include 'includes/navbar.php';
    $sql = $con->query("SELECT * FROM send WHERE rest_id = '$user_id' AND done = 1"); 
  
?>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card strpied-tabled-with-hover">
            <div class="card-header ">
              <h4 class="card-title">Delivered List</h4>
            </div>
            <div class="card-body table-full-width table-responsive">
              <table class="table table-hover table-striped">
                <thead>
                  <th></th>
                  <th>Name</th>
                  <th>Price</th>
                  <th>Customer Name</th>
                  <th>Customer Location</th>
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
<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
  $(document).ready(function() {

      $('.navbar-brand').html("Orders");
       $('title').html("Campus Chow | Orders");
       $('li.orders').addClass("active")
     });
</script>