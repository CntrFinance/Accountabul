<?php
    include("../connection.php");
    header('Content-type: application/json');

    // setting.php
    include('../setting.php');
    
    // googel recaptcha

    $jms_privatekey = $jms_captcha_secrete_key;
    $jms_captcha = $_POST['g-recaptcha-response'];
    $jms_url = 'https://www.google.com/recaptcha/api/siteverify';
    $jms_data = array(
        'secret' => $jms_privatekey,
        'response' => $jms_captcha,
        'remoteip' => $_SERVER['REMOTE_ADDR']
    );

    $jms_curl_config = array(
        CURLOPT_URL => $jms_url,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => $jms_data
    );

    $jms_ch = curl_init();
    curl_setopt_array($jms_ch, $jms_curl_config);
    $response = curl_exec($jms_ch);
    curl_close($jms_ch);
    $jms_json_response = json_decode($response);
    
    if($jms_json_response->success == 1)
    {
        if(!empty($_POST['jms_email_id']) && !empty($_POST['jms_password']))
        {
            if(filter_var($_POST['jms_email_id'], FILTER_VALIDATE_EMAIL) !== false)
            {
                $jms_email_id = $_POST['jms_email_id'];
                $jms_password = md5($_POST['jms_password']);
                
                $jms_verify_status = '1';
                
                $jms_login_data_get_select = "SELECT * FROM `user-registration` WHERE jms_email_id=:jms_email_id and jms_password=:jms_password";

                $jms_login_data_get = $jms_pdo->prepare($jms_login_data_get_select);
                $jms_login_data_get->bindParam(':jms_email_id', $jms_email_id, PDO::PARAM_STR);
                $jms_login_data_get->bindParam(':jms_password', $jms_password, PDO::PARAM_STR);
                $jms_login_data_get->execute();
                $jms_row = $jms_login_data_get->fetchAll(PDO::FETCH_ASSOC);

                if(count($jms_row) == 1)
                {   
                    $sql_login_data_get_select_2 = "SELECT * FROM `user-registration` WHERE jms_verify_status=:jms_verify_status and jms_email_id=:jms_email_id";
                    
                    $jms_login_data_get_2 = $jms_pdo->prepare($sql_login_data_get_select_2);
                    $jms_login_data_get_2->bindParam(':jms_verify_status',$jms_verify_status, PDO::PARAM_STR);
                    $jms_login_data_get_2->bindParam(':jms_email_id', $jms_email_id, PDO::PARAM_STR);
                    $jms_login_data_get_2->execute();
                    $jms_row_2 = $jms_login_data_get_2->fetchAll(PDO::FETCH_ASSOC);
                        
                    if(count($jms_row_2) == 1)
                    {
                        $users_data = $jms_row_2;
                        $_SESSION['jms_user_id'] = $users_data[0]['id'];               

                        // stripe

                        $sql_stripe_data_get_select = "SELECT * FROM `stripe_payments_subscription` WHERE users_id=:jms_user_id";

                        $jms_stripe_data_get = $jms_pdo->prepare($sql_stripe_data_get_select);
                        $jms_stripe_data_get->bindParam(':jms_user_id',$users_data[0]['id'],PDO::PARAM_INT);
                        $jms_stripe_data_get->execute();
                        $jms_row_stripe_data_get = $jms_stripe_data_get->fetchAll(PDO::FETCH_ASSOC);

                        // paypal

                        $sql_paypal_data_get_select = "SELECT * FROM `paypal_payments_subscription` WHERE users_id=:jms_user_id";

                        $jms_paypal_data_get = $jms_pdo->prepare($sql_paypal_data_get_select);
                        $jms_paypal_data_get->bindParam(':jms_user_id',$users_data[0]['id'],PDO::PARAM_INT);
                        $jms_paypal_data_get->execute();
                        $jms_row_paypal_data_get = $jms_paypal_data_get->fetchAll(PDO::FETCH_ASSOC);

                        //get data cancel records date
 
                        $jms_select_cancel_sql = "SELECT * FROM `cancel_subscription` WHERE users_id=:jms_user_id";
                        $jms_select_cancel_data = $jms_pdo->prepare($jms_select_cancel_sql);
                        $jms_select_cancel_data->bindParam(':jms_user_id', $users_data[0]['id'],PDO::PARAM_INT);
                        $jms_select_cancel_data->execute();
                        $jms_row_cancel_login = $jms_select_cancel_data->fetchAll(PDO::FETCH_ASSOC);

                        function compareDates($date1, $date2) 
                        {
                            if($date1 != "" && $date2 != "")
                            {
                                $timestamp1 = strtotime($date1);
                                $timestamp2 = strtotime($date2);
                                
                                return $timestamp1 <= $timestamp2;
                            }
                            else
                            {
                                return false;
                            }
                        }

                        // today date

                        $jms_today_date = date('d-m-Y');
                        
                        // cancel subcription date

                        $jms_next_billing_date = isset($jms_row_cancel_login[0]['nextbilling_date']) ? $jms_row_cancel_login[0]['nextbilling_date'] : "";

                        $jms_cancel_next_billing_date = compareDates($jms_today_date, $jms_next_billing_date);

                        $jms_payment_verify = false;

                        if(count($jms_row_stripe_data_get) > 0)
                        {
                            for($x=0;$x<count($jms_row_stripe_data_get);$x++)
                            {
                                if($jms_row_stripe_data_get[$x]['jms_stripe_status'] == 'active' || ($jms_row_stripe_data_get[$x]['jms_stripe_status'] == 'canceled' && $jms_cancel_next_billing_date == true))
                                {
                                    $jms_payment_verify = true;
                                }    
                            }
                        }

                        if(count($jms_row_paypal_data_get) > 0)
                        {
                            for($x=0;$x<count($jms_row_paypal_data_get);$x++)
                            {
                                if($jms_row_paypal_data_get[$x]['jms_paypal_status'] == 'ACTIVE' || ($jms_row_paypal_data_get[$x]['jms_paypal_status'] == 'CANCELLED' && $jms_cancel_next_billing_date == true))
                                {
                                    $jms_payment_verify = true;
                                }    
                            }
                        }

                        if($jms_row_2[0]['jms_no_save_deal'] != 0 || $jms_row_2[0]['jms_no_save_buy'] != 0)
                        {
                            $jms_payment_verify = true;
                        }

                        if($jms_payment_verify == true)
                        {
                            $jms_redirect_page_name = "profile";
                            $response_array['jms_redirect_page_name'] = $jms_redirect_page_name;
                        }
                        else
                        {
                            $jms_redirect_page_name = "dashboard";
                            $response_array['jms_redirect_page_name'] = $jms_redirect_page_name;
                        }

                        $response_array['status'] = 'success';
                        $response_array['message'] = 'Login successfully done. Redirecting...';
                        echo json_encode($response_array);
                    }
                    else
                    {
                        $response_array['status'] = 'error';
                        $response_array['message'] = 'Verify your email!';
                        echo json_encode($response_array);
                    }
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
    }
    else
    {
        $response_array['status'] = 'error';
        $response_array['message'] = 'Invalid Captcha!';
        echo json_encode($response_array);
    }
?>

