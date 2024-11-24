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

		$updated_on = date('Y-m-d H:i:s');

	    $jms_updated_pass = "UPDATE `deal-evaluation-calc` SET calc_data_records=:jms_json, updated_on=:updated_on WHERE id=:jms_user_id";
	    $jms_updated_pass_update = $jms_pdo->prepare($jms_updated_pass);
	    $jms_updated_pass_update->bindParam(':jms_user_id', $jms_user_id, PDO::PARAM_INT);
	    $jms_updated_pass_update->bindParam(':jms_json', $jms_json, PDO::PARAM_STR);
	    $jms_updated_pass_update->bindParam(':updated_on', $updated_on, PDO::PARAM_STR);
	    $jms_updated_pass_update->execute();

	    $jms_row_update = $jms_updated_pass_update->fetchAll(PDO::FETCH_ASSOC);

	    if (count($jms_row_update) == 0) {
	        $response_array['status'] = 'success';
	        $response_array['message'] = 'Updated successfully done.';
	        echo json_encode($response_array);
	    } else {
	        $response_array['status'] = 'error';
	        $response_array['message'] = 'Something wrong, data not updated into database';
	        echo json_encode($response_array);
	    }
	}
?>