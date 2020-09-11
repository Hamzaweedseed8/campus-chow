<?php 
    require '../db.php';
    include 'includes/head.php';
    if (isset($_SESSION['id'])) {
        echo "<script>window.location = 'index.php';</script>";
    }
    $error_msg = '';
    if(isset($_POST['signin'])) {
        $email = htmlspecialchars(mysqli_real_escape_string($con, $_POST['email']));
        $password = htmlspecialchars(mysqli_real_escape_string($con, $_POST['password']));
        $password = sha1($password);
        $check = $con->query("SELECT * FROM rest_admins WHERE email = '$email' AND password = '$password'") or die(mysqli_error($con));
        if (mysqli_num_rows($check) > 0) {
            while ($row = mysqli_fetch_assoc($check)) {
                $_SESSION['id'] = $row['id'];
                $_SESSION['email'] = $row['email'];
            }
            echo "<script>window.location = 'index.php';</script>";
        }else{
            $error_msg .= "Invalid email or password";
        }
    }
?>
    <div class="container">
        <div class="row LoginContent">
            <div class="col-md-5">
                <div class="card">
                    <?php if(isset($_POST['signin'])):?>
        <p align="center"><?= $error_msg;?></p>
    <?php endif;?>
                    <div class="card-header">
                        <h4 class="card-title text-center">Login</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="login.php">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="email" class="form-control" required="" placeholder="Email" name="email">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="password" class="form-control" required="" placeholder="Password" name="password">
                                    </div>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-info pull-right " name="signin" value="Submit">
                            <br>
                            <br>
                            <p class="text-center">Not Yet A Member? <a href="signup.php">Sign Up</a></p>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>