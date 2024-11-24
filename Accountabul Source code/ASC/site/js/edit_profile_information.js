$(document).ready(function()
{
    $("#jms_loading").hide();

    function disablelog_inForm()
    {
        var form = document.getElementById("jms_edit_profile");
        var elements = form.elements;
        for (var i = 0, len = elements.length; i < len; ++i) {
            elements[i].disabled = true;
        }
    }
    function enablelog_inForm()
    {
        var form = document.getElementById("jms_edit_profile");
        var elements = form.elements;
        for (var i = 0, len = elements.length; i < len; ++i) {
            elements[i].disabled = false;
        }
    }
    function validationWarning_li()
    {   
        $('#jms_first_name').val() == "" ? $('#jms_first_name').css('border-color','red') : $('#jms_first_name').css('border-color','green');
        $('#jms_birthdate').val() == "" ? $('#jms_birthdate').css('border-color','red') : $('#jms_birthdate').css('border-color','green');
        $('#jms_last_name').val()  == "" ? $('#jms_last_name').css('border-color','red') : $('#jms_last_name').css('border-color','green');
        $('#jms_gender').val()  == "" ? $('#jms_gender').css('border-color','red') : $('#jms_gender').css('border-color','green');
        // $('#jms_logo_image').val()  == "" ? $('#jms_logo_image').css('border-color','red') : $('#jms_logo_image').css('border-color','green');
    }
    function validatelog_inForm()
    {   
        var jms_first_name = $('#jms_first_name').val();
        var jms_last_name = $('#jms_last_name').val();
        var jms_gender = $('#jms_gender').val();
        var jms_birthdate = $('#jms_birthdate').val();

        if( jms_first_name == "" || jms_birthdate == "" || jms_last_name == "" || jms_gender == "")
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

    $("#jms_edit_profile").on('submit',(function(e) 
    { 
        e.preventDefault();
        disablelog_inForm();
        if(validatelog_inForm())
        {
            enablelog_inForm();
            $.ajax({
                url: "user_data_file/edit_profile_information_data.php",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend : function()
                {
                    disablelog_inForm();
                    
                    $("#jms_loading").show();
                    setTimeout(function(){ $("#jms_loading").hide(); }, 3000);
                },
                success: function(data)
                {
                    enablelog_inForm();
                    if(data.status == 'error')
                    {
                        $("#jms_loading").hide();

                        $('.jms-profile-edit-message').css('display', 'block');
                        $('.jms-profile-edit-message').html("<div class='alert alert-danger mb-2' role='alert'>"+data.message+"</div>");
                    }
                    else if(data.status == 'success')
                    {
                        $("#jms_loading").hide();

                        $('.jms-profile-edit-message').css('display', 'block');
                        $('.jms-profile-edit-message').html("<div class='alert alert-success mb-2' role='alert'>"+data.message+"</div>");
                        setTimeout(function(){ window.location = 'profile.php'; }, 3000);
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