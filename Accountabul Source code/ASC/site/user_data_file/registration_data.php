<?php
	include("../connection.php");
	header('Content-type: application/json');   

    include("../setting.php");

    $jms_first_name = $_POST['jms_first_name'];
    $jms_last_name = $_POST['jms_last_name'];
    $jms_email_id = $_POST['jms_email_id'];
    $jms_password = md5($_POST['jms_password']);
    $jms_rep_pass = md5($_POST['jms_rep_pass']);
    $jms_gender = $_POST['jms_gender'];
    $jms_birthdate = $_POST['jms_birthdate'];

    $jms_token_verify = md5(uniqid());

    if($_POST['jms_pass_check'] == "Strong")
    {
        if(!empty($jms_first_name) && !empty($jms_last_name) && !empty($jms_email_id) && !empty($jms_password) && !empty($jms_gender) && !empty($jms_birthdate))
        {
            if($jms_password == $jms_rep_pass)
            {
                if(filter_var($_POST['jms_email_id'], FILTER_VALIDATE_EMAIL) !== false)
                {
                    $jms_email_id   = $_POST['jms_email_id'];
                    $jms_select_sql = "SELECT * FROM `user-registration` WHERE jms_email_id=:jms_email_id";

                    $jms_select_data = $jms_pdo->prepare($jms_select_sql);
                    $jms_select_data->bindParam(':jms_email_id',$jms_email_id,PDO::PARAM_STR);
                    $jms_select_data->execute();
                    $jms_row = $jms_select_data->fetchAll(PDO::FETCH_ASSOC);

                    if(count($jms_row) == 0)
                    {
                        try 
                        {
                            $jms_insert_records = "INSERT INTO `user-registration`(`jms_first_name`, `jms_last_name`, `jms_email_id`, `jms_password`, `jms_gender`,`jms_verify_token`,`jms_birthdate`) VALUES (:jms_first_name,:jms_last_name,:jms_email_id,:jms_password,:jms_gender,:jms_token_verify,:jms_birthdate)";
                            $jms_insert_records_stmt = $jms_pdo->prepare($jms_insert_records);
                            $jms_insert_records_stmt->bindParam(':jms_first_name', $jms_first_name,PDO::PARAM_STR);
                            $jms_insert_records_stmt->bindParam(':jms_last_name', $jms_last_name,PDO::PARAM_STR);
                            $jms_insert_records_stmt->bindParam(':jms_email_id', $jms_email_id,PDO::PARAM_STR);
                            $jms_insert_records_stmt->bindParam(':jms_password', $jms_password,PDO::PARAM_STR);
                            $jms_insert_records_stmt->bindParam(':jms_gender', $jms_gender,PDO::PARAM_STR);
                            $jms_insert_records_stmt->bindParam(':jms_token_verify', $jms_token_verify,PDO::PARAM_STR);
                            $jms_insert_records_stmt->bindParam(':jms_birthdate', $jms_birthdate,PDO::PARAM_STR);
                            $jms_insert_records_stmt->execute();

                            //mail code

                            $token_url = $jms_token_url_path.'/verify_user.php?t='.$jms_token_verify;

                            //live

                            $to =  $jms_email_id;

                            $from_email2 = $jms_sender_from_address;
                            $from_name2 = $jms_sender_from_name;

                            // Header for multipart email

                            $headers = "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                            
                            $headers .= "From: {$from_name2} <{$from_email2}>\r\n";

                            $subject = "Activate Your Account and Get Early Access to Accountabul’s Deal Evaluation Calculator!";

                            $message = "<html><body>
                                <div>Hello {$jms_first_name} {$jms_last_name},<br><br>\r\n
                                Welcome to Accountabul! We are excited to have you join us during this soft launch phase.<br><br>\r\n
                                To get started and explore our features, please activate your account by clicking the link below:<br><br>\r\n
                                <a href='{$token_url}' style='font-weight:bold;font-size:15px;'>Activate My Account</a><br><br>\r\n
                                Benefits of Your Membership:<br><br>\r\n
                                Early Access to Deal Evaluation Calculator: As part of our soft launch, you’ll gain exclusive access to our powerful Deal Evaluation Calculator to help you make informed investment decisions.<br><br>\r\n
                                Exclusive NFT Membership: Paid members will receive a unique NFT at the full launch of Accountabul, granting you exclusive access to our blockchain ecosystem and additional features.<br><br>\r\n
                                Residual Income from Rental Properties: Your NFT will also entitle you to earn consistent residual income from our entire portfolio of rental properties.<br><br>\r\n
                                Manage Your Profile: Update your personal information and preferences.<br><br>\r\n
                                Track Your Daily Evaluations: Keep a detailed record of your activities.<br><br>\r\n
                                Access Exclusive Content: Unlock premium resources and tools.<br><br>\r\n
                                Connect with the Community: Engage with other users and experts in your field.<br><br>\r\n
                                We welcome you to the Accountabul community and look forward to your participation and feedback!<br><br>\r\n
                                If you have any questions or need assistance, feel free to reply to this email or visit our Support Center.<br><br>\r\n
                                Thank you for being a part of this exciting journey with Accountabul. We’re eager to support your success!<br><br>\r\n
                                Best regards,<br><br>\r\n
                                The Accountabul Team<br><br>\r\n
                                Need help? Contact Support | Privacy Policy | Terms of Service<br><br>\r\n
                                Accountabul.com<br><br>\r\n
                                Innovate. Evaluate. Succeed.</div>
                            </body></html>";

                            // $headers = "MIME-Version: 1.0\r\n";
                            // $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                            mail($to, $subject, $message, $headers);
                            
                            $response_array['status'] = 'success';
                            $response_array['message'] = 'Please Check Your Inbox or Spam Message';
                            //'Record Added Successfully';
                            echo json_encode($response_array);
                        }
                        catch(PDOException $e) 
                        {
                            // echo "PDO Error: " . $e->getMessage();

                            $response_array['status'] = 'error';
                            $response_array['message'] = 'Something Wrong, Record Not Insert Into Database';
                            echo json_encode($response_array);  
                        }
                    }
                    else
                    {
                        $response_array['status'] = 'error';
                        $response_array['message'] = 'Email id already registered';
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
                $response_array['message'] = 'Password and Confirm Password Not match';
                echo json_encode($response_array);
            }
        }
        else
        {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Please Fill in blank Value';
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