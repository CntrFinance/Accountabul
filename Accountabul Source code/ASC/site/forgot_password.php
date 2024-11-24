<?php 
    include('connection.php'); 
    include('header.php'); 
    include('css/dynamicstyle.php');     
?>

<title>Forgot Password</title>

<!-- Style css -->
<link rel="stylesheet" type="text/css" href="css/style.css">
<style type="text/css">
     .jms-forgot-pass-container
    {
        position: relative;
        width: 400px;
        margin: 80px auto;
        padding: 40px 20px;
        text-align: center;
        background: #fff;
/*        border: 1px solid #ccc;*/
    }
    .jms-forgot-pass-container::before,.jms-forgot-pass-container::after
    {
        content: "";
        position: absolute;
        width: 100%;height: 100%;
        top: 3.5px;left: 0;
        z-index: -1;
        -webkit-transform: rotateZ(4deg);
        -moz-transform: rotateZ(4deg);
        -ms-transform: rotateZ(4deg);
/*        border: 1px solid #ccc;*/
    }
    .jms-forgot-pass-container::after
    {
        top: 5px;
        z-index: -2;
        -webkit-transform: rotateZ(-2deg);
        -moz-transform: rotateZ(-2deg);
        -ms-transform: rotateZ(-2deg);
    }
</style>

<?php include('navbar_top.php');?>

<div class="container-fluid">
    <div class="row d-flex align-items-center jms-height">
        <div class="col-md-12">
            <div class="jms-forgot-pass-container">
                <form class="" id="forgot_password_form" name="forgot_password_form">
                    <div class="row">
                        <!-- User Email id -->
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="jms_email_id" class="w-100 text-left">E-Mail-Adresse</label>
                                <input type="email" class="form-control" id="jms_email_id" name="jms_email_id" placeholder="E-Mail-Adresse" required>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Message -->
                    <div class="jms-forgotpass-message mb-2"></div>
                    
                    <div class="row">
                        <div class="col-8">
                            <button type="submit" class="btn btn-primary btn-block">Fordere ein neues Passwort an</button>
                        </div>
                        <div class="col-4">
                            <a href="login.php">
                                <button type="button" class="btn btn-primary btn-block">Anmeldung</button>
                            </a>    
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>

<script type="text/javascript" src="js/forgot_password.js"></script>