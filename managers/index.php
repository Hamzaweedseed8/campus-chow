<?php 
    require '../db.php';
    if (!isset($_SESSION['id'])) {
        header("Location: login.php");
    }
    
    include 'includes/head.php';
    include 'includes/sidebar.php';
    include 'includes/navbar.php';
?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card ">
                    <div class="card-header ">
                        <h4 class="card-title">Foods list</h4>
                    </div>
                    <div class="card-body ">
                        <?php 
                            if($user_permission == 1){
                                $sql = $con->query("SELECT * FROM rest_foods WHERE id != ''");
                                $count = mysqli_num_rows($sql);
                            }else{
                                $sql = $con->query("SELECT * FROM rest_foods WHERE id != '' AND restaurant_id = '$user_id'");
                                $count = mysqli_num_rows($sql);
                            }
                        ?>
                        <div class="row">
                            <div class="col-md-8">
                                <i class="nc-icon nc-paper-2"></i>
                            </div>
                            <div class="col-md-4">
                                <div><?=$count;?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                if($user_permission == 1){
                    $sql = $con->query("SELECT * FROM rest_admins WHERE id != '' AND permission = 0");
                    $count = mysqli_num_rows($sql);
            ?>
                <div class="col-md-3">
                    <div class="card ">
                        <div class="card-header ">
                            <h4 class="card-title">Restaurants</h4>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-8">
                                    <i class="nc-icon nc-bank"></i>
                                </div>
                                <div class="col-md-4">
                                    <div><?=$count;?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
    $(document).ready(function() {
       $('.navbar-brand').html("Dashboard");
       $('title').html("Campus Chow | Dashboard");
       $('li.dashboard').addClass("active")
    });
</script>

</body>
</html>