<?php 
    include('connection.php');
    if(!isset($_SESSION['jms_user_id']))
    {
        header("location:index.php");
    }
    include("header.php");

    if(isset($_GET['id']) && $_GET['id'])
    {
        $data_id = $_GET['id'];
    }
    else
    {
        $data_id = 0;
    }

    // get data

    $jms_select_sql = "SELECT * FROM `deal-evaluation-calc` WHERE id=:data_id";
    $jms_select_data = $jms_pdo->prepare($jms_select_sql);
    $jms_select_data->bindParam(':data_id', $data_id,PDO::PARAM_INT);
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
    }
    else 
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

    <title>Deal Evaluation</title>

    <!-- Style css -->
    <link rel="stylesheet" type="text/css" href="css/form.css">
    <style type="text/css">
        .jms-container table tr td 
        {
            width: 50%;
            vertical-align: middle;
            padding: 5px !important;
        }
        .jms-expense-financial-cost .form-control 
        {
            padding: 5px !important;
        }
        .jms-expense-financial-cost .form-control:focus 
        {
            box-shadow: none !important;
            border-color: #999 !important;
        }
        .jms-container .table-hover>tbody>tr:hover 
        {
            --bs-table-accent-bg: #007dfe1c !important;
        }
        .jms-expense-financial-cost .jms-heading 
        {
            font-size: 3rem;
            font-weight: bold;
        }
        .jms-projected-expenses tr td,
        .jms-expenses-at-purchase tr td 
        {
            width: 33.33% !important;
        }

        .jms-table-title 
        {
            background: linear-gradient(45deg, var(--primary-color-blue), transparent);
            color: white;
        }
        .jms-expense-financial-cost .input-group .input-group-text 
        {
            background: white;
            border: none;
            border-bottom: 1px solid #999 !important;
            border-radius: 0px;
        }
        .jms-expense-financial-cost input,
        .jms-expense-financial-cost input:focus,
        .jms-expense-financial-cost .input-group input,
        .jms-expense-financial-cost .input-group input:focus 
        {
            border: none !important;
            border-bottom: 1px solid #999 !important;
            border-radius: 0px !important;
        }
        .jms-table-mortgage tr td span,.jms-table-property-expenses-col table tr td span
        {
            background: yellow;
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
        <div class="jms-container jms-expense-financial-cost p-3">
            <input type="hidden" id="jms_user_id" name="jms_user_id" value="<?php echo $data_id;?>">
            <div class="row">
                <div class="col-md-12">
                    <div class="jms-heading text-center my-3">Deal Evaluation Calculator</div>
                </div>

                <div class="jms-calcutor-section">
                    <div class="row d-flex justify-content-center">

                        <!-- personal details -->
                        <div class="col-md-8">
                            <table class="table table-hover">
                                <!-- <thead>
                                    <tr>
                                        <th colspan="2" class="jms-table-title">All in cost 
                                        </th>
                                    </tr>
                                </thead> -->
                                <tr>
                                    <td>Property Address</td>
                                    <td>
                                        <input type="text" class="form-control" id="jms_name" name="jms_name" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_name'] == "" ? '' : $jms_record_prnt['jms_name']);?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Date</td>
                                    <td>
                                        <input type="date" class="w-100" id="jms_date" name="jms_date" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_date'] == "" ? '' : $jms_record_prnt['jms_date']);?>">
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- All in cost: -->
                        <div class="col-md-8">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="jms-table-title">All in cost 
                                        </th>
                                    </tr>
                                </thead>
                                <tr>
                                    <td>Property cost</td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text" id="basic-addon1">$</span>
                                            <input type="text" class="form-control text-end" id="jms_property_cost"
                                                name="jms_property_cost" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_property_cost'] == "" ? '' : $jms_record_prnt['jms_property_cost']);?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Down Payment</td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text" id="basic-addon1">$</span>
                                            <input type="text" class="form-control text-end" id="jms_down_payment"
                                                name="jms_down_payment" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_down_payment'] == "" ? '' : $jms_record_prnt['jms_down_payment']);?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Down Payment Percentage</td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <input type="number" class="form-control text-end" id="jms_down_payment_percentage" name="jms_down_payment_percentage" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_down_payment_percentage'] == "" ? '' : $jms_record_prnt['jms_down_payment_percentage']);?>">
                                            <span class="input-group-text" id="basic-addon1">%</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Residential Appraisal </td>
                                    <td>
                                        <input type="number" class="form-control text-end" id="jms_residential_appraisal" name="jms_residential_appraisal" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_residential_appraisal'] == "" ? '' : $jms_record_prnt['jms_residential_appraisal']);?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Inspection </td>
                                    <td>
                                        <input type="number" class="form-control text-end" id="jms_inspection" name="jms_inspection" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_inspection'] == "" ? '' : $jms_record_prnt['jms_inspection']);?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Closing cost</td>
                                    <td class="d-flex w-100 justify-content-between align-items-center">
                                        <div class="input-group input-group-sm w-50">
                                            <input type="number" class="form-control text-end" id="jms_closing_percentage" name="jms_closing_percentage" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_inspection'] == "" ? '' : $jms_record_prnt['jms_inspection']);?>">
                                            <span class="input-group-text" id="basic-addon1">%</span>
                                        </div>
                                        <div class="text-end" id="jms_closing_cost"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>All In Cost Total</th>
                                    <td>
                                        <div class="text-end" id="jms_all_in_cost_total"></div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- Mortgage: -->
                        <div class="col-md-8">
                            <table class="table table-hover jms-table-mortgage">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="jms-table-title">Mortgage
                                        </th>
                                    </tr>
                                </thead>
                                <tr>
                                    <td>Loan Amount</td>
                                    <td>
                                        <div class="text-end" id="jms_loan_amount"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Annual Interest Rate</td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <input type="number" class="form-control text-end" id="jms_annual_interest_rate" name="jms_annual_interest_rate" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_annual_interest_rate'] == "" ? '' : $jms_record_prnt['jms_annual_interest_rate']);?>">
                                            <span class="input-group-text" id="basic-addon1">%</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Number of Years</td>
                                    <td>
                                        <input type="number" class="form-control text-end" id="jms_number_of_years" name="jms_number_of_years" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_number_of_years'] == "" ? '' : $jms_record_prnt['jms_number_of_years']);?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td><span>Monthly Payment</span></td>
                                    <td>
                                        <div class="text-end"><span id="jms_monthly_payment"></span></div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- Carrying Cost: -->
                        <div class="col-md-8">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="jms-table-title">Carrying Cost
                                        </th>
                                    </tr>
                                </thead>
                                <tr>
                                    <td>Carrying Cost</td>
                                    <td>
                                        <div class="text-end" id="jms_carrying_cost"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Card Annual APR</td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <input type="number" class="form-control text-end" id="jms_card_annual_apr" name="jms_card_annual_apr" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_card_annual_apr'] == "" ? '' : $jms_record_prnt['jms_card_annual_apr']);?>">
                                            <span class="input-group-text" id="basic-addon1">%</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Find Monthly Carrying Cost Fee</td>
                                    <td>
                                        <div class="text-end" id="jms_find_monthly_carrying_cost_fee"></div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- Property Expenses: -->
                        <div class="col-md-8 jms-table-property-expenses-col">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="jms-table-title">Property Expenses
                                        </th>
                                    </tr>
                                </thead>
                                <tr>
                                    <th>Repairs-Annually</th>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text" id="basic-addon1">$</span>
                                            <input type="text" class="form-control text-end" id="jms_repairs_annually" name="jms_repairs_annually" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_repairs_annually'] == "" ? '' : $jms_record_prnt['jms_repairs_annually']);?>">
                                        </div>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td>Yearly</td>
                                    <td>
                                        <div class="text-end" id="jms_repairs_yearly"></div>
                                    </td>
                                </tr> -->
                                <tr>
                                    <td><span>Monthly</span></td>
                                    <td>
                                        <div class="text-end"><span id="jms_repairs_monthly"></span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Daily</td>
                                    <td>
                                        <div class="text-end" id="jms_repairs_daily"></div>
                                    </td>
                                </tr>
                            </table>

                            <table class="table table-hover">
                                <tr>
                                    <th>Utilities-Annually</th>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text" id="basic-addon1">$</span>
                                            <input type="text" class="form-control text-end" id="jms_utilities"
                                                name="jms_utilities"  value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_utilities'] == "" ? '' : $jms_record_prnt['jms_utilities']);?>">
                                        </div>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td>Yearly</td>
                                    <td>
                                        <div class="text-end" id="jms_utilities_yearly"></div>
                                    </td>
                                </tr> -->
                                <tr>
                                    <td><span>Monthly</span></td>
                                    <td>
                                        <div class="text-end"><span id="jms_utilities_monthly"></span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Daily</td>
                                    <td>
                                        <div class="text-end" id="jms_utilities_daily"></div>
                                    </td>
                                </tr>
                            </table>

                            <table class="table table-hover">
                                <tr>
                                    <th>Home Warranty-Annually</th>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text" id="basic-addon1">$</span>
                                            <input type="text" class="form-control text-end" id="jms_home_warranty"
                                                name="jms_home_warranty"  value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_home_warranty'] == "" ? '' : $jms_record_prnt['jms_home_warranty']);?>">
                                        </div>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td>Yearly</td>
                                    <td>
                                        <div class="text-end" id="jms_home_warranty_yearly"></div>
                                    </td>
                                </tr> -->
                                <tr>
                                    <td><span>Monthly</span></td>
                                    <td>
                                        <div class="text-end"><span id="jms_home_warranty_monthly"></span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Daily</td>
                                    <td>
                                        <div class="text-end" id="jms_home_warranty_daily"></div>
                                    </td>
                                </tr>
                            </table>

                            <table class="table table-hover">
                                <tr>
                                    <th>Trash Removal-Annually</th>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text" id="basic-addon1">$</span>
                                            <input type="text" class="form-control text-end" id="jms_trash_removal"
                                                name="jms_trash_removal"  value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_trash_removal'] == "" ? '' : $jms_record_prnt['jms_trash_removal']);?>">
                                        </div>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td>Yearly</td>
                                    <td>
                                        <div class="text-end" id="jms_trash_removal_yearly"></div>
                                    </td>
                                </tr> -->
                                <tr>
                                    <td><span>Monthly</span></td>
                                    <td>
                                        <div class="text-end"><span id="jms_trash_removal_monthly"></span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Daily</td>
                                    <td>
                                        <div class="text-end" id="jms_trash_removal_daily"></div>
                                    </td>
                                </tr>
                            </table>

                            <table class="table table-hover">
                                <tr>
                                    <th>Landscaping-Annually</th>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text" id="basic-addon1">$</span>
                                            <input type="text" class="form-control text-end" id="jms_landscaping"
                                                name="jms_landscaping"  value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_landscaping'] == "" ? '' : $jms_record_prnt['jms_landscaping']);?>">
                                        </div>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td>Yearly</td>
                                    <td>
                                        <div class="text-end" id="jms_landscaping_yearly"></div>
                                    </td>
                                </tr> -->
                                <tr>
                                    <td><span>Monthly</span></td>
                                    <td>
                                        <div class="text-end"><span id="jms_landscaping_monthly"></span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Daily</td>
                                    <td>
                                        <div class="text-end" id="jms_landscaping_daily"></div>
                                    </td>
                                </tr>
                            </table>

                            <table class="table table-hover">
                                <tr>
                                    <th>Property Management(10% of Rents)-Annually</th>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text" id="basic-addon1">$</span>
                                            <input type="text" class="form-control text-end" id="jms_property_management"
                                                name="jms_property_management"  value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_property_management'] == "" ? '' : $jms_record_prnt['jms_property_management']);?>">
                                        </div>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td>Yearly</td>
                                    <td>
                                        <div class="text-end" id="jms_property_management_yearly"></div>
                                    </td>
                                </tr> -->
                                <tr>
                                    <td><span>Monthly</span></td>
                                    <td>
                                        <div class="text-end"><span id="jms_property_management_monthly"></span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Daily</td>
                                    <td>
                                        <div class="text-end" id="jms_property_management_daily"></div>
                                    </td>
                                </tr>
                            </table>

                            <table class="table table-hover">
                                <tr>
                                    <th>Property Taxes-Annually</th>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text" id="basic-addon1">$</span>
                                            <input type="text" class="form-control text-end" id="jms_property_taxes"
                                                name="jms_property_taxes"  value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_property_taxes'] == "" ? '' : $jms_record_prnt['jms_property_taxes']);?>">
                                        </div>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td>Yearly</td>
                                    <td>
                                        <div class="text-end" id="jms_property_taxes_yearly"></div>
                                    </td>
                                </tr> -->
                                <tr>
                                    <td><span>Monthly</span></td>
                                    <td>
                                        <div class="text-end"><span id="jms_property_taxes_monthly"></span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Daily</td>
                                    <td>
                                        <div class="text-end" id="jms_property_taxes_daily"></div>
                                    </td>
                                </tr>
                            </table>

                            <table class="table table-hover">
                                <tr>
                                    <th>Home Owners Insurance-Annually</th>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text" id="basic-addon1">$</span>
                                            <input type="text" class="form-control text-end" id="jms_home_owners_insurance" name="jms_home_owners_insurance"  value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_home_owners_insurance'] == "" ? '' : $jms_record_prnt['jms_home_owners_insurance']);?>">
                                        </div>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td>Yearly</td>
                                    <td>
                                        <div class="text-end" id="jms_home_owners_insurance_yearly"></div>
                                    </td>
                                </tr> -->
                                <tr>
                                    <td><span>Monthly</span></td>
                                    <td>
                                        <div class="text-end"><span id="jms_home_owners_insurance_monthly"></span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Daily</td>
                                    <td>
                                        <div class="text-end" id="jms_home_owners_insurance_daily"></div>
                                    </td>
                                </tr>
                            </table>

                            <table class="table table-hover">
                                <tr>
                                    <th>Cap Ex-Annually</th>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text" id="basic-addon1">$</span>
                                            <input type="text" class="form-control text-end" id="jms_cap_ex"
                                                name="jms_cap_ex"  value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_cap_ex'] == "" ? '' : $jms_record_prnt['jms_cap_ex']);?>">
                                        </div>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td>Yearly</td>
                                    <td>
                                        <div class="text-end" id="jms_cap_ex_yearly"></div>
                                    </td>
                                </tr> -->
                                <tr>
                                    <td><span>Monthly</span></td>
                                    <td>
                                        <div class="text-end"><span id="jms_cap_ex_monthly"></span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Daily</td>
                                    <td>
                                        <div class="text-end" id="jms_cap_ex_daily"></div>
                                    </td>
                                </tr>
                            </table>

                            <table class="table table-hover">
                                <tr>
                                    <th>Raw Expenses Total-Annually</th>
                                    <td>
                                        <div class="text-end" id="jms_raw_expenses_total"></div>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td>Yearly</td>
                                    <td>
                                        <div class="text-end" id="jms_raw_expenses_total_yearly"></div>
                                    </td>
                                </tr> -->
                                <tr>
                                    <td><span>Monthly</span></td>
                                    <td>
                                        <div class="text-end"><span id="jms_raw_expenses_total_monthly"></span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Daily</td>
                                    <td>
                                        <div class="text-end" id="jms_raw_expenses_total_daily"></div>
                                    </td>
                                </tr>
                            </table>

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="jms-table-title">Combined Carrying Cost and Mortgage Expenses
                                        </th>
                                    </tr>
                                </thead>
                                <!-- <tr>
                                    <th>CrC+Mtg Expenses</th>
                                    <th>
                                        <div class="text-end" id="jms_crc_mtg_expenses"></div>
                                    </th>
                                </tr> -->
                                <tr>
                                    <td>Yearly</td>
                                    <td>
                                        <div class="text-end" id="jms_yearly_crc"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Monthly</td>
                                    <td>
                                        <div class="text-end" id="jms_monthly_crc"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Daily</td>
                                    <td>
                                        <div class="text-end" id="jms_daily_crc"></div>
                                    </td>
                                </tr>
                            </table>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="jms-table-title">Gross Operating Expenses
                                        </th>
                                       <!--  <th>
                                            <div class="text-end text-dark" id="jms_raw_expenses_crc_mtg_total"></div>
                                        </th> -->
                                    </tr>
                                </thead>

                                <!-- <tr>
                                    <td>Raw Expenses + CrC+Mtg Total</td>
                                    <td>
                                        <div class="text-end" id="jms_raw_expenses_crc_mtg_total"></div>
                                    </td>
                                </tr> -->
                                
                                <tr>
                                    <td>Yearly</td>
                                    <td>
                                        <div class="text-end" id="jms_yearly_crc_mtg"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Monthly</td>
                                    <td>
                                        <div class="text-end" id="jms_monthly_crc_mtg"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Daily</td>
                                    <td>
                                        <div class="text-end" id="jms_daily_crc_mtg"></div>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <th>Operating Expense Per Month</th>
                                    <th>
                                        <div class="text-end" id="jms_operating_expense_per_month"></div>
                                    </th>
                                </tr> -->
                            </table>

                        </div>

                        <!-- Property Income: -->
                        <div class="col-md-8">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="jms-table-title">Property Income
                                        </th>
                                    </tr>
                                </thead>
                                <tr>
                                    <td>Total Units</td>
                                    <td>
                                        <input type="number" class="form-control text-end" id="jms_total_units" name="jms_total_units" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_total_units'] == "" ? '' : $jms_record_prnt['jms_total_units']);?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Rent per unit</td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text" id="basic-addon1">$</span>
                                            <input type="text" class="form-control text-end" id="jms_rent_per_unit"
                                                name="jms_rent_per_unit" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_rent_per_unit'] == "" ? '' : $jms_record_prnt['jms_rent_per_unit']);?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total rent</td>
                                    <td>
                                        <div class="text-end" id="jms_total_rent"></div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- Other sources of income: -->
                        <div class="col-md-8">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="jms-table-title">Other sources of income
                                        </th>
                                    </tr>
                                </thead>
                                <tr>
                                    <th>Pets</th>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text" id="basic-addon1">$</span>
                                            <input type="text" class="form-control text-end" id="jms_pets"
                                                name="jms_pets" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_pets'] == "" ? '' : $jms_record_prnt['jms_pets']);?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Yearly</td>
                                    <td>
                                        <div class="text-end" id="jms_pets_yearly"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Monthly</td>
                                    <td>
                                        <div class="text-end" id="jms_pets_monthly"></div>
                                    </td>
                                </tr>
                            </table>

                            <table class="table table-hover">
                                <tr>
                                    <th>Parking</th>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text" id="basic-addon1">$</span>
                                            <input type="text" class="form-control text-end" id="jms_parking"
                                                name="jms_parking" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_parking'] == "" ? '' : $jms_record_prnt['jms_parking']);?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Yearly</td>
                                    <td>
                                        <div class="text-end" id="jms_parking_yearly"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Monthly</td>
                                    <td>
                                        <div class="text-end" id="jms_parking_monthly"></div>
                                    </td>
                                </tr>
                            </table>

                            <table class="table table-hover">
                                <tr>
                                    <th>Laundry</th>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text" id="basic-addon1">$</span>
                                            <input type="text" class="form-control text-end" id="jms_laundry"
                                                name="jms_laundry" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_laundry'] == "" ? '' : $jms_record_prnt['jms_laundry']);?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Yearly</td>
                                    <td>
                                        <div class="text-end" id="jms_laundry_yearly"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Monthly</td>
                                    <td>
                                        <div class="text-end" id="jms_laundry_monthly"></div>
                                    </td>
                                </tr>
                            </table>

                            <table class="table table-hover">
                                <tr>
                                    <th>Storage</th>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text" id="basic-addon1">$</span>
                                            <input type="text" class="form-control text-end" id="jms_storage"
                                                name="jms_storage" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_storage'] == "" ? '' : $jms_record_prnt['jms_storage']);?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Yearly</td>
                                    <td>
                                        <div class="text-end" id="jms_storage_yearly"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Monthly</td>
                                    <td>
                                        <div class="text-end" id="jms_storage_monthly"></div>
                                    </td>
                                </tr>
                            </table>

                            <table class="table table-hover">
                                <tr>
                                    <th>Alarm Systems</th>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text" id="basic-addon1">$</span>
                                            <input type="text" class="form-control text-end" id="jms_alarm_systems"
                                                name="jms_alarm_systems" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_alarm_systems'] == "" ? '' : $jms_record_prnt['jms_alarm_systems']);?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Yearly</td>
                                    <td>
                                        <div class="text-end" id="jms_alarm_systems_yearly"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Monthly</td>
                                    <td>
                                        <div class="text-end" id="jms_alarm_systems_monthly"></div>
                                    </td>
                                </tr>
                            </table>

                            <table class="table table-hover">
                                <tr>
                                    <th>Total Property Income</th>
                                    <td>
                                        <div class="text-end" id="jms_total_property_income"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Yearly</td>
                                    <td>
                                        <div class="text-end" id="jms_total_property_income_yearly"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Monthly</td>
                                    <td>
                                        <div class="text-end" id="jms_total_property_income_monthly"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Daily</td>
                                    <td>
                                        <div class="text-end" id="jms_total_property_daily"></div>
                                    </td>
                                </tr>
                                
                            </table>
                        </div>

                        <!-- R.O.I -->
                        <div class="col-md-8">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="jms-table-title">Operating Net Income
                                        </th>
                                    </tr>
                                </thead>
                                <!-- <tr>
                                    <td>Net Operating Income (Find NOI rename pending)</td>
                                    <td>
                                        <div class="text-end" id="jms_total_property_find_noi"></div>
                                    </td>
                                </tr> -->
                                <tr>
                                    <td>Yearly Cash Flow</td>
                                    <td>
                                        <div class="text-end" id="jms_total_property_find_noi"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Monthly Cash Flow</td>
                                    <td>
                                        <div class="text-end" id="jms_total_property_find_noi_monthly"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Daily Cash Flow</td>
                                    <td>
                                        <div class="text-end" id="jms_total_property_find_noi_daily"></div>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td>Yearly cash flow ÷ All in cost</td>
                                    <td>
                                        <div class="text-end" id="jms_yearly_cash_flow_all_in_cost"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Answer From Above multiply *100</td>
                                    <td>
                                        <div class="text-end" id="jms_answer_from_above_multiply_100"></div>
                                    </td>
                                </tr> -->
                                <tr>
                                    <td>ROI(%)</td>
                                    <td>
                                        <div class="text-end" id="jms_roi_per"></div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- Mortgage: -->
                        <div class="col-md-8">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="jms-table-title">New mortgage to Refinanced Mortgage Note
                                        </th>
                                    </tr>
                                </thead>
                                <tr>
                                    <td>New Property Appraisal Price</td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text" id="basic-addon1">$</span>
                                            <input type="text" class="form-control text-end" id="jms_new_property_appraisal_price" name="jms_new_property_appraisal_price" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_new_property_appraisal_price'] == "" ? '' : $jms_record_prnt['jms_new_property_appraisal_price']);?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>LTV Ratio Percentage</td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <input type="number" class="form-control text-end" id="jms_ltv_ratio_percentage" name="jms_ltv_ratio_percentage" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_ltv_ratio_percentage'] == "" ? '' : $jms_record_prnt['jms_ltv_ratio_percentage']);?>">
                                            <span class="input-group-text" id="basic-addon1">%</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Loan Amount</td>
                                    <td>
                                        <div class="text-end" id="jms_mortgage_loan_amount"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Annual Interest Rate</td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <input type="number" class="form-control text-end" id="jms_mortgage_annual_interest_rate" name="jms_mortgage_annual_interest_rate"  value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_mortgage_annual_interest_rate'] == "" ? '' : $jms_record_prnt['jms_mortgage_annual_interest_rate']);?>">
                                            <span class="input-group-text" id="basic-addon1">%</span>
                                        </div>
                                        <!-- <div class="text-end" id="jms_mortgage_annual_interest_rate"></div> -->
                                    </td>
                                </tr>
                                <tr>
                                    <td>Number of Years</td>
                                    <td>
                                        <input type="number" class="form-control text-end" id="jms_mortgage_number_of_years" name="jms_mortgage_number_of_years"  value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_mortgage_number_of_years'] == "" ? '' : $jms_record_prnt['jms_mortgage_number_of_years']);?>">
                                        <!-- <div class="text-end" id="jms_mortgage_number_of_years"></div> -->
                                    </td>
                                </tr>
                                <tr>
                                    <td>Yearly Payment</td>
                                    <td>
                                        <div class="text-end" id="jms_mortgage_yearly_payment"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Monthly Payment</td>
                                    <td>
                                        <div class="text-end" id="jms_mortgage_monthly_payment"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Daily Payment</td>
                                    <td>
                                        <div class="text-end" id="jms_mortgage_daily_payment"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Closing cost</td>
                                    <td class="d-flex w-100 justify-content-between align-items-center">
                                        <div class="input-group input-group-sm w-50">
                                            <input type="number" class="form-control text-end" id="jms_closing_cost_per" name="jms_closing_cost_per" value="<?php echo $jms_print == "" ? '' : ($jms_record_prnt['jms_closing_cost_per'] == "" ? '' : $jms_record_prnt['jms_closing_cost_per']);?>">
                                            <span class="input-group-text" id="basic-addon1">%</span>
                                        </div>
                                        <div class="text-end" id="jms_mortgage_closing_cost_5per"></div>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td>Closing Cost @<span id="jms_closing_cost_per">5</span>%</td>
                                    <td>
                                        <div class="text-end" id="jms_mortgage_closing_cost_5per"></div>
                                    </td>
                                </tr> -->
                                <tr>
                                    <td>Carrying cost</td>
                                    <td>
                                        <div class="text-end" id="jms_mortgage_carrying_cost"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td>
                                        <div class="text-end" id="jms_mortgage_total"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Remaining Cash Balance</td>
                                    <td>
                                        <div class="text-end" id="jms_mortgage_remaining_cash_balance"></div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- Projected NOI After Refinance: -->
                        <div class="col-md-8">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="jms-table-title">Projected NOI After Refinance
                                        </th>
                                    </tr>
                                </thead>
                                <!-- <tr>
                                    <td>New mortgage monthly payment + Raw Expenses</td>
                                    <td>
                                        <div class="text-end" id="jms_new_mortgage_monthly_payment_raw_expenses"></div>
                                    </td>
                                </tr> -->
                                <tr>
                                    <td>Gross Operating Income Yearly</td>
                                    <td>
                                        <div class="text-end" id="jms_noi_yearly"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Gross Operating Income Monthly</td>
                                    <td>
                                        <div class="text-end" id="jms_noi_monthly"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Gross Operating Income Daily</td>
                                    <td>
                                        <div class="text-end" id="jms_noi_daily"></div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- R.O.I After Refinance : -->
                        <div class="col-md-8">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="jms-table-title">R.O.I After Refinance 
                                        </th>
                                    </tr>
                                </thead>
                                <tr>
                                    <td>Net Operating Income (NOI) Monthly</td>
                                    <td>
                                        <div class="text-end" id="jms_12_by_noi"></div>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td>Yearly cash flow / All in cost</td>
                                    <td>
                                        <div class="text-end" id="jms_yearly_cash_flow_all_in_cost_2"></div>
                                    </td>
                                </tr> -->
                                <tr>
                                    <td>ROI(%)</td>
                                    <td>
                                        <div class="text-end" id="jms_roi_per_2"></div>
                                    </td>
                                </tr>
                            </table>
                            <div class="jms-message"></div>
                        </div>

                        <div class="col-md-12 d-flex justify-content-center">
                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <div class="jms-loader" id="jms_loading"></div>
                                </div>
                                <div class="col-md-12 d-flex justify-content-center">
                                    <button class="jms-form-submit" id="jms_edit_deal_evaluation_save_btn" name="jms_edit_deal_evaluation_save_btn">Update</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include("footer.php"); ?>
</body>
<script type="text/javascript" src="js/deal_evaluation_calculate_and_data_save.js"></script>
</html>