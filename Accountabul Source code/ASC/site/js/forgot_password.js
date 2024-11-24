function disable_forgot_password_Form()
{
    var form = document.getElementById("forgot_password_form");
    var elements = form.elements;
    for (var i = 0, len = elements.length; i < len; ++i) {
        elements[i].disabled = true;
    }
}
function enable_forgot_password_Form()
{
    var form = document.getElementById("forgot_password_form");
    var elements = form.elements;
    for (var i = 0, len = elements.length; i < len; ++i) {
        elements[i].disabled = false;
    }
}
function validationWarning_li()
{   
    $('#jms_email_id').val() == "" ? $('#jms_email_id').css('border-color','red') : $('#jms_email_id').css('border-color','green');    
}
function validate_forgot_password_Form()
{
    var jms_email_id = $('#jms_email_id').val();
    
    if( jms_email_id == "")
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
    $("#forgot_password_form").on('submit',(function(e) 
    {
        e.preventDefault();
        disable_forgot_password_Form();
        if(validate_forgot_password_Form())
        {
            enable_forgot_password_Form();
            $.ajax({
                url: "send_forgot_password.php",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend : function()
                {
                    disable_forgot_password_Form();
                },
                success: function(data)
                {
                    enable_forgot_password_Form();
                    if(data.status == 'error')
                    {
                        $('.jms-forgotpass-message').css('display', 'block');
                        $('.jms-forgotpass-message').html("<div class='alert alert-danger mb-0' role='alert'>"+data.message+"</div>");
                    }
                    else if(data.status == 'success')
                    {
                        $('.jms-forgotpass-message').css('display', 'block');
                        $('.jms-forgotpass-message').html("<div class='alert alert-success mb-0' role='alert'>"+data.message+"</div>");
                        // setTimeout(function(){ window.location = 'index.php'; }, 3000);
                    }
                },
                error: function(e)
                {
                    enable_forgot_password_Form();
                }
            });
        }
        else
        {
            enable_forgot_password_Form();
        }
    }));
});


