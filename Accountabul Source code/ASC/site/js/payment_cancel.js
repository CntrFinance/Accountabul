$(document).ready(function()
{
    $("#jms_loading").hide();

	// paypal cancel

	$(".jms-btn-cancel-paypal").on("click",function()
	{	
        var parentElement = $(this).parent();
        var jms_subscription_id = parentElement.find("#jms_subscription_id").text();
        var jms_purchase_name = parentElement.find("#jms_purchase_name").val();
        var jms_record_id = parentElement.find("#jms_record_id").val();

        var jms_formData = new FormData();
        jms_formData.append('jms_subscription_id',jms_subscription_id);
        jms_formData.append('jms_purchase_name',jms_purchase_name);
        jms_formData.append('jms_record_id',jms_record_id);

        var conf = confirm("Do you want to cancel?");
        if(conf == true)
        {
            $(this).prop('disabled', true);

            $.ajax({
                url: "user_data_file/cancel_payment_paypal.php",
                type: "POST",
                data:  jms_formData,
                contentType: false,
                cache: false,
                processData:false,
                beforeSend : function()
                {
                    $("#jms_loading").show();
                    setTimeout(function(){ $("#jms_loading").hide(); }, 3000);
                },
                success: function(data)
                {
                    var messageElement = parentElement.find(".jms-message");
                    if(data.status == 'error')
                    {
                        $("#jms_loading").hide();

                        messageElement.css('display', 'block');
                        messageElement.html("<div class='alert alert-danger mb-2' role='alert'>"+data.message+"</div>");
                    }
                    else if(data.status == 'success')
                    {
                        $("#jms_loading").hide();

                        messageElement.css('display', 'block');
                        messageElement.html("<div class='alert alert-success mb-2' role='alert'>"+data.message+"</div>");
                        setTimeout(function(){ window.location = 'profile.php'; }, 3000);
                    }
                }
            });
        }
	});

	// stripe cancel

	$(".jms-btn-cancel-stripe").on("click",function()
	{	
        var parentElement = $(this).parent();
        var jms_subscription_id = parentElement.find("#jms_subscription_id").text();
        var jms_purchase_name1 = parentElement.find("#jms_purchase_name1").val();

		var jms_formData = new FormData();
		jms_formData.append('jms_subscription_id',jms_subscription_id);
        jms_formData.append('jms_purchase_name1',jms_purchase_name1);

		var conf = confirm("Do you want to cancel?");
        if(conf == true)
        {
            $(this).prop('disabled', true);
             
            $.ajax({
                url: "user_data_file/cancel_payment_stripe.php",
                type: "POST",
                data:  jms_formData,
                contentType: false,
                cache: false,
                processData:false,
                beforeSend : function()
                {
                    $("#jms_loading").show();
                    setTimeout(function(){ $("#jms_loading").hide(); }, 3000);
                },
                success: function(data)
                {
                    var messageElement = parentElement.find(".jms-message");

                    if(data.status == 'error')
                    {
                        $("#jms_loading").hide();

                        messageElement.css('display', 'block');
                        messageElement.html("<div class='alert alert-danger mb-2' role='alert'>"+data.message+"</div>");
                    }
                    else if(data.status == 'success')
                    {
                        $("#jms_loading").hide();

                        messageElement.css('display', 'block');
                        messageElement.html("<div class='alert alert-success mb-2' role='alert'>"+data.message+"</div>");
                        setTimeout(function(){ window.location = 'profile.php'; }, 3000);
                    }
                }
            });
        }
	});
});