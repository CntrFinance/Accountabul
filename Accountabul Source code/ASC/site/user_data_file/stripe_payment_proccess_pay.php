<?php
	include("../connection.php");
	if(!isset($_SESSION['jms_user_id']))
  	{
    	header("location:index.php");
  	}
	header('Content-type: application/json');
	
	include('../setting.php');
	require_once '../tools/stripe_payment/vendor/autoload.php';

	// Retrieve POST and SESSION variables

	$jms_user_id = $_SESSION['jms_user_id'];
	$jms_email_address = $_POST['jms_email_address'];
	$jms_price_total = $_POST['jms_price_total'];
	$jms_card_holder_name = $_POST['jms_card_holder_name'];
	$jms_purchase = $_POST['jms_purchase'];
	$jms_subscriptionid = $_POST['jms_subscriptionid'];

	$stripeToken = $_POST['stripeToken'];

	$stripe = new \Stripe\StripeClient($jms_stripe_secret_key);

	$updated_on = date('Y-m-d H:i:s');

	try 
	{
	    $amount_in_cents = str_replace('$', '', $jms_price_total) * 100;

	    $charge = $stripe->charges->create([
	        "amount" => $amount_in_cents,
	        "currency" => "usd",
	        "source" => $stripeToken,
	        "description" => $jms_purchase,
	        "receipt_email" => $jms_email_address,
	        "metadata" => [
	            "card_holder_name" => $jms_card_holder_name,
	            "user_id" => $jms_user_id
	        ]
	    ]);

	  	$jms_transtaction_id = $charge->id;
	  	$jms_status = $charge->status;

	  	if($jms_status == "succeeded")
	  	{
	  		$jms_insert_records = "INSERT INTO `stripe_payments_purchase`(`users_id`, `transation_id`, `amount`, `status`,`purchase`) VALUES (:jms_user_id,:jms_transtaction_id,:jms_price_total,:jms_status,:jms_purchase)";
		    $jms_insert_records_stmt = $jms_pdo->prepare($jms_insert_records);
		    $jms_insert_records_stmt->bindParam(':jms_user_id', $jms_user_id, PDO::PARAM_INT);
		    $jms_insert_records_stmt->bindParam(':jms_transtaction_id', $jms_transtaction_id, PDO::PARAM_STR);
		    $jms_insert_records_stmt->bindParam(':jms_price_total', $jms_price_total, PDO::PARAM_STR);
		    $jms_insert_records_stmt->bindParam(':jms_status', $jms_status, PDO::PARAM_STR);
		    $jms_insert_records_stmt->bindParam(':jms_purchase', $jms_purchase, PDO::PARAM_STR);

		    try 
		    {
		        $jms_insert_records_stmt->execute();

				// Get user record
				$jms_select_sql = "SELECT * FROM `user-registration` WHERE id = :jms_user_id";
				$jms_select_data = $jms_pdo->prepare($jms_select_sql);
				$jms_select_data->bindParam(':jms_user_id', $jms_user_id, PDO::PARAM_INT);
				$jms_select_data->execute();
				$jms_row = $jms_select_data->fetch(PDO::FETCH_ASSOC);

				if ($jms_row) 
				{
				    $jms_updated_pass = "UPDATE `user-registration` SET ";

				    if (isset($jms_subscriptionid)) 
				    {
				        if ($jms_subscriptionid == 3) 
				        {
				            $jms_updated_pass .= "jms_no_save_deal = :jms_no_save_deal, ";
				        } 
				        else 
				        {
				            $jms_updated_pass .= "jms_no_save_buy = :jms_no_save_buy, ";
				        }
				    } 

				    $jms_updated_pass .= "updated_on = :updated_on WHERE id = :jms_user_id";

				    $jms_updated_pass_update = $jms_pdo->prepare($jms_updated_pass);
				    $jms_updated_pass_update->bindParam(':jms_user_id', $jms_user_id, PDO::PARAM_INT);
				    
				    if (isset($jms_subscriptionid)) 
				    {
				        if ($jms_subscriptionid == 3) 
				        {
				        	$numeric_amount = str_replace('$', '', $jms_price_total);
				            $jms_total_save_old = $jms_row['jms_no_save_deal'];
				            $jms_nosave_deal = ($numeric_amount / $jms_deal_evalution_save_price) + $jms_total_save_old;
				            $jms_updated_pass_update->bindParam(':jms_no_save_deal', $jms_nosave_deal, PDO::PARAM_STR);
				        } 
				        else 
				        {
				        	$numeric_amount = str_replace('$', '', $jms_price_total);
				            $jms_total_save_old = $jms_row['jms_no_save_buy'];
				            $jms_nosave_buy = ($numeric_amount / $jms_buy_and_hold_analysis_price) + $jms_total_save_old;
				            $jms_updated_pass_update->bindParam(':jms_no_save_buy', $jms_nosave_buy, PDO::PARAM_STR);
				        }
				    }

				    $jms_updated_pass_update->bindParam(':updated_on', $updated_on, PDO::PARAM_STR);
				    $jms_updated_pass_update->execute();
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
	} 
	catch (\Stripe\Exception\ApiErrorException $e) 
	{
	    $response_array['status'] = 'error';
		$response_array['message'] = 'Payment not successfully!';
		echo json_encode($response_array);
	}
?>