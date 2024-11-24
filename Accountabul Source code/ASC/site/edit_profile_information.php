<?php
    include("connection.php");
    if(!isset($_SESSION['jms_user_id']))
    {
        header("location:index.php");
    }

    include("header.php");

    $jms_user_id = $_SESSION['jms_user_id'];

    $jms_select_sql = "SELECT * FROM `user-registration` WHERE id = :jms_user_id";
    $jms_select_data = $jms_pdo->prepare($jms_select_sql);
    $jms_select_data->bindParam(':jms_user_id', $jms_user_id, PDO::PARAM_INT);
    $jms_select_data->execute();

    $jms_row = $jms_select_data->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($jms_row[0]['profile_upload'])) 
    {
        $jms_image_src = "user_upload_img/".$jms_row[0]['profile_upload'];
    } else {
        $jms_image_src = 'no_image_upload/noimageupload.png';
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Edit Profile</title>
    
    <!-- css link -->
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/loading.css">

    <style type="text/css">
        .form-check-inline
        {
            margin-right: 0px;
        }
        input[type="file"] {
            display: none;
        }

        .custom-file-upload 
        {
            display: inline-block;
            background: #007dfe;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            margin: 0px;
        }

    </style>
</head>

<body class="jms-bg">
<?php include("navbar_top.php"); ?>

    <div class="container ">
        <div class="jms-container my-5 mx-lg-5 mx-md-5 px-lg-5">
            <div class="row mt-3 d-flex align-items-center">
                <div class="col-lg-6 mt-5 pb-5 px-lg-5 px-md-5 px-sm-3 px-5">
                    <div class="jms-h2">Edit Profile</div>
                    <form class="mt-4" id="jms_edit_profile" name="jms_edit_profile">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6 col-6 ">
                                    <label for="name" class="jms-label">
                                        <i class="fas fa-user"></i>
                                    </label>
                                    <input class="jms-form-input" type="text" name="jms_first_name" id="jms_first_name" placeholder="First Name" value="<?php echo $jms_row[0]['jms_first_name'];?>" required>
                                </div>
                                <div class="col-lg-6 col-6 ">
                                    <input class="jms-form-input px-0" type="text" name="jms_last_name" id="jms_last_name" placeholder="Last Name" class="px-0" value="<?php echo $jms_row[0]['jms_last_name'];?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="pass" class="jms-label">
                                <i class="fa-solid fa-cake-candles"></i>
                            </label>
                            <input class="jms-form-input" type="date" name="jms_birthdate" id="jms_birthdate" value="<?php echo $jms_row[0]['jms_birthdate'];?>" required>
                        </div>

                        <div class="form-group jms-gender-bdr pb-2">
                            <label for="jms_gender" class="jms-form-label ">Gender :</label>
                            <div class="form-check-inline px-md-3 px-0">
                              <input class="form-check-input" type="radio" name="jms_gender" id="male" value="male" required <?php echo $jms_row[0]['jms_gender'] == 'male' ? 'checked' : ''; ?>>
                              <label class="form-check-label jms-form-label" for="male">
                                Male
                              </label>
                            </div>
                            <div class="form-check-inline">
                              <input class="form-check-input" type="radio" name="jms_gender" id="female" value="female" required <?php echo $jms_row[0]['jms_gender'] == 'female' ? 'checked' : ''; ?>>
                              <label class="form-check-label jms-form-label" for="female">
                                Female
                              </label>
                            </div>
                            <div class="form-check-inline px-md-3 px-0">
                              <input class="form-check-input" type="radio" name="jms_gender" id="other" value="other" required <?php echo $jms_row[0]['jms_gender'] == 'other' ? 'checked' : ''; ?>>
                              <label class="form-check-label jms-form-label" for="other">
                                Other
                              </label>
                            </div>
                        </div>

                        <div class="form-group d-flex justify-content-around align-items-center">
                            <div class="form-group image-box d-flex justify-content-center">
                                <img style="width: 150px;height: 150px;" class="" src="img/<?php echo $jms_image_src;?>" id="jms_image_display" name="jms_image_display">
                            </div>
                            <div class="">
                                <label for="jms_logo_image" class="custom-file-upload"><i class="fa-solid fa-upload"></i> Upload Image</label>
                                <input type="file" class="" id="jms_logo_image" name="jms_logo_image" accept=".png, .jpg, .jpeg"  >
                            </div>
                        </div>

                        <div class="jms-profile-edit-message"></div>

                        <div class="col-md-12 d-flex justify-content-center">
                            <div class="jms-loader" id="jms_loading"></div>
                        </div>
                        
                        <div class="form-group form-button text-center">
                            <input type="submit" name="save" id="save" class="jms-form-submit" value="Save">
                        </div>
                    </form>
                </div>
                <div class="col-lg-6 mt-5 d-flex align-items-center justify-content-center pb-5">
                    <img src="img/reg.png" class="img-fluid ">
                </div>
            </div>
        </div>
    </div>


    <?php include("footer.php"); ?> 
    <script type="text/javascript" src="js/custome.js"></script>
    <script type="text/javascript" src="js/edit_profile_information.js"></script>
    <script type="text/javascript">
        // image change js

        $('#jms_logo_image').change(function() 
        {
           $("#jms_logo_image").click();
        });
        
        jms_logo_image.onchange = evt => 
        {
            const [file] = jms_logo_image.files
            if (file) 
            {
                $('#jms_image_display').prop("src",jms_image_display.src = URL.createObjectURL(file) );
            }
        }

        
    </script>
</body>

</html>

