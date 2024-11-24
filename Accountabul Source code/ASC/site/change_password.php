<?php
    include("connection.php");
    if(!isset($_SESSION['jms_user_id']))
    {
        header("location:index.php");
    }

    include("header.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Change Password</title>
    
    <!-- css link -->
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/loading.css">
</head>

<body class="jms-bg">
<?php include("navbar_top.php"); ?>

    <div class="container ">
        <div class="jms-container my-5 mx-lg-5 mx-md-5 px-lg-5">
            <div class="row mt-3 d-flex align-items-center">
                <div class="col-lg-6 mt-5 pb-5 px-lg-5 px-md-5 px-sm-3 px-5">
                    <div class="jms-h2">Change Password</div>
                    <form class="mt-4" id="jms_pass_change_form" name="jms_pass_change_form">
                        <div class="form-group">
                            <label for="c_pw" class="jms-label-password">
                                <i class="fa-solid fa-unlock"></i>
                            </label>
                            <input class="jms-form-input" type="password" name="c_pw" id="c_pw"
                                placeholder="Current Password" required>
                            <label for="c_pw" class="jms-label-view" id="jms_current_password_icon">
                                <i class="fa-regular fa-eye-slash jms-c-password"></i>
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="n_pw" class="jms-label-password">
                                <i class="fa-solid fa-lock"></i>
                            </label>
                            <input class="jms-form-input" type="password" name="n_pw" id="n_pw"
                                placeholder="New Password" required>
                            <label for="n_pw" class="jms-label-view" id="jms_new_password_icon">
                                <i class="fa-regular fa-eye-slash jms-n-password"></i>
                            </label>
                            <small class="form-text form-text d-flex justify-content-between">Note: Strong password required.<span id="jms_span"></span></small>
                        </div>
                        <div class="form-group">
                            <label for="cn_pw" class="jms-label-password">
                                <i class="fa-solid fa-lock"></i>
                            </label>
                            <input class="jms-form-input" type="password" name="cn_pw" id="cn_pw"
                                placeholder="Confirm New Password" required>
                            <label for="cn_pw" class="jms-label-view" id="jms_c_n_password_icon">
                                <i class="fa-regular fa-eye-slash jms-cn-password"></i>
                            </label>
                        </div>
                        <input type="hidden" id="jms_pass_check" name="jms_pass_check">
                        
                        <div class="jms-pass-change-message"></div>

                        <div class="col-md-12 d-flex justify-content-center">
                            <div class="jms-loader" id="jms_loading"></div>
                        </div>

                        <div class="form-group form-button text-center">
                            <input type="submit" name="login" id="signup" class="jms-form-submit" value="Change Password">
                        </div>
                    </form>
                </div>
                <div class="col-lg-6 mt-5 d-flex align-items-center justify-content-center pb-5">
                    <img src="img/change-pass.jpg" class="img-fluid ">
                </div>
            </div>
        </div>
    </div>


    <?php include("footer.php"); ?> 
    <script type="text/javascript" src="js/custome.js"></script>
    <script type="text/javascript" src="js/change_password.js"></script>

    <script type="text/javascript">
        $(document).ready(function()
        {
            $("#n_pw").on('keyup', function()
            {
                var jms_number = /([0-9])/;
                var jms_alphabets = /([a-zA-Z])/;
                var jms_special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;

                if ($('#n_pw').val().length < 6) 
                {
                    $('#jms_pass_check').val("Weak");
                    $("#jms_span").text('Weak').css({'color':'red','font-weight':'bold'});

                    if($('#n_pw').val().length == 0)
                    {
                        $('#jms_pass_check').val("");
                        $("#jms_span").text("");
                    }
                } 
                else 
                {
                    if ($('#n_pw').val().match(jms_number) && $('#n_pw').val().match(jms_alphabets) && $('#n_pw').val().match(jms_special_characters)) 
                    {
                        $('#jms_pass_check').val("Strong");
                        $("#jms_span").text('Strong').css({'color':'green','font-weight':'bold'});
                    } 
                    else 
                    {
                        $('#jms_pass_check').val("Medium");
                        $("#jms_span").text('Medium').css({'color':'orange','font-weight':'bold'});
                    }
                }
            });
        });
    </script>
</body>

</html>

