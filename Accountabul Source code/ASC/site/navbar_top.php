<?php

    if(isset($_SESSION['jms_user_id']) && $_SESSION['jms_user_id'])
    {
        
        $jms_login = 0;
        $jms_user_id = $_SESSION['jms_user_id'];

        // get data

        $jms_select_sql = "SELECT * FROM `user-registration` WHERE id=:jms_user_id";
        $jms_select_data = $jms_pdo->prepare($jms_select_sql);
        $jms_select_data->bindParam(':jms_user_id', $jms_user_id,PDO::PARAM_INT);
        $jms_select_data->execute();
        $jms_row_get_navbar = $jms_select_data->fetchAll(PDO::FETCH_ASSOC);


        $jms_unlimited_deal = $jms_row_get_navbar[0]['jms_unlimited_deal'];
        $jms_no_save_deal = $jms_row_get_navbar[0]['jms_no_save_deal'];

        $jms_unlimited_buy = $jms_row_get_navbar[0]['jms_unlimited_buy'];
        $jms_no_save_buy = $jms_row_get_navbar[0]['jms_no_save_buy'];
        
        $jms_navbar = false;

        if((($jms_unlimited_buy == "Unlimited" && $jms_no_save_buy != 0) || ($jms_unlimited_buy == "Unlimited" && $jms_no_save_buy == 0) || ($jms_unlimited_buy == "" && $jms_no_save_buy != 0)))
        {
            $jms_navbar = true;
            $jms_login = 1;
        }
        else if((($jms_unlimited_deal == "Unlimited" && $jms_no_save_deal != 0) || ($jms_unlimited_deal == "Unlimited" && $jms_no_save_deal == 0) || ($jms_unlimited_deal == "" && $jms_no_save_deal != 0)))
        {
            $jms_navbar = true;
            $jms_login = 1;
        }
    }
    else
    {
        $jms_login = 0;
    }

    $jms_page_name = basename(substr("$_SERVER[REQUEST_URI]",strrpos("$_SERVER[REQUEST_URI]", "/") + 1),".php");
?>

    <style type="text/css">
        .jms-header 
        {
            color: #000;
            background: white;
        }
        .jms-navbar
        {
            box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;
        }
        .jms-header-color 
        {
            color: #000 !important;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 1px;
            text-align: center;
        }
        .jms-header-color:hover 
        {
            color: var(--main-orange-color) !important;
            transition: 0.5s;
        }
        .active 
        {
            background: var(--primary-color-blue);
            border-radius: 10px;
        }
        .active a 
        {
            color: white !important;
        }
        .active a:hover 
        {
            color: white !important;
        }
        .navbar-btn 
        {
            border: 2px solid var(--main-orange-color);
            color: white;
            font-size: 14px;
            padding: 7px 25px 8px 25px;
            text-align: center;
        }
        .navbar-btn:hover 
        {
            background-color: var(--main-orange-color);
            color: black !important;
            transition: 0.5s;
        }
        .navbar-toggler 
        {
            cursor: pointer;
            background: var(--main-orange-color) !important;
        }
        .jms-logo-name
        {
            font-size:1.5rem;
            font-weight:600;
            color: #000000;
        }
        .jms-header
        {
            box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
        }
        .jms-logo
        {
            width: 70px;
        }
    </style>

    <!-- Top Header -->

    <header class="navbar navbar-expand-lg navbar-light bg-white jms-navbar">
        <div class="container">
            <a class="navbar-brand" href="<?php echo $jms_login == 1 ? 'profile.php' : 'dashboard.php';?>">
                <img src="img/logo.png" alt="Logo" class="jms-logo">
            </a>

            <!-- <a class="navbar-brand d-flex align-items-center justify-content-center jms-logo-name" href="<?php echo $jms_login == 1 ? 'deal_evaluation.php' : 'index.php';?>">
                Logo<span style="color: #26a9e2;font-size:40px">.</span>
            </a> -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <?php 
                    if (isset($_SESSION['jms_user_id']) && $_SESSION['jms_user_id']): 
                ?>
                    <ul class="navbar-nav">
                        <?php
                            if($jms_page_name != "dashboard" && $jms_page_name != "conference_room")
                            {
                                if($jms_navbar == true):
                        ?>
                        <li class="nav-item <?php if($jms_page_name == "profile") echo "active";?>">
                            <a href="profile.php" class="nav-link jms-header-color">Profile</a>
                        </li>
                        <li class="nav-item <?php if($jms_page_name == "deal_evaluation") echo "active";?>">
                            <a href="deal_evaluation.php" class="nav-link jms-header-color">Deal Evaluation</a>
                        </li>
                        <!-- <li class="nav-item <?php if($jms_page_name == "buy_and_hold_analysis") echo "active";?>">
                            <a href="buy_and_hold_analysis.php" class="nav-link jms-header-color">Buy and Hold Analysis</a>
                        </li> -->
                        <li class="nav-item <?php if($jms_page_name == "comming_soon") echo "active";?>">
                            <a href="#" class="nav-link jms-header-color">Comming Soon</a>
                        </li>
                        <li class="nav-item <?php if($jms_page_name == "calculator_records") echo "active";?>">
                            <a href="calculator_records.php" class="nav-link jms-header-color">Calculator Records</a>
                        </li>
                        <?php
                                endif;
                        ?>
                        <li class="nav-item <?php if($jms_page_name == "payment") echo "active";?>">
                            <a href="payment.php" class="nav-link jms-header-color">Payment</a>
                        </li>
                        <?php
                            }
                        ?>
                        <li class="nav-item">
                            <a href="logout.php" class="nav-link jms-header-color">Logout</a>
                        </li>
                    </ul>
                <?php else: ?>
                    <ul class="navbar-nav">
                        <li class="nav-item <?php if($jms_page_name == "registration") echo "active";?>">
                            <a href="registration.php" class="nav-link jms-header-color">Registration</a>
                        </li>
                        <li class="nav-item <?php if($jms_page_name == "index" || $jms_page_name == "") echo "active";?>">
                            <a href="index.php" class="nav-link jms-header-color">Login</a>
                        </li>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- header end -->