<!doctype html>
<html lang="en">
    <head>
        <?php include("header.php"); ?>

        <title>Login</title>

        <!-- Style css -->
        <link rel="stylesheet" type="text/css" href="css/style.css">

    </head>
    <body>
        <div class="container-fluid">
            <div class="row d-flex align-items-center jms-height">
                <div class="col-md-12">
                    <div class="row justify-content-md-center mt-3">
                        <div class=" col-xl-3 col-md-5">
                            <div class="card card-outline card-primary">
                                <div class="card-header text-center">
                                    <a class="h2"><b>Admin </b>Login</a>
                                </div>
                                <div class="card-body">
                                    <form class="jms-login-form" id="jms_login_form" name="jms_login_form">
                                        <div class="row">
                                            <!-- User Email id -->
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="jms_email_id">Email Address</label>
                                                    <input type="email" class="form-control" id="jms_email_id" name="jms_email_id" placeholder="Email">
                                                </div>
                                            </div>

                                            <!-- User Password -->
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="jms_password">Password</label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" id="jms_password" name="jms_password" placeholder="Password" required>
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-solid fa-eye-slash jms-pass-login" id="jms_password_icon_admin_login"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Message -->
                                        <div class="jms-login-message"></div>
                                        
                                        <div class="row">
                                            <div class="col-7 d-flex align-items-center">
                                                <p class="mb-0 jms-text-color">
                                                    <a href="forgot_password.php">I forgot my password</a>
                                                </p>
                                            </div>
                                            <div class="col-5">
                                                <button type="submit" class="btn btn-primary btn-block btn-primary">LogIn</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php include("footer.php"); ?> 
        <script type="text/javascript" src="../js/custome.js"></script>
        <script type="text/javascript" src="js/login.js"></script>
        <script type="text/javascript">
            $(document).ready(function()
            {
                $("#jms_password_icon_admin_login").on("click",function()
                {
                    jms_password_view_func('jms_password','#jms_password_icon_admin_login','.jms-pass-login');
                }); 
            });
        </script>
    </body>
</html>