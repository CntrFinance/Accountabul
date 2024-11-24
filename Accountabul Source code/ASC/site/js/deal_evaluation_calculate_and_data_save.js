$(document).ready(function()
{
    $("#jms_loading").hide();

    function numberWithCommas(x) 
    {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    
    /* Input Mask Include */

    $("input[type=text]").not('#jms_name').inputmask('decimal', {
        'alias': 'decimal',
        rightAlign: true,
        'groupSeparator': '.',
        'autoGroup': true
    });

    // all id get in input create array

    var jms_all_input_id = $('input[type=text],input[type=number]').map(function() 
    {
        return this.id;
    }).get();

    var jms_input_ids_array = [];
    
    for (var i = 0; i < jms_all_input_id.length; i++) 
    {
        jms_input_ids_array.push(jms_all_input_id[i]);
    }

    $("#jms_down_payment_percentage").on("input",function()
    {
        var jms_property_cost = parseFloat($("#jms_property_cost").val() == "" ? 0 : $("#jms_property_cost").val().replace(/,+/g,''))
        var jms_down_payment = parseFloat($("#jms_down_payment").val() == "" ? 0 : $("#jms_down_payment").val().replace(/,+/g,''))

        var a = (jms_property_cost * ($(this).val() / 100));
        $("#jms_down_payment").val(a.toFixed(0));

    });

    $("#jms_down_payment").on("input",function()
    {
        var jms_property_cost = parseFloat($("#jms_property_cost").val() == "" ? 0 : $("#jms_property_cost").val().replace(/,+/g,''))
        var jms_down_payment = parseFloat($(this).val() == "" ? 0 : $(this).val().replace(/,+/g,''))

        var a = (jms_down_payment / jms_property_cost) * 100;
        $("#jms_down_payment_percentage").val(a.toFixed(2));
    });

    $("#jms_property_cost").on("keyup",function()
    {
        var jms_property_cost = parseFloat($("#jms_property_cost").val() == "" ? 0 : $("#jms_property_cost").val().replace(/,+/g,''))
        var jms_down_payment = parseFloat($("#jms_down_payment").val() == "" ? 0 : $("#jms_down_payment").val().replace(/,+/g,''))
        var jms_down_payment_percentage = parseFloat($("#jms_down_payment_percentage").val() == "" ? 0 : $("#jms_down_payment_percentage").val().replace(/,+/g,''))

        if(jms_down_payment_percentage != 0 && jms_property_cost != 0)
        {
            var a = (jms_property_cost * (jms_down_payment_percentage/ 100));
            var b = (a / jms_property_cost) * 100;

            $("#jms_down_payment").val(a.toFixed(0));
            $("#jms_down_payment_percentage").val(b.toFixed(2));
        }
        else if(jms_property_cost == 0)
        {
            $("#jms_down_payment").val("");
            $("#jms_down_payment_percentage").val("");
        }
    });

    // calulation on keyup

    function jms_deal_calc_function_ajax()
    {
        var jms_formData = new FormData();
        
        jms_formData.append("jms_property_cost",parseFloat($("#jms_property_cost").val() == "" ? 0 : $("#jms_property_cost").val().replace(/,+/g,'')));
        jms_formData.append("jms_down_payment_percentage",parseFloat($("#jms_down_payment_percentage").val() == "" ? 0 : $("#jms_down_payment_percentage").val().replace(/,+/g,'')));
        
        jms_formData.append("jms_down_payment",parseFloat($("#jms_down_payment").val() == "" ? 0 : $("#jms_down_payment").val().replace(/,+/g,'')));
        jms_formData.append("jms_closing_percentage",parseFloat($("#jms_closing_percentage").val() == "" ? 0 : $("#jms_closing_percentage").val().replace(/,+/g,'')));

        jms_formData.append("jms_residential_appraisal",parseFloat($("#jms_residential_appraisal").val() == "" ? 0 : $("#jms_residential_appraisal").val().replace(/,+/g,'')));
        jms_formData.append("jms_inspection",parseFloat($("#jms_inspection").val() == "" ? 0 : $("#jms_inspection").val().replace(/,+/g,'')));
        
        jms_formData.append("jms_annual_interest_rate",parseFloat($("#jms_annual_interest_rate").val() == "" ? 0 : $("#jms_annual_interest_rate").val().replace(/,+/g,'')));
        jms_formData.append("jms_number_of_years",parseFloat($("#jms_number_of_years").val() == "" ? 0 : $("#jms_number_of_years").val().replace(/,+/g,'')));
        
        jms_formData.append("jms_card_annual_apr",parseFloat($("#jms_card_annual_apr").val() == "" ? 0 : $("#jms_card_annual_apr").val().replace(/,+/g,'')));
        
        jms_formData.append("jms_repairs_annually",parseFloat($("#jms_repairs_annually").val() == "" ? 0 : $("#jms_repairs_annually").val().replace(/,+/g,'')));
        
        jms_formData.append("jms_utilities",parseFloat($("#jms_utilities").val() == "" ? 0 : $("#jms_utilities").val().replace(/,+/g,'')));
        
        jms_formData.append("jms_home_warranty",parseFloat($("#jms_home_warranty").val() == "" ? 0 : $("#jms_home_warranty").val().replace(/,+/g,'')));
        jms_formData.append("jms_trash_removal",parseFloat($("#jms_trash_removal").val() == "" ? 0 : $("#jms_trash_removal").val().replace(/,+/g,'')));
        jms_formData.append("jms_landscaping",parseFloat($("#jms_landscaping").val() == "" ? 0 : $("#jms_landscaping").val().replace(/,+/g,'')));
        jms_formData.append("jms_property_management",parseFloat($("#jms_property_management").val() == "" ? 0 : $("#jms_property_management").val().replace(/,+/g,'')));
        jms_formData.append("jms_property_taxes",parseFloat($("#jms_property_taxes").val() == "" ? 0 : $("#jms_property_taxes").val().replace(/,+/g,'')));
        jms_formData.append("jms_home_owners_insurance",parseFloat($("#jms_home_owners_insurance").val() == "" ? 0 : $("#jms_home_owners_insurance").val().replace(/,+/g,'')));
        jms_formData.append("jms_cap_ex",parseFloat($("#jms_cap_ex").val() == "" ? 0 : $("#jms_cap_ex").val().replace(/,+/g,'')));
        jms_formData.append("jms_raw_expenses_total",parseFloat($("#jms_raw_expenses_total").val() == "" ? 0 : $("#jms_raw_expenses_total").val().replace(/,+/g,'')));
        
        jms_formData.append("jms_total_units",parseFloat($("#jms_total_units").val() == "" ? 0 : $("#jms_total_units").val().replace(/,+/g,'')));
        jms_formData.append("jms_rent_per_unit",parseFloat($("#jms_rent_per_unit").val() == "" ? 0 : $("#jms_rent_per_unit").val().replace(/,+/g,'')));
        jms_formData.append("jms_total_rent",parseFloat($("#jms_total_rent").val() == "" ? 0 : $("#jms_total_rent").val().replace(/,+/g,'')));
        
        jms_formData.append("jms_pets",parseFloat($("#jms_pets").val() == "" ? 0 : $("#jms_pets").val().replace(/,+/g,'')));
        jms_formData.append("jms_parking",parseFloat($("#jms_parking").val() == "" ? 0 : $("#jms_parking").val().replace(/,+/g,'')));
        jms_formData.append("jms_laundry",parseFloat($("#jms_laundry").val() == "" ? 0 : $("#jms_laundry").val().replace(/,+/g,'')));
        jms_formData.append("jms_storage",parseFloat($("#jms_storage").val() == "" ? 0 : $("#jms_storage").val().replace(/,+/g,'')));
        jms_formData.append("jms_alarm_systems",parseFloat($("#jms_alarm_systems").val() == "" ? 0 : $("#jms_alarm_systems").val().replace(/,+/g,'')));
        
        jms_formData.append("jms_new_property_appraisal_price",parseFloat($("#jms_new_property_appraisal_price").val() == "" ? 0 : $("#jms_new_property_appraisal_price").val().replace(/,+/g,'')));
        jms_formData.append("jms_ltv_ratio_percentage",parseFloat($("#jms_ltv_ratio_percentage").val() == "" ? 0 : $("#jms_ltv_ratio_percentage").val().replace(/,+/g,'')));
        
        jms_formData.append("jms_mortgage_annual_interest_rate",parseFloat($("#jms_mortgage_annual_interest_rate").val() == "" ? 0 : $("#jms_mortgage_annual_interest_rate").val().replace(/,+/g,'')));
        jms_formData.append("jms_mortgage_number_of_years",parseFloat($("#jms_mortgage_number_of_years").val() == "" ? 0 : $("#jms_mortgage_number_of_years").val().replace(/,+/g,'')));
        jms_formData.append("jms_closing_cost_per",parseFloat($("#jms_closing_cost_per").val() == "" ? 0 : $("#jms_closing_cost_per").val().replace(/,+/g,'')));
        
        
        $.ajax({
            url: "user_data_file/deal_evaluation_calculation_data.php",
            type: "POST",
            data:  jms_formData,
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
                    // $('.jms-login-message').css('display', 'block');
                    // $('.jms-login-message').html("<div class='alert alert-danger mb-2' role='alert'>"+data.message+"</div>");
                }
                else if(data.status == 'success')
                {
                    $("#jms_closing_cost").text("$"+numberWithCommas(data.jms_closing_cost.toFixed(2)));
                    $("#jms_all_in_cost_total").text("$"+numberWithCommas(data.jms_all_in_cost_total.toFixed(2)));

                    $("#jms_loan_amount").text("$"+numberWithCommas(data.jms_loan_amount.toFixed(2)));
                    $("#jms_monthly_payment").text("$"+numberWithCommas(data.jms_monthly_payment.toFixed(2)));
                    $("#jms_carrying_cost").text("$"+numberWithCommas(data.jms_all_in_cost_total.toFixed(2)));
                    $("#jms_find_monthly_carrying_cost_fee").text("$"+numberWithCommas(data.jms_find_monthly_carrying_cost_fee.toFixed(2)));

                    $("#jms_repairs_monthly").text("$"+numberWithCommas(data.jms_repairs_monthly.toFixed(2)));
                    $("#jms_repairs_daily").text("$"+numberWithCommas(data.jms_repairs_daily.toFixed(2)));

                    $("#jms_utilities_monthly").text("$"+numberWithCommas(data.jms_utilities_monthly.toFixed(2)));
                    $("#jms_utilities_daily").text("$"+numberWithCommas(data.jms_utilities_daily.toFixed(2)));

                    $("#jms_home_warranty_monthly").text("$"+numberWithCommas(data.jms_home_warranty_monthly.toFixed(2)));
                    $("#jms_home_warranty_daily").text("$"+numberWithCommas(data.jms_home_warranty_daily.toFixed(2)));
                      
                    $("#jms_trash_removal_monthly").text("$"+numberWithCommas(data.jms_trash_removal_monthly.toFixed(2)));
                    $("#jms_trash_removal_daily").text("$"+numberWithCommas(data.jms_trash_removal_daily.toFixed(2)));
                      
                    $("#jms_landscaping_monthly").text("$"+numberWithCommas(data.jms_landscaping_monthly.toFixed(2)));
                    $("#jms_landscaping_daily").text("$"+numberWithCommas(data.jms_landscaping_daily.toFixed(2)));
                      
                    $("#jms_property_management_monthly").text("$"+numberWithCommas(data.jms_property_management_monthly.toFixed(2)));
                    $("#jms_property_management_daily").text("$"+numberWithCommas(data.jms_property_management_daily.toFixed(2)));
                    
                    $("#jms_property_taxes_monthly").text("$"+numberWithCommas(data.jms_property_taxes_monthly.toFixed(2)));
                    $("#jms_property_taxes_daily").text("$"+numberWithCommas(data.jms_property_taxes_daily.toFixed(2)));
                    
                    $("#jms_home_owners_insurance_monthly").text("$"+numberWithCommas(data.jms_home_owners_insurance_monthly.toFixed(2)));
                    $("#jms_home_owners_insurance_daily").text("$"+numberWithCommas(data.jms_home_owners_insurance_daily.toFixed(2)));
                    
                    $("#jms_cap_ex_monthly").text("$"+numberWithCommas(data.jms_cap_ex_monthly.toFixed(2)));
                    $("#jms_cap_ex_daily").text("$"+numberWithCommas(data.jms_cap_ex_daily.toFixed(2)));
                     
                    $("#jms_raw_expenses_total").text("$"+numberWithCommas(data.jms_raw_expenses_total.toFixed(2)));
                    $("#jms_raw_expenses_total_monthly").text("$"+numberWithCommas(data.jms_raw_expenses_total_monthly.toFixed(2)));
                    $("#jms_raw_expenses_total_daily").text("$"+numberWithCommas(data.jms_raw_expenses_total_daily.toFixed(2)));
                    
                    $("#jms_yearly_crc").text("$"+numberWithCommas(data.jms_yearly_crc.toFixed(2)));
                    $("#jms_monthly_crc").text("$"+numberWithCommas(data.jms_monthly_crc.toFixed(2)));
                    $("#jms_daily_crc").text("$"+numberWithCommas(data.jms_daily_crc.toFixed(2)));
                    
                    $("#jms_yearly_crc_mtg").text("$"+numberWithCommas(data.jms_raw_expenses_crc_mtg_total.toFixed(2)));
                    $("#jms_monthly_crc_mtg").text("$"+numberWithCommas(data.jms_monthly_crc_mtg.toFixed(2)));
                    $("#jms_daily_crc_mtg").text("$"+numberWithCommas(data.jms_daily_crc_mtg.toFixed(2)));
                    
                    
                    $("#jms_pets_yearly").text("$"+numberWithCommas(data.jms_pets_yearly.toFixed(2)));
                    $("#jms_pets_monthly").text("$"+numberWithCommas(data.jms_pets_monthly.toFixed(2)));
                     
                    $("#jms_parking_yearly").text("$"+numberWithCommas(data.jms_parking_yearly.toFixed(2)));
                    $("#jms_parking_monthly").text("$"+numberWithCommas(data.jms_parking_monthly.toFixed(2)));
                    
                    $("#jms_laundry_yearly").text("$"+numberWithCommas(data.jms_laundry_yearly.toFixed(2)));
                    $("#jms_laundry_monthly").text("$"+numberWithCommas(data.jms_laundry_monthly.toFixed(2)));
                     
                    $("#jms_storage_yearly").text("$"+numberWithCommas(data.jms_storage_yearly.toFixed(2)));
                    $("#jms_storage_monthly").text("$"+numberWithCommas(data.jms_storage_monthly.toFixed(2)));
                     
                    $("#jms_alarm_systems_yearly").text("$"+numberWithCommas(data.jms_alarm_systems_yearly.toFixed(2)));
                    $("#jms_alarm_systems_monthly").text("$"+numberWithCommas(data.jms_alarm_systems_monthly.toFixed(2)));

                    $("#jms_total_property_income").text("$"+numberWithCommas(data.jms_total_property_income.toFixed(2)));
                    $("#jms_total_property_income_yearly").text("$"+numberWithCommas(data.jms_total_property_income_yearly.toFixed(2)));
                    $("#jms_total_property_income_monthly").text("$"+numberWithCommas(data.jms_total_property_income_monthly.toFixed(2)));
                    $("#jms_total_property_daily").text("$"+numberWithCommas(data.jms_total_property_daily.toFixed(2)));

                    $("#jms_total_property_find_noi").text("$"+numberWithCommas(data.jms_total_property_find_noi.toFixed(2)));
                    $("#jms_total_property_find_noi_monthly").text("$"+numberWithCommas(data.jms_total_property_find_noi_monthly.toFixed(2)));
                    $("#jms_total_property_find_noi_daily").text("$"+numberWithCommas(data.jms_total_property_find_noi_daily.toFixed(2)));
                    $("#jms_noi_12").text("$"+numberWithCommas(data.jms_noi_12.toFixed(2)));
                    
                    $("#jms_mortgage_loan_amount").text("$"+numberWithCommas(data.jms_mortgage_loan_amount.toFixed(2)));
                    $("#jms_mortgage_annual_interest_rate").text(data.jms_annual_interest_rate+"%");
                    $("#jms_mortgage_number_of_years").text(data.jms_number_of_years);
                    $("#jms_mortgage_monthly_payment").text("$"+numberWithCommas(data.jms_mortgage_monthly_payment.toFixed(2)));
                    
                    $("#jms_mortgage_closing_cost_5per").text("$"+numberWithCommas(data.jms_mortgage_closing_cost_5per.toFixed(2)));
                    $("#jms_original_mortgage_note").text("$"+numberWithCommas(data.jms_original_mortgage_note.toFixed(2)));
                    $("#jms_mortgage_carrying_cost").text("$"+numberWithCommas(data.jms_mortgage_carrying_cost.toFixed(2)));

                    $("#jms_mortgage_remaining_cash_balance").text("$"+numberWithCommas(data.jms_mortgage_remaining_cash_balance.toFixed(2)));

                    $("#jms_yearly_cash_flow_all_in_cost").text("$"+numberWithCommas(data.jms_yearly_cash_flow_all_in_cost.toFixed(2)));
                    $("#jms_roi_per").text(numberWithCommas(data.jms_roi_per.toFixed(2))+"%");

                    $("#jms_noi_yearly").text("$"+numberWithCommas(data.jms_noi_yearly.toFixed(2)));
                    $("#jms_noi_monthly").text("$"+numberWithCommas(data.jms_noi_monthly.toFixed(2)));
                    $("#jms_noi_daily").text("$"+numberWithCommas(data.jms_noi_daily.toFixed(2)));

                    $("#jms_12_by_noi").text("$"+numberWithCommas(data.jms_12_by_noi.toFixed(2)));
                    $("#jms_roi_per_2").text(numberWithCommas(data.jms_roi_per_2.toFixed(2))+"%");
                    
                    $("#jms_total_rent").text("$"+numberWithCommas(data.jms_total_rent.toFixed(2)));

                    $("#jms_mortgage_yearly_payment").text("$"+numberWithCommas(data.jms_mortgage_yearly_payment.toFixed(2)));
                    $("#jms_mortgage_daily_payment").text("$"+numberWithCommas(data.jms_mortgage_daily_payment.toFixed(2)));
                }
            },
            error: function(e)
            {
            }
        });
    }   

    $('input[type=text],input[type=number]').on('keyup',function()
    {
        jms_deal_calc_function_ajax();
    });

    // save database

    $("#jms_deal_evaluation_save_btn").on("click",function()
    {
        var jms_all_input_id_save = $('input[type=text],input[type=number]').map(function() 
        {
            if (this.id !== 'jms_name') 
            {
                return this.id;
            }
        }).get();

        var jms_input_ids_array_save = [];
        
        for (var i = 0; i < jms_all_input_id_save.length; i++) 
        {
            jms_input_ids_array_save.push(jms_all_input_id_save[i]);
        }

        var jms_formData = new FormData();

        // jms_formData.append("jms_property_address",$("#jms_property_address").val());
        jms_formData.append("jms_user_id",$("#jms_user_id").val());
        jms_formData.append("jms_name",$("#jms_name").val());
        jms_formData.append("jms_date",$("#jms_date").val());
            
        for(var a =0;a<jms_input_ids_array_save.length;a++)
        {
            jms_formData.append(jms_input_ids_array_save[a],parseFloat($("#"+jms_input_ids_array_save[a]).val() == "" ? 0 : $("#"+jms_input_ids_array_save[a]).val().replace(/,+/g,'')));
        }

        $.ajax({
            url: "user_data_file/deal_evaluation_store_data.php",
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
                if(data.status == 'error')
                {
                    $("#jms_loading").hide();

                    $('.jms-message').css('display', 'block');
                    $('.jms-message').html("<div class='alert alert-danger mb-2' role='alert'>"+data.message+"</div>");
                }
                else if(data.status == 'success')
                {
                    $("#jms_loading").hide();

                    $('.jms-message').css('display', 'block');
                    $('.jms-message').html("<div class='alert alert-success mb-2' role='alert'>"+data.message+"</div>");
                    setTimeout(function(){ window.location = 'deal_evaluation.php'; }, 3000);
                }
            },
            error: function(e)
            {
            }
        });
    });

    // update database

    $("#jms_edit_deal_evaluation_save_btn").on("click",function()
    {
        var jms_all_input_id_save = $('input[type=text],input[type=number]').map(function() 
        {
            if (this.id !== 'jms_name') 
            {
                return this.id;
            }
        }).get();

        var jms_input_ids_array_save = [];
        
        for (var i = 0; i < jms_all_input_id_save.length; i++) 
        {
            jms_input_ids_array_save.push(jms_all_input_id_save[i]);
        }

        var jms_formData = new FormData();

        // jms_formData.append("jms_property_address",$("#jms_property_address").val());
        jms_formData.append("jms_user_id",$("#jms_user_id").val());
        jms_formData.append("jms_name",$("#jms_name").val());
        jms_formData.append("jms_date",$("#jms_date").val());
            
        for(var a =0;a<jms_input_ids_array_save.length;a++)
        {
            jms_formData.append(jms_input_ids_array_save[a],parseFloat($("#"+jms_input_ids_array_save[a]).val() == "" ? 0 : $("#"+jms_input_ids_array_save[a]).val().replace(/,+/g,'')));
        }

        $.ajax({
            url: "user_data_file/update_deal_evaluation_store_data.php",
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
                if(data.status == 'error')
                {
                    $("#jms_loading").hide();

                    $('.jms-message').css('display', 'block');
                    $('.jms-message').html("<div class='alert alert-danger mb-2' role='alert'>"+data.message+"</div>");
                }
                else if(data.status == 'success')
                {
                    $("#jms_loading").hide();
                    
                    $('.jms-message').css('display', 'block');
                    $('.jms-message').html("<div class='alert alert-success mb-2' role='alert'>"+data.message+"</div>");
                    setTimeout(function(){ window.location = 'calculator_records.php'; }, 3000);
                }
            },
            error: function(e)
            {
            }
        });
    });

    jms_deal_calc_function_ajax();
});