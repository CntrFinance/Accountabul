<?php
	include("../connection.php");
	if(!isset($_SESSION['jms_user_id']))
  	{
    	header("location:index.php");
  	}
	header('Content-type: application/json');
	
	include('../setting.php');
	require_once '../tools/stripe_payment/vendor/autoload.php';

	$jms_user_id = $_SESSION['jms_user_id'];
	$jms_email_address = $_POST['jms_email_address'];
	$jms_card_holder_name = $_POST['jms_card_holder_name'];
	$stripeToken = $_POST['stripeToken'];

	$jms_purchase_name = $_POST['jms_purchase_name'];

	$jms_product_id = "";
	if($jms_purchase_name == "deal-evalution")
	{
		$jms_product_id = $JMS_PRODUCT_ID_DEAL_EVALUATION_UNLIMITED;
	}
	else if($jms_purchase_name == "buy-and-hold-analysis")
	{
		$jms_product_id = $JMS_PRODUCT_ID_BUY_AND_HOLD_ANALYSIS;
	}
	else
	{
		$jms_product_id = $JMS_PRODUCT_ID_ACCESS_ALL_CALCULATOR;
	}

	$stripe = new \Stripe\StripeClient($jms_stripe_secret_key);

	$customer = $stripe->customers->create([
	    'email'=>$jms_email_address,
	    'name'=>$jms_card_holder_name,
	    'source'=>$stripeToken
	]);

	/* Customer Details */
	
	$customerId = $customer->id;
	$customerName = $customer->name;

	$subscriptions = $stripe->subscriptions->create([
	    'customer'=>$customerId,
	    'items'=>[
	    	['price'=>$jms_product_id]
	    ]
	]);

	/* Subscription Details */

	$jms_subscription_id = $subscriptions->id;
	$jms_subscription_status = $subscriptions->status;
	
	$jms_timestamp = $subscriptions->created;
	$jms_formatted_date = date('Y-m-d', $jms_timestamp);
	$jms_plan_id = $subscriptions->items->data[0]->plan->product;
	$payment_method = 'stripe';
	$is_subscription = 'y';

	if($subscriptions->status == 'active')
	{
        try
       	{
       		$jms_stripe_record_insert = "INSERT INTO `stripe_payments_subscription`(`users_id`,`is_subscription`, `jms_stripe_customer_id`, `jms_stripe_email_id`, `jms_stripe_name`, `jms_stripe_status`, `jms_stripe_starts_data`, `jms_stripe_subscription_id`, `jms_stripe_plan_id`,`purchase`) VALUES (:jms_user_id,:is_subscription,:jms_stripe_customer_id,:jms_stripe_email_id,:jms_stripe_name,:jms_stripe_status,:jms_stripe_starts_data,:jms_stripe_subscription_id,:jms_stripe_plan_id,:purchase)";

		    $jms_stripe_record_insert = $jms_pdo->prepare($jms_stripe_record_insert);
		    $jms_stripe_record_insert->bindParam(':jms_user_id', $jms_user_id,PDO::PARAM_INT);
		    $jms_stripe_record_insert->bindParam(':is_subscription', $is_subscription,PDO::PARAM_STR);
	        $jms_stripe_record_insert->bindParam(':jms_stripe_customer_id', $customerId,PDO::PARAM_STR);
	        $jms_stripe_record_insert->bindParam(':jms_stripe_email_id', $jms_email_address,PDO::PARAM_STR);
	        $jms_stripe_record_insert->bindParam(':jms_stripe_name', $customerName,PDO::PARAM_STR);
	        $jms_stripe_record_insert->bindParam(':jms_stripe_status', $jms_subscription_status,PDO::PARAM_STR);
	        $jms_stripe_record_insert->bindParam(':jms_stripe_starts_data', $jms_formatted_date,PDO::PARAM_STR);
	        $jms_stripe_record_insert->bindParam(':jms_stripe_subscription_id', $jms_subscription_id,PDO::PARAM_STR);
	        $jms_stripe_record_insert->bindParam(':jms_stripe_plan_id', $jms_plan_id,PDO::PARAM_STR);
	        $jms_stripe_record_insert->bindParam(':purchase', $jms_purchase_name,PDO::PARAM_STR);

       		$jms_stripe_record_insert->execute();

       		if($jms_purchase_name != "deal-evalution" && $jms_purchase_name != "buy-and-hold-analysis")
       		{
       			include("card_1_all_calculator.php");
       		}
       		else if($jms_purchase_name != "deal-evalution" || $jms_purchase_name != "buy-and-hold-analysis")
       		{
       			$jms_subscriptionid = $jms_purchase_name == "deal-evalution" ? 2 : 4;

       			include("card_24_dealandbuy_update.php");
       		}

			$response_array['status'] = 'success';
			$response_array['message'] = 'Payment Successfull Done';
			echo json_encode($response_array);
       	}
       	catch (PDOException $e) 
	    {
	        $response_array['status'] = 'error';
			$response_array['message'] = 'Payment not successfully!';
			echo json_encode($response_array);
	    }
	}
	else
	{
		$response_array['status'] = 'error';
		$response_array['message'] = 'Payment not successfully!';
		echo json_encode($response_array);
	}
?>