function disablelog_inForm()
{
    var form = document.getElementById("jms_login_form");
    var elements = form.elements;
    for (var i = 0, len = elements.length; i < len; ++i) {
        elements[i].disabled = true;
    }
}
function enablelog_inForm()
{
    var form = document.getElementById("jms_login_form");
    var elements = form.elements;
    for (var i = 0, len = elements.length; i < len; ++i) {
        elements[i].disabled = false;
    }
}
function validationWarning_li()
{   
    $('#jms_email_id').val() == "" ? $('#jms_email_id').css('border-color','red') : $('#jms_email_id').css('border-color','green');
    $('#jms_password').val()  == "" ? $('#jms_password').css('border-color','red') : $('#jms_password').css('border-color','green');
}
function validatelog_inForm()
{   
    var jms_email_id = $('#jms_email_id').val();
    var jms_password = $('#jms_password').val();

    if( jms_email_id == "" || jms_password == "")
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
    $("#jms_login_form").on('submit',(function(e) 
    { 
        e.preventDefault();
        disablelog_inForm();
        if(validatelog_inForm())
        {
            enablelog_inForm();
            $.ajax({
                url: "get_login.php",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend : function()
                {
                    disablelog_inForm();
                },
                success: function(data)
                {
                    enablelog_inForm();
                    if(data.status == 'error')
                    {
                        $('.jms-login-message').css('display', 'block');
                        $('.jms-login-message').html("<div class='alert alert-danger mb-2' role='alert'>"+data.message+"</div>");
                    }
                    else if(data.status == 'success')
                    {
                        $('.jms-login-message').css('display', 'block');
                        $('.jms-login-message').html("<div class='alert alert-success mb-2' role='alert'>"+data.message+"</div>");
                        setTimeout(function(){ window.location = 'requested.php'; }, 3000);
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
    }));
});


