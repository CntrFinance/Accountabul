<?php
	include("../connection.php");
	if(!isset($_SESSION['jms_user_id']))
  	{
    	header("location:index.php");
  	}
	header('Content-type: application/json');

	$jms_property_cost = $_POST["jms_property_cost"];
	$jms_down_payment = $_POST["jms_down_payment"];
	$jms_down_payment_percentage = $_POST['jms_down_payment_percentage'] / 100;

	$jms_residential_appraisal = $_POST["jms_residential_appraisal"];

	$jms_closing_percentage = $_POST["jms_closing_percentage"] / 100;
	$response_array['jms_closing_percentage'] = $jms_closing_percentage * 100;

	$jms_inspection = $_POST["jms_inspection"];

	$jms_annual_interest_rate = $_POST["jms_annual_interest_rate"];
	$response_array['jms_annual_interest_rate'] = $jms_annual_interest_rate;

	$jms_number_of_years = $_POST["jms_number_of_years"];
	$response_array['jms_number_of_years'] = $jms_number_of_years;

	$jms_card_annual_apr = $_POST["jms_card_annual_apr"] / 100;
	$jms_repairs_annually = $_POST["jms_repairs_annually"];
	$jms_utilities = $_POST["jms_utilities"];
	$jms_home_warranty = $_POST["jms_home_warranty"];
	$jms_trash_removal = $_POST["jms_trash_removal"];
	$jms_landscaping = $_POST["jms_landscaping"];
	$jms_property_management = $_POST["jms_property_management"];
	$jms_property_taxes = $_POST["jms_property_taxes"];
	$jms_home_owners_insurance = $_POST["jms_home_owners_insurance"];
	$jms_cap_ex = $_POST["jms_cap_ex"];
	$jms_raw_expenses_total = $_POST["jms_raw_expenses_total"];
	$jms_total_units = $_POST["jms_total_units"];
	$jms_rent_per_unit = $_POST["jms_rent_per_unit"];
	//$jms_total_rent = $_POST["jms_total_rent"];
	$jms_pets = $_POST["jms_pets"];
	$jms_parking = $_POST["jms_parking"];
	$jms_laundry = $_POST["jms_laundry"];
	$jms_storage = $_POST["jms_storage"];
	$jms_alarm_systems = $_POST["jms_alarm_systems"];
	$jms_new_property_appraisal_price = $_POST["jms_new_property_appraisal_price"];
	$jms_ltv_ratio_percentage = $_POST["jms_ltv_ratio_percentage"] / 100;

	$jms_mortgage_annual_interest_rate = $_POST['jms_mortgage_annual_interest_rate'];
	$jms_mortgage_number_of_years = $_POST['jms_mortgage_number_of_years'];
	$jms_closing_cost_per = $_POST['jms_closing_cost_per'] / 100;

	$jms_total_rent = $jms_total_units * $jms_rent_per_unit;
	$response_array['jms_total_rent'] = $jms_total_rent;

	function jms_monthly_payment_fun($principal, $annualInterestRate, $loanTermYears) 
	{
	    $monthlyInterestRate = $annualInterestRate / 100 / 12;
	    $loanTermMonths = $loanTermYears * 12;
	    $monthlyPayment = ($principal * $monthlyInterestRate) / (1 - pow(1 + $monthlyInterestRate, -$loanTermMonths));
	    return $monthlyPayment;
	}

	function calculateAmounts($principal) 
	{
	    $monthly = $principal / 12;

	    $daily = $principal / 365;

	    return 
	    [
	        'monthly' => $monthly,
	        'daily' => $daily
	    ];
	}

	// All in cost:

	$jms_down_payment_ans = $jms_down_payment * $jms_down_payment_percentage;
	$response_array['jms_down_payment_ans'] = $jms_down_payment_ans;

	// jms_down_payment_percentage
	// jms_closing_percentage


	// $jms_down_payment_ans = $jms_property_cost * ($jms_down_payment_percentage / 100);
	// $response_array['jms_down_payment'] = $jms_down_payment_ans;

	// $jms_down_payment_per = ($jms_down_payment_ans * $jms_property_cost) * 100;
	// $response_array['jms_down_payment_percentage'] = $jms_down_payment_per;


	$jms_loan_amount = $jms_property_cost - $jms_down_payment;
	$response_array['jms_loan_amount'] = $jms_loan_amount;

	$jms_closing_cost = $jms_property_cost * $jms_closing_percentage;
	$response_array['jms_closing_cost'] = $jms_closing_cost;

	$jms_all_in_cost_total = $jms_down_payment + $jms_residential_appraisal + $jms_inspection + $jms_closing_cost;
	$response_array['jms_all_in_cost_total'] = $jms_all_in_cost_total;


	// Mortgage
	
	// $jms_monthly_payment = 0;

	if($jms_annual_interest_rate != 0 && $jms_number_of_years != 0)
	{	
		$jms_monthly_payment = jms_monthly_payment_fun($jms_loan_amount,$jms_annual_interest_rate, $jms_number_of_years);
		$response_array['jms_monthly_payment'] = $jms_monthly_payment;
	}
	else
	{
		$jms_monthly_payment = 0;
		$response_array['jms_monthly_payment'] = $jms_monthly_payment;
	}
	
	$jms_find_monthly_carrying_cost_fee = $jms_all_in_cost_total * $jms_card_annual_apr;
	$response_array['jms_find_monthly_carrying_cost_fee'] = $jms_find_monthly_carrying_cost_fee;


	// Property Expenses

	// Repairs(annually)

	$jms_repairs_annually_ans = calculateAmounts($jms_repairs_annually);

	$jms_repairs_yearly = (Float)$jms_repairs_annually;
	// $response_array['jms_repairs_yearly'] = $jms_repairs_yearly;

	$jms_repairs_monthly = $jms_repairs_annually_ans['monthly'];
	$response_array['jms_repairs_monthly'] = $jms_repairs_monthly;

	$jms_repairs_daily = $jms_repairs_annually_ans['daily'];
	$response_array['jms_repairs_daily'] = $jms_repairs_daily;

	// Utilities

	$jms_utilities_ans = calculateAmounts($jms_utilities);

	$jms_utilities_yearly = (Float)$jms_utilities;
	// $response_array['jms_utilities_yearly'] = $jms_utilities_yearly;

	$jms_utilities_monthly = $jms_utilities_ans['monthly'];
	$response_array['jms_utilities_monthly'] = $jms_utilities_monthly;

	$jms_utilities_daily = $jms_utilities_ans['daily'];
	$response_array['jms_utilities_daily'] = $jms_utilities_daily;


	// Home Warranty

	$jms_home_warranty_ans = calculateAmounts($jms_home_warranty);

	$jms_home_warranty_yearly = (Float)$jms_home_warranty;
	// $response_array['jms_home_warranty_yearly'] = $jms_home_warranty_yearly;

	$jms_home_warranty_monthly = $jms_home_warranty_ans['monthly'];
	$response_array['jms_home_warranty_monthly'] = $jms_home_warranty_monthly;

	$jms_home_warranty_daily = $jms_home_warranty_ans['daily'];
	$response_array['jms_home_warranty_daily'] = $jms_home_warranty_daily;

	// Trash removal

	$jms_trash_removal_ans = calculateAmounts($jms_trash_removal);

	$jms_trash_removal_yearly = (Float)$jms_trash_removal;
	// $response_array['jms_trash_removal_yearly'] = $jms_trash_removal_yearly;

	$jms_trash_removal_monthly = $jms_trash_removal_ans['monthly'];
	$response_array['jms_trash_removal_monthly'] = $jms_trash_removal_monthly;

	$jms_trash_removal_daily = $jms_trash_removal_ans['daily'];
	$response_array['jms_trash_removal_daily'] = $jms_trash_removal_daily;

	// Landscaping

	$jms_landscaping_ans = calculateAmounts($jms_landscaping);

	$jms_landscaping_yearly = (Float)$jms_landscaping;
	// $response_array['jms_landscaping_yearly'] = $jms_landscaping_yearly;

	$jms_landscaping_monthly = $jms_landscaping_ans['monthly'];
	$response_array['jms_landscaping_monthly'] = $jms_landscaping_monthly;

	$jms_landscaping_daily = $jms_landscaping_ans['daily'];
	$response_array['jms_landscaping_daily'] = $jms_landscaping_daily;

	// Property Management(10% of Rents)

	$jms_property_management_ans = calculateAmounts($jms_property_management);

	$jms_property_management_yearly = (Float)$jms_property_management;
	// $response_array['jms_property_management_yearly'] = $jms_property_management_yearly;

	$jms_property_management_monthly = $jms_property_management_ans['monthly'];
	$response_array['jms_property_management_monthly'] = $jms_property_management_monthly;

	$jms_property_management_daily = $jms_property_management_ans['daily'];
	$response_array['jms_property_management_daily'] = $jms_property_management_daily;


	// Property Taxes

	$jms_property_taxes_ans = calculateAmounts($jms_property_taxes);

	$jms_property_taxes_yearly = (Float)$jms_property_taxes;
	// $response_array['jms_property_taxes_yearly'] = $jms_property_taxes_yearly;

	$jms_property_taxes_monthly = $jms_property_taxes_ans['monthly'];
	$response_array['jms_property_taxes_monthly'] = $jms_property_taxes_monthly;

	$jms_property_taxes_daily = $jms_property_taxes_ans['daily'];
	$response_array['jms_property_taxes_daily'] = $jms_property_taxes_daily;

	// Home Owners Insurance

	$jms_home_owners_insurance_ans = calculateAmounts($jms_home_owners_insurance);

	$jms_home_owners_insurance_yearly = (Float)$jms_home_owners_insurance;
	// $response_array['jms_home_owners_insurance_yearly'] = $jms_home_owners_insurance_yearly;

	$jms_home_owners_insurance_monthly = $jms_home_owners_insurance_ans['monthly'];
	$response_array['jms_home_owners_insurance_monthly'] = $jms_home_owners_insurance_monthly;

	$jms_home_owners_insurance_daily = $jms_home_owners_insurance_ans['daily'];
	$response_array['jms_home_owners_insurance_daily'] = $jms_home_owners_insurance_daily;

	// Cap Ex

	$jms_cap_ex_ans = calculateAmounts($jms_cap_ex);

	$jms_cap_ex_yearly = (Float)$jms_cap_ex;
	// $response_array['jms_cap_ex_yearly'] = $jms_cap_ex_yearly;

	$jms_cap_ex_monthly = $jms_cap_ex_ans['monthly'];
	$response_array['jms_cap_ex_monthly'] = $jms_cap_ex_monthly;

	$jms_cap_ex_daily = $jms_cap_ex_ans['daily'];
	$response_array['jms_cap_ex_daily'] = $jms_cap_ex_daily;

	// Raw Expenses Total

	$jms_raw_expenses_total_sum = $jms_repairs_yearly + $jms_utilities_yearly + $jms_home_warranty_yearly + $jms_trash_removal_yearly + $jms_landscaping_yearly + $jms_property_management_yearly + $jms_property_taxes_yearly + $jms_home_owners_insurance_yearly + $jms_cap_ex_yearly;

	$jms_raw_expenses_total_ans = calculateAmounts($jms_raw_expenses_total_sum);

	$jms_raw_expenses_total = (Float)$jms_raw_expenses_total_sum;
	$response_array['jms_raw_expenses_total'] = $jms_raw_expenses_total;

	$jms_raw_expenses_total_yearly = (Float)$jms_raw_expenses_total_sum;
	// $response_array['jms_raw_expenses_total_yearly'] = $jms_raw_expenses_total_yearly;

	$jms_raw_expenses_total_monthly = $jms_raw_expenses_total_ans['monthly'];
	$response_array['jms_raw_expenses_total_monthly'] = $jms_raw_expenses_total_monthly;

	$jms_raw_expenses_total_daily = $jms_raw_expenses_total_ans['daily'];
	$response_array['jms_raw_expenses_total_daily'] = $jms_raw_expenses_total_daily;

	
	// Combined Carrying Cost and Mortgage Expenses

	$jms_crc_mtg_expenses = $jms_monthly_payment + $jms_find_monthly_carrying_cost_fee;
	$response_array['jms_crc_mtg_expenses'] = $jms_crc_mtg_expenses;

	$jms_yearly_crc = $jms_crc_mtg_expenses * 12;
	$response_array['jms_yearly_crc'] = $jms_yearly_crc;

	$jms_monthly_crc = $jms_crc_mtg_expenses;
	$response_array['jms_monthly_crc'] = $jms_monthly_crc;

	$jms_daily_crc = $jms_crc_mtg_expenses / 365;
	$response_array['jms_daily_crc'] = $jms_daily_crc;

	// Gross Operating Expenses

	$jms_raw_expenses_crc_mtg_total = $jms_raw_expenses_total_yearly + $jms_yearly_crc;
	$response_array['jms_raw_expenses_crc_mtg_total'] = $jms_raw_expenses_crc_mtg_total;

	$jms_monthly_crc_mtg = $jms_raw_expenses_total_monthly + $jms_monthly_crc;
	$response_array['jms_monthly_crc_mtg'] = $jms_monthly_crc_mtg;

	$jms_daily_crc_mtg = $jms_raw_expenses_total_daily + $jms_daily_crc;
	$response_array['jms_daily_crc_mtg'] = $jms_daily_crc_mtg;

	
	// Other sources of income

	// Pets

	$jms_pets_ans = calculateAmounts($jms_pets);

	$jms_pets_yearly = (Float)$jms_pets;
	$response_array['jms_pets_yearly'] = $jms_pets_yearly;

	$jms_pets_monthly = $jms_pets_ans['monthly'];
	$response_array['jms_pets_monthly'] = $jms_pets_monthly;

	// Parking

	$jms_parking_ans = calculateAmounts($jms_parking);

	$jms_parking_yearly = (Float)$jms_parking;
	$response_array['jms_parking_yearly'] = $jms_parking_yearly;

	$jms_parking_monthly = $jms_parking_ans['monthly'];
	$response_array['jms_parking_monthly'] = $jms_parking_monthly;

	// Laundry

	$jms_laundry_ans = calculateAmounts($jms_laundry);

	$jms_laundry_yearly = (Float)$jms_laundry;
	$response_array['jms_laundry_yearly'] = $jms_laundry_yearly;

	$jms_laundry_monthly = $jms_laundry_ans['monthly'];
	$response_array['jms_laundry_monthly'] = $jms_laundry_monthly;

	// Storage

	$jms_storage_ans = calculateAmounts($jms_storage);

	$jms_storage_yearly = (Float)$jms_storage;
	$response_array['jms_storage_yearly'] = $jms_storage_yearly;

	$jms_storage_monthly = $jms_storage_ans['monthly'];
	$response_array['jms_storage_monthly'] = $jms_storage_monthly;

	// Alarm Systems

	$jms_alarm_systems_ans = calculateAmounts($jms_alarm_systems);

	$jms_alarm_systems_yearly = (Float)$jms_alarm_systems;
	$response_array['jms_alarm_systems_yearly'] = $jms_alarm_systems_yearly;

	$jms_alarm_systems_monthly = $jms_alarm_systems_ans['monthly'];
	$response_array['jms_alarm_systems_monthly'] = $jms_alarm_systems_monthly;



	$jms_total_property_income = ($jms_total_rent + $jms_pets + $jms_parking + $jms_laundry + $jms_storage + $jms_alarm_systems) * 12;
	$response_array['jms_total_property_income'] = $jms_total_property_income;

	$jms_total_property_income_ans = calculateAmounts($jms_total_property_income);

	$jms_total_property_income_yearly = (Float)$jms_total_property_income ;
	$response_array['jms_total_property_income_yearly'] = $jms_total_property_income_yearly;

	$jms_total_property_income_monthly = $jms_total_property_income_ans['monthly'];
	$response_array['jms_total_property_income_monthly'] = $jms_total_property_income_monthly;

	$jms_total_property_daily = $jms_total_property_income_ans['daily'];
	$response_array['jms_total_property_daily'] = $jms_total_property_daily;

	// Operating Net Income

	$jms_total_property_find_noi = $jms_total_property_income - $jms_raw_expenses_crc_mtg_total;
	$response_array['jms_total_property_find_noi'] = $jms_total_property_find_noi;

	$jms_total_property = calculateAmounts($jms_total_property_find_noi);

	$jms_total_property_find_noi_monthly = $jms_total_property['monthly'];
	$response_array['jms_total_property_find_noi_monthly'] = $jms_total_property_find_noi_monthly;

	$jms_total_property_find_noi_daily = $jms_total_property['daily'];
	$response_array['jms_total_property_find_noi_daily'] = $jms_total_property_find_noi_daily;

	$jms_noi_12 = $jms_total_property_find_noi * 12;
	$response_array['jms_noi_12'] = $jms_noi_12;


	$jms_yearly_cash_flow_all_in_cost = 0;
	if($jms_noi_12 != 0 && $jms_all_in_cost_total != 0)
	{
		$jms_yearly_cash_flow_all_in_cost = $jms_noi_12 / $jms_all_in_cost_total;
		$response_array['jms_yearly_cash_flow_all_in_cost'] = $jms_yearly_cash_flow_all_in_cost;
	}
	else
	{
		$jms_yearly_cash_flow_all_in_cost = 0;
		$response_array['jms_yearly_cash_flow_all_in_cost'] = $jms_yearly_cash_flow_all_in_cost;
	}
	

	$jms_answer_from_above_multiply_100 = $jms_yearly_cash_flow_all_in_cost * 100;
	// $response_array['jms_answer_from_above_multiply_100'] = $jms_answer_from_above_multiply_100;
	
	if($jms_all_in_cost_total != 0)
	{
		$jms_roi_per = ($jms_total_property_find_noi / $jms_all_in_cost_total) * 100;
		$response_array['jms_roi_per'] = $jms_roi_per;
	}
	else
	{
		$jms_roi_per = 0;
		$response_array['jms_roi_per'] = $jms_roi_per;
	}

	$jms_mortgage_loan_amount = $jms_new_property_appraisal_price * $jms_ltv_ratio_percentage;
	$response_array['jms_mortgage_loan_amount'] = $jms_mortgage_loan_amount;

	if($jms_mortgage_loan_amount != 0 && $jms_mortgage_annual_interest_rate != 0 && $jms_mortgage_number_of_years != 0)
	{
		$jms_mortgage_monthly_payment = jms_monthly_payment_fun($jms_mortgage_loan_amount,$jms_mortgage_annual_interest_rate, $jms_mortgage_number_of_years);
		$response_array['jms_mortgage_monthly_payment'] = $jms_mortgage_monthly_payment;

		$jms_mortgage_yearly_payment = $jms_mortgage_monthly_payment * 12;
		$response_array['jms_mortgage_yearly_payment'] = $jms_mortgage_yearly_payment;

		$jms_mortgage_daily_payment = $jms_mortgage_yearly_payment / 365;
		$response_array['jms_mortgage_daily_payment'] = $jms_mortgage_daily_payment;
	}
	else
	{
		$jms_mortgage_monthly_payment = 0;
		$response_array['jms_mortgage_monthly_payment'] = $jms_mortgage_monthly_payment;

		$jms_mortgage_yearly_payment = 0;
		$response_array['jms_mortgage_yearly_payment'] = $jms_mortgage_yearly_payment;

		$jms_mortgage_daily_payment = 0;
		$response_array['jms_mortgage_daily_payment'] = $jms_mortgage_daily_payment;
	}
	
	$jms_mortgage_closing_cost_5per = $jms_mortgage_loan_amount * $jms_closing_cost_per;
	$response_array['jms_mortgage_closing_cost_5per'] = $jms_mortgage_closing_cost_5per;

	$jms_original_mortgage_note = $jms_loan_amount;
	$response_array['jms_original_mortgage_note'] = $jms_original_mortgage_note;
	
	$jms_mortgage_carrying_cost = $jms_all_in_cost_total;
	$response_array['jms_mortgage_carrying_cost'] = $jms_mortgage_carrying_cost;

	$jms_mortgage_remaining_cash_balance = $jms_mortgage_loan_amount - $jms_original_mortgage_note - $jms_mortgage_carrying_cost - $jms_mortgage_closing_cost_5per;

	$response_array['jms_mortgage_remaining_cash_balance'] = $jms_mortgage_remaining_cash_balance;
	
	// Projected NOI After Refinance

	$jms_noi_monthly = $jms_mortgage_monthly_payment + $jms_raw_expenses_total_monthly;
	$response_array['jms_noi_monthly'] = $jms_noi_monthly;

	$jms_noi_yearly =  $jms_noi_monthly * 12;
	$response_array['jms_noi_yearly'] = $jms_noi_yearly;

	$jms_noi_daily = $jms_noi_monthly / 365;
	$response_array['jms_noi_daily'] = $jms_noi_daily;

	// R.O.I After Refinance
	
	$jms_12_by_noi = $jms_noi_monthly;
	$response_array['jms_12_by_noi'] = $jms_12_by_noi;

	if($jms_12_by_noi != 0 && $jms_all_in_cost_total != 0)
	{
		$jms_yearly_cash_flow_all_in_cost = $jms_12_by_noi / $jms_all_in_cost_total;
	}

	$jms_roi_per_2 = $jms_yearly_cash_flow_all_in_cost * 100;
	$response_array['jms_roi_per_2'] = $jms_roi_per_2;


	$response_array['status'] = 'success';
	echo json_encode($response_array);
?>