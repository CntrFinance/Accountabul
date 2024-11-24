<?php
    include("../connection.php");

    if(!isset($_SESSION['jms_admin_user_id']))
    {
        header("location:index.php");
    }

    $jms_select_sql_user_requested = "SELECT * FROM `user-registration` ORDER BY id ASC";

    $jms_select_data_user_requested = $jms_pdo->prepare($jms_select_sql_user_requested);
    $jms_select_data_user_requested->execute();
    $jms_row_user_requested = $jms_select_data_user_requested->fetchAll(PDO::FETCH_ASSOC);

    foreach ($jms_row_user_requested as $row) 
    {
        $jms_users_id = $row['id'];

        // paypal sucription

        $jms_select_get_pay = "SELECT * FROM `paypal_payments_subscription` WHERE users_id = $jms_users_id";

        $jms_select_data_pay = $jms_pdo->prepare($jms_select_get_pay);
        $jms_select_data_pay->execute();
        $jms_row_user_pay = $jms_select_data_pay->fetch(PDO::FETCH_ASSOC);

        // stripe sucription
        
        $jms_select_get_stripe = "SELECT * FROM `stripe_payments_subscription` WHERE users_id = $jms_users_id";

        $jms_select_data_stripe = $jms_pdo->prepare($jms_select_get_stripe);
        $jms_select_data_stripe->execute();
        $jms_row_user_stripe = $jms_select_data_stripe->fetch(PDO::FETCH_ASSOC);
    }


    function formatText($text) 
    {
        $text = str_replace('-', ' ', $text);
        $text = ucwords($text);
        $text = ucfirst($text);
        return $text;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("header.php"); ?>

    <title>All Users</title>

    <!-- css link -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">

<?php include("menu.php"); ?>

<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
                <div class="col-md-12 mt-5">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">All Users</h3>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="p-2 border rounded">
                                        <table id="jms_all_users_list" class="table table-bordered table-striped mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Name</th>    
                                                    <th>Email</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                foreach ($jms_row_user_requested as $row) 
                                                {
                                            ?>
                                                <tr>
                                                    <td><?php echo $row["id"];?></td>
                                                    <td><?php echo $row["jms_first_name"].' - '.$row["jms_last_name"]; ?></td>
                                                    <td><?php echo $row['jms_email_id'];?></td>
                                                    <td>
                                                        <a class="btn btn-warning btn-sm" href="view_payments_details.php?id=<?php echo $row['id'];?>">View Payments</a>
                                                    </td>
                                                </tr>
                                            <?php
                                                }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?> 
<script type="text/javascript" src="js/delete_applicant_information.js"></script>
<script type="text/javascript">
    $(function () 
    {
        $("#jms_all_users_list").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,"order": [[0, 'desc']],scrollY: false,
            scrollCollapse: true,pageLength : 10
        }).buttons().container().appendTo('#jms_all_users_list_wrapper .col-md-6:eq(0)');
    });
</script>
</body>
</html>