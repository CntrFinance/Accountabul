<?php
	include("connection.php");
	header('Content-type: application/json');

	// setting.php
	require_once('setting.php');

	if(!empty($_POST['jms_email_id']))
	{
		if(filter_var($_POST['jms_email_id'], FILTER_VALIDATE_EMAIL) !== false)
		{
			$jms_email_id = $_POST['jms_email_id'];
			$jms_forgot_pass_select = "SELECT * FROM applicant_data WHERE jms_email_id=:jms_email_id";

			$jms_forgot_pass_select_data = $jms_pdo->prepare($jms_forgot_pass_select);
			$jms_forgot_pass_select_data->bindParam(':jms_email_id', $jms_email_id, PDO::PARAM_STR);
		    $jms_forgot_pass_select_data->execute();
		    $jms_row = $jms_forgot_pass_select_data->fetchAll(PDO::FETCH_ASSOC);

			if(count($jms_row) == 1)
			{
				$jms_verify_token = $jms_row[0]['jms_verify_token'];

				$token_url = $jms_token_url_path.'/change_forgot_password.php?t='.$jms_verify_token;
				// email($token_url);

				$jms_user_email_id = $jms_row[0]['jms_email_id'];

				//live

			    $to = $jms_email_id;
				$jms_sender_email = $jms_sender_from_address;
				$subject = "Reset Password";

				$message = "<html><body><a href=$token_url>RESET PASSWORD</a></body></html>";

				$boundary = md5(time());

				// Headers
				
				$headers = "From: $jms_sender_from_name <$jms_sender_email>\r\n";
				$headers .= "Reply-To: $jms_sender_email\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

				// Message Body

				$body = "--$boundary\r\n";
				$body .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				$body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
				$body .= "$message\r\n";

				mail($to, $subject, $body, $headers);

				$response_array['status'] = 'success';
				$response_array['message'] = "An email has been sent to your email address. Check your inbox or spam folder. Click the link to change your password immediately.";
				echo json_encode($response_array);
			}
			else
			{
				$response_array['status'] = 'error';
				$response_array['message'] = 'There is no account associated with this email ID';
				echo json_encode($response_array);
			}
		}
		else
		{
			$response_array['status'] = 'error';
			$response_array['message'] = 'Invalid email ID';
			echo json_encode($response_array);
		}
	}
	else
	{
		$response_array['status'] = 'error';
		$response_array['message'] = 'All form fields are mandatory';
		echo json_encode($response_array);
	}
?>