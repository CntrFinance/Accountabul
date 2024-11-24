<?php
    include('connection.php');
    if(!isset($_SESSION['jms_user_id']))
    {
        header("location:index.php");
    }
    include("setting.php");

    // get data purchase calc

    // deal-evalution
    // buy-and-hold-analysis

    $jms_user_id = $_SESSION['jms_user_id']; 

    // get data cancel records date
    
    $jms_select_stripe_sql = "SELECT * FROM `stripe_payments_subscription` WHERE users_id=:jms_user_id AND purchase='access-all-calculator'";
    $jms_select_stripe_data = $jms_pdo->prepare($jms_select_stripe_sql);
    $jms_select_stripe_data->bindParam(':jms_user_id', $jms_user_id,PDO::PARAM_INT);
    $jms_select_stripe_data->execute();
    $jms_row_stripe_cancel = $jms_select_stripe_data->fetchAll(PDO::FETCH_ASSOC);
    
    $jms_access_all_stripe_card = false;

    if(isset($jms_row_stripe_cancel[0]['jms_stripe_status']) && $jms_row_stripe_cancel[0]['jms_stripe_status'] == 'active')
    {
        $jms_access_all_stripe_card = true;
    }
    else
    {
        $jms_access_all_stripe_card = false;
    }

    $jms_select_stripe_sql_deal = "SELECT * FROM `stripe_payments_subscription` WHERE users_id=:jms_user_id AND purchase='deal-evalution'";
    $jms_select_stripe_data_deal = $jms_pdo->prepare($jms_select_stripe_sql_deal);
    $jms_select_stripe_data_deal->bindParam(':jms_user_id', $jms_user_id,PDO::PARAM_INT);
    $jms_select_stripe_data_deal->execute();
    $jms_row_stripe_cancel_deal = $jms_select_stripe_data_deal->fetchAll(PDO::FETCH_ASSOC);
    
    $jms_deal_stripe_card = false;

    if(isset($jms_row_stripe_cancel_deal[0]['jms_stripe_status']) && $jms_row_stripe_cancel_deal[0]['jms_stripe_status'] == 'active')
    {
        $jms_deal_stripe_card = true;
    }
    else
    {
        $jms_deal_stripe_card = false;
    }


    $jms_select_stripe_sql_buy = "SELECT * FROM `stripe_payments_subscription` WHERE users_id=:jms_user_id AND purchase='buy-and-hold-analysis'";
    $jms_select_stripe_data_buy = $jms_pdo->prepare($jms_select_stripe_sql_buy);
    $jms_select_stripe_data_buy->bindParam(':jms_user_id', $jms_user_id,PDO::PARAM_INT);
    $jms_select_stripe_data_buy->execute();
    $jms_row_stripe_cancel_buy = $jms_select_stripe_data_buy->fetchAll(PDO::FETCH_ASSOC);
    
    $jms_buy_stripe_card = false;

    if(isset($jms_row_stripe_cancel_buy[0]['jms_stripe_status']) && $jms_row_stripe_cancel_buy[0]['jms_stripe_status'] == 'active')
    {
        $jms_buy_stripe_card = true;
    }
    else
    {
        $jms_buy_stripe_card = false;
    }


    // get data cancel records date
    
    $jms_select_paypal_sql = "SELECT * FROM `paypal_payments_subscription` WHERE users_id=:jms_user_id AND purchase='access-all-calculator'";
    $jms_select_paypal_data = $jms_pdo->prepare($jms_select_paypal_sql);
    $jms_select_paypal_data->bindParam(':jms_user_id', $jms_user_id,PDO::PARAM_INT);
    $jms_select_paypal_data->execute();
    $jms_row_paypal_cancel = $jms_select_paypal_data->fetchAll(PDO::FETCH_ASSOC);
    
    $jms_access_all_paypal_card = false;

    if(isset($jms_row_paypal_cancel[0]['jms_paypal_status']) && $jms_row_paypal_cancel[0]['jms_paypal_status'] == 'ACTIVE')
    {
        $jms_access_all_paypal_card = true;
    }
    else
    {
        $jms_access_all_paypal_card = false;
    }

    $jms_select_paypal_sql_deal = "SELECT * FROM `paypal_payments_subscription` WHERE users_id=:jms_user_id AND purchase='deal-evalution'";
    $jms_select_paypal_data_deal = $jms_pdo->prepare($jms_select_paypal_sql_deal);
    $jms_select_paypal_data_deal->bindParam(':jms_user_id', $jms_user_id,PDO::PARAM_INT);
    $jms_select_paypal_data_deal->execute();
    $jms_row_paypal_cancel_deal = $jms_select_paypal_data_deal->fetchAll(PDO::FETCH_ASSOC);
        
    $jms_deal_paypal_card = false;

    if(isset($jms_row_paypal_cancel_deal[0]['jms_paypal_status']) && $jms_row_paypal_cancel_deal[0]['jms_paypal_status'] == 'ACTIVE')
    {
        $jms_deal_paypal_card = true;
    }
    else
    {
        $jms_deal_paypal_card = false;
    }


    $jms_select_paypal_sql_buy = "SELECT * FROM `paypal_payments_subscription` WHERE users_id=:jms_user_id AND purchase='buy-and-hold-analysis'";
    $jms_select_paypal_data_buy = $jms_pdo->prepare($jms_select_paypal_sql_buy);
    $jms_select_paypal_data_buy->bindParam(':jms_user_id', $jms_user_id,PDO::PARAM_INT);
    $jms_select_paypal_data_buy->execute();
    $jms_row_paypal_cancel_buy = $jms_select_paypal_data_buy->fetchAll(PDO::FETCH_ASSOC);
    
    $jms_buy_paypal_card = false;

    if(isset($jms_row_paypal_cancel_buy[0]['jms_paypal_status']) && $jms_row_paypal_cancel_buy[0]['jms_paypal_status'] == 'ACTIVE')
    {
        $jms_buy_paypal_card = true;
    }
    else
    {
        $jms_buy_paypal_card = false;
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Payment</title>

        <?php include("header.php");?>

        <!-- Style css -->
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/form.css">

        <style type="text/css">
            .jms-cards
            {
                box-shadow: var(--box-shadow);
                background: #fff;
                border-radius: 20px 5px;
                font-family: var(--main-font);
                padding: 20px;
                position: relative;
                transition: transform 0.8s ease-in-out, box-shadow 0.8s ease-in-out;
            }
            .jms-cards-heading
            {
                background: #0d6efd;
                border-radius: 20px 5px;
                color: white;
            }
            .jms-card-content ul 
            {
                list-style: none;
                padding-left: 0;
                margin: 0px;
            }
            .jms-card-content ul li 
            {
                position: relative;
                padding-left: 25px; 
                margin-bottom: 5px;
            }
            .jms-card-content ul li::before 
            {
                content: "\f101"; 
                font-family: 'Font Awesome 5 Free'; 
                font-weight: 900; 
                position: absolute;
                left: 0;
                top: 50%; 
                transform: translateY(-50%); 
                font-size: 16px; 
                color: #0d6efd; 
            }

            /* hover */

            .jms-cards.hover ul li::before 
            {
                color: white;
            }
            .jms-cards:hover 
            {
                transform: translateY(-10px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                transition: 0.8s;
            }
            .jms-cards.animate 
            {
                animation: hoverAfterTransition 0.8s ease-in-out forwards;
            }
            @keyframes hoverAfterTransition 
            {
                from 
                {
                    background-color: #fff;
                    color: #000;
                    transform: translateY(0);
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                }
                to 
                {
                    background-color: #0d6efd;
                    color: white;
                    transform: translateY(-10px);
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                }
            }

            /* modal */

            .jms-container-modal .jms-btn
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
            .jms-container-modal .jms-row-box
            {
                font-family: var(--main-font);
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
            .jms-container-modal .jms-row-box:hover
            {
                background: #007dfe1c;
            }
            .jms-container-modal .checkbox-wrapper-18 .round input[type="radio"] 
            {
                scale: 1.5;
                width: 30px;
            }
            .jms-container-modal .jms-row-box-border
            {
                border: 2px solid var(--primary-color-blue);
            }
            .jms-container-modal .jms-price
            {
                font-size: 1.5rem;
                font-weight: 600;
            }
            .jms-form-input
            {
                width: 55% !important;
                padding: 1px 5px !important;
            }

            .jms-radio-btn
            {
                transform: scale(1.5);
            }


            .border-danger {
                border-bottom: 1px solid red !important;
            }
        </style>
    </head>
    <body class="jms-bg">
        <?php include("navbar_top.php");?>

        <!-- Modal -->
        <div class="jms-container-modal modal fade" id="jms_example_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="jms_title_text"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row justify-content-center my-3">
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="jms-message"></div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center jms-row-box" id="jms_q2_section_1">
                                            <div class="checkbox-wrapper-18">
                                                <div class="round">
                                                    <input type="radio" class="jms-checkbox" id="jms_paypal" name="jms_payment_selected" value="paypal">
                                                    <label for="checkbox-18"></label>
                                                </div>
                                            </div>
                                            <div for="jms_paypal">PayPal</div>
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
            </div>
        </div>

        <div class="container my-5">
            <div class="jms-container-cards p-3">
                <div class="row">
                    <!-- <div class="col-md-4 col-sm-6 col-12">
                        <div class="jms-cards mb-md-3 mb-3">
                            <div class="jms-cards-heading p-3">Access All Calculator</div>
                            <div class="jms-card-content my-3">
                                <ul>
                                    <li>$<?php echo $jms_access_all_calculator_price;?> / Month</li>
                                    <li><?php echo $jms_access_all_calculator_save;?> Save / Month</li>
                                </ul>
                            </div>
                            <div class="jms-card-btn">
                                <button type="button" class="btn btn-primary jms-btn" id="jms_subscribe_btn_1" name="jms_subscribe_btn_1" data-id="1" 
                                <?php 
                                    if($jms_access_all_stripe_card == true || $jms_deal_stripe_card == true || $jms_buy_stripe_card == true)
                                    {
                                        echo 'disabled';
                                    }
                                    else if($jms_deal_stripe_card == true && $jms_buy_stripe_card == true)
                                    {
                                        echo 'disabled';
                                    }
                                    else if($jms_access_all_paypal_card == true || $jms_deal_paypal_card == true || $jms_buy_paypal_card == true)
                                    {
                                        echo 'disabled';
                                    }
                                    else if($jms_deal_paypal_card == true && $jms_buy_paypal_card == true)
                                    {
                                        echo 'disabled';
                                    }
                                    else
                                    {
                                        echo '';
                                    }
                                ?>>Subscribe</button>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="jms-cards mb-md-3 mb-3">
                            <div class="jms-cards-heading p-3">Deal Evaluation Calculator Tool</div>
                            <div class="jms-card-content my-3">
                                <ul>
                                    <li><span id="jms_deal_evaluation_price">$<?php echo $jms_deal_evalution_unlimited_price;?></span> / Month</li>
                                    <li>Unlimited Save</li>
                                </ul>
                            </div>
                            <div class="jms-card-btn">
                                <button type="button" class="btn btn-primary jms-btn" id="jms_subscribe_btn_2" name="jms_subscribe_btn_2" data-id="2"
                                <?php 
                                    echo $jms_access_all_stripe_card == true ? 'disabled':''; 
                                    echo $jms_deal_stripe_card == true ? 'disabled':'';

                                    echo $jms_access_all_paypal_card == true ? 'disabled':''; 
                                    echo $jms_deal_paypal_card == true ? 'disabled':'';
                                ?>
                                >Subscribe</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="jms-cards mb-md-3 mb-3">
                            <div class="jms-cards-heading p-3">Deal Evaluation Calculator Tool</div>
                            <div class="jms-card-content my-3">
                                <ul>
                                    <li>$<?php echo $jms_deal_evalution_save_price;?> / <?php echo $jms_deal_evalution_save_no;?> Save</li>
                                    <li class="d-flex justify-content-between"><input type="number" class="jms-form-input w-25" id="jms_dealeval_purchase_val" name="jms_dealeval_purchase_val" placeholder="Enter a save number"><div id="jms_total_dealevalution_3">$0.00</div></li>
                                </ul>
                            </div>
                            <div class="jms-card-btn">
                                <button type="button" class="btn btn-primary jms-btn" id="jms_purchase_btn_3" name="jms_purchase_btn_3" data-id="3">Purchase</button>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-4 col-sm-6 col-12">
                        <div class="jms-cards mb-md-3 mb-3">
                            <div class="jms-cards-heading p-3">Buy and Hold Analysis</div>
                            <div class="jms-card-content my-3">
                                <ul>
                                    <li><span id="jms_buyhold_analysis_price">$<?php echo $jms_buy_and_hold_analysis_unlimited_price;?></span> / Month</li>
                                    <li>Unlimited Save</li>
                                </ul>
                            </div>
                            <div class="jms-card-btn">
                                <button type="button" class="btn btn-primary jms-btn" id="jms_subscribe_btn_4" name="jms_subscribe_btn_4" data-id="4" 
                                <?php 
                                    echo $jms_access_all_stripe_card == true ? 'disabled':''; 
                                    echo $jms_buy_stripe_card == true ? 'disabled':'';

                                    echo $jms_access_all_paypal_card == true ? 'disabled':''; 
                                    echo $jms_buy_paypal_card == true ? 'disabled':'';
                                ?>
                                >Subscribe</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="jms-cards mb-md-3 mb-3">
                            <div class="jms-cards-heading p-3">Buy and Hold Analysis</div>
                            <div class="jms-card-content my-3">
                                <ul>
                                    <li>$<?php echo $jms_buy_and_hold_analysis_price;?> / <?php echo $jms_buy_and_hold_analysis_no;?> Save</li>
                                    <li class="d-flex justify-content-between"><input type="number" class="jms-form-input w-25" id="jms_buyhold_purchase_val" name="jms_buyhold_purchase_val" placeholder="Enter a save number"><div id="jms_total_buyhold_5">$0.00</div></li>
                                </ul>
                            </div>
                            <div class="jms-card-btn">
                                <button type="button" class="btn btn-primary jms-btn" id="jms_subscribe_btn_5" name="jms_subscribe_btn_5" data-id="5">Purchase</button>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>

        <?php include("footer.php"); ?>
        <script type="text/javascript">

            $(document).ready(function()
            {
                $('#jms_example_modal').modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: false
                });

                function jms_model_box(argument) 
                {
                    $("#"+argument).on("click", function() 
                    {
                        var data_id = parseInt($(this).attr('data-id'));

                        if(data_id == 3 || data_id == 5)
                        {
                            if(data_id == 3)
                            {
                                if ($("#jms_dealeval_purchase_val").val() != "") {
                                    $(this).parent().parent().each(function() {
                                        var a = $(this).find(".jms-cards-heading").text();
                                        $("#jms_title_text").text(a);

                                        $("#jms_payment_next_btn").attr("data-id", data_id);

                                        $('#jms_example_modal').modal('show');
                                    });
                                    $("#jms_dealeval_purchase_val").removeClass('border-danger');
                                } else {
                                    $("#jms_dealeval_purchase_val").addClass('border-danger');
                                }
                            }
                            else
                            {
                                if ($("#jms_buyhold_purchase_val").val() != "") {
                                    $(this).parent().parent().each(function() {
                                        var a = $(this).find(".jms-cards-heading").text();
                                        $("#jms_title_text").text(a);

                                        $("#jms_payment_next_btn").attr("data-id", data_id);

                                        $('#jms_example_modal').modal('show');
                                    });
                                    $("#jms_buyhold_purchase_val").removeClass('border-danger');
                                } else {
                                    $("#jms_buyhold_purchase_val").addClass('border-danger');
                                }
                            }
                        }
                        else
                        {
                            $(this).parent().parent().each(function() 
                            {
                                var a = $(this).find(".jms-cards-heading").text();
                                $("#jms_title_text").text(a);

                                $("#jms_payment_next_btn").attr("data-id",data_id);

                                $('#jms_example_modal').modal('show');

                                $("#jms_dealeval_purchase_val,#jms_buyhold_purchase_val").removeClass('border-danger');
                            });
                        }
                    });
                }

                jms_model_box('jms_subscribe_btn_1');
                jms_model_box('jms_subscribe_btn_2');
                jms_model_box('jms_purchase_btn_3');
                jms_model_box('jms_subscribe_btn_4');
                jms_model_box('jms_subscribe_btn_5');

                $('.btn-close').click(function() 
                {
                    $("#jms_paypal").prop('checked', false);
                    $("#jms_stripe").prop('checked', false);

                    $("#jms_q2_section_1").removeClass('jms-row-box-border');
                    $('#jms_q2_section_2').removeClass('jms-row-box-border');

                    $('.jms-message').css('display', 'block');
                    $('.jms-message').html("");
                });

                // btn paypal and stripe

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

                $('#jms_payment_next_btn').on("click",function()
                {
                    

                    var jms_payment_selected = $('input[name="jms_payment_selected"]:checked').val();
                    var data_id = parseInt($(this).attr('data-id'));

                    if(jms_payment_selected) 
                    {
                        if(data_id == 3 || data_id == 5)
                        {
                            var a = [];
                            if(data_id == 3)
                            {
                                a.push($("#jms_total_dealevalution_3").text().replace(/\$/g, ''));
                                a.push("deal-evalution");
                                a.push(3);
                            }
                            else
                            {
                                a.push($("#jms_total_buyhold_5").text().replace(/\$/g, ''));
                                a.push("buy-and-hold-analysis");
                                a.push(5);
                            }
                            
                            if(jms_payment_selected == 'paypal')
                            {
                                window.location.href = "payapal_payment_forms.php?purchase="+a[1]+"&total="+a[0]+"&subscriptionid="+a[2];
                            }
                            else
                            {
                                window.location.href = "stripe_payment_forms.php?purchase="+a[1]+"&total="+a[0]+"&subscriptionid="+a[2];
                            }

                            $("#jms_paypal").prop('checked', false);
                            $("#jms_stripe").prop('checked', false);
                        }
                        else if(data_id == 2 || data_id == 4)
                        {
                            var a = [];
                            if(data_id == 2)
                            {
                                a.push($("#jms_deal_evaluation_price").text().replace(/\$/g, ''));
                                a.push("deal-evalution");
                                a.push(2);
                            }
                            else
                            {
                                a.push($("#jms_buyhold_analysis_price").text().replace(/\$/g, ''));
                                a.push("buy-and-hold-analysis");
                                a.push(4);
                            }
                            
                            if(jms_payment_selected == 'paypal')
                            {
                                window.location.href = "payapal_payment_form.php?purchase="+a[1]+"&subscriptionid="+a[2];
                            }
                            else
                            {
                                window.location.href = "stripe_payment_form.php?purchase="+a[1]+"&subscriptionid="+a[2];
                            }

                            $("#jms_paypal").prop('checked', false);
                            $("#jms_stripe").prop('checked', false);
                        }
                        else
                        {
                            if(jms_payment_selected == 'paypal')
                            {
                                window.location.href = "payapal_payment_form.php?purchase=access-all-calculator&subscriptionid=1";
                            }
                            else
                            {
                                window.location.href = "stripe_payment_form.php?purchase=access-all-calculator&subscriptionid=1";
                            }

                            $("#jms_paypal").prop('checked', false);
                            $("#jms_stripe").prop('checked', false);
                        }

                        $('.jms-message').css('display', 'block');
                        $('.jms-message').html("");
                    }
                    else 
                    {
                        $('.jms-message').css('display', 'block');
                        $('.jms-message').html("<div class='alert alert-danger mb-2' role='alert'>Select payment method</div>");
                    }
                });

                function numberWithCommas(x) 
                {
                    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }

                $("#jms_dealeval_purchase_val").on("input",function()
                {
                    var jms_a = $(this).val() * <?php echo $jms_deal_evalution_save_price?>;
                    $("#jms_total_dealevalution_3").text("$"+numberWithCommas(jms_a.toFixed(2)));
                });

                $("#jms_buyhold_purchase_val").on("input",function()
                {
                    var jms_a = $(this).val() * <?php echo $jms_buy_and_hold_analysis_price?>;
                    $("#jms_total_buyhold_5").text("$"+numberWithCommas(jms_a.toFixed(2)));
                });
            });
        </script>
    </body>
</html>