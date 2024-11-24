<?php
	
    $updated_on = date('Y-m-d H:i:s');

    // paypal

    $jms_select_sql_paypal = "SELECT * FROM `paypal_payments_subscription` WHERE users_id = :jms_user_id ORDER BY id DESC";
    $jms_select_data_paypal = $jms_pdo->prepare($jms_select_sql_paypal);
    $jms_select_data_paypal->bindParam(':jms_user_id', $jms_user_id, PDO::PARAM_INT);
    $jms_select_data_paypal->execute();
    $jms_row_paypal = $jms_select_data_paypal->fetch(PDO::FETCH_ASSOC);

    
    function jms_paypal_get_api($jms_pdo,$subscription_id)
    {
        $jms_pdo;
        include("../setting.php");

        $clientId = $jms_paypal_client_id;
        $clientSecret = $jms_paypal_secret_key;
        $subscriptionId = $subscription_id;//$jms_row_paypal['jms_paypal_subscriptionid'];//"I-1CALYY8BBJ7A";//$jms_row[0]['jms_paypal_subscriptionid']; // Replace with the actual subscription ID

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
            $jms_paypal_status = "CANCELLED";
        }

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($httpCode !== 200) 
        {
            curl_close($curl);
            $jms_paypal_status = "CANCELLED";
        }

        curl_close($curl);

        $tokenData = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) 
        {
            $jms_paypal_status = "CANCELLED";
        }

        if (!isset($tokenData['access_token'])) 
        {
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
            $jms_paypal_status = "CANCELLED";
        }

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($httpCode !== 200) {
            curl_close($curl);
            $jms_paypal_status = "CANCELLED";
        }

        curl_close($curl);

        $subscription = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) 
        {
            $jms_paypal_status = "CANCELLED";
        }

        // Check Subscription Status

        if ($subscription && isset($subscription['status']) && $subscription['status'] === 'ACTIVE') 
        {
            $jms_paypal_status = "ACTIVE";
        } 
        else 
        {
            $jms_paypal_status = "CANCELLED";
        }

        return $jms_paypal_status == "ACTIVE" ? true : false;
    }

    if ($jms_row_paypal !== false) 
    {
        if(isset($jms_row_paypal['purchase']) && $jms_row_paypal['purchase'] == "deal-evalution")
        {
            if(jms_paypal_get_api($jms_pdo,$jms_row_paypal['jms_paypal_subscriptionid']) == false)
            {
                $jms_updated_pass = "UPDATE `user-registration` SET jms_unlimited_deal = :jms_unlimited_deal, updated_on = :updated_on WHERE id = :jms_user_id";
                $jms_updated_pass_update = $jms_pdo->prepare($jms_updated_pass);
                $jms_updated_pass_update->bindParam(':jms_user_id', $jms_user_id, PDO::PARAM_INT);
                
                $jms_unlimited_deal = "";//"Unlimited";
                $jms_updated_pass_update->bindParam(':jms_unlimited_deal', $jms_unlimited_deal, PDO::PARAM_STR);
                $jms_updated_pass_update->bindParam(':updated_on', $updated_on, PDO::PARAM_STR);
                $jms_updated_pass_update->execute();
            }
        }

        if(isset($jms_row_paypal['purchase']) && $jms_row_paypal['purchase'] == "buy-and-hold-analysis")
        {
            if(jms_paypal_get_api($jms_pdo,$jms_row_paypal['jms_paypal_subscriptionid']) == false)
            {
                $jms_updated_pass = "UPDATE `user-registration` SET jms_unlimited_buy = :jms_unlimited_buy, updated_on = :updated_on WHERE id = :jms_user_id";
                $jms_updated_pass_update = $jms_pdo->prepare($jms_updated_pass);
                $jms_updated_pass_update->bindParam(':jms_user_id', $jms_user_id, PDO::PARAM_INT);
                
                $jms_unlimited_buy = "";//"Unlimited";
                $jms_updated_pass_update->bindParam(':jms_unlimited_buy', $jms_unlimited_buy, PDO::PARAM_STR);
                $jms_updated_pass_update->bindParam(':updated_on', $updated_on, PDO::PARAM_STR);
                $jms_updated_pass_update->execute();
            }
        }

        if(isset($jms_row_paypal['purchase']) && $jms_row_paypal['purchase'] == "access-all-calculator")
        {
            if(jms_paypal_get_api($jms_pdo,$jms_row_paypal['jms_paypal_subscriptionid']) == false)
            {
                // get data user record

                $jms_select_sql = "SELECT * FROM `user-registration` WHERE id=:jms_user_id";
                $jms_select_data = $jms_pdo->prepare($jms_select_sql);
                $jms_select_data->bindParam(':jms_user_id', $jms_user_id,PDO::PARAM_INT);
                $jms_select_data->execute();
                $jms_row = $jms_select_data->fetchAll(PDO::FETCH_ASSOC);

                $jms_total_save_old_deal = $jms_row[0]['jms_no_save_deal'];
                $jms_total_save_old_buy = $jms_row[0]['jms_no_save_buy'];

                // user data record update

                $jms_updated_pass = "UPDATE `user-registration` SET jms_no_save_deal=:jms_no_save_deal,jms_no_save_buy=:jms_no_save_buy,jms_deal_save_allno=:jms_deal_save_allno,jms_buy_save_allno=:jms_buy_save_allno,updated_on=:updated_on WHERE id=:jms_user_id";

                $jms_updated_pass_update = $jms_pdo->prepare($jms_updated_pass);
                $jms_updated_pass_update->bindParam(':jms_user_id', $jms_user_id, PDO::PARAM_INT);

                // subscription minus 250 - old save deal evalution 

                $jms_nosave_deal = $jms_total_save_old_deal > 250 ? $jms_total_save_old_deal - 250 : 0;
                $jms_updated_pass_update->bindParam(':jms_no_save_deal', $jms_nosave_deal, PDO::PARAM_STR);

                // subscription minus 250 save deal evalution 

                $jms_deal_save_allno = 0;
                $jms_updated_pass_update->bindParam(':jms_deal_save_allno', $jms_deal_save_allno, PDO::PARAM_STR);

                // subscription minus 250 - old save buy and hold analysis

                $jms_nosave_buy = $jms_total_save_old_buy > 250 ? $jms_total_save_old_buy - 250 : 0;
                $jms_updated_pass_update->bindParam(':jms_no_save_buy', $jms_nosave_buy, PDO::PARAM_STR);

                // subscription minus 250 save deal evalution 

                $jms_buy_save_allno = 0;
                $jms_updated_pass_update->bindParam(':jms_buy_save_allno', $jms_buy_save_allno, PDO::PARAM_STR);

                $jms_updated_pass_update->bindParam(':updated_on', $updated_on, PDO::PARAM_STR);
                $jms_updated_pass_update->execute();
            }
        }
    }

    // stripe

    $jms_select_sql_stripe = "SELECT * FROM `stripe_payments_subscription` WHERE users_id = :jms_user_id ORDER BY id DESC";
    $jms_select_data_stripe = $jms_pdo->prepare($jms_select_sql_stripe);
    $jms_select_data_stripe->bindParam(':jms_user_id', $jms_user_id, PDO::PARAM_INT);
    $jms_select_data_stripe->execute();
    $jms_row_stripe = $jms_select_data_stripe->fetch(PDO::FETCH_ASSOC);


    function jms_stripe_get_api($jms_pdo,$subscription_id)
    {
        $jms_pdo;
        require_once '../tools/stripe_payment/vendor/autoload.php';
        include("../setting.php");

        \Stripe\Stripe::setApiKey($jms_stripe_secret_key);

        $subscriptionId = $subscription_id;//"sub_1Pc5ajDTqe3AeBX59uMyXKbF";//$jms_row[0]['jms_stripe_subscription_id']; // Replace with the actual subscription ID

        $subscription = \Stripe\Subscription::retrieve($subscriptionId);

        if ($subscription->status === 'active') 
        {
            $jms_stripe_status = "active";
        } 
        else 
        {
            $jms_stripe_status = "canceled";
        }

        return $jms_stripe_status == "active" ? true : false;
    }

    if ($jms_row_stripe !== false) 
    {
        if(isset($jms_row_stripe['purchase']) && $jms_row_stripe['purchase'] == "deal-evalution")
        {
            if(jms_stripe_get_api($jms_pdo,$jms_row_stripe['jms_stripe_subscription_id']) == false)
            {
                $jms_updated_pass = "UPDATE `user-registration` SET jms_unlimited_deal = :jms_unlimited_deal, updated_on = :updated_on WHERE id = :jms_user_id";
                $jms_updated_pass_update = $jms_pdo->prepare($jms_updated_pass);
                $jms_updated_pass_update->bindParam(':jms_user_id', $jms_user_id, PDO::PARAM_INT);
                
                $jms_unlimited_deal = "";//"Unlimited";
                $jms_updated_pass_update->bindParam(':jms_unlimited_deal', $jms_unlimited_deal, PDO::PARAM_STR);
                $jms_updated_pass_update->bindParam(':updated_on', $updated_on, PDO::PARAM_STR);
                $jms_updated_pass_update->execute();
            }
        }

        if(isset($jms_row_stripe['purchase']) && $jms_row_stripe['purchase'] == "buy-and-hold-analysis")
        {
            if(jms_stripe_get_api($jms_pdo,$jms_row_stripe['jms_stripe_subscription_id']) == false)
            {
                $jms_updated_pass = "UPDATE `user-registration` SET jms_unlimited_buy = :jms_unlimited_buy, updated_on = :updated_on WHERE id = :jms_user_id";
                $jms_updated_pass_update = $jms_pdo->prepare($jms_updated_pass);
                $jms_updated_pass_update->bindParam(':jms_user_id', $jms_user_id, PDO::PARAM_INT);
                
                $jms_unlimited_buy = "";//"Unlimited";
                $jms_updated_pass_update->bindParam(':jms_unlimited_buy', $jms_unlimited_buy, PDO::PARAM_STR);
                $jms_updated_pass_update->bindParam(':updated_on', $updated_on, PDO::PARAM_STR);
                $jms_updated_pass_update->execute();
            }
        }

        if(isset($jms_row_stripe['purchase']) && $jms_row_stripe['purchase'] == "access-all-calculator")
        {
            if(jms_stripe_get_api($jms_pdo,$jms_row_stripe['jms_stripe_subscription_id']) == false)
            {
                // get data user record

                $jms_select_sql = "SELECT * FROM `user-registration` WHERE id=:jms_user_id";
                $jms_select_data = $jms_pdo->prepare($jms_select_sql);
                $jms_select_data->bindParam(':jms_user_id', $jms_user_id,PDO::PARAM_INT);
                $jms_select_data->execute();
                $jms_row = $jms_select_data->fetchAll(PDO::FETCH_ASSOC);

                $jms_total_save_old_deal = $jms_row[0]['jms_no_save_deal'];
                $jms_total_save_old_buy = $jms_row[0]['jms_no_save_buy'];

                // user data record update

                $jms_updated_pass = "UPDATE `user-registration` SET jms_no_save_deal=:jms_no_save_deal,jms_no_save_buy=:jms_no_save_buy,jms_deal_save_allno=:jms_deal_save_allno,jms_buy_save_allno=:jms_buy_save_allno,updated_on=:updated_on WHERE id=:jms_user_id";

                $jms_updated_pass_update = $jms_pdo->prepare($jms_updated_pass);
                $jms_updated_pass_update->bindParam(':jms_user_id', $jms_user_id, PDO::PARAM_INT);

                // subscription minus 250 - old save deal evalution 

                $jms_nosave_deal = $jms_total_save_old_deal > 250 ? $jms_total_save_old_deal - 250 : 0;
                $jms_updated_pass_update->bindParam(':jms_no_save_deal', $jms_nosave_deal, PDO::PARAM_STR);

                // subscription minus 250 save deal evalution 

                $jms_deal_save_allno = 0;
                $jms_updated_pass_update->bindParam(':jms_deal_save_allno', $jms_deal_save_allno, PDO::PARAM_STR);

                // subscription minus 250 - old save buy and hold analysis

                $jms_nosave_buy = $jms_total_save_old_buy > 250 ? $jms_total_save_old_buy - 250 : 0;
                $jms_updated_pass_update->bindParam(':jms_no_save_buy', $jms_nosave_buy, PDO::PARAM_STR);

                // subscription minus 250 save deal evalution 

                $jms_buy_save_allno = 0;
                $jms_updated_pass_update->bindParam(':jms_buy_save_allno', $jms_buy_save_allno, PDO::PARAM_STR);

                $jms_updated_pass_update->bindParam(':updated_on', $updated_on, PDO::PARAM_STR);
                $jms_updated_pass_update->execute();
            }
        }
    }
?>