<!doctype html>
<html lang="en">
    <head>
        <?php include("header.php"); ?>

        <title>Forgot Password</title>

        <!-- Style css -->
        <link rel="stylesheet" type="text/css" href="css/style.css">

    </head> 
    <body>

        <div class="container-fluid">
            <div class="row d-flex align-items-center jms-height">
                <div class="col-md-12">
                    <div class="row justify-content-md-center mt-5">
                        <div class="col-md-4">
                            <div class="card card-outline card-primary">
                                <div class="card-header text-center">
                                    <a href="" class="h2"><b>Forgot </b>Password</a>
                                </div>
                                <div class="card-body">
                                    <form class="jms-forgot-pass-form" id="forgot_password_form" name="forgot_password_form">
                                        <div class="mb-3">
                                            <input type="email" class="form-control" id="jms_email_id" name="jms_email_id" placeholder="Email">
                                        </div>
                                        <div class="jms-forgotpass-message my-2"></div>
                                        <div class="row">
                                            <div class="col-7">
                                                <button type="submit" class="btn btn-primary btn-block">Request new password</button>
                                            </div>
                                            <div class="col-5">
                                                <a href="index.php">
                                                    <button type="button" class="btn btn-primary btn-block">Login</button>
                                                </a>    
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include("footer.php"); ?>

        <script type="text/javascript" src="js/forgot_password.js"></script>
    </body>
</html>