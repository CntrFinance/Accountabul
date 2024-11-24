<?php 
    include("connection.php");
    
    include("header.php"); 
    include('css/dynamicstyle.php');
?>  
<link rel="stylesheet" type="text/css" href="css/style.css">
<title>Change Forgot Password</title>

<style type="text/css">
     .jms-change-forgot-pass-container
    {
        position: relative;
        width: 400px;
        margin: 80px auto;
        padding: 40px 20px;
        text-align: center;
        background: #fff;
/*        border: 1px solid #ccc;*/
    }
    .jms-change-forgot-pass-container::before,.jms-change-forgot-pass-container::after
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
    .jms-change-forgot-pass-container::after
    {
        top: 5px;
        z-index: -2;
        -webkit-transform: rotateZ(-2deg);
        -moz-transform: rotateZ(-2deg);
        -ms-transform: rotateZ(-2deg);
    }
</style>

<div class="container-fluid">
    <div class="row justify-content-md-center mt-5">
        <div class="col-md-8">
            <div class="jms-change-forgot-pass-container">
                <form class="jms-verify-password-form" id="jms_verify_password_form" name="jms_verify_password_form">
                    <div class="form-group">
                        <label class="w-100 text-left" for="jms_change_n_pw">New Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="jms_change_n_pw" id="jms_change_n_pw" placeholder="New Password" required>                                    
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <i class="fa fa-solid fa-eye-slash jms-change-for-pass-1" id="jms_change_for_password_icon_1_cpw"></i>
                                </div>
                            </div>
                        </div>
                        <small class="form-text form-text d-flex justify-content-between">Note : Strong Password Required.<span id="jms_span"></span></small>
                    </div>
                    <div class="form-group">
                        <label class="w-100 text-left" for="jms_change_cn_pw">Confirm New Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="jms_change_cn_pw" id="jms_change_cn_pw" placeholder="Confirm New Password" required>                                  
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <i class="fa fa-solid fa-eye-slash jms-change-for-pass-2" id="jms_change_for_password_icon_2_cn_pw"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="jms_change_token_id" name="jms_change_token_id" value="<?php echo $_GET['t'];?>">
                    <input type="hidden" id="jms_password_n_pw_input" name="jms_password_n_pw_input">
                    
                    <div class="jms-change-forgot-message mb-2"></div>

                    <div class="row justify-content-center">
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary" id="jms_change_pass" name="jms_change_pass">Change Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("footer.php");?>
             
<script type="text/javascript" src="js/change_forgot_password.js"></script>
<script type="text/javascript" src="js/custome.js"></script>

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
                $('#jms_password_n_pw_input').val("Weak");
                $("#jms_span").text('Weak').css('color','red');

                if($('#jms_change_n_pw').val().length == 0)
                {
                    $('#jms_password_n_pw_input').val("");
                    $("#jms_span").text("");
                }
            } 
            else 
            {
                if ($('#jms_change_n_pw').val().match(jms_number) && $('#jms_change_n_pw').val().match(jms_alphabets) && $('#jms_change_n_pw').val().match(jms_special_characters)) 
                {
                    $('#jms_password_n_pw_input').val("Strong");
                    $("#jms_span").text('Strong').css('color','green');
                } 
                else 
                {
                    $('#jms_password_n_pw_input').val("Medium");
                    $("#jms_span").text('Medium').css('color','orange');
                }
            }
        });
    });
</script>