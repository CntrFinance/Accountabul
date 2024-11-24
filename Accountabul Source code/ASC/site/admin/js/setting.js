function disablelog_inForm()
{
    var form = document.getElementById("jms_setting_form");
    var elements = form.elements;
    for (var i = 0, len = elements.length; i < len; ++i) {
        elements[i].disabled = true;
    }
}
function enablelog_inForm()
{
    var form = document.getElementById("jms_setting_form");
    var elements = form.elements;
    for (var i = 0, len = elements.length; i < len; ++i) {
        elements[i].disabled = false;
    }
}
function validationWarning_li()
{   
    $('#jms_deal_evalution_price').val() == "" ? $('#jms_deal_evalution_price').css('border-color','red') : $('#jms_deal_evalution_price').css('border-color','green');
    $('#jms_buy_and_hold_analysis_price').val() == "" ? $('#jms_buy_and_hold_analysis_price').css('border-color','red') : $('#jms_buy_and_hold_analysis_price').css('border-color','green');
}
function validatelog_inForm()
{   
    var jms_deal_evalution_price = $("#jms_deal_evalution_price").val();
    var jms_buy_and_hold_analysis_price = $("#jms_buy_and_hold_analysis_price").val();

    if(jms_deal_evalution_price  == "" || jms_buy_and_hold_analysis_price == "")
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
    $("#jms_setting_form").on('submit',(function(e) 
    { 
        e.preventDefault();
        disablelog_inForm();
        if(validatelog_inForm())
        {
            enablelog_inForm();
            $.ajax({
                url: "admin_data_file/get_setting_data.php",
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
                        $('.jms-setting-message').css('display', 'block');
                        $('.jms-setting-message').html("<div class='alert alert-danger mb-2' role='alert'>"+data.message+"</div>");
                    }
                    else if(data.status == 'success')
                    {
                        $('.jms-setting-message').css('display', 'block');
                        $('.jms-setting-message').html("<div class='alert alert-success mb-2' role='alert'>"+data.message+"</div>");
                        setTimeout(function(){ window.location = 'setting.php'; }, 3000);
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


