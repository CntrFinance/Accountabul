<?php 
    include('connection.php');
    if(!isset($_SESSION['jms_user_id']))
    {
        header("location:index.php");
    }
    include("header.php");

    include("setting.php");
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Take Subscription</title>

        <!-- Style css -->
        <link rel="stylesheet" type="text/css" href="css/form.css">
        
        <style type="text/css">
            .jms-btn
            {
                font-family: var(--main-font);
                display: inline-block;
                background: var(--primary-color-blue);
                color: #fff;
                border: none;
                width: auto;
                padding: 15px 30px;
                border-radius: 5px;
                cursor: pointer;
                font-size: 15px;
                
            }
            .jms-container
            {
                box-shadow: var(--box-shadow) !important;
            }
            .jms-container a
            {
                text-decoration: none;
            }
            .jms-container a:hover
            {
                color: white !important;
            }


            .jms-row-box
            {
                box-shadow: 0 1px 3px #0000001a,inset 0 0 1px 1px #0000001a;
                border-radius: .5rem;
                background: #ffffff;
                box-sizing: border-box;
                padding: 16px;
                border: 2px solid #dfdfdf;
                min-height: 64px;
                width: 100%;
                cursor: pointer;
            }
            .jms-row-box:hover
            {
                background: #007dfe1c;
            }

            .checkbox-wrapper-18 .round input[type="radio"] 
            {
                scale: 1.5;
                width: 30px;
            }

            .jms-row-box-border
            {
                border: 2px solid var(--primary-color-blue);
            }

            .jms-price
            {
                font-size: 1.5rem;
                font-weight: 600;
            }
        </style>
    </head>
    <body class="jms-bg">
        <?php include("navbar_top.php");?>
        <div class="container mt-5 pt-5">
            <div class="jms-container py-5">
                <div class="row justify-content-center my-4">

                    <div class="col-md-8">
                        <div class="row">
                            
                            <div class="col-md-12">
                                <div class="jms-rpice text-center mb-3"><?php echo $jms_per_months;?></div>
                            </div>
                            
                            <div class="jms-message"></div>
                            
                            <div class="col-md-6">
                                <div class="d-flex align-items-center jms-row-box" id="jms_q2_section_1">
                                    <div class="checkbox-wrapper-18">
                                        <div class="round">
                                            <input type="radio" class="jms-checkbox" id="jms_paypal" name="jms_payment_selected" value="paypal">
                                            <label for="checkbox-18"></label>
                                        </div>
                                    </div>
                                    <div for="jms_paypal">Paypal</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="d-flex align-items-center jms-row-box" id="jms_q2_section_2">
                                    <div class="checkbox-wrapper-18">
                                        <div class="round">
                                            <input type="radio" class="jms-checkbox" id="jms_stripe" name="jms_payment_selected" value="stripe">
                                            <label for="checkbox-18"></label>
                                        </div>
                                    </div>
                                    <div for="jms_stripe">Stripe</div>
                                </div>
                            </div>

                            <div class="col-md-12 d-flex justify-content-center mt-4">
                                <input type="button" class="jms-btn w-50" id="jms_payment_next_btn" name="jms_payment_next_btn" value="Proceed">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        
        <?php include("footer.php"); ?>
    </body>
    <script type="text/javascript" src="js/registration.js"></script>
    <script type="text/javascript" src="js/request_assecc.js"></script>
    <script type="text/javascript" src="js/payment_option.js"></script>
    <script type="text/javascript">
        $(document).ready(function()
        {
            $("#jms_q2_section_1").on("click", function() 
            {
                $(this).addClass('jms-row-box-border');
                $('#jms_q2_section_2').removeClass('jms-row-box-border');

                $("#jms_paypal").prop('checked', true);
                $("#jms_stripe").prop('checked', false);
            });

            $("#jms_q2_section_2").on("click", function() 
            {
                $(this).addClass('jms-row-box-border');
                $('#jms_q2_section_1').removeClass('jms-row-box-border');

                $("#jms_paypal").prop('checked', false);
                $("#jms_stripe").prop('checked', true);
            });
        });
    </script>
</html>