<?php
	include("../connection.php");
	if(!isset($_SESSION['jms_user_id']))
  	{
    	header("location:index.php");
  	}
	header('Content-type: application/json');


	$jms_user_id = $_SESSION['jms_user_id'];


	$jms_records_id = $_POST["jms_records_id"];
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

	$jms_json = json_encode($jms_data);

	$updated_on = date('Y-m-d H:i:s');

    $jms_updated_pass = "UPDATE `buy-and-hold-analysis-calc` SET calc_data_records=:jms_json, updated_on=:updated_on WHERE id=:jms_records_id AND users_id=:jms_user_id";
    $jms_updated_pass_update = $jms_pdo->prepare($jms_updated_pass);
    $jms_updated_pass_update->bindParam(':jms_user_id', $jms_user_id, PDO::PARAM_INT);
    $jms_updated_pass_update->bindParam(':jms_records_id', $jms_records_id, PDO::PARAM_INT);
    $jms_updated_pass_update->bindParam(':jms_json', $jms_json, PDO::PARAM_STR);
    $jms_updated_pass_update->bindParam(':updated_on', $updated_on, PDO::PARAM_STR);
    $jms_updated_pass_update->execute();

    $jms_row_update = $jms_updated_pass_update->fetchAll(PDO::FETCH_ASSOC);

    if (count($jms_row_update) == 0) 
    {
        $response_array['status'] = 'success';
        $response_array['message'] = 'Updated successfully done.';
        echo json_encode($response_array);
    } 
    else 
    {
        $response_array['status'] = 'error';
        $response_array['message'] = 'Something wrong, data not updated into database';
        echo json_encode($response_array);
    }
?>