function disablelog_inForm()
{
    var form = document.getElementById("jms_verify_password_form");
    var elements = form.elements;
    for (var i = 0, len = elements.length; i < len; ++i) {
        elements[i].disabled = true;
    }
}
function enablelog_inForm()
{
    var form = document.getElementById("jms_verify_password_form");
    var elements = form.elements;
    for (var i = 0, len = elements.length; i < len; ++i) {
        elements[i].disabled = false;
    }
}
function validationWarning_li()
{   
    $('#jms_change_n_pw').val() == "" ? $('#jms_change_n_pw').css('border-color','red') : $('#jms_change_n_pw').css('border-color','green');
    $('#jms_change_cn_pw').val()  == "" ? $('#jms_change_cn_pw').css('border-color','red') : $('#jms_change_cn_pw').css('border-color','green');
}
function validatelog_inForm()
{   
    var jms_change_n_pw = $('#jms_change_n_pw').val();
    var jms_change_cn_pw = $('#jms_change_cn_pw').val();

    if( jms_change_n_pw == "" || jms_change_cn_pw == "")
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
    $("#jms_verify_password_form").on('submit',(function(e) 
    { 
        e.preventDefault();
        disablelog_inForm();
        if(validatelog_inForm())
        {
            enablelog_inForm();
            $.ajax({
                url: "change_forgot_password_data.php",
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
                        $('.jms-class-none').css('display','none');
                        $('.jms-change-forgot-message').css('display', 'block');
                        $('.jms-change-forgot-message').html("<div class='alert alert-danger mb-0' role='alert'>"+data.message+"</div>");
                    }
                    else if(data.status == 'success')
                    {
                        $('.jms-class-none').css('display','none');
                        $('.jms-change-forgot-message').css('display', 'block');
                        $('.jms-change-forgot-message').html("<div class='alert alert-success mb-0' role='alert'>"+data.message+"</div>");
                        setTimeout(function(){ window.location = 'login.php'; }, 3000);
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


