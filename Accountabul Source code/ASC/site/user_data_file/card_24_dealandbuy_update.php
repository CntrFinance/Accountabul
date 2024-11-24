<?php

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
	        if ($jms_subscriptionid == 2) 
	        {
	            $jms_updated_pass .= "jms_unlimited_deal = :jms_unlimited_deal, ";
	        } 
	        else if ($jms_subscriptionid == 4) 
	        {
	            $jms_updated_pass .= "jms_unlimited_buy = :jms_unlimited_buy, ";
	        }
	    } 

	    $jms_updated_pass .= "updated_on = :updated_on WHERE id = :jms_user_id";

	    $jms_updated_pass_update = $jms_pdo->prepare($jms_updated_pass);
	    $jms_updated_pass_update->bindParam(':jms_user_id', $jms_user_id, PDO::PARAM_INT);
	    
	    if (isset($jms_subscriptionid)) 
	    {
	        if ($jms_subscriptionid == 2) 
	        {
	            $jms_unlimited_deal = "Unlimited";
	            $jms_updated_pass_update->bindParam(':jms_unlimited_deal', $jms_unlimited_deal, PDO::PARAM_STR);
	        } 
	        else if ($jms_subscriptionid == 4)
	        {
	            $jms_unlimited_buy = "Unlimited";
	            $jms_updated_pass_update->bindParam(':jms_unlimited_buy', $jms_unlimited_buy, PDO::PARAM_STR);
	        }
	    }

	    $jms_updated_pass_update->bindParam(':updated_on', $updated_on, PDO::PARAM_STR);
	    $jms_updated_pass_update->execute();
	}

?>