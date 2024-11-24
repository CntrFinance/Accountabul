<?php
	include("../connection.php");
	if(!isset($_SESSION['jms_user_id']))
  	{
    	header("location:index.php");
  	}
	header('Content-type: application/json');

	function jms_delete_image_logo($image_name)
    {
        $path = "../img/user_upload_img/".$image_name;
    
        if(file_exists($path))
        {
            unlink($path);
            return 1;
        }
    }

	$jms_user_id = $_SESSION["jms_user_id"];
	$jms_first_name = $_POST['jms_first_name'];
	$jms_last_name = $_POST['jms_last_name'];
	$jms_gender = $_POST['jms_gender'];
	$jms_birthdate = $_POST['jms_birthdate'];
	
	// $jms_logo_image = $_FILES['jms_logo_image'];

    $updated_on = date('Y-m-d H:i:s');

    //data get 
    
    $jms_upload_logo_select = "SELECT * FROM `user-registration` WHERE id=:jms_user_id";
    $jms_upload_logo_stmt = $jms_pdo->prepare($jms_upload_logo_select);
    $jms_upload_logo_stmt->bindParam(':jms_user_id', $jms_user_id,PDO::PARAM_INT);
    $jms_upload_logo_stmt->execute();

    $jms_row = $jms_upload_logo_stmt->fetchAll(PDO::FETCH_ASSOC);

    if($_FILES["jms_logo_image"]["name"] != "")
    {
    	$jms_allowedExtensions = array('jpg', 'jpeg', 'png');
	    $jms_logo_image_name_photo   = uniqid()."_".$_FILES["jms_logo_image"]["name"];
	    $jms_logo_image_size_photo   = $_FILES["jms_logo_image"]["size"];
	    $jms_upload_folder_name      = $_FILES["jms_logo_image"]["tmp_name"];
	    $jms_folder         		 = "../img/user_upload_img/" . $jms_logo_image_name_photo;

	    $jms_fileInfo = pathinfo($_FILES["jms_logo_image"]["name"]);
		$jms_extension = strtolower($jms_fileInfo['extension']);

		$jms_max_size = 5242880;

		if($jms_logo_image_size_photo <= $jms_max_size) 
		{
	    	if(in_array($jms_extension, $jms_allowedExtensions))
			{
				move_uploaded_file($jms_upload_folder_name, $jms_folder);



				$jms_updated_pass = "UPDATE `user-registration` SET jms_first_name=:jms_first_name,jms_last_name=:jms_last_name,jms_gender=:jms_gender,profile_upload=:profile_upload,jms_birthdate=:jms_birthdate,updated_on=:updated_on WHERE id=:jms_user_id";
			    $jms_updated_pass_update = $jms_pdo->prepare($jms_updated_pass);
			    $jms_updated_pass_update->bindParam(':jms_user_id', $jms_user_id,PDO::PARAM_INT);
			    $jms_updated_pass_update->bindParam(':jms_first_name', $jms_first_name,PDO::PARAM_STR);
			    $jms_updated_pass_update->bindParam(':jms_last_name', $jms_last_name,PDO::PARAM_STR);
			    $jms_updated_pass_update->bindParam(':jms_gender', $jms_gender,PDO::PARAM_STR);
			    $jms_updated_pass_update->bindParam(':profile_upload', $jms_logo_image_name_photo,PDO::PARAM_STR);
			    $jms_updated_pass_update->bindParam(':jms_birthdate', $jms_birthdate,PDO::PARAM_STR);
			    $jms_updated_pass_update->bindParam(':updated_on', $updated_on,PDO::PARAM_STR);
			    $jms_updated_pass_update->execute();

			    $jms_row_update = $jms_updated_pass_update->fetchAll(PDO::FETCH_ASSOC);

			    if(count($jms_row_update) == 0)
			    {
			    	if(!empty($jms_row[0]['profile_upload']))
			    	{
			    		jms_delete_image_logo($jms_row[0]['profile_upload']);
			    	}
			    	
			    	$response_array['status'] = 'success';
					$response_array['message'] = 'Updated successfully done.';
					echo json_encode($response_array);
			    }
			    else
			    {
			    	$response_array['status'] = 'error';
					$response_array['message'] = 'Something wrong, data not updated into database';
					echo json_encode($response_array);	
			    }
			}
			else
			{
				$response_array['status'] = 'error';
				$response_array['message'] = 'Sorry, only JPG, JPEG & PNG files are allowed.';
				echo json_encode($response_array);
			}
		}
		else
	    {
	    	$response_array['status'] = 'error';
		    $response_array['message'] = 'Uploaded image exceeds the maximum allowed size (5MB).';
		    echo json_encode($response_array);
	    }
    }
    else
    {
    	$jms_updated_pass = "UPDATE `user-registration` SET jms_first_name=:jms_first_name,jms_last_name=:jms_last_name,jms_gender=:jms_gender,jms_birthdate=:jms_birthdate,updated_on=:updated_on WHERE id=:jms_user_id";
	    $jms_updated_pass_update = $jms_pdo->prepare($jms_updated_pass);
	    $jms_updated_pass_update->bindParam(':jms_user_id', $jms_user_id,PDO::PARAM_INT);
	    $jms_updated_pass_update->bindParam(':jms_first_name', $jms_first_name,PDO::PARAM_STR);
	    $jms_updated_pass_update->bindParam(':jms_last_name', $jms_last_name,PDO::PARAM_STR);
	    $jms_updated_pass_update->bindParam(':jms_gender', $jms_gender,PDO::PARAM_STR);
	    $jms_updated_pass_update->bindParam(':jms_birthdate', $jms_birthdate,PDO::PARAM_STR);
	    $jms_updated_pass_update->bindParam(':updated_on', $updated_on,PDO::PARAM_STR);
	    $jms_updated_pass_update->execute();

	    $jms_row_update = $jms_updated_pass_update->fetchAll(PDO::FETCH_ASSOC);

	    if(count($jms_row_update) == 0)
	    {
	    	$response_array['status'] = 'success';
			$response_array['message'] = 'Updated successfully done.';
			echo json_encode($response_array);
	    }
	    else
	    {
	    	$response_array['status'] = 'error';
			$response_array['message'] = 'Something wrong, data not updated into database';
			echo json_encode($response_array);	
	    }
    }

    

	// profile_upload

	
?>