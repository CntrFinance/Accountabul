<?php
	include("../connection.php");
	if(!isset($_SESSION['jms_user_id']))
  	{
    	header("location:index.php");
  	}
	header('Content-type: application/json');

	$jms_user_id = $_POST["jms_user_id"];

	$jms_name = $_POST["jms_name"];
	$jms_date = $_POST["jms_date"];

	if(!empty($jms_name) && !empty($jms_date))
	{
		$jms_property_cost = $_POST["jms_property_cost"];
		$jms_down_payment = $_POST["jms_down_payment"];
		$jms_down_payment_percentage = $_POST["jms_down_payment_percentage"];
		$jms_residential_appraisal = $_POST["jms_residential_appraisal"];
		$jms_inspection = $_POST["jms_inspection"];
		$jms_closing_percentage = $_POST["jms_closing_percentage"];
		$jms_annual_interest_rate = $_POST["jms_annual_interest_rate"];
		$jms_number_of_years = $_POST["jms_number_of_years"];
		$jms_card_annual_apr = $_POST["jms_card_annual_apr"];
		$jms_repairs_annually = $_POST["jms_repairs_annually"];
		$jms_utilities = $_POST["jms_utilities"];
		$jms_home_warranty = $_POST["jms_home_warranty"];
		$jms_trash_removal = $_POST["jms_trash_removal"];
		$jms_landscaping = $_POST["jms_landscaping"];
		$jms_property_management = $_POST["jms_property_management"];
		$jms_property_taxes = $_POST["jms_property_taxes"];
		$jms_home_owners_insurance = $_POST["jms_home_owners_insurance"];
		$jms_cap_ex = $_POST["jms_cap_ex"];
		$jms_total_units = $_POST["jms_total_units"];
		$jms_rent_per_unit = $_POST["jms_rent_per_unit"];
		$jms_pets = $_POST["jms_pets"];
		$jms_parking = $_POST["jms_parking"];
		$jms_laundry = $_POST["jms_laundry"];
		$jms_storage = $_POST["jms_storage"];
		$jms_alarm_systems = $_POST["jms_alarm_systems"];
		$jms_new_property_appraisal_price = $_POST["jms_new_property_appraisal_price"];
		$jms_ltv_ratio_percentage = $_POST['jms_ltv_ratio_percentage'];

		$jms_mortgage_annual_interest_rate = $_POST['jms_mortgage_annual_interest_rate'];
		$jms_mortgage_number_of_years = $_POST['jms_mortgage_number_of_years'];
		$jms_closing_cost_per = $_POST['jms_closing_cost_per'];

		$jms_data = array(
			"jms_name" => $jms_name,
			"jms_date" => $jms_date,
		    "jms_property_cost" => $jms_property_cost,
		    "jms_down_payment" => $jms_down_payment,
		    "jms_down_payment_percentage" => $jms_down_payment_percentage,
		    "jms_residential_appraisal" => $jms_residential_appraisal,
		    "jms_inspection" => $jms_inspection,
		    "jms_closing_percentage" => $jms_closing_percentage,
		    "jms_annual_interest_rate" => $jms_annual_interest_rate,
		    "jms_number_of_years" => $jms_number_of_years,
		    "jms_card_annual_apr" => $jms_card_annual_apr,
		    "jms_repairs_annually" => $jms_repairs_annually,
		    "jms_utilities" => $jms_utilities,
		    "jms_home_warranty" => $jms_home_warranty,
		    "jms_trash_removal" => $jms_trash_removal,
		    "jms_landscaping" => $jms_landscaping,
		    "jms_property_management" => $jms_property_management,
		    "jms_property_taxes" => $jms_property_taxes,
		    "jms_home_owners_insurance" => $jms_home_owners_insurance,
		    "jms_cap_ex" => $jms_cap_ex,
		    "jms_total_units" => $jms_total_units,
		    "jms_rent_per_unit" => $jms_rent_per_unit,
		    "jms_pets" => $jms_pets,
		    "jms_parking" => $jms_parking,
		    "jms_laundry" => $jms_laundry,
		    "jms_storage" => $jms_storage,
		    "jms_alarm_systems" => $jms_alarm_systems,
		    "jms_new_property_appraisal_price" => $jms_new_property_appraisal_price,
		    "jms_ltv_ratio_percentage" => $jms_ltv_ratio_percentage,
		    "jms_mortgage_annual_interest_rate" => $jms_mortgage_annual_interest_rate,
		    "jms_mortgage_number_of_years" => $jms_mortgage_number_of_years,
		    "jms_closing_cost_per" => $jms_closing_cost_per
		);

		$jms_json = json_encode($jms_data);

		$jms_insert_records = "INSERT INTO `deal-evaluation-calc`(`users_id`,`calc_data_records`) VALUES (:jms_user_id,:jms_json)";
	    $jms_insert_records_stmt = $jms_pdo->prepare($jms_insert_records);
	    $jms_insert_records_stmt->bindParam(':jms_user_id', $jms_user_id, PDO::PARAM_INT);
	    $jms_insert_records_stmt->bindParam(':jms_json', $jms_json, PDO::PARAM_STR);
	    $jms_insert_records_stmt->execute();
	   
    	// Get user record

		$jms_select_sql = "SELECT * FROM `user-registration` WHERE id = :jms_user_id";
		$jms_select_data = $jms_pdo->prepare($jms_select_sql);
		$jms_select_data->bindParam(':jms_user_id', $jms_user_id, PDO::PARAM_INT);
		$jms_select_data->execute();
		$jms_row = $jms_select_data->fetch(PDO::FETCH_ASSOC);

		if ($jms_row) 
		{
			if($jms_row['jms_unlimited_deal'] == "")
			{
			    $jms_updated_pass = "UPDATE `user-registration` SET ";

			    if($jms_row['jms_no_save_deal'] != 0 && $jms_row['jms_no_save_deal'] > 0)
	            {
	            	$jms_updated_pass .= "jms_no_save_deal = :jms_no_save_deal,";
	            }

			    // if card 1 buy exit

			    if($jms_row['jms_deal_save_allno'] != 0 && $jms_row['jms_deal_save_allno'] > 0)
	            {
	            	$jms_updated_pass .= "jms_deal_save_allno = :jms_deal_save_allno,";
	            }

	            $jms_updated_pass .= "updated_on = :updated_on WHERE id = :jms_user_id";

			    $jms_updated_pass_update = $jms_pdo->prepare($jms_updated_pass);
			    $jms_updated_pass_update->bindParam(':jms_user_id', $jms_user_id, PDO::PARAM_INT);
			    
	            if($jms_row['jms_no_save_deal'] != 0 && $jms_row['jms_no_save_deal'] > 0)
	            {
	            	$jms_total_save_old = $jms_row['jms_no_save_deal'];
		            $jms_nosave_deal = $jms_total_save_old - 1;

		            $jms_updated_pass_update->bindParam(':jms_no_save_deal', $jms_nosave_deal, PDO::PARAM_STR);
	            }

	            // if card 1 buy exit
	            
	            if($jms_row['jms_deal_save_allno'] != 0 && $jms_row['jms_deal_save_allno'] > 0)
	            {
	            	$jms_total_save_oldf = $jms_row['jms_deal_save_allno'];
		            $jms_nosave_dealf = $jms_total_save_oldf - 1;

		            $jms_updated_pass_update->bindParam(':jms_deal_save_allno', $jms_nosave_dealf, PDO::PARAM_STR);
	            }

			    $jms_updated_pass_update->bindParam(':updated_on', $updated_on, PDO::PARAM_STR);
			    $jms_updated_pass_update->execute();

			    // if canceles databse set value code

			    // get data cancel records date

			    $jms_select_cancel_sql = "SELECT * FROM `cancel_subscription` WHERE users_id=:jms_user_id AND (purchase='deal-evalution' || purchase ='access-all-calculator')";
			    $jms_select_cancel_data = $jms_pdo->prepare($jms_select_cancel_sql);
			    $jms_select_cancel_data->bindParam(':jms_user_id', $jms_user_id,PDO::PARAM_INT);
			    $jms_select_cancel_data->execute();
			    $jms_row_cancel = $jms_select_cancel_data->fetchAll(PDO::FETCH_ASSOC);

			    function compareDates($date1, $date2) 
			    {
			        if($date1 != "" && $date2 != "")
			        {
			            $timestamp1 = strtotime($date1);
			            $timestamp2 = strtotime($date2);
			            
			            return $timestamp1 <= $timestamp2;
			        }
			        else
			        {
			            return false;
			        }
			    }

			    // today date

			    $jms_today_date = date('d-m-Y');
			    
			    // cancel subcription date

			    $jms_next_billing_date = isset($jms_row_cancel[0]['nextbilling_date']) ? $jms_row_cancel[0]['nextbilling_date'] : "";

			    $jms_cancel_next_billing_date = compareDates($jms_today_date, $jms_next_billing_date);


			    if($jms_cancel_next_billing_date == false)
    			{
    				if((isset($jms_row[0]['jms_unlimited_deal']) && $jms_row[0]['jms_unlimited_deal'] != "") || (isset($jms_row[0]['jms_no_save_deal']) && $jms_row[0]['jms_no_save_deal'] != 0))
        			{
	            		include('get_data_paypal_stripe_api.php');
					}
				}
			}
		}

	    $response_array['status'] = 'success';
	    $response_array["message"] = "Record added successfully";
	    echo json_encode($response_array);
	}
	else
	{
		$response_array['status'] = 'error';
        $response_array['message'] = 'Enter value name & date';
        echo json_encode($response_array);
	}
?>