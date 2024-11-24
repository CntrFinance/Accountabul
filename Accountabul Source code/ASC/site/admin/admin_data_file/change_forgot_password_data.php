<?php
	include("../../connection.php");

	header('Content-type: application/json');

	if($_POST['jms_password_n_pw_input'] == "Strong")
	{
		if( !empty($_POST['jms_change_n_pw']) && !empty($_POST['jms_change_cn_pw']))
		{
			if($_POST['jms_change_n_pw']==$_POST['jms_change_cn_pw'])
			{
				$jms_token_id_check 	= $_POST['jms_token_id_check'];

				$jms_select_sql = "SELECT * FROM admin WHERE jms_verify_token=:jms_token_id_check";

				$jms_select_data = $jms_pdo->prepare($jms_select_sql);
				$jms_select_data->bindParam(':jms_token_id_check', $jms_token_id_check, PDO::PARAM_STR);
			    $jms_select_data->execute();
			    $jms_row = $jms_select_data->fetchAll(PDO::FETCH_ASSOC);

				if(count($jms_row) == 1)
				{
					try 
					{
						$updated_on = date('Y-m-d H:i:s');
				        $jms_change_n_pw 	= md5($_POST['jms_change_n_pw']);
				        $jms_verify_token 	= null;

				        $jms_updated_change_forgot_pass = "UPDATE admin SET jms_password=:jms_change_n_pw,jms_verify_token=:jms_verify_token,updated_on=:updated_on WHERE jms_verify_token='$jms_token_id_check'";

				    	$stmt = $jms_pdo->prepare($jms_updated_change_forgot_pass);
					    $stmt->bindParam(':jms_change_n_pw', $jms_change_n_pw, PDO::PARAM_STR);
					    $stmt->bindParam(':jms_verify_token', $jms_verify_token, PDO::PARAM_STR);
					    $stmt->bindParam(':updated_on', $updated_on, PDO::PARAM_STR);
					    $stmt->execute();
					    
					    $response_array['status'] = 'success';
						$response_array['message'] = 'Password changed successfully';
						echo json_encode($response_array);
					}
					catch(PDOException $e) 
					{
						// echo "PDO Error: " . $e->getMessage();

						$response_array['status'] = 'error';
						$response_array['message'] = 'Something wrong, data not updated into database';
						echo json_encode($response_array);	
					}
			    }
			    else
				{
				    $response_array['status'] = 'error';
					$response_array['message'] = 'Please re-enter your mail id';
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
	}
	else
	{
		$response_array['status'] = 'error';
		$response_array['message'] = 'Please Enter Strong Password!';
		echo json_encode($response_array);
	}
?>