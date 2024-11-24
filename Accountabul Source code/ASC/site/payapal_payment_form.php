<?php 
    include('connection.php');
    if(!isset($_SESSION['jms_user_id']))
    {
        header("location:index.php");
    }
    include('setting.php');

    $jms_plan_select = "";

    if(isset($_GET['purchase']) && $_GET['purchase'] == "deal-evalution")
    {
        $jms_plan_select = $JMS_PLAN_ID_DEAL_EVALUATION_UNLIMITED;
    }
    else if(isset($_GET['purchase']) && $_GET['purchase'] == "buy-and-hold-analysis")
    {
        $jms_plan_select = $JMS_PLAN_ID_BUY_AND_HOLD_ANALYSIS;
    }
    else
    {
        $jms_plan_select = $JMS_PLAN_ID_ACCESS_ALL_CALCULATOR;
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
                            <div id="paypal-button-container-<?php echo $jms_plan_select;?>"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php');?>
    <!-- Paypal Form Cdn -->

    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo $jms_paypal_client_id;?>&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script>
    <script>
        paypal.Buttons({
            style: {
                shape: 'rect',
                color: 'gold',
                layout: 'vertical',
                label: 'subscribe'
            },
            createSubscription: function(data, actions) {
                return actions.subscription.create({
                    plan_id: '<?php echo $jms_plan_select; ?>'
                });
            },
            onApprove: function(data, actions) 
            {
                return actions.subscription.get().then(function(details) 
                {
                    var jmsPayPalCustomerId = details.subscriber.payer_id;
                    var jmsPayPalEmailId = details.subscriber.email_address;
                    var jmsPayPalName = details.subscriber.name.given_name + " " + details.subscriber.name.surname;
                    var jmsPayPalStatus = details.status;
                    var jmsPayPalStartDate = details.create_time;
                    var jmsPayPalSubscriptionId = data.subscriptionID;
                    var jmsPayPalOrderId = data.orderID;
                    var jmsPayPalPlanId = '<?php echo $jms_plan_select; ?>';

                    var jms_url_calcname = '<?php echo $_GET['purchase']; ?>';

                    var jmsForm = new FormData();
                    jmsForm.append('jms_paypal_customer_id', jmsPayPalCustomerId);
                    jmsForm.append('jms_paypal_email_id', jmsPayPalEmailId);
                    jmsForm.append('jms_paypal_name', jmsPayPalName);
                    jmsForm.append('jms_paypal_status', jmsPayPalStatus);
                    jmsForm.append('jms_paypal_starts_date', jmsPayPalStartDate);
                    jmsForm.append('jms_paypal_subscriptionid', jmsPayPalSubscriptionId);
                    jmsForm.append('jms_paypal_orderid', jmsPayPalOrderId);
                    jmsForm.append('jms_paypal_plan_id', jmsPayPalPlanId);
                    jmsForm.append('jms_url_calcname', jms_url_calcname);

                    $.ajax({
                        url: "user_data_file/paypal_payment_proccess.php",
                        type: "POST",
                        data: jmsForm,
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function() 
                        {
                            // You can add a loading spinner or disable the button here
                        },
                        success: function(response) 
                        {
                            if (response.status === 'error') 
                            {
                                displayMessage('error', response.message);
                            } 
                            else if (response.status === 'success') 
                            {
                                displayMessage('success', response.message);
                                setTimeout(function() 
                                {
                                    window.location = 'paypal_pay_success.php?plan=subscription';
                                }, 3000);
                            }
                        }
                    });

                    function displayMessage(type, message) 
                    {
                        var messageElement = $('.jms-message');
                        messageElement.css('display', 'block');
                        if (type === 'error') 
                        {
                            messageElement.html("<div class='alert alert-danger mb-2' role='alert'>" + message + "</div>");
                        } 
                        else if (type === 'success') 
                        {
                            messageElement.html("<div class='alert alert-success mb-2' role='alert'>" + message + "</div>");
                        }
                    }
                });
            },
            onError: function(err) 
            {
                document.getElementById('error-message').innerText = 'An error occurred during the subscription process. Please try again.';
            }
        }).render('#paypal-button-container-<?php echo $jms_plan_select; ?>');
    </script>
</html>





