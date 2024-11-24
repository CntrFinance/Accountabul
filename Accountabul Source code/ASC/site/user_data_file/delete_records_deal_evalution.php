<?php
	include("../connection.php");

	if(!empty($_SESSION['jms_user_id']))
	{
		$jms_user_id = $_SESSION['jms_user_id'];
		$id = $_GET['id'];

		// SQL statement

		$sql_delete = "DELETE FROM `deal-evaluation-calc` WHERE id = :id";

		// Prepare and execute the statement

		try 
		{
		    $stmt = $jms_pdo->prepare($sql_delete);
		    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
		    $stmt->execute();

		    // user deal evalution records add

		    // Get user record
			
			$jms_select_sql = "SELECT * FROM `user-registration` WHERE id = :jms_user_id";
			$jms_select_data = $jms_pdo->prepare($jms_select_sql);
			$jms_select_data->bindParam(':jms_user_id', $jms_user_id, PDO::PARAM_INT);
			$jms_select_data->execute();
			$jms_row = $jms_select_data->fetch(PDO::FETCH_ASSOC);

			// Get user record stripe subscription 
 			
			$jms_select_sql = "SELECT * FROM `stripe_payments_subscription` WHERE id = :jms_user_id";
			$jms_select_data = $jms_pdo->prepare($jms_select_sql);
			$jms_select_data->bindParam(':jms_user_id', $jms_user_id, PDO::PARAM_INT);
			$jms_select_data->execute();
			$jms_row_stripe = $jms_select_data->fetch(PDO::FETCH_ASSOC);

		    if($jms_row['jms_unlimited_deal'] == "")
			{
		        $jms_updated_pass = "UPDATE `user-registration` SET jms_no_save_deal = :jms_no_save_deal, updated_on = :updated_on WHERE id = :jms_user_id";
			    $jms_updated_pass_update = $jms_pdo->prepare($jms_updated_pass);
			    $jms_updated_pass_update->bindParam(':jms_user_id', $jms_user_id, PDO::PARAM_INT);

			    $jms_total_save_old = $jms_row['jms_no_save_deal'];
	            $jms_nosave_deal = $jms_total_save_old + 1;

	            $jms_updated_pass_update->bindParam(':jms_no_save_deal', $jms_nosave_deal, PDO::PARAM_STR);
	            $jms_updated_pass_update->bindParam(':updated_on', $updated_on, PDO::PARAM_STR);
				$jms_updated_pass_update->execute();
			}

			echo trim("success");
		}
		catch (PDOException $e) 
		{
		    echo "error";
		}
	}
	else
	{
		header("Location:../index.php");
	}
?>