<?php 
    include('connection.php');
    if(!isset($_SESSION['jms_user_id']))
    {
        header("location:index.php");
    }
    include('setting.php');

    $jms_id = $_SESSION['jms_user_id'];

    // subscription plan 
    
    $jms_row_sql = "SELECT * FROM `stripe_payments_subscription` WHERE users_id=:jms_user_id ORDER BY id DESC";
    $jms_row_data = $jms_pdo->prepare($jms_row_sql);
    $jms_row_data->bindParam(':jms_user_id', $jms_id,PDO::PARAM_INT);
    $jms_row_data->execute();
    $jms_row = $jms_row_data->fetchAll(PDO::FETCH_ASSOC);

    // purchase calculators

    $jms_row_sql_1 = "SELECT * FROM `stripe_payments_purchase` WHERE users_id=:jms_user_id ORDER BY id DESC";
    $jms_row_data_1 = $jms_pdo->prepare($jms_row_sql_1);
    $jms_row_data_1->bindParam(':jms_user_id', $jms_id,PDO::PARAM_INT);
    $jms_row_data_1->execute();
    $jms_row_1 = $jms_row_data_1->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?php include('header.php');?>

        <title>Payment Success</title>

        <!-- Style css -->
        <link rel="stylesheet" type="text/css" href="css/form.css">

        <style type="text/css">
            .jms-container .card .card-body .card-title
            {
                font-size: 1.5rem;
                font-weight: 700;
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
            .jms-btn:focus
            {
                box-shadow: none !important;
            }
            .jms-btn:hover
            {
                background-color: #4292dc;
                border-color: var(--primary-color-blue);
            }
        </style>
    </head>
    <body class="jms-bg">
    <?php include("navbar_top.php");?>

    <div class="container mt-5 pt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="jms-container p-4">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">Payment Successful</div>
                                    <p class="card-text">Thank you for your purchase! Your payment has been processed successfully.</p>
                                    <hr>
                                    <?php if(isset($_GET['plan']) && $_GET['plan'] != "purchase"):?>
                                        <p class="card-text mb-1">Customer Id : <span><?php echo $jms_row[0]['jms_stripe_customer_id'];?></span></p>
                                        <p class="card-text mb-1">Email Id : <span><?php echo $jms_row[0]['jms_stripe_email_id'];?></span></p>
                                        <p class="card-text mb-1">Holder Name : <span><?php echo $jms_row[0]['jms_stripe_name'];?></span></p>
                                        <p class="card-text mb-1">Status : <span><?php echo $jms_row[0]['jms_stripe_status'];?></span></p>
                                        <p class="card-text mb-1">Start Date : <span><?php echo $jms_row[0]['jms_stripe_starts_data'];?></span></p>
                                        <p class="card-text mb-1">Subscription Id : <span><?php echo $jms_row[0]['jms_stripe_subscription_id'];?></span></p>
                                        <p class="card-text mb-1">Plan Id : <span><?php echo $jms_row[0]['jms_stripe_plan_id'];?></span></p>
                                    <?php else: ?>
                                        <p class="card-text mb-1">Transation Id : <span><?php echo $jms_row_1[0]['transation_id'];?></span></p>
                                        <p class="card-text mb-1">Total Amount : <span><?php echo $jms_row_1[0]['amount'];?></span></p>
                                    <?php 
                                        endif;
                                        if((isset($jms_row_1[0]['purchase']) && $jms_row_1[0]['purchase'] == "deal-evalution") || (isset($jms_row[0]['purchase']) && $jms_row[0]['purchase'] == "deal-evalution")):
                                    ?>
                                        <a href="deal_evaluation.php" class="jms-btn btn btn-primary mt-3">Go to Calculator</a>
                                    <?php else: ?> 
                                        <a href="deal_evaluation.php" class="jms-btn btn btn-primary mt-3">Go to Calculator</a>
                                    <?php 
                                        endif; 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php');?>
</html>