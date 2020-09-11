<?php 
    require 'db.php';
     include 'includes/head.php';
     include 'includes/nav.php';
    if($cart_id != ''){
        $cartQ = $con->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
        $result = mysqli_fetch_assoc($cartQ);
        $items = json_decode($result['items'],true);
        $i = 1;
        $sub_total = 0;
        $item_count = 0;
    }
?>
<style type="text/css">
    .modal-backdrop{
        position: unset;
    }
    .modal-content{
    box-shadow: 0 2px 5px rgba(0,0,0,0.4);
  }
  #modal_errors p{
    color: #fff !important;
  }
</style>
    <!-- breadcam_area_start -->
    <div class="breadcam_area breadcam_bg_1 zigzag_bg_2">
        <div class="breadcam_inner">
            <div class="breadcam_text">
                <h3>My Orders</h3>
            </div>
        </div>
    </div>
    <!-- breadcam_area_end -->

    <!-- order_area_start -->
    <div class="order_area">
        <div class="container">
            <div class="row">
        <?php if($cart_id == ''){ ?>
            <div class="col-md-12">
                <div class="bg-danger">
                    <p class="text-center" style="color: #fff; font-size: 25px;">Your order is empty!</p>
                </div>

            </div>
        <?php }else{ ?>
        <div class="col-md-8">
            <div id="msg"></div>
            <table class="table table-bordered table-condensed table-striped ">
                <h3>Items</h3>
                <thead>
                    <th>#</th>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Sub Total</th>
                    <th></th>
                </thead>
                <tbody>
                <?php
                    foreach($items as $item){
                        $_id = $item['id'];
                        $foodQ = $con->query("SELECT * FROM rest_foods WHERE id = '$_id' ");
                        $food = mysqli_fetch_assoc($foodQ);
                        
                ?>
                    <tr>
                        <td><?=$i; ?></td>
                        <td><?=$food['name']; ?></td>
                        <td>&cent<?=$food['price'];?></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-danger pull-left" onclick="update_cart('removeone','<?=$food['id'];?>');">-</button>
                            <?=$item['quantity'];?>
                            <button class="btn btn-sm btn-default pull-right" onclick="update_cart('addone','<?=$food['id'];?>');">+</button>
                        </td>
                        <td>&cent<?=$item['quantity'] * $food['price']; ?></td>
                        <td><button class="btn btn-danger btn-sm" onclick="update_cart('delete','<?=$food['id'];?>')">delete</button></td>
                    </tr>

                    <?php 
                        $i++;
                        $item_count += $item['quantity'];
                        $sub_total += ($food['price'] * $item['quantity']);
                        }
                        $grand_total =  $sub_total;
                    ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-4">
            <table class="table table-bordered table-condensed text-right">
                <h3>Totals</h3>
                <thead class="totals-table-header">
                    <th>Total Items</th>
                    <th>Grand Total</th>
                </thead>
                <tr>
                    <td><?=$item_count;?></td>
                    <td>&cent <?=$grand_total; ?></td>
                </tr>
            </table>
            <button class="btn btn-warning pull-right" data-toggle="modal" data-target="#checkoutModal"> Check Out >></button>
        </div>
        <!-- Modal -->
        <div id="checkoutModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h4 class="modal-title" id="checkoutModalLabel">Delivery Address</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <form action="thanks.php" method="post" id=payment-form>
                                <span class="bg-danger" id="payment-errors"></span>
                                <input type="hidden" name="grand_total" value="<?=$grand_total;?>">
                                <input type="hidden" name="cart_id" value="<?=$cart_id;?>">
                                <input type="hidden" name="description" value="<?=$item_count.' item'.(($item_count > 1)?'s':'');?>">
                                <div id="step1" style="display:block;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="full_name">Full Name:</label>
                                                <input class="form-control" id="full_name" type="text" name="full_name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="email">Email:</label>
                                                <input class="form-control" id="email" type="email" name="email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="email">Phone Number:</label>
                                                <input class="form-control" id="phone" type="tel" name="phone">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="email">Hostel</label>
                                                <input class="form-control" id="hostel" type="text" name="hostel">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="email">Location</label>
                                                <input class="form-control" id="location" type="text" name="location">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="step2" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>Payment On delivery</p>
                                            <p class="text-center"><button type="submit" name="confirmOrders" class="btn btn-warning">Confirm Order</button></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                     <button type="button" class="btn btn-warning" onclick="back_address();" id="back_button" style="display: none;"><< Back </button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-warning" onclick="check_address();" id="next_button"> Next</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
            </div>
        </div>
    </div>
    <!-- order_area_end -->

<?php 
    include 'includes/footer.php';
?>

<script type="text/javascript">
    function update_cart(mode,edit_id){
        $.ajax({
          url : 'includes/add_to_cart.php',
          method : "POST",
          data : {updateCart: 1, mode :mode, edit_id :edit_id},
          success : function(data){
            location.reload();
        },
        error : function(){alert("Something went wrong.");},
        });
    }
    function back_address(){
        $('#payment-errors').html(""); 
        $('#step1').css("display","block");
        $('#step2').css("display","none");
        $('#next_button').css("display","inline-block");
        $('#back_button').css("display","none");
        $('#checkoutModalLabel').html("Delivery Address"); 
    }
function check_address(){
        var data = {
            'full_name' : $('#full_name').val(),
            'email' : $('#email').val(),
            'phone' : $('#phone').val(),
            'hostel' : $('#hostel').val(),
            'location' : $('#location').val(),
    };
    $.ajax({
        url : 'includes/address.php',
        method : 'POST',
        data : data,
        success : function(data){
            if(data != 'passed'){
                $('#payment-errors').html(data);
                
            }
            if(data == 'passed'){
                $('#payment-errors').html(""); 
                $('#step1').css("display","none");
                $('#step2').css("display","block");
                $('#next_button').css("display","none");
                $('#back_button').css("display","inline-block");
                $('#checkoutModalLabel').html("Enter Your Card Details");      
            }
        },
        error : function (){alert("Something went wrong");},
    });
    }
</script>


