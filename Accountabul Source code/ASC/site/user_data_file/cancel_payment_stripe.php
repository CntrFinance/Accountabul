<?php
	include("../connection.php");
	if(!isset($_SESSION['jms_user_id']))
  	{
    	header("location:index.php");
  	}
	header('Content-type: application/json');

	include("../setting.php");
	require_once '../tools/stripe_payment/vendor/autoload.php';

	$jms_user_id = $_SESSION['jms_user_id'];
	$subscription_id = $_POST['jms_subscription_id'];
	$jms_purchase_name1 = $_POST['jms_purchase_name1'];

	$is_subscription = "n";
	$jms_subscription_status = "canceled";
	$method = "stripe";

	try 
	{
		\Stripe\Stripe::setApiKey($jms_stripe_secret_key);

	    $subscription = \Stripe\Subscription::retrieve($subscription_id);
	    $next_billing_date = date('d-m-Y', $subscription->current_period_end);
	    
	   	// cancel payment

	    $stripe = new \Stripe\StripeClient($jms_stripe_secret_key);
		$jms_cancel_stripe = $stripe->subscriptions->cancel($subscription_id, []);

		if($jms_cancel_stripe->status == 'canceled')
		{
		    // insert recrod cancel nextbilling date

			$jms_insert_records = "INSERT INTO `cancel_subscription`(`users_id`,`method`,`subscription_id`,`nextbilling_date`,`purchase`) VALUES (:jms_user_id,:method,:subscription_id,:nextbilling_date,:jms_purchase_name)";
		    $jms_insert_records_stmt = $jms_pdo->prepare($jms_insert_records);
		    $jms_insert_records_stmt->bindParam(':jms_user_id', $jms_user_id, PDO::PARAM_INT);
		    $jms_insert_records_stmt->bindParam(':method', $method, PDO::PARAM_STR);
		    $jms_insert_records_stmt->bindParam(':jms_purchase_name', $jms_purchase_name1, PDO::PARAM_STR);
		    $jms_insert_records_stmt->bindParam(':subscription_id', $subscription_id, PDO::PARAM_STR);
		    $jms_insert_records_stmt->bindParam(':nextbilling_date', $next_billing_date, PDO::PARAM_STR);
		    $jms_insert_records_stmt->execute();

		    // updated database 

		    $sql = "UPDATE `stripe_payments_subscription` 
			        SET is_subscription = :is_subscription,
			            jms_stripe_status = :jms_stripe_status
			        WHERE users_id = :jms_user_id AND purchase = :jms_purchase_name
			        ORDER BY id DESC 
			        LIMIT 1";
			$stmt = $jms_pdo->prepare($sql);
			$stmt->bindParam(':jms_user_id', $jms_user_id, PDO::PARAM_INT);
			$stmt->bindParam(':jms_purchase_name', $jms_purchase_name1, PDO::PARAM_STR);
			$stmt->bindParam(':is_subscription', $is_subscription, PDO::PARAM_STR);
			$stmt->bindParam(':jms_stripe_status', $jms_subscription_status, PDO::PARAM_STR);

			$stmt->execute();

			$response_array['status'] = 'success';
			$response_array['message'] = 'Payment has been canceled successfully';
			echo json_encode($response_array);
		}
		else
		{
			$response_array['status'] = 'error';
			$response_array['message'] = 'Payment is not cancelled!';
			echo json_encode($response_array);
		}
	} catch (\Stripe\Exception\ApiErrorException $e) 
	{
	    $response_array['status'] = 'error';
		$response_array['message'] = 'Payment is not cancelled!';
		echo json_encode($response_array);
	}
	
?>