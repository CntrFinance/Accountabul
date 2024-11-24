function jms_password_view_func(jms_pass_input,jms_icon_id,jms_class_name) 
{
    var x = document.getElementById(jms_pass_input);
    if (x.type === "password") 
    {
        x.type = "text";
        // $(jms_class_name).css({'color':'var(--color1)'});
        $(jms_icon_id).addClass('fa-eye').removeClass('fa-eye-slash');
    } 
    else 
    {
        x.type = "password";
        // $(jms_class_name).css({'color':'#495057'});
        $(jms_icon_id).addClass('fa-eye-slash').removeClass('fa-eye');
    }
} 

// signup page

$("#jms_password_icon_regi").on("click",function()
{
    jms_password_view_func('jms_password','.jms-password','.jms-pass-signup');
});
$("#jms_repeat_password_icon_regi").on("click",function()
{
    jms_password_view_func('jms_rep_pass','.jms-repeat-password','.jms-confirm-password-signup');
});


// login page

$("#jms_password_icon_login").on("click",function()
{
    jms_password_view_func('jms_password','.fa-regular','.jms-pass-login');
});

// forgot password page

$("#jms_password_icon_n_pw").on("click",function()
{
    jms_password_view_func('jms_change_n_pw','#jms_password_icon_n_pw','.jms-cursor-pointer-n-pw');
});

// change password -> current pass.

$("#jms_password_icon_1_cpw").on("click",function()
{
    jms_password_view_func('c_pw','#jms_password_icon_1_cpw','.jms-change-pass-1');
});

// change password -> new pass.

$("#jms_password_icon_2_cpw").on("click",function()
{
    jms_password_view_func('n_pw','#jms_password_icon_2_cpw','.jms-change-pass-2');
});

// change password -> confirm pass.

$("#jms_password_icon_3_cpw").on("click",function()
{
    jms_password_view_func('cn_pw','#jms_password_icon_3_cpw','.jms-change-pass-2');
}); 

//change forgot password

$("#jms_change_for_password_icon_1_cpw").on("click",function()
{
    jms_password_view_func('jms_change_n_pw','#jms_change_for_password_icon_1_cpw','.jms-change-for-pass-1');
}); 

$("#jms_change_for_password_icon_2_cn_pw").on("click",function()
{
    jms_password_view_func('jms_change_cn_pw','#jms_change_for_password_icon_2_cn_pw','.jms-change-for-pass-2');
}); 

$("#jms_password_icon_sigup_1").on("click",function()
{
    jms_password_view_func('jms_password','#jms_password_icon_sigup_1','.jms-password-signup');
}); 

$("#jms_cpassword_icon_sigup_2").on("click",function()
{
    jms_password_view_func('jms_c_password','#jms_cpassword_icon_sigup_2','.jms-cpassword-signup');
}); 



// user side change password

$("#jms_current_password_icon").on("click",function()
{
    jms_password_view_func('c_pw','.jms-c-password','.jms-c-password');
});
$("#jms_new_password_icon").on("click",function()
{
    jms_password_view_func('n_pw','.jms-n-password','.jms-n-password');
});
$("#jms_c_n_password_icon").on("click",function()
{
    jms_password_view_func('cn_pw','.jms-cn-password','.jms-cn-password');
});












// $('#jms_password').focusin(function()
// {
//     if($(this).length == 1)
//     {
//         $('.input-group-text').addClass('jms-focus-input-pass');    
//     }
// }); 

// $('#jms_password').focusout(function()
// {
//     if($(this).length == 1)
//     {
//         $('.input-group-text').removeClass('jms-focus-input-pass');    
//     }
// }); 

