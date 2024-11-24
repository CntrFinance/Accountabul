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
        width: auto;
        padding: 15px 39px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 15px;
    }
</style>

<?php include('navbar_top.php');?>

<!-- Applicant Registration -->

<div class="container mt-5">
    <div class=" p-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-12">
                <div class="h2 mb-0">Coming soon.</div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>


