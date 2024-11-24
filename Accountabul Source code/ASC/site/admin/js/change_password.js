function disable_change_password_Form()
{
    var form = document.getElementById("jms_change_password_form");
    var elements = form.elements;
    for (var i = 0, len = elements.length; i < len; ++i) {
        elements[i].disabled = true;
    }
}
function enable_change_password_Form()
{
    var form = document.getElementById("jms_change_password_form");
    var elements = form.elements;
    for (var i = 0, len = elements.length; i < len; ++i) {
        elements[i].disabled = false;
    }
}
function validationWarning()
{
    $('#c_pw').val() == "" ? $('#c_pw').css('border-color','red') : $('#c_pw').css('border-color','green');
    $('#n_pw').val()  == "" ? $('#n_pw').css('border-color','red') : $('#n_pw').css('border-color','green');
    $('#cn_pw').val() == "" ? $('#cn_pw').css('border-color','red') : $('#cn_pw').css('border-color','green');
}
function validate_change_password_Form()
{
    var c_pw = $('#c_pw').val();
    var n_pw = $('#n_pw').val();
    var cn_pw = $('#cn_pw').val();
    
    if( c_pw == "" || n_pw == "" || cn_pw == "" )
    {
        validationWarning();
        return false;
    }
    else
    {
        validationWarning();
        return true;
    }
}
$(document).ready(function (e) {

    $("#jms_change_password_form").on('submit',(function(e) 
    {
        e.preventDefault();
        
        if($("#jms_pass_check").val() == "Strong")
        {
            disable_change_password_Form();
            if(validate_change_password_Form())
            {
                enable_change_password_Form();
                $.ajax({
                    url: "admin_data_file/c_password.php",
                    type: "POST",
                    data:  new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend : function()
                    {
                        disable_change_password_Form();
                    },
                    success: function(data)
                    {
                        enable_change_password_Form();
                        if(data.status == 'error')
                        {
                            $('.jms-change-pass').css('display', 'block');
                            $('.jms-change-pass').html("<div class='alert alert-danger mb-0' role='alert'>"+data.message+"</div>");
                        }
                        else if(data.status == 'success')
                        {
                            $('.jms-change-pass').css('display', 'block');
                            $('.jms-change-pass').html("<div class='alert alert-success mb-0' role='alert'>"+data.message+"</div>");
                            setTimeout(function(){ window.location = 'logout.php'; }, 3000);
                        }
                    },
                    error: function(e)
                    {
                        enable_change_password_Form();
                    }
                });
            }
            else
            {
                enable_change_password_Form();
            }
        }
        else
        {
            $('.jms-change-pass').css('display', 'block');
            $('.jms-change-pass').html("<div class='alert alert-danger mb-0' role='alert'>Please Enter Strong Password!</div>");
        }
    }));
});


