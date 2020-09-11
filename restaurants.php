<?php 
    require 'db.php';
 include 'includes/head.php';
 include 'includes/nav.php';

 $sql = $con->query("SELECT * FROM rest_admins WHERE id != 0 AND permission = 0");
?>

    <!-- breadcam_area_start -->
    <div class="breadcam_area breadcam_bg_1 zigzag_bg_2">
        <div class="breadcam_inner">
            <div class="breadcam_text">
                <h3>Our Restaurants</h3>
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
                ?>
                <div class="col-xl-4 col-md-6">
                    <div class="single_order">
                        <div class="order_thumb">
                            <img src="<?=$row['image'];?>" alt="">
                        </div>
                        <div class="order_info">
                            <h3><a href="#"><?=$row['restaurant_name'];?></a></h3>
                            <p><?=$row['restaurant_address'];?></p>
                            <a href="single-restaurant.php?details=<?=$row['id'];?>" class="boxed_btn">Explore</a>
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