
$("#jms_loading").hide();

function disablelog_inForm()
{
    var form = document.getElementById("jms_registration_from");
    var elements = form.elements;
    for (var i = 0, len = elements.length; i < len; ++i) {
        elements[i].disabled = true;
    }
}
function enablelog_inForm()
{
    var form = document.getElementById("jms_registration_from");
    var elements = form.elements;
    for (var i = 0, len = elements.length; i < len; ++i) {
        elements[i].disabled = false;
    }
}
function validationWarning_li()
{   
    $('#jms_first_name').val() == "" ? $('#jms_first_name').css('border-color','red') : $('#jms_first_name').css('border-color','green');
    $('#jms_last_name').val() == "" ? $('#jms_last_name').css('border-color','red') : $('#jms_last_name').css('border-color','green');
    $('#jms_email_id').val() == "" ? $('#jms_email_id').css('border-color','red') : $('#jms_email_id').css('border-color','green');
    $('#jms_password').val() == "" ? $('#jms_password').css('border-color','red') : $('#jms_password').css('border-color','green');
    $('#jms_gender').val() == "" ? $('#jms_gender').css('border-color','red') : $('#jms_gender').css('border-color','green');
    $('#jms_rep_pass').val() == "" ? $('#jms_rep_pass').css('border-color','red') : $('#jms_rep_pass').css('border-color','green');
    $('#jms_birthdate').val() == "" ? $('#jms_birthdate').css('border-color','red') : $('#jms_birthdate').css('border-color','green');
}
function validatelog_inForm()
{   
    var jms_first_name = $("#jms_first_name").val();
    var jms_last_name = $("#jms_last_name").val();
    var jms_email_id = $("#jms_email_id").val();
    var jms_password = $("#jms_password").val();
    var jms_gender = $("#jms_gender").val();
    var jms_rep_pass = $("#jms_rep_pass").val();
    var jms_birthdate = $("#jms_birthdate").val();

    if(jms_birthdate == "" || jms_first_name == "" || jms_last_name == "" || jms_email_id == "" || jms_password == "" || jms_gender == "" || jms_rep_pass == "")
    {
        validationWarning_li();
        return false;
    }
    else
    {
        validationWarning_li();
        return true;
    }
}

$(document).ready(function (e) 
{ 
    $("#jms_registration_from").on('submit',(function(e) 
    { 
        e.preventDefault();
        
        var jms_email_id = $('#jms_email_id').val();
        var validRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        
        if(jms_email_id.match(validRegex))
        {
            disablelog_inForm();
            if(validatelog_inForm())
            {
                enablelog_inForm();

                $.ajax({
                    url: "user_data_file/registration_data.php",
                    type: "POST",
                    data:  new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend : function()
                    {
                        disablelog_inForm();

                        $("input[type=submit]").prop('disabled', true);

                        $("#jms_loading").show();
                        setTimeout(function(){ $("#jms_loading").hide(); }, 3000);
                    },
                    success: function(data)
                    {
                        enablelog_inForm();
                        if(data.status == 'error')
                        {
                            $("#jms_loading").hide();

                            $('.jms-login-message').css('display', 'block');
                            $('.jms-login-message').html("<div class='alert alert-danger mb-2' role='alert'>"+data.message+"</div>");
                            grecaptcha.reset();
                        }
                        else if(data.status == 'success')
                        {
                            $("#jms_loading").hide();

                            $('.jms-login-message').css('display', 'block');
                            $('.jms-login-message').html("<div class='alert alert-success mb-2' role='alert'>"+data.message+"</div>");
                            setTimeout(function(){ window.location = 'index.php'; }, 3000);
                        }
                    },
                    error: function(e)
                    {
                        enablelog_inForm();
                    }
                });
            }
            else
            {
                enablelog_inForm();
            }
        }
        else
        {
            $('.jms-login-message').css('display', 'block');
            $('.jms-login-message').html("<div class='alert alert-danger' role='alert'>Please Email id Proper enter!</div>"); 
        }
    }));
});


