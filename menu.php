<?php 
    require 'db.php';
 include 'includes/head.php';
 include 'includes/nav.php';

 $sql = $con->query("SELECT * FROM rest_foods WHERE id != 0");
?>
    <!-- breadcam_area_start -->
    <div class="breadcam_area breadcam_bg_1 zigzag_bg_2">
        <div class="breadcam_inner">
            <div class="breadcam_text">
                <h3>Our Menus</h3>
            </div>
        </div>
    </div>
    <!-- breadcam_area_end -->

    <!-- order_area_start -->
    <div class="order_area">
        <div class="container">
            <div class="row">
                <?php 
                    while ($row = mysqli_fetch_array($sql)) {
                        $photos = explode(',',$row['pictures']);
                ?>
                <div class="col-xl-4 col-md-6">
                    <div class="single_order">
                        <div class="order_thumb">
                            <img src="<?=$photos[0];?>" alt="">
                            <div class="order_prise">
                                <span><?=$row['price'];?></span>
                            </div>
                        </div>
                        <div class="order_info">
                            <h3><a href="#"><?=$row['name'];?></a></h3>
                            <div>
                                <?=$row['restaurant_name'];?>
                            </div>
                            <a id="orderDetails" pid="<?=$row['id'];?>" class="boxed_btn">Order Now</a>
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
$(document).ready(function() {
    $("body").delegate("#orderDetails", "click", function(event) {
        event.preventDefault();
        var id = $(this).attr("pid");
        $.ajax({
            url: "includes/modal.php",
            method: "POST",
            data: {orderNow: 1, id: id},
            success: function(data) {
                $('body').append(data);
            $('#details-modal').modal('toggle');
            }
        })
    });
     $("body").delegate("#addToCart", "click", function(event) {
        $('#modal_errors').html("");
        var quantity = $('#quantity').val();
        var id = $(this).attr('cartid');
        var error = '';
        if(quantity == '' || quantity == 0){
            error += '<p class="bg-danger text-center">You must choose a quantity.</p>';
            $('#modal_errors').html(error);
            return;
        }else {
            $.ajax({
                url : 'includes/add_to_cart.php',
                method : 'POST',
                data : {add_to_cart: 1,id: id, quantity: quantity},
                success : function(){
                location.reload();
                },
                error : function(){alert("Something went wrong");}
            });
        }
    });

});
</script>