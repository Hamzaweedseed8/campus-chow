<?php 
    require 'db.php';
 include 'includes/head.php';
 include 'includes/nav.php';
?>
    <!-- slider_area-start -->
    <div class="slider_area zigzag_bg_2">
        <div class="slider_sctive owl-carousel">
            <div class="single_slider slider_img_1">
                <div class="single_slider-iner">
                    <div class="slider_contant text-center">
                        <h3>Campus Chow</h3>
                            <p></p>
                    </div>
                </div>
            </div>
            <div class="single_slider slider_img_1">
                <div class="single_slider-iner">
                    <div class="slider_contant text-center">
                        <h3>Campus Chow</h3>
                            <p></p>
                    </div>
                </div>
            </div>
            <div class="single_slider slider_img_1">
                <div class="single_slider-iner">
                    <div class="slider_contant text-center">
                        <h3>Campus Chow</h3>
                            <p></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- order_area_start -->
    <?php 
        $sql = $con->query("SELECT * FROM rest_admins WHERE id != 0 AND permission = 0 LIMIT 6");
    ?>
    <div class="order_area">
        <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="section_title mb-70">
                            <h3>Popular Restaurants</h3>
                        </div>
                    </div>
                </div>
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
<?php 
    include 'includes/footer.php';
?>

