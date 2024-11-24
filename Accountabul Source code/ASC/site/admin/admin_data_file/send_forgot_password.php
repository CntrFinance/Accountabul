<?php
	include("../../connection.php");
	header('Content-type: application/json');

	// setting.php
	require_once('../../setting.php');

	if(!empty($_POST['jms_email_id']))
	{
		if(filter_var($_POST['jms_email_id'], FILTER_VALIDATE_EMAIL) !== false)
		{
			$jms_email_id = $_POST['jms_email_id'];
			$jms_select_sql = "SELECT * FROM admin WHERE jms_email_id='$jms_email_id'";

			$jms_select_data = $jms_pdo->prepare($jms_select_sql);
		    $jms_select_data->execute();
		    $jms_row = $jms_select_data->fetchAll(PDO::FETCH_ASSOC);

			if(count($jms_row) == 1)
			{
				//update token

				$updated_on = date('Y-m-d H:i:s');
		        $jms_verify_token 	= md5(rand());
		        	
		        $jms_updated_send_forgot_pass = "UPDATE admin SET jms_verify_token=:jms_verify_token,updated_on=:updated_on WHERE jms_email_id='$jms_email_id'";

		    	$stmt = $jms_pdo->prepare($jms_updated_send_forgot_pass);
			    $stmt->bindParam(':jms_verify_token', $jms_verify_token);
			    $stmt->bindParam(':updated_on', $updated_on);
			    $stmt->execute();

			    //get token

			    $jms_select_get_token = "SELECT * FROM admin WHERE jms_email_id='$jms_email_id'";

				$jms_select_get_token = $jms_pdo->prepare($jms_select_get_token);
			    $jms_select_get_token->execute();
			    $jms_row_get_token = $jms_select_get_token->fetchAll(PDO::FETCH_ASSOC);

			    if(count($jms_row_get_token) == 1)
			    {
					$token_url = $jms_token_url_path.'/admin/change_forgot_password.php?t='.$jms_row_get_token[0]['jms_verify_token'];

					$jms_user_email_id = $jms_row[0]['jms_email_id'];

					//live

				    $to = $jms_email_id;
					// $jms_sender_email = $jms_sender_from_address;
					$subject = "Reset password";

					$message = "<html><body><a href=$token_url>RESET PASSWORD</a></body></html>";

					$boundary = md5(time());

					// Headers
					
					// $headers = "From: $jms_sender_from_name <$jms_sender_email>\r\n";
					// $headers .= "Reply-To: $jms_sender_email\r\n";
					$headers = "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

					// Message Body

					$body = "--$boundary\r\n";
					$body .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
					$body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
					$body .= "$message\r\n";

					mail($to, $subject, $body, $headers);

					// $response_array['body'] = $body;

				    $response_array['status'] = 'success';
					$response_array['message'] = "An email has been sent to your email address. Check your inbox or spam folder. Click the link to change your password immediately."; 
					echo json_encode($response_array);
				}
				else
				{
					$response_array['status'] = 'error';
					$response_array['message'] = "token not verify";
					echo json_encode($response_array);
				}
			}
			else
			{
				$response_array['status'] = 'error';
				$response_array['message'] = 'There is no account associated with this email id';
				echo json_encode($response_array);
			}
		}
		else
		{
			$response_array['status'] = 'error';
			$response_array['message'] = 'Invalid email id';
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