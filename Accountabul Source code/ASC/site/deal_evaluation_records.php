<?php 
    include('connection.php');
    if(!isset($_SESSION['jms_user_id']))
    {
        header("location:index.php");
    }
    include("header.php");

    if(isset($_SESSION['jms_user_id']) && $_SESSION['jms_user_id'])
    {
        $jms_user_id = $_SESSION['jms_user_id'];
    }
    else
    {
        $jms_user_id = 0;
    }

    // get data

    $jms_select_sql = "SELECT * FROM `deal-evaluation-calc` WHERE users_id=:jms_user_id AND calc_data_records != ''";
    $jms_select_data = $jms_pdo->prepare($jms_select_sql);
    $jms_select_data->bindParam(':jms_user_id', $jms_user_id,PDO::PARAM_INT);
    $jms_select_data->execute();
    $jms_row = $jms_select_data->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Deal Evaluation Records</title>

    <!-- Style css -->
    <link rel="stylesheet" type="text/css" href="css/form.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <style type="text/css">
        .jms-container table tr td 
        {
            vertical-align: middle;
            padding: 5px !important;
        }
        .jms-container .table-hover>tbody>tr:hover 
        {
            --bs-table-accent-bg: #007dfe1c !important;
        }
        .jms-projected-expenses tr td,
        .jms-expenses-at-purchase tr td 
        {
            width: 33.33% !important;
        }
    </style>
</head>
<body class="jms-bg">
    <?php include("navbar_top.php");?>
    <div class="container my-5">
        <div class="jms-container jms-expense-financial-cost p-5">
            
            <div class="row">
                <div class="col-md-12">
                    <table id="jms_list">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($jms_row as $item) 
                                {
                                    $json_data = json_decode($item['calc_data_records'], true);
                            ?>
                            <tr>
                                <td><?php echo $json_data['jms_name'];?></td>
                                <td><?php echo date('d-m-Y', strtotime($json_data['jms_date']));?></td>
                                <td>
                                    <a href="edit_deal_evaluation_rocord.php?id=<?php echo $item['id'];?>" class="btn btn-sm btn-primary" id="jms_edit" name="jms_edit">Edit</a>
                                    <div class="btn btn-sm bg-danger text-white" id="jms_delete" data-id="<?php echo $item['id']; ?>">Delete</div>
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

    <?php include("footer.php"); ?>
</body>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#jms_list').DataTable({
            "paging": true,      
            "lengthChange": true,
            "searching": true,   
            "info": true         
        });
    });

    // delete records

    $(document).ready(function()
    {
        $(document).on('click', '#jms_delete', function(e){
            e.preventDefault();
            var id = $(this).attr("data-id");
            var conf = confirm("Are you sure you want to delete this row?");
            if(conf == true)
            {
                $.ajax({
                    url: "user_data_file/delete_records_deal_evalution.php?id="+id,
                    cache: false,
                    success: function(result){
                        if(result.trim() == "success")
                        {
                            alert('Deleted Successfully'); 
                            window.location = 'deal_evaluation_records.php';
                        }
                        else
                        {
                            alert('Not Deleted. Something Wrong');
                            window.location = 'deal_evaluation_records.php';
                        }
                    }
                });
            }
        });
    });
</script>
</html>