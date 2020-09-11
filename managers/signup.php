<?php 
    require '../db.php';
    include 'includes/head.php';
    $error_msg = '';
    $dbpath = '';
    $saved_image = '';
    if (isset($_POST['signup'])) {
        $full_name = htmlspecialchars(mysqli_real_escape_string($con, $_POST['full_name']));
        $email = htmlspecialchars(mysqli_real_escape_string($con, $_POST['email']));
        $phone = htmlspecialchars(mysqli_real_escape_string($con, $_POST['phone']));
        $rest_name = htmlspecialchars(mysqli_real_escape_string($con, $_POST['rest_name']));
        $password = htmlspecialchars(mysqli_real_escape_string($con, $_POST['password']));
        $rest_address = htmlspecialchars(mysqli_real_escape_string($con, $_POST['rest_address']));
        if (!empty($full_name) && !empty($email) && !empty($phone) && !empty($rest_name) && !empty($rest_address)) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error_msg .= 'Invalid Email Address';
                
            }elseif (strlen($full_name) < 5) {
                $error_msg .= "Full name too short";
                
            }elseif (strlen($password) < 6){
                $error_msg .= "Password too weak";
                
            }else{
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
                            $uploadPath[] = BASEURL.'managers/assets/img/managers/'.$uploadName; 
                            if ($i != 0) {
                                $dbpath .= ',';
                            }
                            $dbpath .= 'managers/assets/img/managers/' . $uploadName;
                            if ($mimeType != 'image') {
                                $error_msg .= 'The File must be an Image.';
                                
                            }
                            if ($fileSize > 15000000) {
                                $error_msg .= 'The files size must be under 15MB.';
                                
                            }
                        }
                    }

                $password = sha1($password);
                $check = $con->query("SELECT * FROM rest_admins WHERE email = '$email'");
                if (mysqli_num_rows($check) > 0) {
                    $error_msg .= "Account with the email already exists";
                    
                }else{
                    if($photoCount > 0){
                    for($i = 0; $i < $photoCount;$i++){
                        move_uploaded_file($tmpLoc[$i], $uploadPath[$i]);
                    }
                }
                $add_acc = $con->query("INSERT INTO rest_admins (full_name, email, phone_number, restaurant_name, restaurant_address, password, image) VALUES ('$full_name', '$email', '$phone', '$rest_name', '$rest_address', '$password', '$dbpath')") or die(mysqli_error($con));
                if ($add_acc) {
                    while ($row = mysqli_fetch_assoc($check)) {
                        $_SESSION['id'] = $row['id'];
                        $_SESSION['email'] = $row['email'];
                    }
                    echo "<script>window.location = 'index.php';</script>";
                }
                }
            }
        }else{
            $error_msg .= "Fill all form fields before submitting";
            
        }
    }
?>
    <div class="container">
        <div class="row LoginContent">
            <div class="col-md-6">
                <div class="card">
                    <?php if(isset($_POST['signup'])):?>
        <p align="center"><?= $error_msg;?></p>
    <?php endif;?>
                    <div class="card-header">
                        <h4 class="card-title text-center">Register</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="signup.php"  enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" required="" placeholder="Full Name" name="full_name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control" required="" placeholder="Email" name="email">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="password" class="form-control" required="" placeholder="Password" name="password">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="tel" class="form-control" required="" placeholder="Phone Number" name="phone">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" required="" placeholder="Restaurant Name" name="rest_name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" required="" placeholder="Restaurant Address" name="rest_address">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Images</label>
                                        <input type="file" name="photo[]" class="form-control" multiple required>
                                    </div>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-info pull-right text-right " name="signup" value="submit">
                            <p class="text-center">Alredy A Member? <a href="login.php">Sign In</a></p>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>