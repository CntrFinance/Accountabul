<?php 
    include('connection.php');

    if(!isset($_SESSION['jms_user_id']))
    {
        header("location:index.php");
    }

    include("header.php");
    include("setting.php");

    $jms_user_id = $_SESSION['jms_user_id'];

    $jms_select_sql = "SELECT * FROM `user-registration` WHERE id=:jms_user_id";

    $jms_select_data = $jms_pdo->prepare($jms_select_sql);
    $jms_select_data->bindParam(':jms_user_id',$jms_user_id,PDO::PARAM_INT);
    $jms_select_data->execute();
    $jms_row = $jms_select_data->fetchAll(PDO::FETCH_ASSOC);

    $jms_a = false;

    $jms_unlimited_deal = $jms_row[0]['jms_unlimited_deal'];
    $jms_no_save_deal = $jms_row[0]['jms_no_save_deal'];

    if((($jms_unlimited_deal == "Unlimited" && $jms_no_save_deal != 0) || ($jms_unlimited_deal == "Unlimited" && $jms_no_save_deal == 0) || ($jms_unlimited_deal == "" && $jms_no_save_deal != 0)))
    {
        $jms_a = true;
    }
    // else if(count($jms_row_deal) > 0)
    // {
    //     $jms_a = true;
    // }
    else
    {
        $jms_a = false;
        header("location:dashboard.php");
    }

    $jms_image_src = $jms_select_data->rowCount() != 0 ? $jms_row[0]['profile_upload'] : '';

    // paypal

    $jms_select_sql_paypal = "SELECT * FROM `paypal_payments_subscription` WHERE users_id=:jms_user_id AND jms_paypal_status='ACTIVE'";

    $jms_select_data_paypal = $jms_pdo->prepare($jms_select_sql_paypal);
    $jms_select_data_paypal->bindParam(':jms_user_id',$jms_user_id,PDO::PARAM_INT);
    $jms_select_data_paypal->execute();
    $jms_row_paypal = $jms_select_data_paypal->fetchAll(PDO::FETCH_ASSOC);

    // stripe

    $jms_select_sql_stripe = "SELECT * FROM `stripe_payments_subscription` WHERE users_id=:jms_user_id AND jms_stripe_status='active'";

    $jms_select_data_stripe = $jms_pdo->prepare($jms_select_sql_stripe);
    $jms_select_data_stripe->bindParam(':jms_user_id',$jms_user_id,PDO::PARAM_INT);
    $jms_select_data_stripe->execute();
    $jms_row_stripe = $jms_select_data_stripe->fetchAll(PDO::FETCH_ASSOC);


    function formatText($text) 
    {
        $text = str_replace('-', ' ', $text);
        $text = ucwords($text);
        $text = ucfirst($text);
        return $text;
    }

    function save($pass,$pass1,$save1,$save2)
    {
        if($pass1 == 'deal-evalution')
        {
            $jms_a = $save1;
        }
        else if($pass1 == 'buy-and-hold-analysis')
        {
            $jms_a = $save2;
        }

        $amount = $pass;
        $amount_cleaned = str_replace(['$', ' '], '', $amount);
        $amount_float = floatval($amount_cleaned);
        $result = $amount_float / $jms_a;
        return $result;
    }


    // get data cancel records date
 
    $jms_select_cancel_sql = "SELECT * FROM `cancel_subscription` WHERE users_id=:jms_user_id";
    $jms_select_cancel_data = $jms_pdo->prepare($jms_select_cancel_sql);
    $jms_select_cancel_data->bindParam(':jms_user_id', $jms_user_id,PDO::PARAM_INT);
    $jms_select_cancel_data->execute();
    $jms_row_cancel = $jms_select_cancel_data->fetchAll(PDO::FETCH_ASSOC);

    function compareDates($date1, $date2) 
    {
        if($date1 != "" && $date2 != "")
        {
            $timestamp1 = strtotime($date1);
            $timestamp2 = strtotime($date2);
            
            return $timestamp1 <= $timestamp2;
        }
        else
        {
            return false;
        }
    }


    // get data purchase save

    $jms_select_sql = "SELECT 
        'Stripe' AS payment_type, 
        `id`, 
        `users_id`, 
        `transation_id`, 
        `save_num`, 
        `amount`, 
        `status`, 
        `purchase`,
        `created_on`,
        NULL AS payer_id
    FROM `stripe_payments_purchase` 
    WHERE users_id = :jms_user_id 

    UNION ALL

    SELECT 
        'PayPal' AS payment_type, 
        `id`, 
        `users_id`, 
        `transation_id`, 
        `save_num`, 
        `amount`, 
        `status`, 
        `purchase`,
        `created_on`,
        `payer_id`
    FROM `paypal_payments_purchase` 
    WHERE users_id = :jms_user_id 

    ORDER BY id DESC";

    $jms_select_data = $jms_pdo->prepare($jms_select_sql);
    $jms_select_data->bindParam(':jms_user_id', $jms_user_id, PDO::PARAM_INT);
    $jms_select_data->execute();
    $jms_row_1 = $jms_select_data->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <!-- css link -->
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/loading.css">

    <style type="text/css">
        .jms-cp-link
        {
            text-decoration: none;
        }
        .jms-cp-link:hover
        {
            color: white;
        }
        .jms-btn
        {
            font-family: var(--main-font);
            display: inline-block;
            background: var(--primary-color-blue);
            color: #fff;
            border: none;
            width: auto;
            padding: 10px 30px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 15px;
            text-decoration: none;
        }
        .jms-btn-cancel
        {
            background: var(--danger-color-red);
            border: none;

            font-family: var(--main-font);
            display: inline-block;
            color: #fff;
            width: auto;
            padding: 10px 30px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 15px;
            text-decoration: none;
        }
        .jms-btn:focus,.jms-btn-cancel:focus
        {
            box-shadow: none !important;
        }
        .jms-btn:hover
        {
            background-color: #4292dc;
            border-color: var(--primary-color-blue);
        }
        .jms-btn-cancel:hover
        {
            background-color: var(--danger-color-red);
            border-color: var(--danger-color-red);
        }
        .jms-container .table-hover>tbody>tr:hover
        {
            --bs-table-accent-bg: #007dfe1c !important;
        }
        .jms-img-icon
        {
            border-radius: 100px;
        }
    </style>
