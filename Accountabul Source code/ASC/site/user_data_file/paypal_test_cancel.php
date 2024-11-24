<?php
	include("../connection.php");
	if(!isset($_SESSION['jms_user_id']))
  	{
    	header("location:index.php");
  	}
	header('Content-type: application/json');

	include("../setting.php");
	require_once '../tools/paypal_payment/vendor/autoload.php';

	// paypal get

	// function getAccessToken()
	// {
	//     $url = 'https://api.sandbox.paypal.com/v1/oauth2/token'; // or live URL for production
	//     $clientId = 'Abv95j9htM5lackVg_ZZUA_DXXu3v6VP5La3n7Ds1uMf3E0n5d9rAzrHwWPaeSryFbqxJFbbCZI7_CAH';
	//     $clientSecret = 'EOQv5xr9yQWVQlDsOVVD5RxHyhFl6016gBCg8Qq_7ak4ShJYkm0KZ257VW7W4TdE4i78YuO8lUPrk-z2';

	//     $ch = curl_init();
	//     curl_setopt($ch, CURLOPT_URL, $url);
	//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	//     curl_setopt($ch, CURLOPT_POST, true);
	//     curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
	//     curl_setopt($ch, CURLOPT_HTTPHEADER, [
	//         'Accept: application/json',
	//         'Accept-Language: en_US',
	//     ]);
	//     curl_setopt($ch, CURLOPT_USERPWD, $clientId . ':' . $clientSecret); // Use CURLOPT_USERPWD for basic auth

	//     $response = curl_exec($ch);
	//     $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	//     $error = curl_error($ch);
	//     curl_close($ch);

	//     if ($httpCode !== 200) {
	//         echo "Error: HTTP Status Code $httpCode\n";
	//         echo "Response: $response\n";
	//     }

	//     if ($error) {
	//         echo 'cURL Error: ' . $error;
	//         return null;
	//     } 

	//     $json = json_decode($response);
	//     if (json_last_error() !== JSON_ERROR_NONE) {
	//         echo 'JSON Decode Error: ' . json_last_error_msg();
	//         return null;
	//     }

	//     if (isset($json->access_token)) {
	//         return $json->access_token;
	//     } else {
	//         echo 'Access token not found in response.';
	//         return null;
	//     }
	// }

	// function getSubscriptionDetails($subscriptionId) 
	// {
	//     $accessToken = getAccessToken();
	//     if (!$accessToken) {
	//         return null; // Handle the error as needed
	//     }

	//     $url = 'https://api.sandbox.paypal.com/v1/billing/subscriptions/' . $subscriptionId;

	//     $ch = curl_init();
	//     curl_setopt($ch, CURLOPT_URL, $url);
	//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	//     curl_setopt($ch, CURLOPT_HTTPHEADER, [
	//         'Authorization: Bearer ' . $accessToken,
	//         'Content-Type: application/json',
	//     ]);

	//     $response = curl_exec($ch);
	//     $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	//     $error = curl_error($ch);
	//     curl_close($ch);

	//     if ($httpCode !== 200) {
	//         echo "Error: HTTP Status Code $httpCode\n";
	//         echo "Response: $response\n";
	//     }

	//     if ($error) {
	//         echo 'cURL Error: ' . $error;
	//         return null;
	//     }

	//     return json_decode($response);
	// }

	// $subscriptionDetails = getSubscriptionDetails('I-H21Y1CJ4MWEK');
	// echo '<pre>';
	// print_r($subscriptionDetails);
	// echo '</pre>';

	// if (isset($subscriptionDetails->billing_info->next_billing_date)) 
	// {
	//     $endDate = $subscriptionDetails->billing_info->next_billing_date;
	//     echo 'Subscription ends on: ' . $endDate;
	// } else {
	//     echo 'Could not retrieve end date.';
	// }


	// stripe
	
	require_once '../tools/stripe_payment/vendor/autoload.php';

	\Stripe\Stripe::setApiKey('sk_test_51OY4u8DTqe3AeBX59nNQyQ34nLpB9exWQwpNhVwPvDRX0LrCVIVh2IYyTa3yq0wZxg3uvY8St70kLgQNb7yea6qy00dtHL2utL');

	try {
	    // Retrieve the subscription
	    $subscription = \Stripe\Subscription::retrieve('sub_1PbigMDTqe3AeBX5CXKEKYz1');
	    
	    // Check the next billing date
	    $next_billing_date = $subscription->current_period_end;
	    echo 'Next billing date: ' . date('Y-m-d H:i:s', $next_billing_date);
	    	
	    	print_r($subscription);
	    	
	    // Cancel the subscription at the end of the period
	    $subscription->cancel([
	        'at_period_end' => true,
	    ]);

	    echo 'Subscription will be canceled at the end of the billing period.';
	} catch (\Stripe\Exception\ApiErrorException $e) {
	    // Handle the error
	    echo 'Error: ' . $e->getMessage();
	}
?>