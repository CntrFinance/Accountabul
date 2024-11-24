<?php
    include("../connection.php");

    if(!isset($_SESSION['jms_admin_user_id']))
    {
        header("location:index.php");
    }
    
    $admin_id = $_SESSION['jms_admin_user_id'];

    // get admin setting data

    $jms_select_sql = "SELECT * FROM `setting` WHERE admin_id=:admin_id";
    $jms_select_data = $jms_pdo->prepare($jms_select_sql);
    $jms_select_data->bindParam(':admin_id', $admin_id,PDO::PARAM_INT);
    $jms_select_data->execute();
    $jms_row = $jms_select_data->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("header.php"); ?>

    <title>Setting</title>

    <!-- css link -->
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <style type="text/css">
        .card-header
        {
            background-color: var(--white) !important;
        }
        .card-footer
        {
            background-color: var(--white) !important;
            border-top:1px solid rgba(0,0,0,.125) !important;
            border-radius: 0px 0px 5px 5px;
        }
        .display-4 
        {
            font-size: 1.5rem;
            font-weight: 400;
        }
        .input-group .input-group-prepend .input-group-text
        {
            background: #fff;
            border-bottom: 1px solid #cdcdcd !important;
            border-radius: 0px;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">

<?php include("menu.php"); ?>

<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
                <div class="col-md-12 mt-5">
                    <div class="card card-outline card-primary">
                        <div class="card-header text-center">
                            <h3 class="card-title">Setting</h3>
                        </div>
                        <form class="jms-setting-form" id="jms_setting_form" name="jms_setting_form">
                            <div class="card-body">
                                <div class="row border rounded my-3 justify-content-center">
                                    <div class="col-md-12">
                                        <div class="text-center border-bottom my-3">
                                            <div class="display-4 mb-2">Fixed Save Price</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="jms_deal_evalution_price">Deal Evalution Price</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">$</span>
                                                </div>
                                                <input type="number" class="form-control text-right" name="jms_deal_evalution_price" id="jms_deal_evalution_price" placeholder="Enter Deal Evalution 1 Save Price" value="<?php echo isset($jms_row[0]['jms_deal_evalution_price']) ? $jms_row[0]['jms_deal_evalution_price'] : 0;?>" step="0.01" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="jms_buy_and_hold_analysis_price">Buy and Hold Analysis Price</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">$</span>
                                                </div>
                                                <input type="number" class="form-control text-right" name="jms_buy_and_hold_analysis_price" id="jms_buy_and_hold_analysis_price" placeholder="Enter Buy and Hold Analysis 1 Save Price" value="<?php echo isset($jms_row[0]['jms_buy_and_hold_analysis_price']) ? $jms_row[0]['jms_buy_and_hold_analysis_price'] : 0;?>" step="0.01" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                                <!-- Maessage -->
                                <div class="jms-setting-message"></div>                           
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include("footer.php"); ?> 
<script type="text/javascript" src="js/setting.js"></script>

</body>
</html>