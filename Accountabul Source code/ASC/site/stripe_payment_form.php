<?php 
    include('connection.php');
    if(!isset($_SESSION['jms_user_id']))
    {
        header("location:index.php");
    }
    include('setting.php');


    if(isset($_GET['purchase']) && $_GET['purchase'])
    {
        $jms_purchase_name = $_GET['purchase'];
    }
    else
    {
        $jms_purchase_name = "";
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?php include('header.php');?>

        <title>Stripe</title>

        <!-- Style css -->
        <link rel="stylesheet" type="text/css" href="css/form.css">
        <link rel="stylesheet" type="text/css" href="css/loading.css">

        <style type="text/css">
            .jms-container .form-control:focus
            {
                box-shadow: none !important;
                border-color: #ced4da !important;
            }
            .jms-container .form-row 
            {
                margin-bottom: 20px;
            }
            .jms-container label 
            {
                display: block;
                margin-bottom: 8px;
                font-weight: bold;
            }
            .jms-container #card-element 
            {
                border: 1px solid #ccc;
                padding: 10px;
                border-radius: 4px;
                background-color: #f8f8f8;
            }
            .jms-container button 
            {
                background-color: #007dfe;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
            }
            .jms-container button:hover 
            {
                background-color: #007dfe;
            }
            .jms-container input
            {
                width: 100% !important;
                display: block !important;
                border: none !important;
                border-bottom: 1px solid #999 !important;
                padding: 6px 6px !important;
                font-family: var(--main-font) !important;
                box-sizing: border-box !important;
                font-size: 16px !important;
                border-radius: 0px;
            }
            .jms-container #card-element
            {
                width: 100% !important;
                display: block !important;
                border: none !important;
                border-bottom: 1px solid #999 !important;
                padding: 10px 5px !important;
                font-family: var(--main-font) !important;
                box-sizing: border-box !important;
                font-size: 16px !important;
                border-radius: 0px;
                background: white;
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
            <div class="row justify-content-center pt-5">
                <div class="col-md-5">
                    <div class="jms-container p-4">
                        <form method="post" id="jms_stripe_payment_form" name="jms_stripe_payment_form">
                            <div class="mb-3">
                                <label for="jms_email_address" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="jms_email_address" name="jms_email_address" placeholder="Enter email address" required>
                            </div>
                            <div class="mb-3">
                                <label for="jms_card_holder_name" class="form-label">Card Holder</label>
                                <input type="text" class="form-control" id="jms_card_holder_name" name="jms_card_holder_name" placeholder="Enter card holder" required>
                            </div>
                            <div class="form-row">
                                <label for="card-element">Credit or debit card</label>
                                <div id="card-element"></div>
                                <div id="card-errors"></div>
                            </div>
                            <div class="col-md-12 d-flex justify-content-center">
                                <div class="jms-loader" id="jms_loading"></div>
                            </div>
                            <div class="col-md-12 d-flex justify-content-center mt-2">
                                <button type="submit" class="btn btn-block btn-primary jms-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php include('footer.php');?>
        <script src="https://js.stripe.com/v3/"></script>
        <script>
            $(document).ready(function()
            {
                $("#jms_loading").hide();

                // const stripe = Stripe('pk_test_51OY4u8DTqe3AeBX5Jeppbo6gzjveGlrW4GOmjZjsAKtUKbdZ6a4vJNCPbOBsBMTcvoDNMlt5bDUhogELNYeZGm1H00XpqfMhsJ');
                const stripe = Stripe('<?php echo $jms_stripe_publishable_key;?>');

                const elements = stripe.elements();

                const style = 
                {
                    base: 
                    {
                        fontSize: '16px',
                        color: '#32325d',
                        '::placeholder': 
                        {
                        color: '#aab7c4',
                        },
                    },
                    invalid: 
                    {
                        color: '#fa755a',
                    },
                };

                const card = elements.create('card', { style });

                card.mount('#card-element');

                $('#jms_stripe_payment_form').on('submit', async function(event) 
                {
                    event.preventDefault();

                    const { token, error } = await stripe.createToken(card);

                    if (error) 
                    {
                        $('#card-errors').css('display', 'block');
                        $('#card-errors').html("<div class='alert alert-danger my-2' role='alert'>"+error.message+"</div>");
                    } 
                    else 
                    {
                        stripeTokenHandler(token);
                    }
                });

                const stripeTokenHandler = (token) => 
                {
                    const hiddenInput = $('<input>')
                        .attr('type', 'hidden')
                        .attr('name', 'stripeToken')
                        .attr('value', token.id);
                    $('#jms_stripe_payment_form').append(hiddenInput);

                    var jms_email_address = $("#jms_email_address").val();
                    var jms_card_holder_name = $("#jms_card_holder_name").val();
                    var stripeToken = token.id;
                    var jms_purchase_name = '<?php echo $jms_purchase_name;?>';

                    var form = new FormData();
                    form.append('jms_email_address',jms_email_address);
                    form.append('jms_card_holder_name',jms_card_holder_name);
                    form.append('stripeToken',stripeToken);
                    form.append('jms_purchase_name',jms_purchase_name);

                    $.ajax({
                        url: "user_data_file/stripe_payment_proccess.php",
                        type: "POST",
                        data: form,
                        contentType: false,
                        cache: false,
                        processData:false,
                        beforeSend : function()
                        {
                            $("#jms_loading").show();
                            setTimeout(function(){ $("#jms_loading").hide(); }, 3000);
                        },
                        success: function(data)
                        {
                            if(data.status == 'error')
                            {
                                $('#card-errors').css('display', 'block');
                                $('#card-errors').html("<div class='alert alert-danger my-2' role='alert'>"+data.message+"</div>");
                            }
                            else if(data.status == 'success')
                            {
                                $("#jms_loading").hide();

                                $('#card-errors').css('display', 'block');
                                $('#card-errors').html("<div class='alert alert-success my-2' role='alert'>"+data.message+"</div>");
                                setTimeout(function(){ window.location = 'stripe_pay_success.php?plan=subscription'; }, 3000);
                            }
                        }
                    });
                };
            });
        </script>
</html>