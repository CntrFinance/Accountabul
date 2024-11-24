<?php
	include("../connection.php");
	if(!isset($_SESSION['jms_user_id']))
  	{
    	header("location:index.php");
  	}
	header('Content-type: application/json');

	include("../setting.php");
	require_once '../tools/paypal_payment/vendor/autoload.php';

	use GuzzleHttp\Client;
	use GuzzleHttp\Exception\RequestException;

	class PayPalSubscriptionCanceller 
	{
	    private $client;
	    private $clientId;
	    private $clientSecret;
	    private $accessToken;
	    private $pdo;

	    public function __construct($clientId, $clientSecret, PDO $pdo) 
	    {
	        $this->clientId = $clientId;
	        $this->clientSecret = $clientSecret;
	        $this->pdo = $pdo;
	        $this->client = new Client([
	            'base_uri' => 'https://api.sandbox.paypal.com', // Use 'https://api.paypal.com' for live
	        ]);
	    }

	    public function authenticate() 
	    {
	        try 
	        {
	            $response = $this->client->post('/v1/oauth2/token', [
	                'headers' => [
	                    'Authorization' => 'Basic ' . base64_encode($this->clientId . ':' . $this->clientSecret),
	                    'Content-Type' => 'application/x-www-form-urlencoded',
	                ],
	                'form_params' => [
	                    'grant_type' => 'client_credentials',
	                ],
	            ]);

	            $data = json_decode($response->getBody(), true);
	            $this->accessToken = $data['access_token'];
	        } catch (RequestException $e) 
	        {
	            $response_array['status'] = 'error';
	            $response_array['message'] = 'Error obtaining access token';
	            echo json_encode($response_array);
	            exit;
	        }
	    }

	    public function cancelSubscription($subscriptionId, $reason = 'No longer needed') 
	    {
	        global $jms_user_id,$is_subscription,$jms_paypal_status,$jms_record_id;

	        try 
	        {
	            $response = $this->client->post("/v1/billing/subscriptions/$subscriptionId/cancel", [
	                'headers' => [
	                    'Authorization' => 'Bearer ' . $this->accessToken,
	                    'Content-Type' => 'application/json',
	                ],
	                'json' => [
	                    'reason' => $reason,
	                ],
	            ]);

	            if ($response->getStatusCode() === 204) 
	            {

	                // $sql = "UPDATE `paypal_payments_subscription` SET is_subscription = :is_subscription,
	                //         jms_paypal_status = :jms_paypal_status
	                //         WHERE users_id = :jms_user_id ORDER BY id DESC";
	                // $stmt = $this->pdo->prepare($sql);
	                // $stmt->bindParam(':jms_user_id', $jms_user_id, PDO::PARAM_INT);
	                // $stmt->bindParam(':is_subscription', $is_subscription, PDO::PARAM_STR);
	                // $stmt->bindParam(':jms_paypal_status', $jms_paypal_status, PDO::PARAM_STR);


	                $sql = "UPDATE `paypal_payments_subscription` 
					        SET is_subscription = :is_subscription,
					            jms_paypal_status = :jms_paypal_status
					        WHERE users_id = :jms_user_id AND id=:jms_record_id";
					$stmt = $this->pdo->prepare($sql);
					$stmt->bindParam(':jms_user_id', $jms_user_id, PDO::PARAM_INT);
					$stmt->bindParam(':is_subscription', $is_subscription, PDO::PARAM_STR);
					$stmt->bindParam(':jms_paypal_status', $jms_paypal_status, PDO::PARAM_STR);
					$stmt->bindParam(':jms_record_id', $jms_record_id, PDO::PARAM_STR);

					$stmt->execute();
					
	                $response_array['status'] = 'success';
	                $response_array['message'] = 'Payment has been canceled successfully';
	                echo json_encode($response_array);
	            } else 
	            {
	                $response_array['status'] = 'error';
	                $response_array['message'] = "Failed to cancel subscription. Status code: " . $response->getStatusCode();
	                echo json_encode($response_array);
	            }
	        } catch (RequestException $e) 
	        {
	            $response_array['status'] = 'error';
	            $response_array['message'] = "Error canceling subscription";
	            echo json_encode($response_array);
	        } catch (PDOException $e) 
	        {
	            $response_array['status'] = 'error';
	            $response_array['message'] = "Database error: " . $e->getMessage();
	            echo json_encode($response_array);
	        }
	    }
	}
	
	$jms_user_id = $_SESSION['jms_user_id'];
	$pdo = $jms_pdo;
    $clientId = $jms_paypal_client_id;
	$clientSecret = $jms_paypal_secret_key;
    
    $subscription_id = $_POST['jms_subscription_id'];
    $jms_purchase_name = $_POST['jms_purchase_name'];
    $jms_record_id = $_POST['jms_record_id'];

    $is_subscription = "n";
  	$jms_paypal_status = 'CANCELLED';

  	// get nextbilling date 

    function getAccessToken($clientId, $clientSecret) {
	    $url = 'https://api.sandbox.paypal.com/v1/oauth2/token';
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
	    curl_setopt($ch, CURLOPT_HTTPHEADER, [
	        'Accept: application/json',
	        'Accept-Language: en_US',
	    ]);
	    curl_setopt($ch, CURLOPT_USERPWD, $clientId . ':' . $clientSecret);

	    $response = curl_exec($ch);
	    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	    $error = curl_error($ch);
	    curl_close($ch);

	    if ($httpCode !== 200 || $error) {
	        // echo "Error: HTTP Status Code $httpCode\nResponse: $response\ncURL Error: $error\n";
	        return null;
	    }

	    $json = json_decode($response);
	    if (json_last_error() !== JSON_ERROR_NONE) {
	        // echo "JSON Decode Error: " . json_last_error_msg() . "\n";
	        return null;
	    }

	    return $json->access_token ?? null;
	}

	function getSubscriptionDetails($accessToken, $subscriptionId) {
	    $url = 'https://api.sandbox.paypal.com/v1/billing/subscriptions/' . $subscriptionId;
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, [
	        'Authorization: Bearer ' . $accessToken,
	        'Content-Type: application/json',
	    ]);

	    $response = curl_exec($ch);
	    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	    $error = curl_error($ch);
	    curl_close($ch);

	    if ($httpCode !== 200 || $error) {
	        // echo "Error: HTTP Status Code $httpCode\nResponse: $response\ncURL Error: $error\n";
	        return null;
	    }

	    return json_decode($response, true);
	}

	// Usage
	
	$accessToken = getAccessToken($jms_paypal_client_id, $jms_paypal_secret_key);

	if($accessToken) 
	{
	    $subscriptionDetails = getSubscriptionDetails($accessToken, $subscription_id);
	    
	    if ($subscriptionDetails) 
	    {
	        if (isset($subscriptionDetails['billing_info']['next_billing_time'])) 
	        {
	            $nextBillingDateTime = $subscriptionDetails['billing_info']['next_billing_time'];

	            $dateTime = new DateTime($nextBillingDateTime);

				$nextBillingDate = $dateTime->format('d-m-Y');

				$method = "paypal";

				// insert recrod cancel nextbilling date

				$jms_insert_records = "INSERT INTO `cancel_subscription`(`users_id`,`method`,`subscription_id`,`nextbilling_date`,`purchase`) VALUES (:jms_user_id,:method,:subscription_id,:nextbilling_date,:jms_purchase_name)";
			    $jms_insert_records_stmt = $jms_pdo->prepare($jms_insert_records);
			    $jms_insert_records_stmt->bindParam(':jms_user_id', $jms_user_id, PDO::PARAM_INT);
			    $jms_insert_records_stmt->bindParam(':method', $method, PDO::PARAM_STR);
			    $jms_insert_records_stmt->bindParam(':jms_purchase_name', $jms_purchase_name, PDO::PARAM_STR);
			    $jms_insert_records_stmt->bindParam(':subscription_id', $subscription_id, PDO::PARAM_STR);
			    $jms_insert_records_stmt->bindParam(':nextbilling_date', $nextBillingDate, PDO::PARAM_STR);
			    $jms_insert_records_stmt->execute();
	        } 
	        else
	        {
	            $response_array['status'] = 'error';
				$response_array['message'] = "Next billing date not set.";
				echo json_encode($response_array);
				exit;
	        }
	    } 
	    else
	    {
	        $response_array['status'] = 'error';
			$response_array['message'] = "Failed to retrieve subscription details.";
			echo json_encode($response_array);
			exit;
	    }
	} 
	else
	{
	    $response_array['status'] = 'error';
		$response_array['message'] = "Failed to retrieve access token.";
		echo json_encode($response_array);
		exit;
	}

    $canceller = new PayPalSubscriptionCanceller($clientId, $clientSecret, $pdo);
    $canceller->authenticate();
    $canceller->cancelSubscription($subscription_id);
?>