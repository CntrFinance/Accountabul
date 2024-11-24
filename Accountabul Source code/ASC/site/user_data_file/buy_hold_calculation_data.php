<?php
	include("../connection.php");
	if(!isset($_SESSION['jms_user_id']))
  	{
    	header("location:index.php");
  	}
	header('Content-type: application/json');

	$jms_purchase_price = $_POST['jms_purchase_price'];
	$jms_loan_to_value_ltv = $_POST['jms_loan_to_value_ltv'] / 100;
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

	$jms_mortgage_original_interest = $_POST['jms_mortgage_original_interest'] / 100;
	$jms_mortgage_refi_interest = $_POST['jms_mortgage_refi_interest'] / 100;

	$jms_financial_cost_loan_fee_financial_cost = $_POST['jms_financial_cost_loan_fee_financial_cost'];
	$jms_financial_cost_appraisal_financial_cost = $_POST['jms_financial_cost_appraisal_financial_cost'];
	$jms_financial_cost_inspection_financial_cost = $_POST['jms_financial_cost_inspection_financial_cost'];

	$jms_credit_card_capital_interest_rate = $_POST['jms_credit_card_capital_interest_rate'];



	function jms_function_monthly($jms_a)
	{
		return $jms_a / 12;
	}

	/* Property Address and type of building */

	$jms_loan_amount = $jms_purchase_price * $jms_loan_to_value_ltv; 
	$response_array['jms_loan_amount'] = $jms_loan_amount;

	$jms_down_payment = $jms_purchase_price - $jms_loan_amount; 
	$response_array['jms_down_payment'] = $jms_down_payment;

	/* Profit ( If I sold the property) */

	$jms_less_purchase_price = (Float)$jms_purchase_price;
	$response_array['jms_less_purchase_price'] = $jms_less_purchase_price;

	$jms_transaction_cost_of_sale = $jms_arv_comps * 0.08;
	$response_array['jms_transaction_cost_of_sale'] = $jms_transaction_cost_of_sale;

	$jms_profit = $jms_arv_comps - $jms_renovation_cost - $jms_less_purchase_price - $jms_transaction_cost_of_sale;
	$response_array['jms_profit'] = $jms_profit;


	/* Cash out Refinance */

	$jms_refinance_amount_75_per_ltv = $jms_arv_comps * 0.75;
	$response_array['jms_refinance_amount_75_per_ltv'] = $jms_refinance_amount_75_per_ltv;

	$jms_closing_cost_cash_out_refinance = $jms_refinance_amount_75_per_ltv  * 0.03;
	$response_array['jms_closing_cost_cash_out_refinance'] = $jms_closing_cost_cash_out_refinance;

	$jms_cashout_cash_out_refinance = $jms_refinance_amount_75_per_ltv - $jms_loan_amount - $jms_renovation_cost;
	$response_array['jms_cashout_cash_out_refinance'] = $jms_cashout_cash_out_refinance;

	$jms_finance_fee_cash_out_refinance = $jms_refinance_amount_75_per_ltv * 0.02;
	$response_array['jms_finance_fee_cash_out_refinance'] = $jms_finance_fee_cash_out_refinance;

	$jms_profit_cash_out_refinance = $jms_cashout_cash_out_refinance - $jms_finance_fee_cash_out_refinance - $jms_closing_cost_cash_out_refinance;
	$response_array['jms_profit_cash_out_refinance'] = $jms_profit_cash_out_refinance;


	/* Annual Property Operationing Data */

	// Potential Gross Income

	$jms_potential_gross_income_annual_property = (($jms_monthly_rent_per_unit_studio_property_info * $jms_total_units_type_studio_property_info) + ($jms_monthly_rent_per_unit_1bd_property_info * $jms_total_units_type_1bd_property_info) + ($jms_monthly_rent_per_unit_2bd_property_info * $jms_total_units_type_2bd_property_info) + ($jms_monthly_rent_per_unit_3bd_property_info * $jms_total_units_type_3bd_property_info)) * 12;
	$response_array['jms_potential_gross_income_annual_property'] = $jms_potential_gross_income_annual_property;

	// Vacancy Rate (10%)

	$jms_vacancy_rate_10_annual_property = $jms_potential_gross_income_annual_property * 0.1;
	$response_array['jms_vacancy_rate_10_annual_property'] = $jms_vacancy_rate_10_annual_property;

	// Gross Operating Income

	$jms_gross_operating_income_annual_property = ($jms_potential_gross_income_annual_property + $jms_additional_income) - $jms_vacancy_rate_10_annual_property;
	$response_array['jms_gross_operating_income_annual_property'] = $jms_gross_operating_income_annual_property;

	$jms_management_fee_cost_annually = $jms_gross_operating_income_annual_property * 0.1;
	$response_array['jms_management_fee_cost_annually'] = $jms_management_fee_cost_annually;

	/* Annual Property Operationing Data 2 */

	// Potential Gross Income

	$jms_potential_gross_income_annual_property_2 = (($jms_monthly_rent_per_unit_studio * $jms_total_units_type_studio_property_info) + ($jms_monthly_rent_per_unit_1bd * $jms_total_units_type_1bd_property_info) + ($jms_monthly_rent_per_unit_2bd * $jms_total_units_type_2bd_property_info) + ($jms_monthly_rent_per_unit_3bd * $jms_total_units_type_3bd_property_info)) * 12;
	$response_array['jms_potential_gross_income_annual_property_2'] = $jms_potential_gross_income_annual_property_2;

	// Vacancy Rate (10%)

	$jms_vacancy_rate_10_annual_property_2 = $jms_potential_gross_income_annual_property_2 * 0.1;
	$response_array['jms_vacancy_rate_10_annual_property_2'] = $jms_vacancy_rate_10_annual_property_2;


	// Gross Operating Income

	$jms_gross_operating_income_annual_property_2 = $jms_potential_gross_income_annual_property_2 - $jms_vacancy_rate_10_annual_property_2;
	$response_array['jms_gross_operating_income_annual_property_2'] = $jms_gross_operating_income_annual_property_2;

	$jms_management_fee_cost_annually_2 = $jms_gross_operating_income_annual_property_2 * 0.1;
	$response_array['jms_management_fee_cost_annually_2'] = $jms_management_fee_cost_annually_2;

	/* PROJECTED EXPENSES */

	$jms_taxes_projected_expenses_monthly = jms_function_monthly($jms_taxes_projected_expenses);
    $response_array['jms_taxes_projected_expenses_monthly'] = $jms_taxes_projected_expenses_monthly;

	$jms_insurance_projected_expenses_monthly = jms_function_monthly($jms_insurance_projected_expenses);
	$response_array['jms_insurance_projected_expenses_monthly'] = $jms_insurance_projected_expenses_monthly;

	$jms_water_sewer_projected_expenses_monthly = jms_function_monthly($jms_water_sewer_projected_expenses);
	$response_array['jms_water_sewer_projected_expenses_monthly'] = $jms_water_sewer_projected_expenses_monthly;

	$jms_utilities_projected_expenses_monthly = jms_function_monthly($jms_utilities_projected_expenses);
	$response_array['jms_utilities_projected_expenses_monthly'] = $jms_utilities_projected_expenses_monthly;

	$jms_garbage_projected_expenses_monthly = jms_function_monthly($jms_garbage_projected_expenses);
	$response_array['jms_garbage_projected_expenses_monthly'] = $jms_garbage_projected_expenses_monthly;

	$jms_management_fee_expenses_purchase_monthly_projected_expenses = jms_function_monthly($jms_management_fee_cost_annually_2);
	$response_array['jms_management_fee_expenses_purchase_monthly_projected_expenses'] = $jms_management_fee_expenses_purchase_monthly_projected_expenses;

	$jms_repairs_projected_expenses_monthly = jms_function_monthly($jms_repairs_projected_expenses);
	$response_array['jms_repairs_projected_expenses_monthly'] = $jms_repairs_projected_expenses_monthly;

	$jms_legal_projected_expenses_monthly = jms_function_monthly($jms_legal_projected_expenses);
	$response_array['jms_legal_projected_expenses_monthly'] = $jms_legal_projected_expenses_monthly;

	$jms_lanscaping_projected_expenses_monthly = jms_function_monthly($jms_lanscaping_projected_expenses);
	$response_array['jms_lanscaping_projected_expenses_monthly'] = $jms_lanscaping_projected_expenses_monthly;

	$jms_pest_control_projected_expenses_monthly = jms_function_monthly($jms_pest_control_projected_expenses);
	$response_array['jms_pest_control_projected_expenses_monthly'] = $jms_pest_control_projected_expenses_monthly;

	$jms_office_projected_expenses_monthly = jms_function_monthly($jms_office_projected_expenses);
	$response_array['jms_office_projected_expenses_monthly'] = $jms_office_projected_expenses_monthly;

	$jms_other_projected_expenses_monthly = jms_function_monthly($jms_other_projected_expenses);
	$response_array['jms_other_projected_expenses_monthly'] = $jms_other_projected_expenses_monthly;


	$jms_total_projected_expenses_monthly= $jms_taxes_projected_expenses_monthly + $jms_insurance_projected_expenses_monthly + $jms_water_sewer_projected_expenses_monthly + $jms_utilities_projected_expenses_monthly + $jms_garbage_projected_expenses_monthly + $jms_management_fee_expenses_purchase_monthly_projected_expenses + $jms_repairs_projected_expenses_monthly + $jms_legal_projected_expenses_monthly + $jms_lanscaping_projected_expenses_monthly + $jms_pest_control_projected_expenses_monthly + $jms_office_projected_expenses_monthly + $jms_other_projected_expenses_monthly;
	$response_array['jms_total_projected_expenses_monthly'] = $jms_total_projected_expenses_monthly;

	$jms_total_projected_expenses_cost_annually = $jms_taxes_projected_expenses + $jms_insurance_projected_expenses + $jms_water_sewer_projected_expenses + $jms_utilities_projected_expenses + $jms_garbage_projected_expenses + $jms_management_fee_cost_annually_2 + $jms_repairs_projected_expenses + $jms_legal_projected_expenses + $jms_lanscaping_projected_expenses + $jms_pest_control_projected_expenses + $jms_office_projected_expenses + $jms_other_projected_expenses;
	$response_array['jms_total_projected_expenses_cost_annually'] = $jms_total_projected_expenses_cost_annually;



	/* Annual Operatig Expenses */

	$jms_operating_expenses = $jms_total_projected_expenses_cost_annually;
	$response_array['jms_operating_expenses'] = $jms_operating_expenses;

	$jms_noi = $jms_gross_operating_income_annual_property_2 - $jms_operating_expenses;
	$response_array['jms_noi'] = $jms_noi;

	


	/* Mortgage */


	$jms_original_loan_mortgage = $jms_loan_amount;
	$response_array['jms_original_loan_mortgage'] = $jms_original_loan_mortgage;

	$jms_refi_loan_amount_mortgage = $jms_refinance_amount_75_per_ltv;
	$response_array['jms_refi_loan_amount_mortgage'] = $jms_refi_loan_amount_mortgage;


	/* 
		No name table

		Annual Debt Service (30 year term)	
		Annual Cash Flow	
		Monthly NOI (10% Vacancy Rate)	
		Monthly NOI (Fully Occupied)
	*/

	$N10 = $jms_mortgage_refi_interest; 
	$N9 = $jms_refi_loan_amount_mortgage; 

	$monthlyRate = $N10 / 12;

	$totalPayments = 360;

	function calculatePMT($rate, $nper, $pv) 
	{
	    if ($rate == 0) 
	    {
	        return -$pv / $nper;
	    } else {
	        return -($pv * $rate) / (1 - pow(1 + $rate, -$nper));
	    }
	}

	// Calculate the monthly payment
	try {
	    $monthlyPayment = calculatePMT($monthlyRate, $totalPayments, -$N9);
	    if ($monthlyPayment === false) {
	        throw new Exception('Calculation error');
	    }
	} catch (Exception $e) {
	    $monthlyPayment = 0;
	}

	// Annual payment
	$annualPayment = $monthlyPayment * 12;

	$jms_annual_debt_service = $annualPayment;
	$response_array['jms_annual_debt_service'] = $jms_annual_debt_service;

	$jms_annual_cash_flow = $jms_noi - $jms_annual_debt_service;
	$response_array['jms_annual_cash_flow'] = $jms_annual_cash_flow;

	$jms_monthly_noi_vacancy_rate = $jms_annual_cash_flow / 12;
	$response_array['jms_monthly_noi_vacancy_rate'] = $jms_monthly_noi_vacancy_rate;

	$jms_monthly_noi_fully_occupied = ($jms_vacancy_rate_10_annual_property_2 / 12) + $jms_monthly_noi_vacancy_rate;
	$response_array['jms_monthly_noi_fully_occupied'] = $jms_monthly_noi_fully_occupied;

	/* EXPENSES AT PURCHASE */

	$jms_taxes_expenses_purchase_monthly = jms_function_monthly($jms_taxes_expenses_purchase);
    $response_array['jms_taxes_expenses_purchase_monthly'] = $jms_taxes_expenses_purchase_monthly;

	$jms_insurance_expenses_purchase_monthly = jms_function_monthly($jms_insurance_expenses_purchase);
	$response_array['jms_insurance_expenses_purchase_monthly'] = $jms_insurance_expenses_purchase_monthly;

	$jms_water_sewer_expenses_purchase_monthly = jms_function_monthly($jms_water_sewer_expenses_purchase);
	$response_array['jms_water_sewer_expenses_purchase_monthly'] = $jms_water_sewer_expenses_purchase_monthly;

	$jms_utilities_expenses_purchase_monthly = jms_function_monthly($jms_utilities_expenses_purchase);
	$response_array['jms_utilities_expenses_purchase_monthly'] = $jms_utilities_expenses_purchase_monthly;

	$jms_garbage_expenses_purchase_monthly = jms_function_monthly($jms_garbage_expenses_purchase);
	$response_array['jms_garbage_expenses_purchase_monthly'] = $jms_garbage_expenses_purchase_monthly;

	$jms_management_fee_expenses_purchase_monthly = jms_function_monthly($jms_management_fee_cost_annually);
	$response_array['jms_management_fee_expenses_purchase_monthly'] = $jms_management_fee_expenses_purchase_monthly;

	$jms_repairs_expenses_purchase_monthly = jms_function_monthly($jms_repairs_expenses_purchase);
	$response_array['jms_repairs_expenses_purchase_monthly'] = $jms_repairs_expenses_purchase_monthly;

	$jms_legal_expenses_purchase_monthly = jms_function_monthly($jms_legal_expenses_purchase);
	$response_array['jms_legal_expenses_purchase_monthly'] = $jms_legal_expenses_purchase_monthly;

	$jms_lanscaping_expenses_purchase_monthly = jms_function_monthly($jms_lanscaping_expenses_purchase);
	$response_array['jms_lanscaping_expenses_purchase_monthly'] = $jms_lanscaping_expenses_purchase_monthly;

	$jms_pest_control_expenses_purchase_monthly = jms_function_monthly($jms_pest_control_expenses_purchase);
	$response_array['jms_pest_control_expenses_purchase_monthly'] = $jms_pest_control_expenses_purchase_monthly;

	$jms_office_expenses_purchase_monthly = jms_function_monthly($jms_office_expenses_purchase);
	$response_array['jms_office_expenses_purchase_monthly'] = $jms_office_expenses_purchase_monthly;

	$jms_other_expenses_purchase_monthly = jms_function_monthly($jms_other_expenses_purchase);
	$response_array['jms_other_expenses_purchase_monthly'] = $jms_other_expenses_purchase_monthly;

	$jms_total_expenses_purchase_monthly = $jms_taxes_expenses_purchase_monthly + $jms_insurance_expenses_purchase_monthly + $jms_water_sewer_expenses_purchase_monthly + $jms_utilities_expenses_purchase_monthly + $jms_garbage_expenses_purchase_monthly + $jms_management_fee_expenses_purchase_monthly + $jms_repairs_expenses_purchase_monthly + $jms_legal_expenses_purchase_monthly + $jms_lanscaping_expenses_purchase_monthly + $jms_pest_control_expenses_purchase_monthly + $jms_office_expenses_purchase_monthly + $jms_other_expenses_purchase_monthly;
	$response_array['jms_total_expenses_purchase_monthly'] = $jms_total_expenses_purchase_monthly;

	$jms_total_expenses_purchase_cost_annually = $jms_taxes_expenses_purchase + $jms_insurance_expenses_purchase + $jms_water_sewer_expenses_purchase + $jms_utilities_expenses_purchase + $jms_garbage_expenses_purchase + $jms_management_fee_cost_annually + $jms_repairs_expenses_purchase + $jms_legal_expenses_purchase + $jms_lanscaping_expenses_purchase + $jms_pest_control_expenses_purchase + $jms_office_expenses_purchase + $jms_other_expenses_purchase;
	$response_array['jms_total_expenses_purchase_cost_annually'] = $jms_total_expenses_purchase_cost_annually;

	/* Annual Operatig Expenses */

	$jms_operating_expenses_2 = $jms_total_expenses_purchase_cost_annually;
	$response_array['jms_operating_expenses_2'] = $jms_operating_expenses_2;

	$jms_noi_2 = $jms_gross_operating_income_annual_property - $jms_total_expenses_purchase_cost_annually;
	$response_array['jms_noi_2'] = $jms_noi_2;

	/* Financial Cost */

	// Down Payment

	$jms_down_payment_financial_cost = $jms_down_payment;
	$response_array['jms_down_payment_financial_cost'] = $jms_down_payment_financial_cost;

	// Closing Cost

	$jms_closing_cost_financial_cost = $jms_original_loan_mortgage*0.04;
	$response_array['jms_closing_cost_financial_cost'] = $jms_closing_cost_financial_cost;

	// Cash to Close

	$jms_cash_to_close_financial_cost = $jms_down_payment_financial_cost + $jms_financial_cost_loan_fee_financial_cost + $jms_closing_cost_financial_cost + $jms_financial_cost_appraisal_financial_cost + $jms_financial_cost_inspection_financial_cost;
	$response_array['jms_cash_to_close_financial_cost'] = $jms_cash_to_close_financial_cost;

	/* Credit Card for Capital */

	// Amount Borrowed

	$jms_amount_borrowed_credit_card_for_capital = $jms_cash_to_close_financial_cost;
	$response_array['jms_amount_borrowed_credit_card_for_capital'] = $jms_amount_borrowed_credit_card_for_capital;

	// Interest Rate(APR)

	// Minimum Payment (%)

	$jms_minimum_payment_credit_card_for_capital = 0.02;

	// Min Monthly Payment

	if (!empty($jms_amount_borrowed_credit_card_for_capital) && !empty($jms_credit_card_capital_interest_rate) && !empty($jms_minimum_payment_credit_card_for_capital)) 
	{
	    $jms_min_monthly_payment_credit_card_for_capital = $jms_minimum_payment_credit_card_for_capital * $jms_amount_borrowed_credit_card_for_capital ? $jms_minimum_payment_credit_card_for_capital * $jms_amount_borrowed_credit_card_for_capital : 0;
	    $response_array['jms_min_monthly_payment_credit_card_for_capital'] = $jms_min_monthly_payment_credit_card_for_capital;
	} 
	else 
	{
		$jms_min_monthly_payment_credit_card_for_capital = 0;
	    $response_array['jms_min_monthly_payment_credit_card_for_capital'] = $jms_min_monthly_payment_credit_card_for_capital;
	}


	/* 
		No name table

		Annual Debt Service (30 year term)	
		Credit Card Min Annual Payment	
		Annual Cash Flow	
		Monthly NOI (10% Vacancy Rate)	
		Monthly NOI (Fully Occupied)
	*/

	$N7 = $jms_mortgage_original_interest; 
	$N6 = $jms_original_loan_mortgage;

	$monthlyRate1 = $N7 / 12;

	$totalPayments1 = 360;

	// Calculate the monthly payment
	try 
	{
	    $monthlyPayment1 = calculatePMT($monthlyRate1, $totalPayments1, -$N6);
	    if ($monthlyPayment1 === false) 
	    {
	        throw new Exception('Calculation error');
	    }
	} 
	catch (Exception $e) 
	{
	    $monthlyPayment1 = 0;
	}

	// Annual payment
	$annualPayment1 = $monthlyPayment1 * 12;

	$jms_annual_debt_service_2 = $annualPayment1;
	$response_array['jms_annual_debt_service_2'] = $jms_annual_debt_service_2;

	$jms_credit_card_min_annual_payment_2 = $jms_min_monthly_payment_credit_card_for_capital * 12;
	$response_array['jms_credit_card_min_annual_payment_2'] = $jms_credit_card_min_annual_payment_2;

	$jms_annual_cash_flow_2 = $jms_noi_2 - $jms_annual_debt_service_2 - $jms_credit_card_min_annual_payment_2;
	$response_array['jms_annual_cash_flow_2'] = $jms_annual_cash_flow_2;

	$jms_monthly_noi_vacancy_rate_2 = $jms_annual_cash_flow_2 / 12;
	$response_array['jms_monthly_noi_vacancy_rate_2'] = $jms_monthly_noi_vacancy_rate_2;

	$jms_monthly_noi_fully_occupied_2 = $jms_monthly_noi_vacancy_rate_2 + ($jms_vacancy_rate_10_annual_property / 12);
	$response_array['jms_monthly_noi_fully_occupied_2'] = $jms_monthly_noi_fully_occupied_2;


	/* Initial Analysis - Key Numbers */

	if(!empty($jms_noi_2) && !empty($jms_purchase_price))
	{
		$jms_cap_rate = ($jms_noi_2 / $jms_purchase_price) * 100;
		$response_array['jms_cap_rate'] = $jms_cap_rate;
	}
	else
	{
		$jms_cap_rate = 0;
		$response_array['jms_cap_rate'] = $jms_cap_rate;
	}

	
	if(!empty($jms_annual_cash_flow_2) && !empty($jms_down_payment))
	{
		$jms_cash_on_cash_return = ($jms_annual_cash_flow_2 / $jms_down_payment) * 100;
		$response_array['jms_cash_on_cash_return'] = $jms_cash_on_cash_return;
	}
	else
	{
		$jms_cash_on_cash_return = 0;
		$response_array['jms_cash_on_cash_return'] = $jms_cash_on_cash_return;
	}

	if(!empty($jms_annual_debt_service_2) && !empty($jms_noi_2))
	{
		$jms_debt_coverage_ratio = ($jms_noi_2 / $jms_annual_debt_service_2);
		$response_array['jms_debt_coverage_ratio'] = $jms_debt_coverage_ratio;
	}
	else
	{
		$jms_debt_coverage_ratio = 0;
		$response_array['jms_debt_coverage_ratio'] = $jms_debt_coverage_ratio;
	}
	

	/* Simple Comparison Analysis */

	if(!empty($jms_of_units) && !empty($jms_annual_cash_flow_2))
	{
		$jms_noi_per_unit_monthly = ($jms_annual_cash_flow_2/$jms_of_units)/12;
		$response_array['jms_noi_per_unit_monthly'] = $jms_noi_per_unit_monthly;
	}
	else
	{
		$jms_noi_per_unit_monthly = 0;
		$response_array['jms_noi_per_unit_monthly'] = $jms_noi_per_unit_monthly;
	}

	if(!empty($jms_purchase_price) && !empty($jms_sq_of_buiding))
	{
		$jms_pp_sq_ft = ($jms_purchase_price / $jms_sq_of_buiding);
		$response_array['jms_pp_sq_ft'] = $jms_pp_sq_ft;
	}
	else
	{
		$jms_pp_sq_ft = 0;
		$response_array['jms_pp_sq_ft'] = $jms_pp_sq_ft;
	}

	


	$response_array['status'] = 'success';
	echo json_encode($response_array);
?>