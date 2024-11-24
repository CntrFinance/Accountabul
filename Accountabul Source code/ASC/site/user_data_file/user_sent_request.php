<?php
	include("../connection.php");
	if(!isset($_SESSION['jms_user_id']))
  	{
    	header("location:index.php");
  	}
	header('Content-type: application/json');

	$jms_user_id = $_POST["jms_user_id"];
    $jms_is_requested = 'y';

	$jms_select_sql = "SELECT * FROM `user-registration` WHERE id=:jms_user_id";
    $jms_select_data = $jms_pdo->prepare($jms_select_sql);
    $jms_select_data->bindParam(':jms_user_id', $jms_user_id,PDO::PARAM_INT);
    $jms_select_data->execute();
    $jms_row = $jms_select_data->fetchAll(PDO::FETCH_ASSOC);

    $updated_on = date('Y-m-d H:i:s');

    if(count($jms_row) == 1)
    {
        $jms_updated_pass = "UPDATE `user-registration` SET is_requested=:jms_is_requested,updated_on=:updated_on WHERE id=:jms_user_id";
        $jms_updated_pass_update = $jms_pdo->prepare($jms_updated_pass);
        $jms_updated_pass_update->bindParam(':jms_user_id', $jms_user_id,PDO::PARAM_INT);
        $jms_updated_pass_update->bindParam(':jms_is_requested', $jms_is_requested,PDO::PARAM_STR);
        $jms_updated_pass_update->bindParam(':updated_on', $updated_on,PDO::PARAM_STR);
        $jms_updated_pass_update->execute();

        $jms_row_update = $jms_updated_pass_update->fetchAll(PDO::FETCH_ASSOC);

        if(count($jms_row_update) == 0)
        {
         $response_array['status'] = 'success';
         $response_array['message'] = 'Request sent';
         echo json_encode($response_array);
        }
        else
        {
         $response_array['status'] = 'error';
         $response_array['message'] = 'Something wrong, request not sent';
         echo json_encode($response_array);  
        }
    }
?>