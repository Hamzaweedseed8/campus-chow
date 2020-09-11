    <div class="wrapper">
        <div class="sidebar" data-image="../assets/img/sidebar-5.jpg">
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="#" class="simple-text">
                        Campus Chow
                    </a>
                </div>
                <ul class="nav">
                    <li class="nav-item dashboard">
                        <a class="nav-link" href="index.php">
                            <i class="nc-icon nc-chart-pie-35"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="foods">
                        <a class="nav-link" href="foods.php">
                            <i class="nc-icon nc-paper-2"></i>
                            <p>Foods</p>
                        </a>
                    </li>
                    <?php 
                        if($user_permission == 1){
                    ?>
                    <li class="restaurants">
                        <a class="nav-link" href="restaurants.php">
                            <i class="nc-icon nc-bank"></i>
                            <p>Restaurants</p>
                        </a>
                    </li>
                    <li class="mails">
                        <a class="nav-link" href="./mails.php">
                            <i class="nc-icon nc-circle-09"></i>
                            <p>Mails</p>
                        </a>
                    </li>
                    <?php } ?> 
                    <li class="orders">
                        <a class="nav-link" href="orders.php">
                            <i class="nc-icon nc-notes"></i>
                            <p>Orders</p>
                        </a>
                    </li>
                    <li class="">
                        <a class="nav-link" href="logout.php">
                            <i class="nc-icon nc-button-power"></i>
                            <p>Logout</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>