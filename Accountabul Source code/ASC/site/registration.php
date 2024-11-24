<?php 
    include('connection.php');
    include("header.php");
    include("setting.php");
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Registration</title>

        <!-- Style css -->
        <link rel="stylesheet" type="text/css" href="css/form.css">
        <link rel="stylesheet" type="text/css" href="css/loading.css">

        <style type="text/css">
            .form-check-inline
            {
                margin-right: 0px;
            }
        </style>
    </head>
    <body class="jms-bg">
        <?php include("navbar_top.php");?>
        <div class="container">
            <div class="jms-container my-5 mx-lg-5 mx-md-5 px-lg-5">
                <div class="row mt-3 d-flex align-items-center">
                    <div class="col-lg-6 mt-5 pb-5 px-lg-5 px-md-5 px-sm-3 px-5">
                        <div class="jms-h2">Registration</div>
                        <form class="mt-4" id="jms_registration_from" name="jms_registration_from">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6 col-6 ">
                                        <label for="name" class="jms-label">
                                            <i class="fas fa-user"></i>
                                        </label>
                                        <input class="jms-form-input" type="text" name="jms_first_name" id="jms_first_name"
                                            placeholder="First Name" required>
                                    </div>
                                    <div class="col-lg-6 col-6 ">
                                        <input class="jms-form-input px-0" type="text" name="jms_last_name" id="jms_last_name"
                                            placeholder="Last Name" class="px-0" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="jms-label">
                                    <i class="fa-solid fa-envelope"></i>
                                </label>
                                <input class="jms-form-input" type="email" name="jms_email_id" id="jms_email_id"
                                    placeholder="Your Email" required>
                            </div>

                            <div class="form-group">
                                <label for="pass" class="jms-label">
                                    <i class="fa-solid fa-cake-candles"></i>
                                </label>
                                <input class="jms-form-input" type="date" name="jms_birthdate" id="jms_birthdate">
                            </div>

                            <div class="form-group jms-gender-bdr pb-2">
                                <label for="jms_gender" class="jms-form-label ">Gender :</label>
                                <div class="form-check-inline px-md-3 px-0">
                                  <input class="form-check-input" type="radio" name="jms_gender" id="male" value="male" required>
                                  <label class="form-check-label jms-form-label" for="male">
                                    Male
                                  </label>
                                </div>
                                <div class="form-check-inline">
                                  <input class="form-check-input" type="radio" name="jms_gender" id="female" value="female" required>
                                  <label class="form-check-label jms-form-label" for="female">
                                    Female
                                  </label>
                                </div>
                                <div class="form-check-inline px-md-3 px-0">
                                  <input class="form-check-input" type="radio" name="jms_gender" id="other" value="other" required>
                                  <label class="form-check-label jms-form-label" for="other">
                                    Other
                                  </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="jms_password" class="jms-label-password">
                                    <i class="fa-solid fa-lock"></i>
                                </label>
                                <input class="jms-form-input" type="password" name="jms_password" id="jms_password"
                                    placeholder="Password" required>
                                <label for="jms_password" class="jms-label-view" id="jms_password_icon_regi">
                                    <i class="fa-regular fa-eye-slash jms-password"></i>
                                </label>
                                <small class="form-text form-text d-flex justify-content-between">Note: Strong password required.<span id="jms_span"></span></small>
                            </div>

                            <div class="form-group">
                                <label for="jms_rep_pass" class="jms-label">
                                    <i class="fa-solid fa-lock"></i>
                                </label>
                                <input class="jms-form-input" type="password" name="jms_rep_pass" id="jms_rep_pass"
                                    placeholder="Repeat your password">
                                <label for="jms_rep_pass" class="jms-label-view" id="jms_repeat_password_icon_regi">
                                    <i class="fa-regular fa-eye-slash  jms-repeat-password"></i>
                                </label>
                            </div>

                           <!--  <div class="form-group d-flex align-items-center ">
                                <input type="checkbox" name="agree-term" id="jms_agree" class="m-1">
                                <label for="agree-term" class="jms-label-agree">I agree all statements in <a href="#" class="term-service text-dark">Terms of service</a></label>
                            </div> -->

                            <div class="form-group">
                                <div id="html_element"></div>
                            </div>
                            
                            <div class="jms-login-message"></div>

                            <div class="col-md-12 d-flex justify-content-center">
                                <div class="jms-loader" id="jms_loading"></div>
                            </div>
                            
                            <div class="form-group form-button text-center">
                                <input type="submit" name="signup" id="signup" class="jms-form-submit" value="Register">
                            </div>
                            <input type="hidden" id="jms_pass_check" name="jms_pass_check">
                        </form>

                    </div>

                    <div class="col-lg-6 mt-5 d-flex align-items-center justify-content-center pb-5">
                        <img src="img/reg.png" class="img-fluid ">
                    </div>

                    <div id="jms_html"></div>
                </div>
            </div>
        </div>
        
        <?php include("footer.php"); ?>
        <script type="text/javascript" src="js/custome.js"></script>
        <script type="text/javascript" src="js/registration.js"></script>
        <script type="text/javascript">
            var onloadCallback = function() 
            {
                grecaptcha.render('html_element', 
                {
                    // 'sitekey' : '6LdM75QpAAAAAFlRofphJZgugZHL_yIUJ0qfUtLL'
                    'sitekey' : "<?php echo $jms_captcha_site_key; ?>"
                });
            };

            $(document).ready(function()
            {
                $("#jms_password").on('keyup', function()
                {
                    var jms_number = /([0-9])/;
                    var jms_alphabets = /([a-zA-Z])/;
                    var jms_special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;

                    if ($('#jms_password').val().length < 6) 
                    {
                        // $('#jms_password').removeClass();
                        // $('#jms_password').addClass('jms-weak-password');
                        // $('#jms_password').html("Weak");

                        $('#jms_pass_check').val("Weak");
                        $("#jms_span").text('Weak').css({'color':'red','font-weight':'bold'});

                        // $("#jms_password").css({'border':'1px solid red','border-right':'none',});
                        // $(".input-group-text").removeClass('jms-focus-input-pass').css({'border':'1px solid red','border-left':'none',});

                        if($('#jms_password').val().length == 0)
                        {
                            // $('#jms_password').html("");
                            $('#jms_pass_check').val("");
                            $("#jms_span").text("");

                            // $("#jms_password").css({'border':'1px solid #ced4da','border-right':'none'});
                            // $(".input-group-text").removeClass('jms-focus-input-pass').css({'border':'1px solid #ced4da','border-left':'none',});
                        }
                    } 
                    else 
                    {
                        if ($('#jms_password').val().match(jms_number) && $('#jms_password').val().match(jms_alphabets) && $('#jms_password').val().match(jms_special_characters)) 
                        {
                            // $('#jms_password').removeClass();
                            // $('#jms_password').addClass('jms-strong-password');
                            // $('#jms_password').html("Strong");
                            
                            $('#jms_pass_check').val("Strong");

                            // $("#jms_password").css({'border':'1px solid green','border-right':'none',});
                            // $(".input-group-text").removeClass('jms-focus-input-pass').css({'border':'1px solid green','border-left':'none',});

                            $("#jms_span").text('Strong').css({'color':'green','font-weight':'bold'});
                        } 
                        else 
                        {
                            // $('#jms_password').removeClass();
                            // $('#jms_password').addClass('jms-medium-password');
                            // $('#jms_password').html("Medium");

                            $('#jms_pass_check').val("Medium");
                            $("#jms_span").text('Medium').css({'color':'orange','font-weight':'bold'});

                            // $("#jms_password").css({'border':'1px solid orange','border-right':'none',});
                            // $(".input-group-text").removeClass('jms-focus-input-pass').css({'border':'1px solid orange','border-left':'none',});
                        }
                    }
                });
            });
        </script>
    </body>
</html>