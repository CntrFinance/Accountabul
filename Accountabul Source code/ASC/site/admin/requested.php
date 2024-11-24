<?php
    include("../connection.php");

    if(!isset($_SESSION['jms_admin_user_id']))
    {
        header("location:index.php");
    }

    $jms_select_sql_user_requested = "SELECT * FROM `user-registration` WHERE is_requested = 'y' ORDER BY id ASC";

    $jms_select_data_user_requested = $jms_pdo->prepare($jms_select_sql_user_requested);
    $jms_select_data_user_requested->execute();
    $jms_row_user_requested = $jms_select_data_user_requested->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("header.php"); ?>

    <title>Users Request</title>

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
                            <h3 class="card-title">Users Request</h3>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="p-2 border rounded">
                                        <table id="jms_user_requested_list" class="table table-bordered table-striped mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Name</th>    
                                                    <th>Email</th>
                                                    <th>Status</th>
                                                    <th>Update Request</th>
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
                                                            <td><?php echo $row['jms_email_id']; ?></td>
                                                            <td>
                                                                <?php
                                                                    if($row['request_access'] == 'accept')
                                                                    {
                                                                ?>
                                                                    <div class="bg-success text-center rounded p-1">Accepted</div>
                                                                <?php
                                                                    }
                                                                    else if($row['request_access'] == 'reject')
                                                                    {
                                                                ?>
                                                                    <div class="bg-danger text-center rounded p-1">Rejected</div>
                                                                <?php
                                                                    }
                                                                    else if($row['request_access'] == '')
                                                                    {
                                                                ?>
                                                                    <div class="bg-warning text-center rounded p-1">Pending</div>
                                                                <?php
                                                                    }
                                                                ?>
                                                                </td>
                                                            <td>
                                                                <div class="row">
                                                                    <div class="col-md-8 mb-lg-0 mb-2">
                                                                        <select class="form-control form-control-sm mr-2" id="jms_request_access_<?php echo $row['id']; ?>"  name="jms_request_asscess_<?php echo $row['id']; ?>">
                                                                            <option value="" selected>Select</option>
                                                                            <?php
                                                                                if($row['request_access'] == '')
                                                                                {
                                                                            ?>
                                                                                <option value="accept">Accept</option>
                                                                                <option value="reject">Reject</option>
                                                                            <?php
                                                                                }
                                                                                else if($row['request_access'] == 'accept')
                                                                                {
                                                                            ?>
                                                                                <option value="accept" selected>Accept</option>
                                                                                <option value="reject">Reject</option>
                                                                            <?php
                                                                                }
                                                                                else if($row['request_access'] == 'reject')
                                                                                {
                                                                            ?>
                                                                                <option value="accept">Accept</option>
                                                                                <option value="reject"selected>Reject</option>
                                                                            <?php
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <button class="btn btn-sm btn-primary" id="jms_save_access_request" data-id="<?php echo $row["id"];  ?>">Save</button>
                                                                    </div>
                                                                </div>
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
        $("#jms_user_requested_list").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,"order": [[0, 'desc']],scrollY: false,
            scrollCollapse: true,pageLength : 10
        }).buttons().container().appendTo('#jms_user_requested_list_wrapper .col-md-6:eq(0)');
    });
</script>

<script>
    $(document).on('click',"#jms_save_access_request",function(e) 
    { 
        var jms_user_id = $(this).attr('data-id');
        var jms_val = $(this).closest('tr').find('#jms_request_access_' + $(this).data('id')).val();
        var formData = new FormData();
        formData.append('jms_user_id', jms_user_id);
        formData.append('jms_val', jms_val);

        $.ajax({
            url: "admin_data_file/get_requested.php",
            type: "POST",
            data:  formData,
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
                    
                }
                else if(data.status == 'success')
                {   
                    setTimeout(function(){ window.location = 'requested.php'; }, 3000);

                    var Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });

                    if(jms_val == 'accept')
                    {
                        Toast.fire({
                            icon: 'success',position: 'top',
                            title: 'Request Successfully Accepted'
                        })
                    }
                    else
                    {
                        Toast.fire({
                            icon: 'error',position: 'top',
                            title: 'Request Rejected'
                        })
                    }
                }
            },
            error: function(e)
            {
                
            }
        });
    });
</script>
</body>
</html>