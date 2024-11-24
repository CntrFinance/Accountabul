$(document).ready(function()
{
    $('#jms_payment_next_btn').on("click",function()
    {
        var jms_payment_selected = $('input[name="jms_payment_selected"]:checked').val();
        
        if(jms_payment_selected) 
        {
            if(jms_payment_selected == 'paypal')
            {
                window.location.href = "payapal_payment_form.php";
            }
            else
            {
                window.location.href = "stripe_payment_form.php";
            }
        } 
        else 
        {
            $('.jms-message').css('display', 'block');
            $('.jms-message').html("<div class='alert alert-danger mb-2' role='alert'>Select payment method</div>");
            setTimeout(function(){ window.location = 'subscription.php'; }, 3000);
        }
    });
});