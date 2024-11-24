<?php
	include("../connection.php");
	header('Content-type: application/json');

	$jms_token_id = $_POST['jms_token_id'];

	if(isset($jms_token_id))
	{
		$jms_select_sql = "SELECT jms_verify_token,jms_verify_status FROM `user-registration` WHERE jms_verify_token = :jms_token_id";

		$jms_select_data = $jms_pdo->prepare($jms_select_sql);
		$jms_select_data->bindParam(':jms_token_id', $jms_token_id,PDO::PARAM_STR);
	    $jms_select_data->execute();
	    $jms_row = $jms_select_data->fetchAll(PDO::FETCH_ASSOC);

		if(count($jms_row) == 1)
		{
			if($jms_row[0]['jms_verify_status'] == 0)
			{
				try 
				{
					$jms_verify_status_1 = 1;
					$updated_on = date('Y-m-d H:i:s');
					$jms_cliked_token = $jms_row[0]['jms_verify_token'];

					$jms_updated_verify = "UPDATE `user-registration` SET jms_verify_status=:jms_verify_status_1,updated_on=:updated_on WHERE jms_verify_token = :jms_cliked_token";

			    	$jms_updatet_verify_stmt = $jms_pdo->prepare($jms_updated_verify);
				    $jms_updatet_verify_stmt->bindParam(':jms_verify_status_1', $jms_verify_status_1,PDO::PARAM_INT);
				    $jms_updatet_verify_stmt->bindParam(':jms_cliked_token', $jms_cliked_token,PDO::PARAM_STR);
				    $jms_updatet_verify_stmt->bindParam(':updated_on', $updated_on,PDO::PARAM_STR);
				    $jms_updatet_verify_stmt->execute();

				    $response_array['status'] = 'success';
					$response_array['message'] = 'Your account verified';
					echo json_encode($response_array);
				}
				catch(PDOException $e) 
				{
					// echo "PDO Error: " . $e->getMessage();

					$response_array['status'] = 'error';
					$response_array['message'] = 'Verification failed';
					echo json_encode($response_array);
				}
			}
			else
			{
				$response_array['status'] = 'success';
				$response_array['message'] = 'Email already verified please login';
				echo json_encode($response_array);
			}
		}
		else
		{
			$response_array['status'] = 'error';
			$response_array['message'] = 'Invalid link';
			echo json_encode($response_array);
		}
	}
	else
	{
		$response_array['status'] = 'error';
		$response_array['message'] = 'Not allowed';
		echo json_encode($response_array);
	}
?>


