<?php
	include("connection.php");

	header('Content-type: application/json');

	if($_POST['jms_password_n_pw_input'] == "Strong")
	{
		if( !empty($_POST['jms_change_n_pw']) && !empty($_POST['jms_change_cn_pw']))
		{
			if($_POST['jms_change_n_pw']==$_POST['jms_change_cn_pw'])
			{
				$jms_change_token_id 	= $_POST['jms_change_token_id'];

				$jms_change_forgot_pass_select_sql = "SELECT * FROM applicant_data WHERE jms_verify_token=:jms_change_token_id";

				$jms_change_forgot_pass_select = $jms_pdo->prepare($jms_change_forgot_pass_select_sql);
				$jms_change_forgot_pass_select->bindParam(':jms_change_token_id', $jms_change_token_id, PDO::PARAM_STR);
			    $jms_change_forgot_pass_select->execute();
			    $jms_row = $jms_change_forgot_pass_select->fetchAll(PDO::FETCH_ASSOC);

				if(count($jms_row) == 1)
				{
					try 
					{
						$updated_on = date('Y-m-d H:i:s');
				        $jms_change_n_pw 	= md5($_POST['jms_change_n_pw']);
				        	
				        $jms_updated_change_forgot_pass = "UPDATE applicant_data SET jms_password=:jms_change_n_pw,updated_on=:updated_on WHERE jms_verify_token=:jms_change_token_id";

				    	$jms_change_forgot_pass_stmt = $jms_pdo->prepare($jms_updated_change_forgot_pass);
				    	$jms_change_forgot_pass_stmt->bindParam(':jms_change_token_id', $jms_change_token_id, PDO::PARAM_STR);
				    	$jms_change_forgot_pass_stmt->bindParam(':jms_change_n_pw', $jms_change_n_pw, PDO::PARAM_STR);
				    	$jms_change_forgot_pass_stmt->bindParam(':updated_on', $updated_on, PDO::PARAM_STR);
					    $jms_change_forgot_pass_stmt->execute();
					    
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
	}
	else
	{
		$response_array['status'] = 'error';
		$response_array['message'] = 'Please Enter Strong Password!';
		echo json_encode($response_array);
	}
?>