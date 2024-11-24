<?php
    // include("../connection.php");
    if(!isset($_SESSION['jms_admin_user_id']))
    {
        header("location:index.php");
    } 
?>

<style type="text/css">
    .fname-lname
    {
        padding: 8px 8px;
        background-color: #cfcfcf;
        color: black;
        border-radius: 50%;
        font-size: 0.8rem;
        margin-right:6px;
    }
    .user-panel .info 
    {
        padding: 5px 5px 5px 5px !important;
    }
    .user-panel .image 
    {        
        padding-top: 4px !important;
    }
    .brand-link .brand-image 
    {
        margin-left: 0.5rem !important;
    } 
       
</style>
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="themes.php" class="brand-link">
            <!--<img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light"></span>-->
        </a>
        <?php

            $jms_admin_user_id=$_SESSION['jms_admin_user_id'];
            $jms_select_sql_admin = "SELECT * FROM admin WHERE id = :jms_admin_user_id";

            $jms_select_data_admin = $jms_pdo->prepare($jms_select_sql_admin);
            $jms_select_data_admin->bindParam(':jms_admin_user_id', $jms_admin_user_id, PDO::PARAM_INT);
            $jms_select_data_admin->execute();
            $jms_row_view = $jms_select_data_admin->fetchAll(PDO::FETCH_ASSOC);

            $jms_users_data = $jms_row_view[0];
        ?>
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <!-- <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
                    <a href="requested.php">
                        <span class="fname-lname img-circle elevation-2"><?php echo strtoupper(substr($jms_users_data["jms_first_name"],0,1)); ?> <?php echo strtoupper(substr($jms_users_data["jms_last_name"],0,1)); ?></span>
                    </a>
                </div>
                <div class="info">                    
                    <a href="requested.php" class="d-block">
                        <?php echo ucfirst($jms_users_data["jms_first_name"]); ?> <?php echo ucfirst($jms_users_data["jms_last_name"]); ?>
                    </a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="requested.php" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                Users Request
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="all_users.php" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                All Users
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="setting.php" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                Setting
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="change_password.php" class="nav-link">
                            <i class="nav-icon fas fa-key"></i>
                            <p>
                                Change Password
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i><i class=""></i>
                            <p>
                                Logout
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</div>