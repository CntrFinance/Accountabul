<?php
	include("../../connection.php");
	if(!isset($_SESSION['jms_admin_user_id']))
  	{
    	header("location:index.php");
  	}
	header('Content-type: application/json');

	$admin_id = $_SESSION["jms_admin_user_id"];


    $jms_deal_evalution_price = $_POST['jms_deal_evalution_price'];
    $jms_buy_and_hold_analysis_price = $_POST['jms_buy_and_hold_analysis_price'];

	$jms_select_sql = "SELECT * FROM `setting` WHERE admin_id=:admin_id";
    $jms_select_data = $jms_pdo->prepare($jms_select_sql);
    $jms_select_data->bindParam(':admin_id', $admin_id,PDO::PARAM_INT);
    $jms_select_data->execute();
    $jms_row = $jms_select_data->fetchAll(PDO::FETCH_ASSOC);

    $updated_on = date('Y-m-d H:i:s');

    if(count($jms_row) == 0)
    {
        $jms_insert_records = "INSERT INTO `setting`(`admin_id`,`jms_deal_evalution_price`, `jms_buy_and_hold_analysis_price`) VALUES (:admin_id,:jms_deal_evalution_price,:jms_buy_and_hold_analysis_price)";
        $jms_insert_records_stmt = $jms_pdo->prepare($jms_insert_records);
        $jms_insert_records_stmt->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
        $jms_insert_records_stmt->bindParam(':jms_deal_evalution_price', $jms_deal_evalution_price, PDO::PARAM_STR);
        $jms_insert_records_stmt->bindParam(':jms_buy_and_hold_analysis_price', $jms_buy_and_hold_analysis_price, PDO::PARAM_STR);
        $jms_insert_records_stmt->execute();


        $response_array['status'] = 'success';
        $response_array['message'] = 'Data Successfully Inserted.';
        echo json_encode($response_array);
    }
    else
    {
        $jms_updated_data = "UPDATE `setting` SET jms_deal_evalution_price=:jms_deal_evalution_price,jms_buy_and_hold_analysis_price=:jms_buy_and_hold_analysis_price,updated_on=:updated_on WHERE id=:id";

        $id = $jms_row[0]['id'];
        $jms_update_records_stmt = $jms_pdo->prepare($jms_updated_data);
        $jms_update_records_stmt->bindParam(':id',$id, PDO::PARAM_INT);
        $jms_update_records_stmt->bindParam(':jms_deal_evalution_price', $jms_deal_evalution_price, PDO::PARAM_STR);
        $jms_update_records_stmt->bindParam(':jms_buy_and_hold_analysis_price', $jms_buy_and_hold_analysis_price, PDO::PARAM_STR);
        $jms_update_records_stmt->bindParam(':updated_on', $updated_on, PDO::PARAM_STR);
        $jms_update_records_stmt->execute();


        $response_array['status'] = 'success';
        $response_array['message'] = 'Updated successfully done.';
        echo json_encode($response_array);
    }
?>