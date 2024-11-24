<?php
	// include('connection.php');
    // if(!isset($_SESSION['jms_user_id']))
    // {
    //     header("location:index.php");
    // }
    // // header('Content-type: application/json');

    // // 

    // if(isset($_SESSION['jms_user_id']) && $_SESSION['jms_user_id'])
    // {
    //     $jms_user_id = $_SESSION['jms_user_id'];
    // }
    // else
    // {
    //     $jms_user_id = 0;
    // }
	
	include('setting.php');

    // get user reg.

    $jms_select_sql = "SELECT * FROM `user-registration` WHERE id=:jms_user_id";
    $jms_select_data = $jms_pdo->prepare($jms_select_sql);
    $jms_select_data->bindParam(':jms_user_id', $jms_user_id,PDO::PARAM_INT);
    $jms_select_data->execute();
    $jms_row = $jms_select_data->fetchAll(PDO::FETCH_ASSOC);

    // $jms_paypal_status = 0;
    $jms_paypal_status = "";
    // $jms_stripe_status = 0;
    $jms_paypal_status = "";

    if($jms_row[0]['payment_method'] == 'paypal')
    {
    	$clientId = $jms_paypal_client_id;
		$clientSecret = $jms_paypal_secret_key;
		$subscriptionId = $jms_row[0]['jms_paypal_subscriptionid']; // Replace with the actual subscription ID

		// Step 1: Obtain OAuth 2.0 Token

		$curl = curl_init();
		curl_setopt_array($curl, [
		    CURLOPT_URL => "https://api-m.sandbox.paypal.com/v1/oauth2/token",
		    CURLOPT_RETURNTRANSFER => true,
		    CURLOPT_USERPWD => $clientId . ":" . $clientSecret,
		    CURLOPT_POST => true,
		    CURLOPT_POSTFIELDS => "grant_type=client_credentials",
		    CURLOPT_HTTPHEADER => [
		        "Content-Type: application/x-www-form-urlencoded"
		    ],
		]);

		$response = curl_exec($curl);

		if ($response === false) 
		{
		    $error = curl_error($curl);
		    curl_close($curl);
		    // $jms_paypal_status = 0;
		    $jms_paypal_status = "CANCELLED";
		}

		$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		if ($httpCode !== 200) 
		{
		    curl_close($curl);
		    // $jms_paypal_status = 0;
		    $jms_paypal_status = "CANCELLED";
		}

		curl_close($curl);

		$tokenData = json_decode($response, true);
		if (json_last_error() !== JSON_ERROR_NONE) 
		{
		    // $jms_paypal_status = 0;
		    $jms_paypal_status = "CANCELLED";
		}

		if (!isset($tokenData['access_token'])) 
		{
		    // $jms_paypal_status = 0;
		    $jms_paypal_status = "CANCELLED";
		}

		$token = $tokenData['access_token'];

		// Step 2: Retrieve Subscription Details

		$curl = curl_init();
		curl_setopt_array($curl, [
		    CURLOPT_URL => "https://api-m.sandbox.paypal.com/v1/billing/subscriptions/{$subscriptionId}",
		    CURLOPT_RETURNTRANSFER => true,
		    CURLOPT_HTTPHEADER => [
		        "Content-Type: application/json",
		        "Authorization: Bearer {$token}"
		    ],
		]);

		$response = curl_exec($curl);

		if ($response === false) {
		    $error = curl_error($curl);
		    curl_close($curl);
		    // $jms_paypal_status = 0;
		    $jms_paypal_status = "CANCELLED";
		}

		$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		if ($httpCode !== 200) {
		    curl_close($curl);
		    // $jms_paypal_status = 0;
		    $jms_paypal_status = "CANCELLED";
		}

		curl_close($curl);

		$subscription = json_decode($response, true);
		if (json_last_error() !== JSON_ERROR_NONE) 
		{
		    // $jms_paypal_status = 0;
		    $jms_paypal_status = "CANCELLED";
		}

		// Check Subscription Status


		if ($subscription && isset($subscription['status']) && $subscription['status'] === 'ACTIVE') 
		{
		    // echo "<pre>";
		    
		    // echo "</pre>";

		    // $jms_paypal_status = 1;

		    $jms_paypal_status = "ACTIVE";
		} 
		else 
		{
		    // echo "User is not subscribed.";

		    // $jms_paypal_status = 0;
		    $jms_paypal_status = "CANCELLED";
		}
    }
    else
    {

    	require_once 'tools/stripe_payment/vendor/autoload.php';

		\Stripe\Stripe::setApiKey($jms_stripe_secret_key);

		$subscriptionId = $jms_row[0]['jms_stripe_subscription_id']; // Replace with the actual subscription ID

		try 
		{
		    $subscription = \Stripe\Subscription::retrieve($subscriptionId);

		    if ($subscription->status === 'active') 
		    {
		        // echo "Subscription is active.";
		        $jms_stripe_status = 1;
		    } 
		    else 
		    {
		        // echo "Subscription is not active. Current status: " . $subscription->status;
		        $jms_stripe_status = 0;
		    }
		} 
		catch (\Stripe\Exception\ApiErrorException $e) 
		{
		    // echo "Error retrieving subscription: " . $e->getMessage();

		    $jms_stripe_status = 0;
		}
    }
?>