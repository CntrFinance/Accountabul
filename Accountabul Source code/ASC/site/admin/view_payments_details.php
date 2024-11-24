<?php
    include("../connection.php");

    if(!isset($_SESSION['jms_admin_user_id']))
    {
        header("location:index.php");
    }

    include('../setting.php');

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
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("header.php"); ?>

    <title>All Users</title>

    <!-- css link -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">

<?php include("menu.php"); ?>

<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
                <div class="col-md-12 mt-5">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">View Payment Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <?php
                                        $jms_users_id = $_GET['id'];

                                        // paypal sucription

                                        $jms_select_get_pay = "SELECT * FROM `paypal_payments_subscription` WHERE users_id = :user_id ORDER BY id DESC";

                                        $jms_select_data_pay = $jms_pdo->prepare($jms_select_get_pay);
                                        $jms_select_data_pay->bindParam(':user_id', $jms_users_id, PDO::PARAM_INT);
                                        $jms_select_data_pay->execute();
                                        $jms_row_user_pay = $jms_select_data_pay->fetchALL(PDO::FETCH_ASSOC);

                                        // stripe sucription
                                        
                                        $jms_select_get_stripe = "SELECT * FROM `stripe_payments_subscription` WHERE users_id = :user_id ORDER BY id DESC";

                                        $jms_select_data_stripe = $jms_pdo->prepare($jms_select_get_stripe);
                                        $jms_select_data_stripe->bindParam(':user_id', $jms_users_id, PDO::PARAM_INT);
                                        $jms_select_data_stripe->execute();
                                        $jms_row_user_stripe = $jms_select_data_stripe->fetchALL(PDO::FETCH_ASSOC);

                                        // stripe purchase saves
        
                                        $jms_select_save_stripe = "SELECT * FROM `stripe_payments_purchase` WHERE users_id = :user_id ORDER BY id DESC";

                                        $jms_select_save_stripe = $jms_pdo->prepare($jms_select_save_stripe);
                                        $jms_select_save_stripe->bindParam(':user_id', $jms_users_id, PDO::PARAM_INT);
                                        $jms_select_save_stripe->execute();
                                        $jms_row_user_stripe_save = $jms_select_save_stripe->fetchALL(PDO::FETCH_ASSOC);

                                        // paypal purchase saves
        
                                        $jms_select_save_paypal = "SELECT * FROM `paypal_payments_purchase` WHERE users_id = :user_id ORDER BY id DESC";

                                        $jms_select_save_paypal = $jms_pdo->prepare($jms_select_save_paypal);
                                        $jms_select_save_paypal->bindParam(':user_id', $jms_users_id, PDO::PARAM_INT);
                                        $jms_select_save_paypal->execute();
                                        $jms_row_user_paypal_save = $jms_select_save_paypal->fetchALL(PDO::FETCH_ASSOC);

                                        if ($jms_row_user_stripe) 
                                        {
                                        ?>
                                        <div class="font-weight-bold border rounded border p-2 h4">Stripe Subscription Payments</div>
                                        <?php
                                            for ($i=0; $i < count($jms_row_user_stripe); $i++) 
                                            {
                                    ?>
                                    <div class="border rounded p-2 mb-3">
                                        <div class="font-weight-bold border-bottom mb-2 pb-2"><?php echo formatText($jms_row_user_stripe[$i]['purchase'])?></div>
                                        <div><b>Customer Id:</b> <?php echo $jms_row_user_stripe[$i]['jms_stripe_customer_id']?></div>
                                        <div><b>Purchase:</b> <?php echo $jms_row_user_stripe[$i]['purchase']?></div>
                                        <div><b>Email Id:</b> <?php echo $jms_row_user_stripe[$i]['jms_stripe_email_id']?></div>
                                        <div><b>Holder Name:</b> <?php echo $jms_row_user_stripe[$i]['jms_stripe_name']?></div>
                                        <div><b>Status:</b> <?php echo $jms_row_user_stripe[$i]['jms_stripe_status']?></div>
                                        <div><b>Starts Date:</b> <?php echo $jms_row_user_stripe[$i]['jms_stripe_starts_data']?></div>
                                        <div><b>Subscription Id:</b> <?php echo $jms_row_user_stripe[$i]['jms_stripe_subscription_id']?></div>
                                        <div><b>Plan Id:</b> <?php echo $jms_row_user_stripe[$i]['jms_stripe_plan_id']?></div>
                                    </div>
                                    <?php
                                            }
                                        }

                                        if ($jms_row_user_stripe_save) 
                                        {
                                    ?>
                                        <div class="font-weight-bold border rounded border p-2 h4">Stripe One Time Payments</div>
                                    <?php
                                            for ($i=0; $i < count($jms_row_user_stripe_save); $i++) 
                                            {
                                    ?>
                                    <div class="border rounded p-2 mb-3">
                                        <div class="font-weight-bold border-bottom mb-2 pb-2"><?php echo formatText($jms_row_user_stripe_save[$i]['purchase'])?></div>
                                        <div><b>Transation Id:</b> <?php echo $jms_row_user_stripe_save[$i]['transation_id']?></div>
                                        <div><b>Purchase:</b> <?php echo $jms_row_user_stripe_save[$i]['purchase']?></div>
                                        <div><b>Amount:</b> <?php echo $jms_row_user_stripe_save[$i]['amount']?></div>
                                        <div><b>Save:</b> <?php echo save($jms_row_user_stripe_save[$i]['amount'],$jms_row_user_stripe_save[$i]['purchase'],$jms_deal_evalution_save_price,$jms_buy_and_hold_analysis_price);?></div>
                                    </div>
                                    <?php  
                                            }
                                        }

                                        if (!empty($jms_row_user_pay) || !empty($jms_row_user_paypal_save)) 
                                        {
                                                                                
                                        // paypal

                                        if ($jms_row_user_pay) 
                                        {
                                    ?>
                                        <div class="font-weight-bold border rounded border p-2 h4">Paypal Subscription Payments</div>
                                    <?php
                                        }
                                    ?>
                                    <?php
                                            for ($i=0; $i < count($jms_row_user_pay); $i++) 
                                            {
                                    ?>
                                    <div class="border rounded p-2 mb-3">
                                        <div class="font-weight-bold border-bottom border-dark"><?php echo formatText($jms_row_user_pay[$i]['purchase'])?></div>
                                        <div><b>Customer Id:</b> <?php echo $jms_row_user_pay[$i]['jms_paypal_customer_id'];?></div>
                                        <div><b>Purchase:</b> <?php echo $jms_row_user_pay[$i]['purchase']?></div>
                                        <div><b>Email Id:</b> <?php echo $jms_row_user_pay[$i]['jms_paypal_email_id']?></div>
                                        <div><b>Holder Name:</b> <?php echo $jms_row_user_pay[$i]['jms_paypal_name']?></div>
                                        <div><b>Status:</b> <?php echo $jms_row_user_pay[$i]['jms_paypal_status']?></div>
                                        <div><b>Starts Date:</b> <?php echo $jms_row_user_pay[$i]['jms_paypal_starts_date']?></div>
                                        <div><b>Subscription Id:</b> <?php echo $jms_row_user_pay[$i]['jms_paypal_subscriptionid']?></div>
                                        <div><b>Order Id:</b> <?php echo $jms_row_user_pay[$i]['jms_paypal_orderid']?></div>
                                        <div><b>Plan Id:</b> <?php echo $jms_row_user_pay[$i]['jms_paypal_plan_id']?></div>
                                        <div><b>Subscription Id:</b> <?php echo $jms_row_user_pay[$i]['jms_subscription_id']?></div>
                                    </div>
                                    <?php
                                            }
                                        }

                                        if ($jms_row_user_paypal_save) 
                                        {
                                    ?>
                                        <div class="font-weight-bold border rounded border p-2 h4">Paypal One Time Payments</div>
                                    <?php
                                            for ($i=0; $i < count($jms_row_user_paypal_save); $i++) 
                                            {
                                    ?>
                                    <div class="border rounded p-2 mb-3">
                                        <div class="font-weight-bold border-bottom mb-2 pb-2"><?php echo formatText($jms_row_user_paypal_save[$i]['purchase'])?></div>
                                        <div><b>Transation Id:</b> <?php echo $jms_row_user_paypal_save[$i]['transation_id']?></div>
                                        <div><b>Purchase:</b> <?php echo $jms_row_user_paypal_save[$i]['purchase']?></div>
                                        <div><b>Amount:</b> <?php echo $jms_row_user_paypal_save[$i]['amount']?></div>
                                        <div><b>Save:</b> <?php echo save($jms_row_user_paypal_save[$i]['amount'],$jms_row_user_paypal_save[$i]['purchase'],$jms_deal_evalution_save_price,$jms_buy_and_hold_analysis_price);?></div>
                                    </div>
                                    <?php
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?> 
<script type="text/javascript" src="js/delete_applicant_information.js"></script>
<script type="text/javascript">
    $(function () 
    {
        $("#jms_all_users_list").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,"order": [[0, 'desc']],scrollY: false,
            scrollCollapse: true,pageLength : 10
        }).buttons().container().appendTo('#jms_all_users_list_wrapper .col-md-6:eq(0)');
    });
</script>
</body>
</html>