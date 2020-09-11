<?php 
    require '../db.php';
    if (!isset($_SESSION['id'])) {
        header("Location: login.php");
    }
    include 'includes/head.php';
    include 'includes/sidebar.php';
    include 'includes/navbar.php';
    
        $sql = $con->query("SELECT * FROM mails WHERE id !='' ORDER BY dated");
        if(isset($_GET['delete'])){
            $d_id = $_GET['delete'];
            $sql = $con->query("DELETE FROM mails WHERE id = '$d_id'");
            if($sql){
                echo "<script>window.location = 'mails.php';</script>";
            }
        }
        if(isset($_GET['view'])){
            $_id = $_GET['view'];
            $sql = $con->query("SELECT * FROM mails WHERE id = '$_id'");
            $row = mysqli_fetch_array($sql);

    ?>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card strpied-tabled-with-hover">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <p>Full Name: <?=$row['full_name'];?></p>
                                    <p>Phone:  <?=$row['phone'];?></p>
                                    <p>Email: <?=$row['email'];?></p>
                                    <p> <?=$row['message'];?></p>
                                    <p>
                                        <a class="btn btn-sm btn-primary" href="mails.php" title="Edit">back</a>
                                        <a href="mails.php?delete=<?=$_id;?>" class="btn-sm btn btn-danger">delete</a>
                                        
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
                            <h4 class="card-title">Mails</h4>
                        </div>
                        <div class="card-body table-full-width table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <th>No.</th>
                                    <th>Full Name</th>
                                    <th>Phone</th>
                                    <th>Sent Date</th>
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
                                            <td><?=$row['full_name'];?></td>
                                            <td><?=$row['phone'];?></td>
                                            <td><?=pretty_date($row['dated']);?></td>
                                                <td>
                                                    <a class="btn btn-sm btn-info" href="mails.php?view=<?=$row['id'];?>" title="Detail">detail</a>
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
 include 'includes/footer.php' ?>
<script type="text/javascript">
    $(document).ready(function() {
       $('.navbar-brand').html("Mails");
       $('title').html("Campus Chow | Mails");
       $('li.mails').addClass("active")
    });
</script>

</body>
</html>