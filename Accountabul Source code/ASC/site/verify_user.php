<!doctype html>
<html lang="en">
    <head>
        <?php 
        	include("connection.php");
        	include("header.php"); 
        ?>
        <!-- Style css -->
        <link rel="stylesheet" type="text/css" href="css/form.css">
        
        <title>Email Verify</title>
        <style type="text/css">
            .jms-verify-container
            {
                font-family: var(--main-font);
            }
            .jms-verify-form
            {
                box-shadow: 0 15px 16.83px .17px rgba(0, 0, 0, .05) !important;
                border-radius: 20px !important;
                background: white;
            }
            .jms-img-logo
            {
                width: 150px;
                height: 150px;
            }
            a
            {
                text-decoration: none;
            }
            a:hover
            {
                color: white;
            }
        </style>
    </head>
    <body class="jms-bg">
        
        <?php include("navbar_top.php"); ?>
        
        <!-- login form -->

        <div class="container pt-5">
            <div class="jms-verify-container">
                <div class="row my-4 justify-content-center">
                    <div class="col-md-4">
                        <form class="jms-verify-form p-4" id="verify_check_form" name="verify_check_form">
                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <img src="img/right.png" class="jms-img-logo">
                                </div>
                                <div class="col-md-12 d-flex justify-content-center h3 text-center">Email is verified</div>
                                <div class="col-md-12 d-flex justify-content-center text-center my-2">
                                    <div class="jms-verify-message my-2"></div>
                                </div>
                                <input type="hidden" id="jms_token_id" name="jms_token_id" value="<?php echo $_GET['t'];?>">
                                <div class="col-12 d-flex justify-content-center">
                                    <a href='index.php' class="jms-form-submit">
                                        Login
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
       

        <?php include("footer.php"); ?>    
             
        <script type="text/javascript" src="js/custome.js"></script>

        <script type="text/javascript">
            $(document).ready(function()
            {
                function jms_verify_email()
                {
                	let jms_myform = document.getElementById("verify_check_form");
    				let jms_verify_form = new FormData(jms_myform);
                	$.ajax({
	                    url: "user_data_file/verify_user_mail.php",
	                    type: "POST",
	                    data:  jms_verify_form,
	                    contentType: false,
	                    cache: false,
	                    processData:false,
	                    beforeSend : function()
	                    {
	                    },
	                    success: function(data)
	                    {
	                        if(data.status == 'error')
	                        {
	                            $('.jms-verify-message').css('display', 'block');
	                            $('.jms-verify-message').html("<div class='' role='alert'>"+data.message+"</div>");
	                        }
	                        else if(data.status == 'success')
	                        {
	                            $('.jms-verify-message').css('display', 'block');
	                            $('.jms-verify-message').html("<div class='' role='alert'>"+data.message+"</div>");
	                        }
	                    }
	                });
                }
                jms_verify_email();
            });
        </script>

    </body>
</html>