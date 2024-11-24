<?php
	include("../connection.php");
	if(!isset($_SESSION['jms_user_id']))
  	{
    	header("location:index.php");
  	}
	header('Content-type: application/json');

	$jms_user_id = $_POST["jms_user_id"];
	$jms_property_address = $_POST['jms_property_address'];
	$jms_purchase_price = $_POST['jms_purchase_price'];
	$jms_loan_to_value_ltv = $_POST['jms_loan_to_value_ltv'];
	$jms_arv_comps = $_POST['jms_arv_comps'];
	$jms_renovation_cost = $_POST['jms_renovation_cost'];
	$jms_monthly_rent_per_unit_studio = $_POST['jms_monthly_rent_per_unit_studio'];
	$jms_monthly_rent_per_unit_1bd = $_POST['jms_monthly_rent_per_unit_1bd'];
	$jms_monthly_rent_per_unit_2bd = $_POST['jms_monthly_rent_per_unit_2bd'];
	$jms_monthly_rent_per_unit_3bd = $_POST['jms_monthly_rent_per_unit_3bd'];
	$jms_of_units = $_POST['jms_of_units'];
	$jms_sq_of_buiding = $_POST['jms_sq_of_buiding'];
	$jms_monthly_rent_per_unit_studio_property_info = $_POST['jms_monthly_rent_per_unit_studio_property_info'];
	$jms_total_units_type_studio_property_info = $_POST['jms_total_units_type_studio_property_info'];
	$jms_monthly_rent_per_unit_1bd_property_info = $_POST['jms_monthly_rent_per_unit_1bd_property_info'];
	$jms_total_units_type_1bd_property_info = $_POST['jms_total_units_type_1bd_property_info'];
	$jms_monthly_rent_per_unit_2bd_property_info = $_POST['jms_monthly_rent_per_unit_2bd_property_info'];
	$jms_total_units_type_2bd_property_info = $_POST['jms_total_units_type_2bd_property_info'];
	$jms_monthly_rent_per_unit_3bd_property_info = $_POST['jms_monthly_rent_per_unit_3bd_property_info'];
	$jms_total_units_type_3bd_property_info = $_POST['jms_total_units_type_3bd_property_info'];
	$jms_additional_income = $_POST['jms_additional_income'];
	$jms_taxes_projected_expenses = $_POST['jms_taxes_projected_expenses'];
	$jms_insurance_projected_expenses = $_POST['jms_insurance_projected_expenses'];
	$jms_water_sewer_projected_expenses = $_POST['jms_water_sewer_projected_expenses'];
	$jms_utilities_projected_expenses = $_POST['jms_utilities_projected_expenses'];
	$jms_garbage_projected_expenses = $_POST['jms_garbage_projected_expenses'];
	$jms_repairs_projected_expenses = $_POST['jms_repairs_projected_expenses'];
	$jms_legal_projected_expenses = $_POST['jms_legal_projected_expenses'];
	$jms_lanscaping_projected_expenses = $_POST['jms_lanscaping_projected_expenses'];
	$jms_pest_control_projected_expenses = $_POST['jms_pest_control_projected_expenses'];
	$jms_office_projected_expenses = $_POST['jms_office_projected_expenses'];
	$jms_other_projected_expenses = $_POST['jms_other_projected_expenses'];
	$jms_mortgage_original_interest = $_POST['jms_mortgage_original_interest'];
	$jms_mortgage_refi_interest = $_POST['jms_mortgage_refi_interest'];
	$jms_financial_cost_loan_fee_financial_cost = $_POST['jms_financial_cost_loan_fee_financial_cost'];
	$jms_financial_cost_appraisal_financial_cost = $_POST['jms_financial_cost_appraisal_financial_cost'];
	$jms_financial_cost_inspection_financial_cost = $_POST['jms_financial_cost_inspection_financial_cost'];
	$jms_credit_card_capital_interest_rate = $_POST['jms_credit_card_capital_interest_rate'];
	$jms_taxes_expenses_purchase = $_POST['jms_taxes_expenses_purchase'];
	$jms_insurance_expenses_purchase = $_POST['jms_insurance_expenses_purchase'];
	$jms_water_sewer_expenses_purchase = $_POST['jms_water_sewer_expenses_purchase'];
	$jms_utilities_expenses_purchase = $_POST['jms_utilities_expenses_purchase'];
	$jms_garbage_expenses_purchase = $_POST['jms_garbage_expenses_purchase'];
	$jms_repairs_expenses_purchase = $_POST['jms_repairs_expenses_purchase'];
	$jms_legal_expenses_purchase = $_POST['jms_legal_expenses_purchase'];
	$jms_lanscaping_expenses_purchase = $_POST['jms_lanscaping_expenses_purchase'];
	$jms_pest_control_expenses_purchase = $_POST['jms_pest_control_expenses_purchase'];
	$jms_office_expenses_purchase = $_POST['jms_office_expenses_purchase'];
	$jms_other_expenses_purchase = $_POST['jms_other_expenses_purchase'];

	$jms_data = array(
		"jms_property_address" => $jms_property_address,
		"jms_purchase_price" => $jms_purchase_price,
		"jms_loan_to_value_ltv" => $jms_loan_to_value_ltv,
		"jms_arv_comps" => $jms_arv_comps,
		"jms_renovation_cost" => $jms_renovation_cost,
		"jms_monthly_rent_per_unit_studio" => $jms_monthly_rent_per_unit_studio,
		"jms_monthly_rent_per_unit_1bd" => $jms_monthly_rent_per_unit_1bd,
		"jms_monthly_rent_per_unit_2bd" => $jms_monthly_rent_per_unit_2bd,
		"jms_monthly_rent_per_unit_3bd" => $jms_monthly_rent_per_unit_3bd,
		"jms_of_units" => $jms_of_units,
		"jms_sq_of_buiding" => $jms_sq_of_buiding,
		"jms_monthly_rent_per_unit_studio_property_info" => $jms_monthly_rent_per_unit_studio_property_info,
		"jms_total_units_type_studio_property_info" => $jms_total_units_type_studio_property_info,
		"jms_monthly_rent_per_unit_1bd_property_info" => $jms_monthly_rent_per_unit_1bd_property_info,
		"jms_total_units_type_1bd_property_info" => $jms_total_units_type_1bd_property_info,
		"jms_monthly_rent_per_unit_2bd_property_info" => $jms_monthly_rent_per_unit_2bd_property_info,
		"jms_total_units_type_2bd_property_info" => $jms_total_units_type_2bd_property_info,
		"jms_monthly_rent_per_unit_3bd_property_info" => $jms_monthly_rent_per_unit_3bd_property_info,
		"jms_total_units_type_3bd_property_info" => $jms_total_units_type_3bd_property_info,
		"jms_additional_income" => $jms_additional_income,
		"jms_taxes_projected_expenses" => $jms_taxes_projected_expenses,
		"jms_insurance_projected_expenses" => $jms_insurance_projected_expenses,
		"jms_water_sewer_projected_expenses" => $jms_water_sewer_projected_expenses,
		"jms_utilities_projected_expenses" => $jms_utilities_projected_expenses,
		"jms_garbage_projected_expenses" => $jms_garbage_projected_expenses,
		"jms_repairs_projected_expenses" => $jms_repairs_projected_expenses,
		"jms_legal_projected_expenses" => $jms_legal_projected_expenses,
		"jms_lanscaping_projected_expenses" => $jms_lanscaping_projected_expenses,
		"jms_pest_control_projected_expenses" => $jms_pest_control_projected_expenses,
		"jms_office_projected_expenses" => $jms_office_projected_expenses,
		"jms_other_projected_expenses" => $jms_other_projected_expenses,
		"jms_mortgage_original_interest" => $jms_mortgage_original_interest,
		"jms_mortgage_refi_interest" => $jms_mortgage_refi_interest,
		"jms_financial_cost_loan_fee_financial_cost" => $jms_financial_cost_loan_fee_financial_cost,
		"jms_financial_cost_appraisal_financial_cost" => $jms_financial_cost_appraisal_financial_cost,
		"jms_financial_cost_inspection_financial_cost" => $jms_financial_cost_inspection_financial_cost,
		"jms_credit_card_capital_interest_rate" => $jms_credit_card_capital_interest_rate,
		"jms_taxes_expenses_purchase" => $jms_taxes_expenses_purchase,
		"jms_insurance_expenses_purchase" => $jms_insurance_expenses_purchase,
		"jms_water_sewer_expenses_purchase" => $jms_water_sewer_expenses_purchase,
		"jms_utilities_expenses_purchase" => $jms_utilities_expenses_purchase,
		"jms_garbage_expenses_purchase" => $jms_garbage_expenses_purchase,
		"jms_repairs_expenses_purchase" => $jms_repairs_expenses_purchase,
		"jms_legal_expenses_purchase" => $jms_legal_expenses_purchase,
		"jms_lanscaping_expenses_purchase" => $jms_lanscaping_expenses_purchase,
		"jms_pest_control_expenses_purchase" => $jms_pest_control_expenses_purchase,
		"jms_office_expenses_purchase" => $jms_office_expenses_purchase,
		"jms_other_expenses_purchase" => $jms_other_expenses_purchase
	);

	if(!empty($jms_property_address))
	{
		$jms_json = json_encode($jms_data);

		$jms_insert_records = "INSERT INTO `buy-and-hold-analysis-calc`(`users_id`,`calc_data_records`) VALUES (:jms_user_id,:jms_json)";
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
			if($jms_row['jms_unlimited_buy'] == "")
			{
			    $jms_updated_pass = "UPDATE `user-registration` SET ";

			    if($jms_row['jms_no_save_buy'] != 0 && $jms_row['jms_no_save_buy'] > 0)
	            {
	            	$jms_updated_pass .= "jms_no_save_buy = :jms_no_save_buy,";
	            }

			    // if card 1 buy exit

			    if($jms_row['jms_buy_save_allno'] != 0 && $jms_row['jms_buy_save_allno'] > 0)
	            {
	            	$jms_updated_pass .= "jms_buy_save_allno = :jms_buy_save_allno,";
	            }

	            $jms_updated_pass .= "updated_on = :updated_on WHERE id = :jms_user_id";

			    $jms_updated_pass_update = $jms_pdo->prepare($jms_updated_pass);
			    $jms_updated_pass_update->bindParam(':jms_user_id', $jms_user_id, PDO::PARAM_INT);
			    
			    if($jms_row['jms_no_save_buy'] != 0 && $jms_row['jms_no_save_buy'] > 0)
			    {
			    	$jms_total_save_old = $jms_row['jms_no_save_buy'];
	            	$jms_nosave_buy = $jms_total_save_old - 1;
	            	$jms_updated_pass_update->bindParam(':jms_no_save_buy', $jms_nosave_buy, PDO::PARAM_STR);
			    }

	            // if card 1 buy exit
	            
	            if($jms_row['jms_buy_save_allno'] != 0 && $jms_row['jms_buy_save_allno'] > 0)
	            {
	            	$jms_total_save_oldf = $jms_row['jms_buy_save_allno'];
		            $jms_nosave_buy = $jms_total_save_oldf - 1;

		            $jms_updated_pass_update->bindParam(':jms_buy_save_allno', $jms_nosave_buy, PDO::PARAM_STR);
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
    				if((isset($jms_row[0]['jms_unlimited_buy']) && $jms_row[0]['jms_unlimited_buy'] != "") || (isset($jms_row[0]['jms_no_save_buy']) && $jms_row[0]['jms_no_save_buy'] != 0))
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
		$response_array['message'] = 'Please Enter Property Address';
		echo json_encode($response_array);	
	}
?>