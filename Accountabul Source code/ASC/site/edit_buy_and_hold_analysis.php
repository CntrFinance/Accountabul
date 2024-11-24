<?php 
    include('connection.php');
    if(!isset($_SESSION['jms_user_id']))
    {
        header("location:index.php");
    }

    $jms_record_id = isset($_GET['id']) ? $_GET['id'] : 0;

    if(isset($_SESSION['jms_user_id']) && $_SESSION['jms_user_id'])
    {
        $jms_user_id = $_SESSION['jms_user_id'];
    }
    else
    {
        $jms_user_id = 0;
    }

    // get data

    $jms_select_sql = "SELECT calc_data_records FROM `buy-and-hold-analysis-calc` WHERE users_id=:jms_user_id AND calc_data_records != '' AND id=:jms_record_id";
    $jms_select_data = $jms_pdo->prepare($jms_select_sql);
    $jms_select_data->bindParam(':jms_user_id', $jms_user_id,PDO::PARAM_INT);
    $jms_select_data->bindParam(':jms_record_id', $jms_record_id,PDO::PARAM_INT);
    
    $jms_select_data->execute();
    $jms_row = $jms_select_data->fetchAll(PDO::FETCH_ASSOC);

    if (isset($jms_row[0]) && isset($jms_row[0]['calc_data_records'])) 
    {
        $jms_record_prnt = json_decode($jms_row[0]['calc_data_records'], true);
        
        if (!empty($jms_record_prnt)) 
        {
            $jms_print = $jms_record_prnt;
        } 
        else 
        {
            $jms_print = '';
        }
    } else 
    {
        $jms_print = '';
    }
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Edit Buy and Hold Analysis</title>

        <?php include("header.php");?>

        <!-- Style css -->
        <link rel="stylesheet" type="text/css" href="css/form.css">
        
        <style type="text/css">
            .jms-btn:hover 
            {
                color: white;
                background-color: #4292dc;
            }
            .jms-btn
            {
                font-family: var(--main-font);
                display: inline-block;
                background: var(--primary-color-blue);
                color: #fff;
                border: none;
                width: auto;
                padding: 15px 55px;
                border-radius: 5px;
                cursor: pointer;
                font-size: 15px;
                text-decoration: none;
            }
            .jms-container table tr td
            {
                width: 50%;
                vertical-align:middle;
                padding: 5px !important;
            }
            .jms-buy-hold-analysis .form-control
            {
                padding: 5px !important;
            }
            .jms-buy-hold-analysis .form-control:focus
            {
                box-shadow: none !important;
            }
            .jms-container .table-hover>tbody>tr:hover
            {
                --bs-table-accent-bg: #007dfe1c !important;
            }
            .jms-buy-hold-analysis .jms-heading
            {
                font-size: 3rem;
                font-weight: bold;
            }

            .jms-projected-expenses tr td,.jms-expenses-at-purchase tr td
            {
                width: 33.33% !important;
            }
            .jms-table-title
            {
                background: linear-gradient(45deg, var(--primary-color-blue), transparent);
                color: white;
            }

            .jms-calculatar-section .input-group .input-group-text
            {
                background: white;
                border: none;
                border-bottom: 1px solid #999 !important;
                border-radius: 0px;
            }
            .jms-calculatar-section input,.jms-calculatar-section input:focus,.jms-calculatar-section .input-group input,.jms-calculatar-section .input-group input:focus
            {
                border: none !important;
                border-bottom: 1px solid #999 !important;
                border-radius: 0px !important;
            }


            .jms-loader 
            {
                width: 48px;
                height: 48px;
                border-radius: 50%;
                position: relative;
                border: 3px solid;
                border-color: #007dfe #007dfe transparent transparent;
                box-sizing: border-box;
                animation: rotation 1s linear infinite;
            }
            .jms-loader::after,
            .jms-loader::before 
            {
              content: '';  
              box-sizing: border-box;
              position: fixed;
              left: 0;
              right: 0;
              top: 0;
              bottom: 0;
              margin: auto;
              border: 3px solid;
              border-color: transparent transparent #007dfe #007dfe;
              width: 40px;
              height: 40px;
              border-radius: 50%;
              box-sizing: border-box;
              animation: rotationBack 0.5s linear infinite;
              transform-origin: center center;
            }
            .jms-loader::before 
            {
              width: 32px;
              height: 32px;
              border-color: #007dfe #007dfe transparent transparent;
              animation: rotation 1.5s linear infinite;
            }
                
            @keyframes rotation 
            {
              0% {
                transform: rotate(0deg);
              }
              100% {
                transform: rotate(360deg);
              }
            } 
            @keyframes rotationBack 
            {
              0% {
                transform: rotate(0deg);
              }
              100% {
                transform: rotate(-360deg);
              }
            }
        </style>
    </head>
    <body class="jms-bg">
        <?php include("navbar_top.php");?>
        <div class="container my-5">
            <div class="jms-container jms-buy-hold-analysis p-3">
                <input type="hidden" id="jms_user_id" name="jms_user_id" value="<?php echo $jms_user_id;?>">
                <input type="hidden" id="jms_records_id" name="jms_records_id" value="<?php echo $jms_record_id;?>">
                <div class="row">
                    <div class="col-md-12">
                        <div class="jms-heading text-center my-3">Buy & Hold Analysis</div>
                    </div>
                </div>
                <div class="jms-calculatar-section">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th colspan="2" class="jms-table-title">Property Address and type of building</th>
                                            </tr>
                                        </thead>
                                        <tr>
                                            <th>Property Address</th>
                                            <td>
                                                <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_property_address'] == "" ? '' : $jms_record_prnt['jms_property_address']);?>" class="form-control" id="jms_property_address" name="jms_property_address">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Purchase Price</th>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text" id="basic-addon1">$</span>
                                                    <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_purchase_price'] == 0 ? '' : $jms_record_prnt['jms_purchase_price']);?>" class="form-control text-end" id="jms_purchase_price" name="jms_purchase_price">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Loan-To-Value (LTV)</th>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <input type="number" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_loan_to_value_ltv'] == 0 ? '' : $jms_record_prnt['jms_loan_to_value_ltv']);?>" class="form-control text-end" id="jms_loan_to_value_ltv" name="jms_loan_to_value_ltv">
                                                    <span class="input-group-text" id="basic-addon1">%</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Loan Amount</th>
                                            <td>
                                                <div class="text-end" id="jms_loan_amount_property_type_building"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Down Payment</th>
                                            <td>
                                                <div class="text-end" id="jms_down_payment_property_type_building"></div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-hover" id="jms_property_info">
                                        <thead>
                                            <tr><th colspan="2" class="jms-table-title">Property Info</th></tr>
                                        </thead>
                                        <tr>
                                            <td># of Units</td>
                                            <td>
                                                <input type="number" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_of_units'] == 0 ? '' : $jms_record_prnt['jms_of_units']);?>" class="form-control text-end" id="jms_of_units" name="jms_of_units">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>SQ of Buiding</td>
                                            <td>
                                                <input type="number" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_sq_of_buiding'] == 0 ? '' : $jms_record_prnt['jms_sq_of_buiding']);?>" class="form-control text-end" id="jms_sq_of_buiding" name="jms_sq_of_buiding">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Monthly Rent Per Unit: Studio</td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text" id="basic-addon1">$</span>
                                                    <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_monthly_rent_per_unit_studio_property_info'] == 0 ? '' : $jms_record_prnt['jms_monthly_rent_per_unit_studio_property_info']);?>" class="form-control text-end" id="jms_monthly_rent_per_unit_studio_property_info" name="jms_monthly_rent_per_unit_studio_property_info">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Total Units Type: Studio</td>
                                            <td>
                                                <input type="number" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_total_units_type_studio_property_info'] == 0 ? '' : $jms_record_prnt['jms_total_units_type_studio_property_info']);?>" class="form-control form-control-sm text-end" id="jms_total_units_type_studio_property_info" name="jms_total_units_type_studio_property_info">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Monthly Rent Per Unit: 1bd</td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text" id="basic-addon1">$</span>
                                                    <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_monthly_rent_per_unit_1bd_property_info'] == 0 ? '' : $jms_record_prnt['jms_monthly_rent_per_unit_1bd_property_info']);?>" class="form-control text-end" id="jms_monthly_rent_per_unit_1bd_property_info" name="jms_monthly_rent_per_unit_1bd_property_info">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Total Units Type: 1bd</td>
                                            <td>
                                                <input type="number" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_total_units_type_1bd_property_info'] == 0 ? '' : $jms_record_prnt['jms_total_units_type_1bd_property_info']);?>" class="form-control form-control-sm text-end" id="jms_total_units_type_1bd_property_info" name="jms_total_units_type_1bd_property_info">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Monthly Rent Per Unit: 2bd</td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text" id="basic-addon1">$</span>
                                                    <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_monthly_rent_per_unit_2bd_property_info'] == 0 ? '' : $jms_record_prnt['jms_monthly_rent_per_unit_2bd_property_info']);?>" class="form-control text-end" id="jms_monthly_rent_per_unit_2bd_property_info" name="jms_monthly_rent_per_unit_2bd_property_info">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Total Units Type: 2bd</td>
                                            <td>
                                                <input type="number" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_total_units_type_2bd_property_info'] == 0 ? '' : $jms_record_prnt['jms_total_units_type_2bd_property_info']);?>" class="form-control form-control-sm text-end" id="jms_total_units_type_2bd_property_info" name="jms_total_units_type_2bd_property_info">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Monthly Rent Per Unit: 3+bd</td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text" id="basic-addon1">$</span>
                                                    <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_monthly_rent_per_unit_3bd_property_info'] == 0 ? '' : $jms_record_prnt['jms_monthly_rent_per_unit_3bd_property_info']);?>" class="form-control text-end" id="jms_monthly_rent_per_unit_3bd_property_info" name="jms_monthly_rent_per_unit_3bd_property_info">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Total Unit Type: 3+bd</td>
                                            <td>
                                                <input type="number" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_total_units_type_3bd_property_info'] == 0 ? '' : $jms_record_prnt['jms_total_units_type_3bd_property_info']);?>" class="form-control form-control-sm text-end" id="jms_total_units_type_3bd_property_info" name="jms_total_units_type_3bd_property_info">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th colspan="2" class="jms-table-title">Cash out Refinance</th>
                                            </tr>
                                        </thead>
                                        <tr>
                                            <th>Refinance Amount (75% LTV)</th>
                                            <td>
                                                <div class="text-end" id="jms_refinance_amount_cash_out_refinance"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Closing Cost (3%)</th>
                                            <td>
                                                <div class="text-end" id="jms_closing_cost_cash_out_refinance"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Cashout (including down payment)</th>
                                            <td>
                                                <div class="text-end" id="jms_cashout_cash_out_refinance"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Finance Fee (2%)</th>
                                            <td>
                                                <div class="text-end" id="jms_finance_fee_cash_out_refinance"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Profit</th>
                                            <td>
                                                <div class="text-end" id="jms_profit_cash_out_refinance"></div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th colspan="2" class="jms-table-title">Profit ( If I sold the property)</th>
                                            </tr>
                                        </thead>
                                        <tr>
                                            <th>ARV/Comps</th>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text" id="basic-addon1">$</span>
                                                    <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_arv_comps'] == 0 ? '' : $jms_record_prnt['jms_arv_comps']);?>" class="form-control text-end" id="jms_arv_comps" name="jms_arv_comps">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Renovation Cost</th>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text" id="basic-addon1">$</span>
                                                    <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_renovation_cost'] == 0 ? '' : $jms_record_prnt['jms_renovation_cost']);?>" class="form-control text-end" id="jms_renovation_cost" name="jms_renovation_cost">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Less Purchase Price</th>
                                            <td>
                                                <div class="text-end" id="jms_less_purchase_price"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Transaction/Cost of Sale (8%)</th>
                                            <td>
                                                <div class="text-end" id="jms_transaction_cost_of_sale"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Profit</th>
                                            <td>
                                                <div class="text-end" id="jms_profit"></div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-hover" id="jms_PROJECTED_RENT_INCREASE_ANALYSIS">
                                        <thead>
                                            <tr>
                                                <th colspan="2" class="jms-table-title">PROJECTED RENT INCREASE ANALYSIS</th>
                                            </tr>
                                        </thead>
                                        <tr>
                                            <th>Monthly Rent Per Unit: Studio</th>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text" id="basic-addon1">$</span>
                                                    <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_monthly_rent_per_unit_studio'] == 0 ? '' : $jms_record_prnt['jms_monthly_rent_per_unit_studio']);?>" class="form-control text-end" id="jms_monthly_rent_per_unit_studio" name="jms_monthly_rent_per_unit_studio">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Monthly Rent Per Unit 1bd</th>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text" id="basic-addon1">$</span>
                                                    <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_monthly_rent_per_unit_1bd'] == 0 ? '' : $jms_record_prnt['jms_monthly_rent_per_unit_1bd']);?>" class="form-control text-end" id="jms_monthly_rent_per_unit_1bd" name="jms_monthly_rent_per_unit_1bd">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Monthly Rent Per Unit 2bd</th>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text" id="basic-addon1">$</span>
                                                    <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_monthly_rent_per_unit_2bd'] == 0 ? '' : $jms_record_prnt['jms_monthly_rent_per_unit_2bd']);?>" class="form-control text-end" id="jms_monthly_rent_per_unit_2bd" name="jms_monthly_rent_per_unit_2bd">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Monthly Rent Per Unit 3+bd</th>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text" id="basic-addon1">$</span>
                                                    <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_monthly_rent_per_unit_3bd'] == 0 ? '' : $jms_record_prnt['jms_monthly_rent_per_unit_3bd']);?>" class="form-control text-end" id="jms_monthly_rent_per_unit_3bd" name="jms_monthly_rent_per_unit_3bd">
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr><th colspan="2" class="jms-table-title">Annual Property Operating Data</th></tr>
                                        </thead>
                                        <tr>
                                            <td>Potential Gross Income</td>
                                            <td>
                                                <div class="text-end" id="jms_potential_gross_income" name="jms_potential_gross_income"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Vacancy Rate (10%)</td>
                                            <td>
                                                <div class="text-end" id="jms_vacancy_rate_10" name="jms_vacancy_rate_10"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Additional Income</td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text" id="basic-addon1">$</span>
                                                    <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_additional_income'] == 0 ? '' : $jms_record_prnt['jms_additional_income']);?>" class="form-control text-end" id="jms_additional_income" name="jms_additional_income">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Gross Operating Income</th>
                                            <th>
                                                <div class="text-end" id="jms_gross_operating_income" name="jms_gross_operating_income"></div>
                                            </th>
                                        </tr>
                                    </table>

                                    

                                    <table class="table table-hover">
                                        <thead>
                                            <tr><th colspan="2" class="jms-table-title">Annual Property Operating Data</th></tr>
                                        </thead>
                                        <tr>
                                            <td>Potential Gross Income</td>
                                            <td>
                                                <div class="text-end" id="jms_potential_gross_income_2" name="jms_potential_gross_income_2"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Vacancy Rate (10%)</td>
                                            <td>
                                                <div class="text-end" id="jms_vacancy_rate_10_2" name="jms_vacancy_rate_10_2"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Gross Operating Income</th>
                                            <th>
                                                <div class="text-end" id="jms_gross_operating_income_2" name="jms_gross_operating_income_2"></div>
                                            </th>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover jms-projected-expenses" id="jms_PROJECTED_EXPENSES">
                                            <thead>
                                                <tr>
                                                    <th colspan="3" class="jms-table-title">PROJECTED EXPENSES</th>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <th>Type</th>
                                                    <th>Cost Annually</th>
                                                    <th>Monthly</th>
                                                </tr>
                                            </thead>
                                            <tr>
                                                <td>Taxes</td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text" id="basic-addon1">$</span>
                                                        <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_taxes_projected_expenses'] == 0 ? '' : $jms_record_prnt['jms_taxes_projected_expenses']);?>" class="form-control text-end" id="jms_taxes_projected_expenses" name="jms_taxes_projected_expenses">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-end" id="jms_taxes_projected_expenses_monthly"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Insurance</td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text" id="basic-addon1">$</span>
                                                        <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_insurance_projected_expenses'] == 0 ? '' : $jms_record_prnt['jms_insurance_projected_expenses']);?>" class="form-control text-end" id="jms_insurance_projected_expenses" name="jms_insurance_projected_expenses">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-end" id="jms_insurance_projected_expenses_monthly"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Water/Sewer</td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text" id="basic-addon1">$</span>
                                                        <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_water_sewer_projected_expenses'] == 0 ? '' : $jms_record_prnt['jms_water_sewer_projected_expenses']);?>" class="form-control text-end" id="jms_water_sewer_projected_expenses" name="jms_water_sewer_projected_expenses">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-end" id="jms_water_sewer_projected_expenses_monthly"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Utilities</td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text" id="basic-addon1">$</span>
                                                        <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_utilities_projected_expenses'] == 0 ? '' : $jms_record_prnt['jms_utilities_projected_expenses']);?>" class="form-control text-end" id="jms_utilities_projected_expenses" name="jms_utilities_projected_expenses">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-end" id="jms_utilities_projected_expenses_monthly"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Garbage</td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text" id="basic-addon1">$</span>
                                                        <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_garbage_projected_expenses'] == 0 ? '' : $jms_record_prnt['jms_garbage_projected_expenses']);?>" class="form-control text-end" id="jms_garbage_projected_expenses" name="jms_garbage_projected_expenses">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-end" id="jms_garbage_projected_expenses_monthly"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Management Fee</td>
                                                <td>
                                                    <div class="text-end" id="jms_management_fee_cost_annually_projected_expenses"></div>
                                                </td>
                                                <td>
                                                    <div class="text-end" id="jms_management_fee_expenses_purchase_monthly_projected_expenses"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Repairs</td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text" id="basic-addon1">$</span>
                                                        <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_repairs_projected_expenses'] == 0 ? '' : $jms_record_prnt['jms_repairs_projected_expenses']);?>" class="form-control text-end" id="jms_repairs_projected_expenses" name="jms_repairs_projected_expenses">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-end" id="jms_repairs_projected_expenses_monthly"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Legal</td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text" id="basic-addon1">$</span>
                                                        <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_legal_projected_expenses'] == 0 ? '' : $jms_record_prnt['jms_legal_projected_expenses']);?>" class="form-control text-end" id="jms_legal_projected_expenses" name="jms_legal_projected_expenses">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-end" id="jms_legal_projected_expenses_monthly"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Lanscaping</td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text" id="basic-addon1">$</span>
                                                        <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_lanscaping_projected_expenses'] == 0 ? '' : $jms_record_prnt['jms_lanscaping_projected_expenses']);?>" class="form-control text-end" id="jms_lanscaping_projected_expenses" name="jms_lanscaping_projected_expenses">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-end" id="jms_lanscaping_projected_expenses_monthly"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Pest Control</td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text" id="basic-addon1">$</span>
                                                        <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_pest_control_projected_expenses'] == 0 ? '' : $jms_record_prnt['jms_pest_control_projected_expenses']);?>" class="form-control text-end" id="jms_pest_control_projected_expenses" name="jms_pest_control_projected_expenses">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-end" id="jms_pest_control_projected_expenses_monthly"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Office</td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text" id="basic-addon1">$</span>
                                                        <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_office_projected_expenses'] == 0 ? '' : $jms_record_prnt['jms_office_projected_expenses']);?>" class="form-control text-end" id="jms_office_projected_expenses" name="jms_office_projected_expenses">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-end" id="jms_office_projected_expenses_monthly"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Other</td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text" id="basic-addon1">$</span>
                                                        <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_other_projected_expenses'] == 0 ? '' : $jms_record_prnt['jms_other_projected_expenses']);?>" class="form-control text-end" id="jms_other_projected_expenses" name="jms_other_projected_expenses">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-end" id="jms_other_projected_expenses_monthly"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Total</th>
                                                <th>
                                                    <div class="text-end" id="jms_total_cost_annually_projected_expenses"></div>
                                                </th>
                                                <th>
                                                    <div class="text-end" id="jms_total_monthlly_projected_expenses"></div>
                                                </th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr><th colspan="2" class="jms-table-title">Annual Operating Expenses</th></tr>
                                        </thead>
                                        <tr>
                                            <td>Operating expenses</td>
                                            <td>
                                                <div class="text-end" id="jms_operating_expenses" name="jms_operating_expenses"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>NOI</td>
                                            <td>
                                                <div class="text-end" id="jms_noi" name="jms_noi"></div>
                                            </td>
                                        </tr>
                                    </table>

                                    <table class="table table-hover">
                                        <thead>
                                            <tr><th colspan="2" class="jms-table-title">Mortgage</th></tr>
                                        </thead>
                                        <tr>
                                            <td>Original Loan</td>
                                            <td><div class="text-end" id="jms_original_loan_mortgage"></div></td>
                                        </tr>
                                        <tr>
                                            <td>interest (%)</td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <input type="number" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_mortgage_original_interest'] == 0 ? '' : $jms_record_prnt['jms_mortgage_original_interest']);?>" class="form-control text-end" id="jms_mortgage_original_interest" name="jms_mortgage_original_interest">
                                                    <span class="input-group-text" id="basic-addon1">%</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Refi - Loan Amount</td>
                                            <td><div class="text-end" id="jms_refi_loan_amount_mortgage"></div></td>
                                        </tr>
                                        <tr>
                                            <td>Interest(%)</td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <input type="number" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_mortgage_refi_interest'] == 0 ? '' : $jms_record_prnt['jms_mortgage_refi_interest']);?>" class="form-control text-end" id="jms_mortgage_refi_interest" name="jms_mortgage_refi_interest">
                                                    <span class="input-group-text" id="basic-addon1">%</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>

                                    <table class="table table-hover mt-5">
                                        <tr>
                                            <td>Annual Debt Service (30 year term)</td>
                                            <td>
                                                <div class="text-end" id="jms_annual_debt_service" name="jms_annual_debt_service"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Annual Cash Flow</td>
                                            <td>
                                                <div class="text-end" id="jms_annual_cash_flow" name="jms_annual_cash_flow"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Monthly NOI (10% Vacancy Rate)</td>
                                            <td>
                                                <div class="text-end" id="jms_monthly_noi_vacancy_rate" name="jms_monthly_noi_vacancy_rate"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Monthly NOI (Fully Occupied)</th>
                                            <td>
                                                <div class="text-end" id="jms_monthly_noi_fully_occupied" name="jms_monthly_noi_fully_occupied"></div>
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-hover" id="jms_financial_cost">
                                        <thead>
                                            <tr><th colspan="2" class="jms-table-title">Financial Cost</th></tr>
                                        </thead>
                                        <tr>
                                            <td>Down Payment</td>
                                            <td>
                                                <div class="text-end" id="jms_down_payment_financial_cost"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Loan Fee</td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text" id="basic-addon1">$</span>
                                                    <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_financial_cost_loan_fee_financial_cost'] == 0 ? '' : $jms_record_prnt['jms_financial_cost_loan_fee_financial_cost']);?>" class="form-control text-end" id="jms_financial_cost_loan_fee_financial_cost" name="jms_financial_cost_loan_fee_financial_cost">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Closing Cost</td>
                                            <td><div class="text-end" id="jms_closing_cost_financial_cost"></div></td>
                                        </tr>
                                        <tr>
                                            <td>Appraisal</td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text" id="basic-addon1">$</span>
                                                    <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_financial_cost_appraisal_financial_cost'] == 0 ? '' : $jms_record_prnt['jms_financial_cost_appraisal_financial_cost']);?>" class="form-control text-end" id="jms_financial_cost_appraisal_financial_cost" name="jms_financial_cost_appraisal_financial_cost">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Inspection</td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text" id="basic-addon1">$</span>
                                                    <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_financial_cost_inspection_financial_cost'] == 0 ? '' : $jms_record_prnt['jms_financial_cost_inspection_financial_cost']);?>" class="form-control text-end" id="jms_financial_cost_inspection_financial_cost" name="jms_financial_cost_inspection_financial_cost">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Cash to Close</th>
                                            <th><div class="text-end" id="jms_cash_to_close_financial_cost_financial_cost"></div></th>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr><th colspan="2" class="jms-table-title">Credit Card for Capital</th></tr>
                                        </thead>
                                        <tr>
                                            <td>Amount Borrowed</td>
                                            <td><div class="text-end" id="jms_amount_borrowed_credit_card_for_capital"></div></td>
                                        </tr>
                                        <tr>
                                            <td>Interest Rate(APR)</td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <input type="number" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_credit_card_capital_interest_rate'] == 0 ? '' : $jms_record_prnt['jms_credit_card_capital_interest_rate']);?>" class="form-control text-end" id="jms_credit_card_capital_interest_rate" name="jms_credit_card_capital_interest_rate">
                                                    <span class="input-group-text" id="basic-addon1">%</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Minimum Payment (%)</td>
                                            <td><div class="text-end" id="jms_minimum_payment_credit_card_for_capital">2.00%</div></td>
                                        </tr>
                                        <tr>
                                            <th>Min Monthly Payment</th>
                                            <td><div class="text-end" id="jms_min_monthly_payment_credit_card_for_capital"></div></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover jms-expenses-at-purchase" id="jms_EXPENSES_AT_PURCHASE">
                                            <thead>
                                                <tr>
                                                    <th colspan="3" class="jms-table-title">EXPENSES AT PURCHASE</th>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <th>Type</th>
                                                    <th>Cost Annually</th>
                                                    <th>Monthly</th>
                                                </tr>
                                            </thead>
                                            <tr>
                                                <td>Taxes</td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text" id="basic-addon1">$</span>
                                                        <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_taxes_expenses_purchase'] == 0 ? '' : $jms_record_prnt['jms_taxes_expenses_purchase']);?>" class="form-control text-end" id="jms_taxes_expenses_purchase" name="jms_taxes_expenses_purchase">
                                                    </div>
                                                </td>
                                                <td><div class="text-end" id="jms_taxes_expenses_purchase_monthly"></div></td>
                                            </tr>
                                            <tr>
                                                <td>Insurance</td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text" id="basic-addon1">$</span>
                                                        <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_insurance_expenses_purchase'] == 0 ? '' : $jms_record_prnt['jms_insurance_expenses_purchase']);?>" class="form-control text-end" id="jms_insurance_expenses_purchase" name="jms_insurance_expenses_purchase">
                                                    </div>
                                                </td>
                                                <td><div class="text-end" id="jms_insurance_expenses_purchase_monthly"></div></td>
                                            </tr>
                                            <tr>
                                                <td>Water/Sewer</td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text" id="basic-addon1">$</span>
                                                        <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_water_sewer_expenses_purchase'] == 0 ? '' : $jms_record_prnt['jms_water_sewer_expenses_purchase']);?>" class="form-control text-end" id="jms_water_sewer_expenses_purchase" name="jms_water_sewer_expenses_purchase">
                                                    </div>
                                                </td>
                                                <td><div class="text-end" id="jms_water_sewer_expenses_purchase_monthly"></div></td>
                                            </tr>
                                            <tr>
                                                <td>Utilities</td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text" id="basic-addon1">$</span>
                                                        <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_utilities_expenses_purchase'] == 0 ? '' : $jms_record_prnt['jms_utilities_expenses_purchase']);?>" class="form-control text-end" id="jms_utilities_expenses_purchase" name="jms_utilities_expenses_purchase">
                                                    </div>
                                                </td>
                                                <td><div class="text-end" id="jms_utilities_expenses_purchase_monthly"></div></td>
                                            </tr>
                                            <tr>
                                                <td>Garbage</td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text" id="basic-addon1">$</span>
                                                        <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_garbage_expenses_purchase'] == 0 ? '' : $jms_record_prnt['jms_garbage_expenses_purchase']);?>" class="form-control text-end" id="jms_garbage_expenses_purchase" name="jms_garbage_expenses_purchase">
                                                    </div>
                                                </td>
                                                <td><div class="text-end" id="jms_garbage_expenses_purchase_monthly"></div></td>
                                            </tr>
                                            <tr>
                                                <td>Management Fee</td>
                                                <td>
                                                    <div class="text-end" id="jms_management_fee_cost_annually"></div>
                                                </td>
                                                <td>
                                                    <div class="text-end" id="jms_management_fee_expenses_purchase_monthly"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Repairs</td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text" id="basic-addon1">$</span>
                                                        <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_repairs_expenses_purchase'] == 0 ? '' : $jms_record_prnt['jms_repairs_expenses_purchase']);?>" class="form-control text-end" id="jms_repairs_expenses_purchase" name="jms_repairs_expenses_purchase">
                                                    </div>
                                                </td>
                                                <td><div class="text-end" id="jms_repairs_expenses_purchase_monthly"></div></td>
                                            </tr>
                                            <tr>
                                                <td>Legal</td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text" id="basic-addon1">$</span>
                                                        <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_legal_expenses_purchase'] == 0 ? '' : $jms_record_prnt['jms_legal_expenses_purchase']);?>" class="form-control text-end" id="jms_legal_expenses_purchase" name="jms_legal_expenses_purchase">
                                                    </div>
                                                </td>
                                                <td><div class="text-end" id="jms_legal_expenses_purchase_monthly"></div></td>
                                            </tr>
                                            <tr>
                                                <td>Lanscaping</td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text" id="basic-addon1">$</span>
                                                        <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_lanscaping_expenses_purchase'] == 0 ? '' : $jms_record_prnt['jms_lanscaping_expenses_purchase']);?>" class="form-control text-end" id="jms_lanscaping_expenses_purchase" name="jms_lanscaping_expenses_purchase">
                                                    </div>
                                                </td>
                                                <td><div class="text-end" id="jms_lanscaping_expenses_purchase_monthly"></div></td>
                                            </tr>
                                            <tr>
                                                <td>Pest Control</td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text" id="basic-addon1">$</span>
                                                        <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_pest_control_expenses_purchase'] == 0 ? '' : $jms_record_prnt['jms_pest_control_expenses_purchase']);?>" class="form-control text-end" id="jms_pest_control_expenses_purchase" name="jms_pest_control_expenses_purchase">
                                                    </div>
                                                </td>
                                                <td><div class="text-end" id="jms_pest_control_expenses_purchase_monthly"></div></td>
                                            </tr>
                                            <tr>
                                                <td>Office</td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text" id="basic-addon1">$</span>
                                                        <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_office_expenses_purchase'] == 0 ? '' : $jms_record_prnt['jms_office_expenses_purchase']);?>" class="form-control text-end" id="jms_office_expenses_purchase" name="jms_office_expenses_purchase">
                                                    </div>
                                                </td>
                                                <td><div class="text-end" id="jms_office_expenses_purchase_monthly"></div></td>
                                            </tr>
                                            <tr>
                                                <td>Other</td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text" id="basic-addon1">$</span>
                                                        <input type="text" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_other_expenses_purchase'] == 0 ? '' : $jms_record_prnt['jms_other_expenses_purchase']);?>" class="form-control text-end" id="jms_other_expenses_purchase" name="jms_other_expenses_purchase">
                                                    </div>
                                                </td>
                                                <td><div class="text-end" id="jms_other_expenses_purchase_monthly"></div></td>
                                            </tr>
                                            <tr>
                                                <th>Total</th>
                                                <th class="text-end" id="jms_total_cost_annually"></th>
                                                <th class="text-end" id="jms_total_monthlly"></th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                     <table class="table table-hover">
                                        <thead>
                                            <tr><th colspan="2" class="jms-table-title">Annual Operating Expenses</th></tr>
                                        </thead>
                                        <tr>
                                            <td>Operating expenses</td>
                                            <td>
                                                <div class="text-end" id="jms_operating_expenses_2" name="jms_operating_expenses_2"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>NOI</td>
                                            <td>
                                                <div class="text-end" id="jms_noi_2" name="jms_noi_2"></div>
                                            </td>
                                        </tr>
                                    </table>

                                    <table class="table table-hover mt-3">
                                        <tr>
                                            <td>Annual Debt Service (30 year term)</td>
                                            <td>
                                                <div class="text-end" id="jms_annual_debt_service_2" name="jms_annual_debt_service_2"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Credit Card Min Annual Payment</td>
                                            <td>
                                                <div class="text-end" id="jms_credit_card_min_annual_payment_2" name="jms_credit_card_min_annual_payment_2"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Annual Cash Flow</td>
                                            <td>
                                                <div class="text-end" id="jms_annual_cash_flow_2" name="jms_annual_cash_flow_2"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Monthly NOI (10% Vacancy Rate)</td>
                                            <td>
                                                <div class="text-end" id="jms_monthly_noi_vacancy_rate_2" name="jms_monthly_noi_vacancy_rate_2"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Monthly NOI (Fully Occupied)</th>
                                            <td>
                                                <div class="text-end" id="jms_monthly_noi_fully_occupied_2" name="jms_monthly_noi_fully_occupied_2"></div>
                                            </td>
                                        </tr>
                                    </table>


                                    <table class="table table-hover">
                                        <thead>
                                            <tr><th colspan="2" class="jms-table-title">Simple Comparison Analysis</th></tr>
                                        </thead>
                                        <tr>
                                            <td>NOI per unit (monthly)</td>
                                            <td>
                                                <div class="text-end" id="jms_noi_per_unit_monthly" name="jms_noi_per_unit_monthly"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>pp sq ft</td>
                                            <td>
                                                <div class="text-end" id="jms_pp_sq_ft" name="jms_pp_sq_ft"></div>
                                            </td>
                                        </tr>
                                    </table>
                                    

                                    <table class="table table-hover mt-3">
                                        <thead>
                                            <tr><th colspan="2" class="jms-table-title">Initial Analysis - Key Numbers</th></tr>
                                        </thead>
                                        <tr>
                                            <th>CAP Rate</th>
                                            <td>
                                                <div class="text-end" id="jms_cap_rate" name="jms_cap_rate"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Cash on Cash Return</th>
                                            <td>
                                                <div class="text-end" id="jms_cash_on_cash_return" name="jms_cash_on_cash_return"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Debt Coverage Ratio</th>
                                            <td>
                                                <div class="text-end" id="jms_debt_coverage_ratio" name="jms_debt_coverage_ratio"></div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="jms-message"></div>
                                
                                <div class="col-md-12 d-flex justify-content-center">
                                    <div class="row">
                                        <div class="col-md-12 d-flex justify-content-center">
                                            <div class="jms-loader" id="jms_loading"></div>
                                        </div>
                                        <div class="col-md-12 d-flex justify-content-center">
                                            <button class="jms-form-submit" id="jms_edit_buy_hold_analysis_save_btn" name="jms_edit_buy_hold_analysis_save_btn">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php include("footer.php"); ?>
        <script type="text/javascript" src="js/buy_hold_analysis_calculation_and_data_save.js"></script>
    </body>
</html>