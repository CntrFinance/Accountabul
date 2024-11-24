<?php
	include("../connection.php");
	if(!isset($_SESSION['jms_user_id']))
  	{
    	header("location:index.php");
  	}
	header('Content-type: application/json');
	
	$jms_user_id = $_SESSION['jms_user_id'];
	
	$jms_paypal_customer_id = $_POST['jms_paypal_customer_id'];
	$jms_paypal_email_id = $_POST['jms_paypal_email_id'];
	$jms_paypal_name = $_POST['jms_paypal_name'];
	$jms_paypal_status = $_POST['jms_paypal_status'];
	$jms_paypal_starts_date = $_POST['jms_paypal_starts_date'];
	$jms_paypal_subscriptionid = $_POST['jms_paypal_subscriptionid'];
	$jms_paypal_orderid = $_POST['jms_paypal_orderid'];
	$jms_paypal_plan_id = $_POST['jms_paypal_plan_id'];

	$jms_url_calcname = $_POST['jms_url_calcname'];

	$is_subscription = 'y';
	
	if($jms_paypal_status == 'ACTIVE')
	{
	    try
       	{
       		$jms_paypal_record_insert = "INSERT INTO `paypal_payments_subscription`(`users_id`, `is_subscription`, `jms_paypal_customer_id`, `jms_paypal_email_id`, `jms_paypal_name`, `jms_paypal_status`, `jms_paypal_starts_date`, `jms_paypal_subscriptionid`, `jms_paypal_orderid`, `jms_paypal_plan_id`,`purchase`) VALUES (:jms_user_id,:is_subscription,:jms_paypal_customer_id,:jms_paypal_email_id,:jms_paypal_name,:jms_paypal_status,:jms_paypal_starts_date,:jms_paypal_subscriptionid,:jms_paypal_orderid,:jms_paypal_plan_id,:purchase)";

		    $jms_paypal_record_insert = $jms_pdo->prepare($jms_paypal_record_insert);
		    $jms_paypal_record_insert->bindParam(':jms_user_id', $jms_user_id,PDO::PARAM_INT);
		    $jms_paypal_record_insert->bindParam(':is_subscription', $is_subscription,PDO::PARAM_STR);
	        $jms_paypal_record_insert->bindParam(':jms_paypal_customer_id', $jms_paypal_customer_id,PDO::PARAM_STR);
	        $jms_paypal_record_insert->bindParam(':jms_paypal_email_id', $jms_paypal_email_id,PDO::PARAM_STR);
	        $jms_paypal_record_insert->bindParam(':jms_paypal_name', $jms_paypal_name,PDO::PARAM_STR);
	        $jms_paypal_record_insert->bindParam(':jms_paypal_status', $jms_paypal_status,PDO::PARAM_STR);
	        $jms_paypal_record_insert->bindParam(':jms_paypal_starts_date', $jms_paypal_starts_date,PDO::PARAM_STR);
	        $jms_paypal_record_insert->bindParam(':jms_paypal_subscriptionid', $jms_paypal_subscriptionid,PDO::PARAM_STR);
	        $jms_paypal_record_insert->bindParam(':jms_paypal_orderid', $jms_paypal_orderid,PDO::PARAM_STR);
	        $jms_paypal_record_insert->bindParam(':jms_paypal_plan_id', $jms_paypal_plan_id,PDO::PARAM_STR);
	        $jms_paypal_record_insert->bindParam(':purchase', $jms_url_calcname,PDO::PARAM_STR);

       		$jms_paypal_record_insert->execute();

       		if($jms_url_calcname != "deal-evalution" && $jms_url_calcname != "buy-and-hold-analysis")
       		{
       			include("card_1_all_calculator.php");
       		}
       		else if($jms_url_calcname != "deal-evalution" || $jms_url_calcname != "buy-and-hold-analysis")
       		{
       			$jms_subscriptionid = $jms_url_calcname == "deal-evalution" ? 2 : 4;

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