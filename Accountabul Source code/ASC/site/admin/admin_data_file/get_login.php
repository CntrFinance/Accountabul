<?php
    include("../connection.php");
    header('Content-type: application/json');

    
    if(!empty($_POST['jms_email_id']) && !empty($_POST['jms_password']))
    {
        if(filter_var($_POST['jms_email_id'], FILTER_VALIDATE_EMAIL) !== false)
        {
            $jms_email_id = $_POST['jms_email_id'];
            $jms_password = md5($_POST['jms_password']);
            $jms_select_sql = "SELECT * FROM admin WHERE jms_email_id=:jms_email_id and jms_password=:jms_password";

            $jms_select_data = $jms_pdo->prepare($jms_select_sql);
            $jms_select_data->bindParam(':jms_email_id', $jms_email_id, PDO::PARAM_STR);
            $jms_select_data->bindParam(':jms_password', $jms_password, PDO::PARAM_STR);
            $jms_select_data->execute();
            $jms_row = $jms_select_data->fetchAll(PDO::FETCH_ASSOC);

            if(count($jms_row) == 1)
            {   
                $users_data = $jms_row;
                $_SESSION['jms_admin_user_id'] = $users_data[0]['id'];               

                $response_array['status'] = 'success';
                $response_array['message'] = 'Login successfully done. Redirecting...';
                echo json_encode($response_array);
            }
            else
            {
                $response_array['status'] = 'error';
                $response_array['message'] = 'Invalid email id or password';
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