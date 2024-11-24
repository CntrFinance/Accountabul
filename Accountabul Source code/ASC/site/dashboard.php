<?php 
    include('connection.php');
    
    if(!isset($_SESSION['jms_user_id']))
    {
        header("location:index.php");
    }

    include('header.php'); 
?>

<title>Dashboard</title>

<!-- Style css -->
<link rel="stylesheet" type="text/css" href="css/form.css">

<style type="text/css">
    .jms-btn-dashboard
    {
        font-family: var(--main-font);
        display: inline-block;
        background: var(--primary-color-blue);
        color: #fff;
        border: none;
        width: 350px;
        padding: 20px 40px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1.5rem;
    }
    .jms-box-container
    {
        height: 68vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<?php include('navbar_top.php');?>

<!-- Applicant Registration -->

<div class="container mt-5">
    <div class="p-5 jms-box-container">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-6 col-md-12 col-sm-12 col-12 d-flex justify-content-center">
                <input type="button" class="jms-btn-dashboard mb-lg-0 mb-md-3 mb-3" id="jms_payment_processing" name="jms_payment_processing" value="Payments Processing">
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 col-12 d-flex justify-content-center">
                <input type="button" class="jms-btn-dashboard" id="jms_no_payments" name="jms_no_payments" value="No Payments">
            </div>  
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
<script type="text/javascript" src="js/custome.js"></script>
<script type="text/javascript">
    $(document).ready(function()
    {
        // payment processing

        $("#jms_payment_processing").on("click",function()
        {
            window.location.href = "payment.php";
        });

        // not payment today

        $("#jms_no_payments").on("click",function()
        {
            window.location.href = "conference_room.php";
        });
    });
</script>

