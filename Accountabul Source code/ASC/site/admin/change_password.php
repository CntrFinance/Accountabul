<?php
    include("../connection.php");

    if(!isset($_SESSION['jms_admin_user_id']))
    {
        header("location:index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("header.php"); ?>

    <title>Change Password</title>

    <!-- css link -->
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <style type="text/css">
        .card-header
            {
                background-color: var(--white) !important;
            }
            .card-footer
            {
                background-color: var(--white) !important;
                border-top:1px solid rgba(0,0,0,.125) !important;
            }
            .card-footer:last-child
            {
                border-radius:  0 0 10px 10px !important;
            }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">

<?php include("menu.php"); ?>

<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
                <!-- left column -->
                <div class="col-md-12 mt-5">
                    <div class="card card-outline card-primary">
                        <div class="card-header text-center">
                            <h3 class="card-title">Change Password</h3>
                        </div>
                        <form class="jms-change-password-form" id="jms_change_password_form" name="jms_change_password_form">

                            <!-- Message -->
                            <div class="jms-login-message"></div>

                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-md-10">
                                        <div class="border rounded p-3">
                                            <div class="form-group">
                                                <label for="o_pw">Current Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" name="c_pw" id="c_pw" placeholder="Current Password" required>
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <i class="fa fa-solid fa-eye-slash jms-change-pass-1" id="jms_password_icon_1_cpw"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="n_pw">New Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" name="n_pw" id="n_pw" placeholder="New password" required>                                    
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <i class="fa fa-solid fa-eye-slash jms-change-pass-2" id="jms_password_icon_2_cpw"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <small class="form-text form-text d-flex justify-content-between">Note: Strong password required.<span id="jms_span"></span></small>
                                            </div>
                                            <div class="form-group">
                                                <label for="cn_pw">Confirm New Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" name="cn_pw" id="cn_pw" placeholder="Confirm New Password" required>                                  
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <i class="fa fa-solid fa-eye-slash jms-change-pass-3" id="jms_password_icon_3_cpw"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                        <!-- Maessage -->
                                        
                                        <div class="jms-change-pass mt-2"></div> 
                                    </div>
                                </div>                          
                            </div>

                            <!-- Hidden input -->

                            <input type="hidden" id="jms_pass_check" name="jms_pass_check">

                            <!-- /.card-body -->
                            <div class="card-footer d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?> 
<script type="text/javascript" src="../js/custome.js"></script>
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
                // $('#n_pw').removeClass();
                // $('#n_pw').addClass('jms-weak-password');
                // $('#n_pw').html("Weak");

                $('#jms_pass_check').val("Weak");
                $("#jms_span").text('Weak').css('color','red');

                // $("#n_pw").css({'border':'1px solid red','border-right':'none',});
                // $(".input-group-text").removeClass('jms-focus-input-pass').css({'border':'1px solid red','border-left':'none',});

                if($('#n_pw').val().length == 0)
                {
                    // $('#n_pw').html("");
                    $('#jms_pass_check').val("");
                    $("#jms_span").text("");

                    // $("#n_pw").css({'border':'1px solid #ced4da','border-right':'none'});
                    // $(".input-group-text").removeClass('jms-focus-input-pass').css({'border':'1px solid #ced4da','border-left':'none',});
                }
            } 
            else 
            {
                if ($('#n_pw').val().match(jms_number) && $('#n_pw').val().match(jms_alphabets) && $('#n_pw').val().match(jms_special_characters)) 
                {
                    // $('#n_pw').removeClass();
                    // $('#n_pw').addClass('jms-strong-password');
                    // $('#n_pw').html("Strong");
                    
                    $('#jms_pass_check').val("Strong");

                    // $("#n_pw").css({'border':'1px solid green','border-right':'none',});
                    // $(".input-group-text").removeClass('jms-focus-input-pass').css({'border':'1px solid green','border-left':'none',});

                    $("#jms_span").text('Strong').css('color','green');
                } 
                else 
                {
                    // $('#n_pw').removeClass();
                    // $('#n_pw').addClass('jms-medium-password');
                    // $('#n_pw').html("Medium");

                    $('#jms_pass_check').val("Medium");
                    $("#jms_span").text('Medium').css('color','orange');

                    // $("#n_pw").css({'border':'1px solid orange','border-right':'none',});
                    // $(".input-group-text").removeClass('jms-focus-input-pass').css({'border':'1px solid orange','border-left':'none',});
                }
            }
        });
    });
</script>
</body>
</html>