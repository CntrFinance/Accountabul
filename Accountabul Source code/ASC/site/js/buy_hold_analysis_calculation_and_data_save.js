$(document).ready(function()
{
    $("#jms_loading").hide();
    function numberWithCommas(x) 
    {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    /* Input Mask Include */

    $("#jms_financial_cost input[type=text],#jms_renovation_cost,#jms_purchase_price,#jms_arv_comps,#jms_PROJECTED_RENT_INCREASE_ANALYSIS input[type=text],#jms_property_info input[type=text],#jms_additional_income,#jms_PROJECTED_EXPENSES input[type=text],#jms_EXPENSES_AT_PURCHASE input[type=text]").inputmask('decimal', {
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

    // calulation on keyup

    function jms_buy_and_hold_analysis_function()
    {
        var jms_formData = new FormData();

        jms_formData.append("jms_purchase_price",parseFloat($("#jms_purchase_price").val() == "" ? 0 : $("#jms_purchase_price").val().replace(/,+/g,'')));
        jms_formData.append("jms_loan_to_value_ltv",parseFloat($("#jms_loan_to_value_ltv").val() == "" ? 0 : $("#jms_loan_to_value_ltv").val().replace(/,+/g,'')));
        jms_formData.append("jms_arv_comps",parseFloat($("#jms_arv_comps").val() == "" ? 0 : $("#jms_arv_comps").val().replace(/,+/g,'')));
        jms_formData.append("jms_renovation_cost",parseFloat($("#jms_renovation_cost").val() == "" ? 0 : $("#jms_renovation_cost").val().replace(/,+/g,'')));
        
        jms_formData.append("jms_monthly_rent_per_unit_studio",parseFloat($("#jms_monthly_rent_per_unit_studio").val() == "" ? 0 : $("#jms_monthly_rent_per_unit_studio").val().replace(/,+/g,'')));
        jms_formData.append("jms_monthly_rent_per_unit_1bd",parseFloat($("#jms_monthly_rent_per_unit_1bd").val() == "" ? 0 : $("#jms_monthly_rent_per_unit_1bd").val().replace(/,+/g,'')));
        jms_formData.append("jms_monthly_rent_per_unit_2bd",parseFloat($("#jms_monthly_rent_per_unit_2bd").val() == "" ? 0 : $("#jms_monthly_rent_per_unit_2bd").val().replace(/,+/g,'')));
        jms_formData.append("jms_monthly_rent_per_unit_3bd",parseFloat($("#jms_monthly_rent_per_unit_3bd").val() == "" ? 0 : $("#jms_monthly_rent_per_unit_3bd").val().replace(/,+/g,'')));
        
        jms_formData.append("jms_of_units",parseFloat($("#jms_of_units").val() == "" ? 0 : $("#jms_of_units").val().replace(/,+/g,'')));
        jms_formData.append("jms_sq_of_buiding",parseFloat($("#jms_sq_of_buiding").val() == "" ? 0 : $("#jms_sq_of_buiding").val().replace(/,+/g,'')));
        jms_formData.append("jms_monthly_rent_per_unit_studio_property_info",parseFloat($("#jms_monthly_rent_per_unit_studio_property_info").val() == "" ? 0 : $("#jms_monthly_rent_per_unit_studio_property_info").val().replace(/,+/g,'')));
        jms_formData.append("jms_total_units_type_studio_property_info",parseFloat($("#jms_total_units_type_studio_property_info").val() == "" ? 0 : $("#jms_total_units_type_studio_property_info").val().replace(/,+/g,'')));
        jms_formData.append("jms_monthly_rent_per_unit_1bd_property_info",parseFloat($("#jms_monthly_rent_per_unit_1bd_property_info").val() == "" ? 0 : $("#jms_monthly_rent_per_unit_1bd_property_info").val().replace(/,+/g,'')));
        jms_formData.append("jms_total_units_type_1bd_property_info",parseFloat($("#jms_total_units_type_1bd_property_info").val() == "" ? 0 : $("#jms_total_units_type_1bd_property_info").val().replace(/,+/g,'')));
        jms_formData.append("jms_monthly_rent_per_unit_2bd_property_info",parseFloat($("#jms_monthly_rent_per_unit_2bd_property_info").val() == "" ? 0 : $("#jms_monthly_rent_per_unit_2bd_property_info").val().replace(/,+/g,'')));
        jms_formData.append("jms_total_units_type_2bd_property_info",parseFloat($("#jms_total_units_type_2bd_property_info").val() == "" ? 0 : $("#jms_total_units_type_2bd_property_info").val().replace(/,+/g,'')));
        jms_formData.append("jms_monthly_rent_per_unit_3bd_property_info",parseFloat($("#jms_monthly_rent_per_unit_3bd_property_info").val() == "" ? 0 : $("#jms_monthly_rent_per_unit_3bd_property_info").val().replace(/,+/g,'')));
        jms_formData.append("jms_total_units_type_3bd_property_info",parseFloat($("#jms_total_units_type_3bd_property_info").val() == "" ? 0 : $("#jms_total_units_type_3bd_property_info").val().replace(/,+/g,'')));
        
        jms_formData.append("jms_additional_income",parseFloat($("#jms_additional_income").val() == "" ? 0 : $("#jms_additional_income").val().replace(/,+/g,'')));
        
        jms_formData.append("jms_mortgage_original_interest",parseFloat($("#jms_mortgage_original_interest").val() == "" ? 0 : $("#jms_mortgage_original_interest").val().replace(/,+/g,'')));
        jms_formData.append("jms_mortgage_refi_interest",parseFloat($("#jms_mortgage_refi_interest").val() == "" ? 0 : $("#jms_mortgage_refi_interest").val().replace(/,+/g,'')));
        
        jms_formData.append("jms_taxes_projected_expenses",parseFloat($("#jms_taxes_projected_expenses").val() == "" ? 0 : $("#jms_taxes_projected_expenses").val().replace(/,+/g,'')));
        jms_formData.append("jms_insurance_projected_expenses",parseFloat($("#jms_insurance_projected_expenses").val() == "" ? 0 : $("#jms_insurance_projected_expenses").val().replace(/,+/g,'')));
        jms_formData.append("jms_water_sewer_projected_expenses",parseFloat($("#jms_water_sewer_projected_expenses").val() == "" ? 0 : $("#jms_water_sewer_projected_expenses").val().replace(/,+/g,'')));
        jms_formData.append("jms_utilities_projected_expenses",parseFloat($("#jms_utilities_projected_expenses").val() == "" ? 0 : $("#jms_utilities_projected_expenses").val().replace(/,+/g,'')));
        jms_formData.append("jms_garbage_projected_expenses",parseFloat($("#jms_garbage_projected_expenses").val() == "" ? 0 : $("#jms_garbage_projected_expenses").val().replace(/,+/g,'')));
        jms_formData.append("jms_repairs_projected_expenses",parseFloat($("#jms_repairs_projected_expenses").val() == "" ? 0 : $("#jms_repairs_projected_expenses").val().replace(/,+/g,'')));
        jms_formData.append("jms_legal_projected_expenses",parseFloat($("#jms_legal_projected_expenses").val() == "" ? 0 : $("#jms_legal_projected_expenses").val().replace(/,+/g,'')));
        jms_formData.append("jms_lanscaping_projected_expenses",parseFloat($("#jms_lanscaping_projected_expenses").val() == "" ? 0 : $("#jms_lanscaping_projected_expenses").val().replace(/,+/g,'')));
        jms_formData.append("jms_pest_control_projected_expenses",parseFloat($("#jms_pest_control_projected_expenses").val() == "" ? 0 : $("#jms_pest_control_projected_expenses").val().replace(/,+/g,'')));
        jms_formData.append("jms_office_projected_expenses",parseFloat($("#jms_office_projected_expenses").val() == "" ? 0 : $("#jms_office_projected_expenses").val().replace(/,+/g,'')));
        jms_formData.append("jms_other_projected_expenses",parseFloat($("#jms_other_projected_expenses").val() == "" ? 0 : $("#jms_other_projected_expenses").val().replace(/,+/g,'')));
        
        jms_formData.append("jms_taxes_expenses_purchase",parseFloat($("#jms_taxes_expenses_purchase").val() == "" ? 0 : $("#jms_taxes_expenses_purchase").val().replace(/,+/g,'')));
        jms_formData.append("jms_insurance_expenses_purchase",parseFloat($("#jms_insurance_expenses_purchase").val() == "" ? 0 : $("#jms_insurance_expenses_purchase").val().replace(/,+/g,'')));
        jms_formData.append("jms_water_sewer_expenses_purchase",parseFloat($("#jms_water_sewer_expenses_purchase").val() == "" ? 0 : $("#jms_water_sewer_expenses_purchase").val().replace(/,+/g,'')));
        jms_formData.append("jms_utilities_expenses_purchase",parseFloat($("#jms_utilities_expenses_purchase").val() == "" ? 0 : $("#jms_utilities_expenses_purchase").val().replace(/,+/g,'')));
        jms_formData.append("jms_garbage_expenses_purchase",parseFloat($("#jms_garbage_expenses_purchase").val() == "" ? 0 : $("#jms_garbage_expenses_purchase").val().replace(/,+/g,'')));
        jms_formData.append("jms_repairs_expenses_purchase",parseFloat($("#jms_repairs_expenses_purchase").val() == "" ? 0 : $("#jms_repairs_expenses_purchase").val().replace(/,+/g,'')));
        jms_formData.append("jms_legal_expenses_purchase",parseFloat($("#jms_legal_expenses_purchase").val() == "" ? 0 : $("#jms_legal_expenses_purchase").val().replace(/,+/g,'')));
        jms_formData.append("jms_lanscaping_expenses_purchase",parseFloat($("#jms_lanscaping_expenses_purchase").val() == "" ? 0 : $("#jms_lanscaping_expenses_purchase").val().replace(/,+/g,'')));
        jms_formData.append("jms_pest_control_expenses_purchase",parseFloat($("#jms_pest_control_expenses_purchase").val() == "" ? 0 : $("#jms_pest_control_expenses_purchase").val().replace(/,+/g,'')));
        jms_formData.append("jms_office_expenses_purchase",parseFloat($("#jms_office_expenses_purchase").val() == "" ? 0 : $("#jms_office_expenses_purchase").val().replace(/,+/g,'')));
        jms_formData.append("jms_other_expenses_purchase",parseFloat($("#jms_other_expenses_purchase").val() == "" ? 0 : $("#jms_other_expenses_purchase").val().replace(/,+/g,'')));
        
        jms_formData.append("jms_financial_cost_loan_fee_financial_cost",parseFloat($("#jms_financial_cost_loan_fee_financial_cost").val() == "" ? 0 : $("#jms_financial_cost_loan_fee_financial_cost").val().replace(/,+/g,'')));
        jms_formData.append("jms_financial_cost_appraisal_financial_cost",parseFloat($("#jms_financial_cost_appraisal_financial_cost").val() == "" ? 0 : $("#jms_financial_cost_appraisal_financial_cost").val().replace(/,+/g,'')));
        jms_formData.append("jms_financial_cost_inspection_financial_cost",parseFloat($("#jms_financial_cost_inspection_financial_cost").val() == "" ? 0 : $("#jms_financial_cost_inspection_financial_cost").val().replace(/,+/g,'')));
        
        jms_formData.append("jms_credit_card_capital_interest_rate",parseFloat($("#jms_credit_card_capital_interest_rate").val() == "" ? 0 : $("#jms_credit_card_capital_interest_rate").val().replace(/,+/g,'')));
       
        $.ajax({
            url: "user_data_file/buy_hold_calculation_data.php",
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
                    $("#jms_loan_amount_property_type_building").text("$"+numberWithCommas(data.jms_loan_amount.toFixed(2)));
                    $("#jms_down_payment_property_type_building").text("$"+numberWithCommas(data.jms_down_payment.toFixed(2)));

                    // Profit ( If I sold the property)

                    $("#jms_less_purchase_price").text("$"+numberWithCommas(data.jms_less_purchase_price.toFixed(2)));
                    $("#jms_transaction_cost_of_sale").text("$"+numberWithCommas(data.jms_transaction_cost_of_sale.toFixed(2)));
                    $("#jms_profit").text("$"+numberWithCommas(data.jms_profit.toFixed(2)));

                    // Cash out Refinance

                    $("#jms_refinance_amount_cash_out_refinance").text("$"+numberWithCommas(data.jms_refinance_amount_75_per_ltv.toFixed(2)));
                    $("#jms_closing_cost_cash_out_refinance").text("$"+numberWithCommas(data.jms_closing_cost_cash_out_refinance.toFixed(2)));
                    $("#jms_cashout_cash_out_refinance").text("$"+numberWithCommas(data.jms_cashout_cash_out_refinance.toFixed(2)));
                    $("#jms_finance_fee_cash_out_refinance").text("$"+numberWithCommas(data.jms_finance_fee_cash_out_refinance.toFixed(2)));
                    $("#jms_profit_cash_out_refinance").text("$"+numberWithCommas(data.jms_profit_cash_out_refinance.toFixed(2)));
                    
                    // Annual Property Operationing Data

                    $("#jms_potential_gross_income").text("$"+numberWithCommas(data.jms_potential_gross_income_annual_property.toFixed(2)));
                    $("#jms_vacancy_rate_10").text("$"+numberWithCommas(data.jms_vacancy_rate_10_annual_property.toFixed(2)));
                    $("#jms_gross_operating_income").text("$"+numberWithCommas(data.jms_gross_operating_income_annual_property.toFixed(2)));

                    // Annual Property Operationing Data 2

                    $("#jms_potential_gross_income_2").text("$"+numberWithCommas(data.jms_potential_gross_income_annual_property_2.toFixed(2)));
                    $("#jms_vacancy_rate_10_2").text("$"+numberWithCommas(data.jms_vacancy_rate_10_annual_property_2.toFixed(2)));
                    $("#jms_gross_operating_income_2").text("$"+numberWithCommas(data.jms_gross_operating_income_annual_property_2.toFixed(2)));

                    // PROJECTED EXPENSES

                    $("#jms_management_fee_cost_annually_projected_expenses").text("$"+numberWithCommas(data.jms_management_fee_cost_annually_2.toFixed(2)));

                    $("#jms_taxes_projected_expenses_monthly").text("$"+numberWithCommas(data.jms_taxes_projected_expenses_monthly.toFixed(2)));
                    $("#jms_insurance_projected_expenses_monthly").text("$"+numberWithCommas(data.jms_insurance_projected_expenses_monthly.toFixed(2)));
                    $("#jms_water_sewer_projected_expenses_monthly").text("$"+numberWithCommas(data.jms_water_sewer_projected_expenses_monthly.toFixed(2)));
                    $("#jms_utilities_projected_expenses_monthly").text("$"+numberWithCommas(data.jms_utilities_projected_expenses_monthly.toFixed(2)));
                    $("#jms_garbage_projected_expenses_monthly").text("$"+numberWithCommas(data.jms_garbage_projected_expenses_monthly.toFixed(2)));
                    $("#jms_management_fee_expenses_purchase_monthly_projected_expenses").text("$"+numberWithCommas(data.jms_management_fee_expenses_purchase_monthly_projected_expenses.toFixed(2)));
                    $("#jms_repairs_projected_expenses_monthly").text("$"+numberWithCommas(data.jms_repairs_projected_expenses_monthly.toFixed(2)));
                    $("#jms_legal_projected_expenses_monthly").text("$"+numberWithCommas(data.jms_legal_projected_expenses_monthly.toFixed(2)));
                    $("#jms_lanscaping_projected_expenses_monthly").text("$"+numberWithCommas(data.jms_lanscaping_projected_expenses_monthly.toFixed(2)));
                    $("#jms_pest_control_projected_expenses_monthly").text("$"+numberWithCommas(data.jms_pest_control_projected_expenses_monthly.toFixed(2)));
                    $("#jms_office_projected_expenses_monthly").text("$"+numberWithCommas(data.jms_office_projected_expenses_monthly.toFixed(2)));
                    $("#jms_other_projected_expenses_monthly").text("$"+numberWithCommas(data.jms_other_projected_expenses_monthly.toFixed(2)));
                    
                    $("#jms_total_cost_annually_projected_expenses").text("$"+numberWithCommas(data.jms_total_projected_expenses_cost_annually.toFixed(2)));
                    $("#jms_total_monthlly_projected_expenses").text("$"+numberWithCommas(data.jms_total_projected_expenses_monthly.toFixed(2)));
                    

                    // Annual Operatig Expenses

                    $("#jms_operating_expenses").text("$"+numberWithCommas(data.jms_operating_expenses.toFixed(2)));
                    $("#jms_noi").text('$'+numberWithCommas(data.jms_noi.toFixed(2)));
                    

                    // Mortgage

                    $("#jms_original_loan_mortgage").text('$'+numberWithCommas(data.jms_original_loan_mortgage.toFixed(2)));
                    $("#jms_refi_loan_amount_mortgage").text('$'+numberWithCommas(data.jms_refi_loan_amount_mortgage.toFixed(2)));
                    
                    $("#jms_annual_debt_service").text('$'+numberWithCommas(data.jms_annual_debt_service.toFixed(2)));
                    $("#jms_annual_cash_flow").text('$'+numberWithCommas(data.jms_annual_cash_flow.toFixed(2)));
                    $("#jms_monthly_noi_vacancy_rate").text('$'+numberWithCommas(data.jms_monthly_noi_vacancy_rate.toFixed(2)));
                    $("#jms_monthly_noi_fully_occupied").text('$'+numberWithCommas(data.jms_monthly_noi_fully_occupied.toFixed(2)));

                    //EXPENSES AT PURCHASE 

                    $("#jms_management_fee_cost_annually").text("$"+numberWithCommas(data.jms_management_fee_cost_annually.toFixed(2)));

                    $('#jms_taxes_expenses_purchase_monthly').text("$"+numberWithCommas(data.jms_taxes_expenses_purchase_monthly.toFixed(2)));
                    $('#jms_insurance_expenses_purchase_monthly').text("$"+numberWithCommas(data.jms_insurance_expenses_purchase_monthly.toFixed(2)));
                    $('#jms_water_sewer_expenses_purchase_monthly').text("$"+numberWithCommas(data.jms_water_sewer_expenses_purchase_monthly.toFixed(2)));
                    $('#jms_utilities_expenses_purchase_monthly').text("$"+numberWithCommas(data.jms_utilities_expenses_purchase_monthly.toFixed(2)));
                    $('#jms_garbage_expenses_purchase_monthly').text("$"+numberWithCommas(data.jms_garbage_expenses_purchase_monthly.toFixed(2)));
                    $('#jms_management_fee_expenses_purchase_monthly').text("$"+numberWithCommas(data.jms_management_fee_expenses_purchase_monthly.toFixed(2)));
                    $('#jms_repairs_expenses_purchase_monthly').text("$"+numberWithCommas(data.jms_repairs_expenses_purchase_monthly.toFixed(2)));
                    $('#jms_legal_expenses_purchase_monthly').text("$"+numberWithCommas(data.jms_legal_expenses_purchase_monthly.toFixed(2)));
                    $('#jms_lanscaping_expenses_purchase_monthly').text("$"+numberWithCommas(data.jms_lanscaping_expenses_purchase_monthly.toFixed(2)));
                    $('#jms_pest_control_expenses_purchase_monthly').text("$"+numberWithCommas(data.jms_pest_control_expenses_purchase_monthly.toFixed(2)));
                    $('#jms_office_expenses_purchase_monthly').text("$"+numberWithCommas(data.jms_office_expenses_purchase_monthly.toFixed(2)));
                    $('#jms_other_expenses_purchase_monthly').text("$"+numberWithCommas(data.jms_other_expenses_purchase_monthly.toFixed(2)));

                    $('#jms_total_cost_annually').text("$"+numberWithCommas(data.jms_total_expenses_purchase_cost_annually.toFixed(2)));
                    $('#jms_total_monthlly').text("$"+numberWithCommas(data.jms_total_expenses_purchase_monthly.toFixed(2)));

                    //Annual Operatig Expenses 

                    $('#jms_operating_expenses_2').text("$"+numberWithCommas(data.jms_operating_expenses_2.toFixed(2)));
                    $('#jms_noi_2').text("$"+numberWithCommas(data.jms_noi_2.toFixed(2)));

                    // Financial Cost 

                    $('#jms_down_payment_financial_cost').text("$"+numberWithCommas(data.jms_down_payment_financial_cost.toFixed(2)));
                    $('#jms_closing_cost_financial_cost').text("$"+numberWithCommas(data.jms_closing_cost_financial_cost.toFixed(2)));
                    $('#jms_cash_to_close_financial_cost_financial_cost').text("$"+numberWithCommas(data.jms_cash_to_close_financial_cost.toFixed(2)));

                    // Credit Card for Capital

                    $('#jms_amount_borrowed_credit_card_for_capital').text("$"+numberWithCommas(data.jms_amount_borrowed_credit_card_for_capital.toFixed(2)));
                    $('#jms_min_monthly_payment_credit_card_for_capital').text("$"+numberWithCommas(data.jms_min_monthly_payment_credit_card_for_capital.toFixed(2)));

                    $("#jms_annual_debt_service_2").text('$'+numberWithCommas(data.jms_annual_debt_service_2.toFixed(2)));
                    $("#jms_credit_card_min_annual_payment_2").text('$'+numberWithCommas(data.jms_credit_card_min_annual_payment_2.toFixed(2)));
                    $("#jms_annual_cash_flow_2").text('$'+numberWithCommas(data.jms_annual_cash_flow_2.toFixed(2)));
                    $("#jms_monthly_noi_vacancy_rate_2").text('$'+numberWithCommas(data.jms_monthly_noi_vacancy_rate_2.toFixed(2)));
                    $("#jms_monthly_noi_fully_occupied_2").text('$'+numberWithCommas(data.jms_monthly_noi_fully_occupied_2.toFixed(2)));

                    $("#jms_cap_rate").text(numberWithCommas(data.jms_cap_rate.toFixed(2))+"%");
                    $("#jms_cash_on_cash_return").text(numberWithCommas(data.jms_cash_on_cash_return.toFixed(2))+"%");
                    $("#jms_debt_coverage_ratio").text(numberWithCommas(data.jms_debt_coverage_ratio.toFixed(2)));
                    
                    $("#jms_noi_per_unit_monthly").text("$"+numberWithCommas(data.jms_noi_per_unit_monthly.toFixed(2)));
                    $("#jms_pp_sq_ft").text("$"+numberWithCommas(data.jms_pp_sq_ft.toFixed(2)));
                }
            },
            error: function(e)
            {
            }
        });
    }

    jms_buy_and_hold_analysis_function();
    
    $('input[type=text],input[type=number]').on('keyup',function()
    {
        jms_buy_and_hold_analysis_function();
    });

    // save database

    $("#jms_buy_hold_analysis_save_btn").on("click",function()
    {
        var jms_all_input_id_save = $('input[type=text],input[type=number]').map(function() 
        {
            return this.id;
        }).get();

        var jms_input_ids_array_save = [];
        
        for (var i = 0; i < jms_all_input_id_save.length; i++) 
        {
            jms_input_ids_array_save.push(jms_all_input_id_save[i]);
        }

        var jms_formData = new FormData();

        
        jms_formData.append("jms_user_id",$("#jms_user_id").val());
        jms_formData.append("jms_property_address",$("#jms_property_address").val());

        for(var a=1;a<jms_input_ids_array_save.length;a++)
        {
            jms_formData.append(jms_input_ids_array_save[a],parseFloat($("#"+jms_input_ids_array_save[a]).val() == "" ? 0 : $("#"+jms_input_ids_array_save[a]).val().replace(/,+/g,'')));
        }

        $.ajax({
            url: "user_data_file/buy_hold_calculation_store_data.php",
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
                    setTimeout(function(){ window.location = 'buy_and_hold_analysis.php'; }, 3000);
                }
            },
            error: function(e)
            {
            }
        });
    });

    // update database

    $("#jms_edit_buy_hold_analysis_save_btn").on("click",function()
    {
        var jms_all_input_id_save = $('input[type=text],input[type=number]').map(function() 
        {
            if (this.id !== 'jms_property_address') 
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

        jms_formData.append("jms_records_id",$("#jms_records_id").val());
        jms_formData.append("jms_property_address",$("#jms_property_address").val());

        for(var a =0;a<jms_input_ids_array_save.length;a++)
        {
            jms_formData.append(jms_input_ids_array_save[a],parseFloat($("#"+jms_input_ids_array_save[a]).val() == "" ? 0 : $("#"+jms_input_ids_array_save[a]).val().replace(/,+/g,'')));
        }

        $.ajax({
            url: "user_data_file/update_buy_and_hold_analysis_data.php",
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
});