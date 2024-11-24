<?php
	include("../../connection.php");
	if(!isset($_SESSION['jms_admin_user_id']))
  	{
    	header("location:index.php");
  	}
	header('Content-type: application/json');

	if(!empty($_POST['c_pw']) && !empty($_POST['n_pw']) && !empty($_POST['cn_pw']))
	{
		if($_POST['n_pw']==$_POST['cn_pw'])
		{
			$jms_admin_user_id=$_SESSION['jms_admin_user_id'];
			$c_pw 	= md5($_POST['c_pw']);

			$jms_select_sql = "SELECT * FROM admin WHERE jms_password=:c_pw and id=:jms_admin_user_id";

			$jms_select_data = $jms_pdo->prepare($jms_select_sql);
			$jms_select_data->bindParam(':c_pw', $c_pw, PDO::PARAM_STR);
			$jms_select_data->bindParam(':jms_admin_user_id', $jms_admin_user_id, PDO::PARAM_INT);
		    $jms_select_data->execute();
		    $jms_row = $jms_select_data->fetchAll(PDO::FETCH_ASSOC);

			if(count($jms_row) == 1)
			{
				$updated_on = date('Y-m-d H:i:s');
		        $n_pw 	= md5($_POST['n_pw']);

		        $jms_updated_pass = "UPDATE admin SET jms_password = :n_pw,updated_on=:updated_on WHERE id=:jms_admin_user_id";
			    $stmt = $jms_pdo->prepare($jms_updated_pass);
			    $stmt->bindParam(':n_pw', $n_pw, PDO::PARAM_STR);
			    $stmt->bindParam(':updated_on', $updated_on, PDO::PARAM_INT);
			    $stmt->bindParam(':jms_admin_user_id', $jms_admin_user_id, PDO::PARAM_INT);
			    $stmt->execute();
			    $rowCount = $stmt->rowCount();

		        if($rowCount == 1)
		        {
		        	$response_array['status'] = 'success';
					$response_array['message'] = 'Password changed successfully';
					echo json_encode($response_array);
		        }
		        else
		        {
		        	$response_array['status'] = 'error';
					$response_array['message'] = 'Something wrong, data not updated into database';
					echo json_encode($response_array);	
		        }   
		    }
		    else
			{
			    $response_array['status'] = 'error';
				$response_array['message'] = 'Wrong current password';
				echo json_encode($response_array);
			}
		}
		else
		{
		   	$response_array['status'] = 'error';
			$response_array['message'] = 'New password and Confirm Password not matched';
			echo json_encode($response_array);
		}
	}
	else
	{
		$response_array['status'] = 'error';
		$response_array['message'] = 'All form fields required';
		echo json_encode($response_array);
	}
	
?>