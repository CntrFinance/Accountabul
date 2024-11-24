<?php 
    include('connection.php');
    if(!isset($_SESSION['jms_user_id']))
    {
        header("location:index.php");
    }
    include('setting.php');

    
    if(isset($_GET['total']) && $_GET['total'])
    {
        $jms_price = $_GET['total'];
        $subscriptionid = isset($_GET['subscriptionid']) ? $_GET['subscriptionid'] : 0;
    }
    else
    {
        $jms_price = 0;
        $subscriptionid = 0;
    }
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
        </style>
    </head>
    <body class="jms-bg">
    <?php include("navbar_top.php");?>

    <div class="container mt-5 pt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="jms-container p-4">
                    <div class="row justify-content-center">
                        <div class="jms-message"></div>
                        <div class="col-md-12">
                            <div id="paypal-button-container"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php');?>
    <!-- Paypal Form Cdn -->

    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo $jms_paypal_client_id;?>"></script>
    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: <?php echo $jms_price;?> // The amount to be paid
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) 
                {
                    var jms_paypal_customer_id = details.id;
                    var jms_paypal_payer_id = details.payer.payer_id;
                    var jms_purchase = '<?php echo $_GET['purchase'];?>';
                    var jms_price = <?php echo $jms_price;?>;
                    var jms_status = details.status;
                    var jms_subscriptionid = <?php echo $subscriptionid; ?>;

                    var jms_form = new FormData();
                    jms_form.append('jms_paypal_customer_id',jms_paypal_customer_id);
                    jms_form.append('jms_paypal_payer_id',jms_paypal_payer_id);
                    jms_form.append('jms_purchase',jms_purchase);
                    jms_form.append('jms_price',jms_price);
                    jms_form.append('jms_status',jms_status);
                    jms_form.append('jms_subscriptionid',jms_subscriptionid);


                    $.ajax({
                        url: "user_data_file/paypal_payment_proccess_pay.php",
                        type: "POST",
                        data:  jms_form,
                        contentType: false,
                        cache: false,
                        processData:false,
                        beforeSend : function()
                        {
                        },
                        success: function(data)
                        {
                            if(data.status == 'error')
                            {
                                $('.jms-message').css('display', 'block');
                                $('.jms-message').html("<div class='alert alert-danger mb-2' role='alert'>"+data.message+"</div>");
                            }
                            else if(data.status == 'success')
                            {
                                $('.jms-message').css('display', 'block');
                                $('.jms-message').html("<div class='alert alert-success mb-2' role='alert'>"+data.message+"</div>");
                                setTimeout(function(){ window.location = 'paypal_pay_success.php?plan=purchase'; }, 3000);
                            }
                        }
                    });
                });
            }
        }).render('#paypal-button-container'); // Display PayPal button
    </script>
</html>





