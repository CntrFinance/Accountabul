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

        <title>Buy and Hold Calculator</title>

        <!-- Style css -->
        <link rel="stylesheet" type="text/css" href="css/form.css">
        <link rel="stylesheet" type="text/css" href="css/loading.css">

    </head>
    <body class="jms-bg">
        <?php include("navbar_top.php");?>
        <div class="container">
            <div class="jms-container my-5 mx-lg-5 mx-md-5 px-lg-5">
                <div class="row mt-3 d-flex align-items-center">
                    <div class="col-lg-6 mt-5 d-flex align-items-center justify-content-center pb-5">
                        <img src="img/login.jpg" class="img-fluid ">
                    </div>
                    <div class="col-lg-6 mt-5 pb-5 px-lg-5 px-md-5 px-sm-3 px-4">
                        <div class="jms-h2">Login</div>
                        <form class="mt-4" id="jms_login_form" name="jms_login_form">
                            <div class="form-group">
                                <label for="email" class="jms-label">
                                    <i class="fa-solid fa-envelope"></i>
                                </label>
                                <input class="jms-form-input" type="email" name="jms_email_id" id="jms_email_id"
                                    placeholder="Email Address" required>
                            </div>
                            <div class="form-group">
                                <label for="jms_password" class="jms-label">
                                    <i class="fa-solid fa-lock"></i>
                                </label>
                                <input class="jms-form-input" type="password" name="jms_password" id="jms_password"
                                    placeholder="Password" required>
                                <label for="jms_password" class="jms-label-view" id="jms_password_icon_login">
                                    <i class="fa-regular fa-eye-slash"></i>
                                    <!-- <i class="fa-regular fa-eye-slash"></i> -->
                                </label>
                            </div>
                            <div class="form-group">
                                <div id="html_element"></div>
                            </div>
                            
                            <div class="jms-login-message"></div>

                            <div class="col-md-12 d-flex justify-content-center">
                                <div class="jms-loader" id="jms_loading"></div>
                            </div>

                            <div class="form-group form-button text-center">
                                <input type="submit" name="login" id="signup" class="jms-form-submit" value="Login">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <?php include("footer.php"); ?>
    
    
    <script type="text/javascript" src="js/custome.js"></script>
    <script type="text/javascript" src="js/login.js"></script>
    <script type="text/javascript">
        var onloadCallback = function() 
        {
            grecaptcha.render('html_element', 
            {
                // 'sitekey' : '6LdM75QpAAAAAFlRofphJZgugZHL_yIUJ0qfUtLL'
                'sitekey' : "<?php echo $jms_captcha_site_key; ?>"
            });
        };
    </script>
    </body>
</html>