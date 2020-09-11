<?php 
    require '../db.php';
    if (!isset($_SESSION['id'])) {
        header("Location: login.php");
    }
    include 'includes/head.php';
    include 'includes/sidebar.php';
    include 'includes/navbar.php';
    
    $sql = $con->query("SELECT * FROM rest_admins WHERE id != '' AND permission = 0");

    if(isset($_GET['delete'])){
        $_id = $_GET['delete'];
        $sql = $con->query("DELETE FROM rest_admins WHERE id = '$_id' AND permission = 0");
        if($sql){
            echo "<script>window.location = 'restaurants.php';</script>";
        }
    }
    $error_msg = "";
    if(isset($_GET['view'])){
        $_id = $_GET['view'];
        $sql = $con->query("SELECT * FROM rest_admins WHERE id = '$_id' AND permission = 0");
        $row = mysqli_fetch_array($sql);
    ?>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card strpied-tabled-with-hover">
                        <div class="card-header ">
                            <h4 class="card-title"><?=$row['restaurant_name'];?></h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- <img src="../<?=$row['pictures'];?>" class="img-fluid"> -->
                                </div>
                                <div class="col-md-8">
                                    <p><?=$row['restaurant_address'];?></p>
                                    <p><?=$row['full_name'];?></p>
                                    <p><?=$row['email'];?></p>
                                    <p><?=$row['phone_number'];?></p>
                                    <p>
                                        <a class="btn btn-sm btn-fill btn-primary" href="restaurants.php?edit=<?=$row['id'];?>" title="Edit">edit</a>
                                        <a href="restaurants.php?delete=<?=$row['id'];?>" title="Delete" class="btn btn-danger btn-fill btn-sm">delete</a>
                                    </p>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    }else{
 ?>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card strpied-tabled-with-hover">
                        <div class="card-header ">
                            <h4 class="card-title">Resatuarants</h4>
                        </div>
                        <div class="card-body table-full-width table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                if(mysqli_num_rows($sql) > 0){
                                                    $no = 1;
                                                while ($row = mysqli_fetch_array($sql)) {
                                             ?>
                                            <tr>
                                                <td><?=$no;?></td>
                                                <td><?=$row['restaurant_name'];?></td>
                                                <td><?=$row['restaurant_address'];?></td>
                                                <td><?=$row['email'];?></td>
                                                <td><?=$row['phone_number'];?></td>
                                                <td>
                                                    <a class="btn btn-sm btn-fill btn-info" href="restaurants.php?view=<?=$row['id'];?>" title="Detail">detail</a>
                                                </td>
                                                <th>
                                                    <a class="btn btn-sm btn-fill btn-danger" href="restaurants.php?delete=<?=$row['id'];?>" title="Delete">delete</a>
                                                </th>
                                            </tr>
                                            <?php 
                                            $no++;}
                                        }else{
                                            ?>
                                            <tr>
                                               <td colspan="5"> aww empty</td>
                                            </tr>
                                            <?php
                                        } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <?php } ?>
 <?php include 'includes/footer.php' ?>
<script type="text/javascript">
    $(document).ready(function() {
       $('.navbar-brand').html("Resatuarants");
       $('title').html("Campus Chow | Resatuarants");
       $('li.restaurants').addClass("active")
    });
</script>

</body>
</html>