<!doctype html>
<html lang="en">
    <head>
        <?php 
            include("../connection.php");
            include("header.php"); 
        ?>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <title>Change Forgot Password</title>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row justify-content-md-center mt-5">
                <div class="col-md-4">
                    <div class="card card-outline card-primary">
                        <form class="jms-verify-password-form" name="jms_verify_password_form" id="jms_verify_password_form">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="jms_change_n_pw">Change New Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" name="jms_change_n_pw" id="jms_change_n_pw" placeholder="Change New Password" required>                                    
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <i class="fa fa-solid fa-eye-slash jms-change-for-pass-1" id="jms_change_for_password_icon_1_cpw"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <small class="form-text form-text d-flex justify-content-between">Note: Strong password required.<span id="jms_span"></span></small>
                                </div>
                                <div class="form-group">
                                    <label for="jms_change_cn_pw">Confirm New Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" name="jms_change_cn_pw" id="jms_change_cn_pw" placeholder="Confirm New Password" required>                                  
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <i class="fa fa-solid fa-eye-slash jms-change-for-pass-2" id="jms_change_for_password_icon_2_cn_pw"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="jms_token_id_check" name="jms_token_id_check" value="<?php echo $_GET['t'];?>">
                                <input type="hidden" id="jms_password_n_pw_input" name="jms_password_n_pw_input">
                                <div class="jms-change-forgot-message"></div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="jms_change_pass" name="jms_change_pass">Change Password</button>
                            </div>
                        </form>                        
                    </div>
                </div>
            </div>
        </div>

        <?php include("footer.php");?>
             
        <script type="text/javascript" src="js/change_forgot_password.js"></script>
        <script type="text/javascript" src="../js/custome.js"></script>

        <script type="text/javascript">
            $(document).ready(function()
            {
                $("#jms_change_n_pw").on('keyup', function()
                {
                    var jms_number = /([0-9])/;
                    var jms_alphabets = /([a-zA-Z])/;
                    var jms_special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;

                    if ($('#jms_change_n_pw').val().length < 6) 
                    {
                        // $('#jms_change_n_pw').removeClass();
                        // $('#jms_change_n_pw').addClass('jms-weak-password');
                        // $('#jms_change_n_pw').html("Weak");

                        $('#jms_password_n_pw_input').val("Weak");
                        $("#jms_span").text('Weak').css('color','red');

                        // $("#jms_change_n_pw").css({'border':'1px solid red','border-right':'none',});
                        // $(".input-group-text").removeClass('jms-focus-input-pass').css({'border':'1px solid red','border-left':'none',});

                        if($('#jms_change_n_pw').val().length == 0)
                        {
                            // $('#jms_change_n_pw').html("");
                            $('#jms_password_n_pw_input').val("");
                            $("#jms_span").text("");

                            // $("#jms_change_n_pw").css({'border':'1px solid #ced4da','border-right':'none'});
                            // $(".input-group-text").removeClass('jms-focus-input-pass').css({'border':'1px solid #ced4da','border-left':'none',});
                        }
                    } 
                    else 
                    {
                        if ($('#jms_change_n_pw').val().match(jms_number) && $('#jms_change_n_pw').val().match(jms_alphabets) && $('#jms_change_n_pw').val().match(jms_special_characters)) 
                        {
                            // $('#jms_change_n_pw').removeClass();
                            // $('#jms_change_n_pw').addClass('jms-strong-password');
                            // $('#jms_change_n_pw').html("Strong");
                            
                            $('#jms_password_n_pw_input').val("Strong");

                            // $("#jms_change_n_pw").css({'border':'1px solid green','border-right':'none',});
                            // $(".input-group-text").removeClass('jms-focus-input-pass').css({'border':'1px solid green','border-left':'none',});

                            $("#jms_span").text('Strong').css('color','green');
                        } 
                        else 
                        {
                            // $('#jms_change_n_pw').removeClass();
                            // $('#jms_change_n_pw').addClass('jms-medium-password');
                            // $('#jms_change_n_pw').html("Medium");

                            $('#jms_password_n_pw_input').val("Medium");
                            $("#jms_span").text('Medium').css('color','orange');

                            // $("#jms_change_n_pw").css({'border':'1px solid orange','border-right':'none',});
                            // $(".input-group-text").removeClass('jms-focus-input-pass').css({'border':'1px solid orange','border-left':'none',});
                        }
                    }
                });
            });
        </script>

    </body>
</html>