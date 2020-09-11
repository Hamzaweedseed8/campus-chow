<?php 
    require '../db.php';
    if (!isset($_SESSION['id'])) {
        header("Location: login.php");
    }
    include 'includes/head.php';
    include 'includes/sidebar.php';
    include 'includes/navbar.php';
    
    
    if($user_permission == 1){
        $sql = $con->query("SELECT * FROM rest_foods WHERE restaurant_id !=''");

        if(isset($_GET['view'])){
        $_id = $_GET['view'];
        $sql = $con->query("SELECT * FROM rest_foods WHERE id = '$_id'");
        $row = mysqli_fetch_array($sql);

        $r_id = $row['restaurant_id'];
        $rsql = $con->query("SELECT * FROM rest_admins WHERE id = '$r_id'");
        $Row = mysqli_fetch_array($rsql);

    ?>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card strpied-tabled-with-hover">
                        <div class="card-header ">
                            <h4 class="card-title"><?=$row['name'];?></h4>
                            <p class="card-category"></p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="../<?=$row['pictures'];?>" class="img-fluid">
                                </div>
                                <div class="col-md-8">
                                    <p>Price:  &cent<?=$row['price'];?></p>
                                    <p>Reaturant Name:  <?=$row['restaurant_name'];?></p>
                                    <p>Email: <?=$Row['email'];?></p>
                                    <p>Phone Number: <?=$Row['phone_number'];?></p>
                                    <p>
                                        <a class="btn btn-sm btn-primary" href="foods.php" title="Edit">back</a>
                                        
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
                            <h4 class="card-title">Foods List</h4>
                        </div>
                        <div class="card-body table-full-width table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <th>No.</th>
                                    <th>Food Name</th>
                                    <th>Price</th>
                                    <th>Restaurant Name</th>
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
                                            <td><?=$row['name'];?></td>
                                            <td><?=$row['price'];?></td>
                                            <td><?=$row['restaurant_name'];?></td>
                                                <td>
                                                    <a class="btn btn-sm btn-info" href="foods.php?view=<?=$row['id'];?>" title="Detail">detail</a>
                                                </td>
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

<?php
}
    }else{

    $sql = $con->query("SELECT * FROM rest_foods WHERE restaurant_id = '$user_id'");
    if(isset($_GET['delete'])){
        $_id = $_GET['delete'];
        $sql = $con->query("DELETE FROM rest_foods WHERE id = '$_id'");
        if($sql){
            echo "<script>window.location = 'foods.php';</script>";
        }
    }
    $error_msg = "";
    $dbpath = '';
    $saved_image = '';
    if(isset($_GET['add'])){
        if (isset($_POST['add'])) {
        $food_name = htmlspecialchars(mysqli_real_escape_string($con, $_POST['name']));
        $price = htmlspecialchars(mysqli_real_escape_string($con, $_POST['price']));
        if (!empty($food_name) && !empty($price)) {

            $allowed = array('png', 'jpeg', 'jpeg','gif');
            $uploadPath = array();
            $tmpLoc = array();
                $photoCount = count($_FILES['photo']['name']);
                if($photoCount > 0){
                    for($i = 0;$i<$photoCount;$i++){
                        $name = $_FILES['photo']['name'][$i];
                        $nameArray = explode('.', $name);
                        $fileName = $nameArray[0];
                        $fileExt  = $nameArray[1];
                        $mime = explode('/', $_FILES['photo']['type'][$i]);
                        $mimeType = $mime[0];
                        $mimeExt = $mime[1];
                        $tmpLoc[] = $_FILES['photo']['tmp_name'][$i];
                        $fileSize = $_FILES['photo']['size'][$i];
                        $uploadName = md5(microtime()).'.'.$fileExt;
                        $uploadPath[] = BASEURL.'assets/img/foods/'.$uploadName; 
                        if ($i != 0) {
                            $dbpath .= ',';
                        }
                        $dbpath .= 'assets/img/foods/' . $uploadName;
                        if ($mimeType != 'image') {
                            $error_msg .= 'The File must be an Image.';
                        }
                        if ($fileSize > 15000000) {
                            $error_msg .= 'The files size must be under 15MB.';
                        }
                    }
                }
            if (strlen($food_name) < 5) {
                $error_msg .= "name too short";
                die();
            }else{
                if($photoCount > 0){
                    for($i = 0; $i < $photoCount;$i++){
                        move_uploaded_file($tmpLoc[$i], $uploadPath[$i]);
                    }
                }
                $insert = $con->query("INSERT INTO rest_foods (name, restaurant_id, pictures, price, restaurant_name) VALUES ('$food_name', '$user_id', '$dbpath', '$price', '$restaurant_name')") or die(mysqli_error($con));
                if($insert){
                     echo "<script>window.location = 'foods.php';</script>";
                    // header('Location: foods.php');
                }
            }
        }else{
            $error_msg .= "Fill all form fields before submitting";
            die();
        }
    }
        ?>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header">
                        <h4 class="card-title">Add food</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="foods.php?add=1"  enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Food Name</label>
                                        <input type="text" class="form-control" required="" placeholder="Name" name="name">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input type="text" class="form-control" required="" placeholder="Price" name="price">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Images</label>
                                        <input type="file" name="photo[]" class="form-control" multiple required>
                                    </div>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-info pull-right " name="add" value="Submit">
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <?php
    }elseif(isset($_GET['edit'])){
        $_id = $_GET['edit'];
        $sql = $con->query("SELECT * FROM rest_foods WHERE id = '$_id'");
        $row = mysqli_fetch_array($sql);

        if (isset($_GET['delete_image'])) {
            $imgi = (int)$_GET['imgi'] - 1;
            if(!empty($row['pictures'])){
                $images = explode(',', $row['pictures']);
                $image_url = $_SERVER['DOCUMENT_ROOT'].'/campus_chow/'.$images[$imgi];
                unlink($image_url);
                unset($images[$imgi]);
                $imageString = implode(',', $images);
                $delteImg = $con->query("UPDATE rest_foods SET pictures = '{$imageString}' WHERE id = '$_id' ");
                if($delteImg){
                    header('Location: foods.php?edit='.$_id);
                    echo "<script>window.location = 'foods.php?edit=".$_id.";</script>";
                }
            }
        }

        $saved_image = (($row['pictures'] != '') ? $row['pictures'] : '');
        $dbpath = $saved_image;

        if (isset($_POST['edit'])) {
        $food_name = htmlspecialchars(mysqli_real_escape_string($con, $_POST['name']));
        $price = htmlspecialchars(mysqli_real_escape_string($con, $_POST['price']));
        if (!empty($food_name) && !empty($price)) {

            $allowed = array('png', 'jpeg', 'jpeg','gif');
            $uploadPath = array();
            $tmpLoc = array();
                $photoCount = count($_FILES['photo']['name']);
                if($photoCount > 0){
                    for($i = 0;$i<$photoCount;$i++){
                        $name = $_FILES['photo']['name'][$i];
                        $nameArray = explode('.', $name);
                        $fileName = $nameArray[0];
                        $fileExt  = $nameArray[1];
                        $mime = explode('/', $_FILES['photo']['type'][$i]);
                        $mimeType = $mime[0];
                        $mimeExt = $mime[1];
                        $tmpLoc[] = $_FILES['photo']['tmp_name'][$i];
                        $fileSize = $_FILES['photo']['size'][$i];
                        $uploadName = md5(microtime()).'.'.$fileExt;
                        $uploadPath[] = BASEURL.'assets/img/foods/'.$uploadName; 
                        if ($i != 0) {
                            $dbpath .= ',';
                        }
                        $dbpath .= 'assets/img/foods/' . $uploadName;
                        if ($mimeType != 'image') {
                            $error_msg .= 'The File must be an Image.';
                        }
                        if ($fileSize > 15000000) {
                            $error_msg .= 'The files size must be under 15MB.';
                        }
                    }
                }
            if (strlen($food_name) < 5) {
                $error_msg .= "name too short";
                die();
            }else{
                if($photoCount > 0){
                    for($i = 0; $i < $photoCount;$i++){
                        move_uploaded_file($tmpLoc[$i], $uploadPath[$i]);
                    }
                }
                $insert = $con->query("UPDATE rest_foods SET name = '$food_name', restaurant_id = '$user_id', pictures = '$dbpath', price = '$price', restaurant_name = '$restaurant_name' WHERE id = '$_id'") or die(mysqli_error($con));
                if($insert){
                     echo "<script>window.location = 'foods.php';</script>";
                    // header('Location: foods.php');
                }
            }
        }else{
            $error_msg .= "Fill all form fields before submitting";
            die();
        }
    }
    ?>
      <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header">
                        <h4 class="card-title">Edit food</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="foods.php?edit=<?=$_id;?>"  enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Food Name</label>
                                        <input type="text" class="form-control" required="" placeholder="Name" name="name" value="<?=$row['name'];?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input type="text" class="form-control" required="" placeholder="Price" name="price" value="<?=$row['price'];?>">
                                    </div>
                                </div>
                               </div>
                               <div class="row">

                                <?php
                                 if($saved_image != ''){
                                            $imgi = 1; 
                                            $images = explode(',',$saved_image);
                                        ?>
                                        <?php foreach ($images as $image){?>
                                            <div class="col-md-4">
                                            <div class="" style="width:100%">
                                                <img src="../<?=$image;?>" alt="saved image" style="height: 250px" class="img-fluid"><br>
                                                <a href="foods.php?delete_image=1&edit=<?=$_id;?>&imgi=<?=$imgi;?>" class="text-danger">Delete Image</a>
                                            </div>
                                        </div>
                                        <?php 
                                            $imgi++;
                                           }}else{
                                            ?>
                                            <div class="col-md-4">
                                            <label> Image</label>
                                            <input type="file" name="photo[]" class="form-control" multiple required>
                                        </div>
                                            <?php
                                           } ?>
                            </div>
                            <input type="submit" class="btn btn-info btn-sm " name="edit" value="Submit">
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <?php
    }elseif(isset($_GET['view'])){
        $_id = $_GET['view'];
        $sql = $con->query("SELECT * FROM rest_foods WHERE id = '$_id'");
        $row = mysqli_fetch_array($sql);
    ?>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card strpied-tabled-with-hover">
                        <div class="card-header ">
                            <h4 class="card-title"><?=$row['name'];?></h4>
                            <p class="card-category"></p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="../<?=$row['pictures'];?>" class="img-fluid">
                                </div>
                                <div class="col-md-8">
                                    <p>&cent <?=$row['price'];?></p>
                                    <p>
                                        <a class="btn btn-sm btn-primary" href="foods.php?edit=<?=$row['id'];?>" title="Edit">edit</a>
                                        <a href="foods.php?delete=<?=$row['id'];?>" title="Delete" class="btn btn-danger btn-sm">delete</a>
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
                            <h4 class="card-title">Foods List</h4>
                            <p class="card-category"><a href="foods.php?add=1" title="add" class="btn btn-info">Add food</a></p>
                        </div>
                        <div class="card-body table-full-width table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <th>No.</th>
                                <th>Food Name</th>
                                <th>Price</th>
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
                                                <td><?=$row['name'];?></td>
                                                <td><?=$row['price'];?></td>
                                                <td>
                                                    <a class="btn btn-sm btn-info" href="foods.php?view=<?=$row['id'];?>" title="Detail">detail</a>
                                                </td>
                                                <td>
                                                    <a class="btn btn-sm btn-primary" href="foods.php?edit=<?=$row['id'];?>" title="Edit">edit</a>

                                                </td>
                                                <th>
                                                    <a class="btn btn-sm btn-danger" href="foods.php?delete=<?=$row['id'];?>" title="Delete">delete</a>
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
    <?php } } ?>
 <?php include 'includes/footer.php' ?>
<script type="text/javascript">
    $(document).ready(function() {
       $('.navbar-brand').html("Foods List");
       $('title').html("Campus Chow | Foods List");
       $('li.foods').addClass("active")
    });
</script>

</body>
</html>