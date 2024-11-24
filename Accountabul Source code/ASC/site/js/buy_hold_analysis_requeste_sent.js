// Request sent 

$("#jms_request_sent_btn").on("click",function()
{
    var jms_formData_sent_request = new FormData();
    jms_formData_sent_request.append("jms_user_id",$("#jms_user_id").val());

    $.ajax({
        url: "user_data_file/user_sent_request.php",
        type: "POST",
        data:  jms_formData_sent_request,
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
                $('.jms-message').css('display', 'block');
                $('.jms-message').html("<div class='alert alert-danger mb-2' role='alert'>"+data.message+"</div>");
            }
            else if(data.status == 'success')
            {
                $('.jms-message').css('display', 'block');
                $('.jms-message').html("<div class='alert alert-success mb-2' role='alert'>"+data.message+"</div>");
                setTimeout(function(){ window.location = 'buy_and_hold_analysis.php'; }, 3000);
            }
        },
        error: function(e)
        {
        }
    });
});