</head>

<body class="jms-bg">

<?php include("navbar_top.php");?>

    <div class="container">

        <div class="jms-container mt-5 mx-lg-5 mx-md-5 ">
            <div class="row mt-3 d-flex align-items-center p-lg-0 p-3">

                <div class="col-lg-5 mb-lg-0 mb-5">
                    <div class="bg-c-lite-green jms-user-profile">
                        <div class="text-center mt-3">

                            <?php
                                if($jms_image_src == "")
                                {
                            ?>
                            <span class=" text-white jms-span ">
                                <span class="fname-lname img-circle elevation-2"><?php echo strtoupper(substr($jms_row[0]["jms_first_name"],0,1)); ?> <?php echo strtoupper(substr($jms_row[0]["jms_last_name"],0,1)); ?></span>
                            </span>
                            <?php
                                }
                                else
                                {
                            ?>
                            <img style="width: 100px;height: 100px;" class="jms-img-icon" src="img/user_upload_img/<?php echo $jms_image_src;?>" id="jms_image_display" name="jms_image_display">
                            <?php
                                }
                            ?>
                        </div>

                        
                        
                        <h6 class="text-center mt-4 text-white"><?php echo ucfirst($jms_row[0]['jms_first_name']).' '.ucfirst($jms_row[0]['jms_last_name']);?></h6>
                        <!-- <div class="text-center mt-3">
                            <a class="jms-cp-link" href="change_password.php">Change Password</a>
                        </div> -->
                    </div>
                </div>

                <div class="col-lg-7 px-lg-5 ">
                    <div class="jms-c"><h2 class="m-0 jms-prof-info ">Information</h2></div>
                    <div class="row ">
                        <div class="col-lg-8 col-md-7 col-12 mt-3">
                            <div class="text-muted ">First Name:</div>
                            <h6 class="jms-info-detail"><?php echo $jms_row[0]['jms_first_name'];?></h6>
                        </div>
                        <div class="col-lg-4 col-md-5 col-12 mt-3">
                            <div class="text-muted">Last Name:</div>
                            <h6 class="jms-info-detail"><?php echo $jms_row[0]['jms_last_name'];?></h6>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-lg-8 col-md-7 col-sm-12 col-12 mt-3 ">
                            <div class="text-muted ">Email:</div>
                            <h6 class="jms-info-detail"><?php echo $jms_row[0]['jms_email_id'];?></h6>
                        </div>
                        <div class="col-lg-4 col-md-5 col-sm-12 col-12 mt-3">
                            <div class="text-muted">Gender:</div>
                            <h6 class="jms-info-detail pb-lg-0 pb-5"><?php echo ucfirst($jms_row[0]['jms_gender']);?></h6>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-lg-8 col-md-7 col-sm-12 col-12 mt-3 ">
                            <div class="text-muted ">Birthdate:</div>

                            <h6 class="jms-info-detail"><?php echo date('m/d/Y', strtotime($jms_row[0]['jms_birthdate']));?></h6>
                        </div>
                        <div class="col-lg-4 col-md-5 col-sm-12 col-12 mt-3">

                            <?php
                                $birthdate = $jms_row[0]['jms_birthdate'];
                                $currentDate = new DateTime();
                                $birthDate = new DateTime($birthdate);

                                $age = $currentDate->diff($birthDate)->y;
                            ?>

                            <div class="text-muted">Age:</div>
                            <h6 class="jms-info-detail pb-lg-0 pb-5"><?php echo $age;?> Years</h6>
                        </div>
                    </div>
                    <div class="row justify-content-end mt-3">
                        <div class="col-md-12 d-flex justify-content-between">
                            <a class="jms-btn btn btn-primary" href="change_password.php">Change Password</a>
                            <a class="jms-btn btn btn-primary" href="edit_profile_information.php">Profile Edit</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <?php
        if(isset($jms_row[0]['jms_no_save_deal']) && $jms_row[0]['jms_no_save_deal'] != 0 || isset($jms_row[0]['jms_no_save_buy']) && $jms_row[0]['jms_no_save_buy'] != 0)
        {
        ?>
        <div class="jms-container my-5 mx-lg-5 mx-md-5 p-4">
            <div class="row">
                <div class="col-md-12">
                    <table class="table mb-0 table-hover" id="jms_list">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center h3">Total Saves Remaining</th>
                            </tr>
                        </thead>
                        <?php
                            if(isset($jms_row[0]['jms_no_save_deal']))
                            {
                        ?>
                        <tr>
                            <td>Deal Evaluation</td>
                            <td><?php echo $jms_row[0]['jms_no_save_deal'];?></td>
                        </tr>
                        <?php
                            }

                            if(isset($jms_row[0]['jms_no_save_buy']))
                            {
                            ?>
                        <tr>
                            <td>Buy and Hold Analysis</td>
                            <td><?php echo $jms_row[0]['jms_no_save_buy'];?></td>
                        </tr>
                        <?php
                            }
                        ?>
                    </table>        
                </div>                
            </div>
        </div>
        <?php
        }
        ?>

        <!-- save more purchase -->
        <?php
            if(count($jms_row_1) > 0)
            {
        ?>
        <div class="jms-container my-5 mx-lg-5 mx-md-5 p-4">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-hover" id="jms_list">
                        <thead>
                            <tr>
                                <th colspan="4" class="text-center h3">Payments History</th>
                            </tr>
                        </thead>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Payment Methods</th>
                                <th>Save</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                for ($i=0; $i < count($jms_row_1); $i++) 
                                { 
                            ?>
                            <tr>
                                <td><?php echo date('m/d/Y', strtotime($jms_row_1[$i]['created_on'])); ;?></td>
                                <td><?php echo $jms_row_1[$i]['payment_type'];?></td>
                                <td><?php echo save($jms_row_1[$i]['amount'],$jms_row_1[$i]['purchase'],$jms_deal_evalution_save_price,$jms_buy_and_hold_analysis_price);?></td>
                                <td><?php echo $jms_row_1[$i]['amount'];?></td>
                            </tr>
                            <?php
                                }

                            ?>
                            
                        </tbody>
                    </table>        
                </div>                
            </div>
        </div>
        <?php
            }
        ?>

        <!-- suncription purchase -->
        <?php
            if((count($jms_row_paypal) == 1 && count($jms_row_stripe) == 1) || (count($jms_row_paypal) == 1 || count($jms_row_stripe) == 1))
            {
        ?>
        <div class="jms-container my-5 mx-lg-5 mx-md-5 p-4">
            <div class="row">
                <div class="col-md-12">
        <?php 
                if(count($jms_row_paypal) == 1)
                {
                    if(isset($jms_row_paypal[0]['jms_paypal_status']) && $jms_row_paypal[0]['jms_paypal_status'] == 'ACTIVE') 
                    {
        ?>
                        <div class="card my-3 mx-lg-3 mx-md-3">
                            <div class="card-body">
                                <input type="hidden" id="jms_record_id" name="jms_record_id" value="<?php echo $jms_row_paypal[0]['id'];?>">
                                <input type="hidden" id="jms_purchase_name" name="jms_purchase_name" value="<?php echo $jms_row_paypal[0]['purchase'];?>">
                                <p class="card-text mb-1 fw-bold">PayPal</p>
                                <p class="card-text mb-1">Subscription Name: <span><?php echo formatText($jms_row_paypal[0]['purchase']);?></span></p>
                                <p class="card-text mb-1">Email ID: <span><?php echo $jms_row_paypal[0]['jms_paypal_email_id'];?></span></p>
                                <p class="card-text mb-1">Card Holder: <span><?php echo $jms_row_paypal[0]['jms_paypal_name'];?></span></p>
                                <p class="card-text mb-1">Status: <span><?php echo $jms_row_paypal[0]['jms_paypal_status'];?></span></p>
                                <p class="card-text mb-1">Start Date: <span><?php echo date('m/d/Y', strtotime($jms_row_paypal[0]['jms_paypal_starts_date']));?></span></p>
                                <p class="card-text mb-1">Customer ID: <span><?php echo $jms_row_paypal[0]['jms_paypal_customer_id'];?></span></p>
                                <p class="card-text mb-1">Subscription ID: <span id="jms_subscription_id" name="jms_subscription_id"><?php echo $jms_row_paypal[0]['jms_paypal_subscriptionid'];?></span></p>
                                <p class="card-text mb-1">Order ID: <span><?php echo $jms_row_paypal[0]['jms_paypal_orderid'];?></span></p>
                                
                                <div class="jms-message"></div>

                                <div class="col-md-12 d-flex justify-content-center">
                                    <div class="jms-loader" id="jms_loading"></div>
                                </div>

                                <input type="button" class="jms-btn-cancel jms-btn-cancel-paypal btn btn-danger" id="jms_paypal_cancel_btn" name="jms_paypal_cancel_btn" value="Subscription Cancel">
                            </div>
                        </div>
        <?php 
                    }
                }
                
                if(count($jms_row_stripe) == 1)
                {
                    if(isset($jms_row_stripe[0]['jms_stripe_status']) && $jms_row_stripe[0]['jms_stripe_status'] == 'active') 
                    {
        ?>
                        <div class="card my-3 mx-lg-3 mx-md-3">
                            <div class="card-body">
                                <input type="hidden" id="jms_purchase_name1" name="jms_purchase_name1" value="<?php echo $jms_row_stripe[0]['purchase'];?>">
                                <p class="card-text mb-1 fw-bold">Stripe</p>
                                <p class="card-text mb-1">Subscription Name: <span><?php echo formatText($jms_row_stripe[0]['purchase']);?></span></p>
                                <p class="card-text mb-1">Email ID: <span><?php echo $jms_row_stripe[0]['jms_stripe_email_id'];?></span></p>
                                <p class="card-text mb-1">Card Holder: <span><?php echo $jms_row_stripe[0]['jms_stripe_name'];?></span></p>
                                <p class="card-text mb-1">Status: <span><?php echo $jms_row_stripe[0]['jms_stripe_status'];?></span></p>
                                <p class="card-text mb-1">Start Date: <span><?php echo 
                                date('m/d/Y', strtotime($jms_row_stripe[0]['jms_stripe_starts_data']));?></span></p>
                                <p class="card-text mb-1">Customer ID: <span><?php echo $jms_row_stripe[0]['jms_stripe_customer_id'];?></span></p>
                                <p class="card-text mb-1">Subscription ID: <span id="jms_subscription_id" name="jms_subscription_id"><?php echo $jms_row_stripe[0]['jms_stripe_subscription_id'];?></span></p>

                                <div class="jms-message"></div>

                                <div class="col-md-12 d-flex justify-content-center">
                                    <div class="jms-loader" id="jms_loading"></div>
                                </div>

                                <input type="button" class="jms-btn-cancel jms-btn-cancel-stripe btn btn-danger" id="jms_stripe_cancel_btn" name="jms_stripe_cancel_btn" value="Subscription Cancel">
                            </div>
                        </div>
        <?php   
                    }
                }
        ?>
                </div>
            </div>
        </div>
        <?php
            }
        
            if((count($jms_row_paypal) == 2 && count($jms_row_stripe) == 2) || (count($jms_row_paypal) == 2 || count($jms_row_stripe) == 2))
            {
        ?>      
        <div class="jms-container my-5 mx-lg-5 mx-md-5 p-4">
            <div class="row">
                <div class="col-md-12"> 
        <?php 
            
            if(count($jms_row_paypal) == 2)
            {
                for ($i=0; $i < count($jms_row_paypal); $i++) 
                { 
                    ?>
                        <div class="card my-3 mx-lg-3 mx-md-3">
                            <div class="card-body">
                                <input type="hidden" id="jms_record_id" name="jms_record_id" value="<?php echo $jms_row_paypal[0]['id'];?>">
                                <input type="hidden" id="jms_purchase_name" name="jms_purchase_name" value="<?php echo $jms_row_paypal[$i]['purchase'];?>">
                                <p class="card-text mb-1 fw-bold">PayPal</p>
                                <p class="card-text mb-1">Subscription Name: <span><?php echo formatText($jms_row_paypal[$i]['purchase']);?></span></p>
                                <p class="card-text mb-1">Email ID: <span><?php echo $jms_row_paypal[$i]['jms_paypal_email_id'];?></span></p>
                                <p class="card-text mb-1">Card Holder: <span><?php echo $jms_row_paypal[$i]['jms_paypal_name'];?></span></p>
                                <p class="card-text mb-1">Status: <span><?php echo $jms_row_paypal[$i]['jms_paypal_status'];?></span></p>
                                <p class="card-text mb-1">Start Date: <span><?php echo date('m/d/Y', strtotime($jms_row_paypal[$i]['jms_paypal_starts_date']));?></span></p>
                                <p class="card-text mb-1">Customer ID: <span><?php echo $jms_row_paypal[$i]['jms_paypal_customer_id'];?></span></p>
                                <p class="card-text mb-1">Subscription ID: <span id="jms_subscription_id" name="jms_subscription_id"><?php echo $jms_row_paypal[$i]['jms_paypal_subscriptionid'];?></span></p>
                                <p class="card-text mb-1">Order ID: <span><?php echo $jms_row_paypal[$i]['jms_paypal_orderid'];?></span></p>
                                
                                <div class="jms-message"></div>

                                <div class="col-md-12 d-flex justify-content-center">
                                    <div class="jms-loader" id="jms_loading"></div>
                                </div>

                                <input type="button" class="jms-btn-cancel jms-btn-cancel-paypal btn btn-danger" id="jms_paypal_cancel_btn" name="jms_paypal_cancel_btn" value="Subscription Cancel">
                            </div>
                        </div>
                    <?php
                }
            }
            
            if(count($jms_row_stripe) == 2)
            {
                for ($i=0; $i < count($jms_row_stripe); $i++) 
                { 
                    ?>
                        <div class="card my-3 mx-lg-3 mx-md-3">
                            <div class="card-body">
                                <input type="hidden" id="jms_purchase_name1" name="jms_purchase_name1" value="<?php echo $jms_row_stripe[$i]['purchase'];?>">
                                <p class="card-text mb-1 fw-bold">Stripe</p>
                                <p class="card-text mb-1">Subscription Name: <span><?php echo formatText($jms_row_stripe[$i]['purchase']);?></span></p>
                                <p class="card-text mb-1">Email ID: <span><?php echo $jms_row_stripe[$i]['jms_stripe_email_id'];?></span></p>
                                <p class="card-text mb-1">Card Holder: <span><?php echo $jms_row_stripe[$i]['jms_stripe_name'];?></span></p>
                                <p class="card-text mb-1">Status: <span><?php echo $jms_row_stripe[$i]['jms_stripe_status'];?></span></p>
                                <p class="card-text mb-1">Start Date: <span><?php echo date('m/d/Y', strtotime($jms_row_stripe[$i]['jms_stripe_starts_data']));?></span></p>
                                <p class="card-text mb-1">Customer ID: <span><?php echo $jms_row_stripe[$i]['jms_stripe_customer_id'];?></span></p>
                                <p class="card-text mb-1">Subscription ID: <span id="jms_subscription_id" name="jms_subscription_id"><?php echo $jms_row_stripe[$i]['jms_stripe_subscription_id'];?></span></p>

                                <div class="jms-message"></div>

                                <div class="col-md-12 d-flex justify-content-center">
                                    <div class="jms-loader" id="jms_loading"></div>
                                </div>
                                
                                <input type="button" class="jms-btn-cancel jms-btn-cancel-stripe btn btn-danger" id="jms_stripe_cancel_btn" name="jms_stripe_cancel_btn" value="Subscription Cancel">
                            </div>
                        </div>
                    <?php
                }
            }
        ?>
                </div>
            </div>
        </div>
        <?php
        }
        ?>

        <!-- show message subscrition cancellation after -->

        <?php 
            // today date

            $jms_today_date = date('d-m-Y');
            
            // cancel subcription date

            for ($i=0; $i < count($jms_row_cancel); $i++) 
            { 
                $jms_next_billing_date = isset($jms_row_cancel[$i]['nextbilling_date']) ? $jms_row_cancel[$i]['nextbilling_date'] : "";

                $jms_cancel_next_billing_date = compareDates($jms_today_date, $jms_next_billing_date);

                if($jms_cancel_next_billing_date == true):
                ?>
                <div class="jms-container my-5 mx-lg-5 mx-md-5 p-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-danger mb-0">You can use the <?php echo formatText($jms_row_cancel[$i]['purchase'])." ".$jms_next_billing_date;?> till this date.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
                endif; 
            }
        ?>
                
    </div>

    <?php include("footer.php"); ?>
    <script type="text/javascript" src="js/payment_cancel.js"></script>
</body>

</html>
