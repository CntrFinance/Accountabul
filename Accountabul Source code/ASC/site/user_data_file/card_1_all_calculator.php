<?php
    
    include("../setting.php");
    
	// get data user record

    $jms_select_sql = "SELECT * FROM `user-registration` WHERE id=:jms_user_id";
    $jms_select_data = $jms_pdo->prepare($jms_select_sql);
    $jms_select_data->bindParam(':jms_user_id', $jms_user_id,PDO::PARAM_INT);
    $jms_select_data->execute();
    $jms_row = $jms_select_data->fetchAll(PDO::FETCH_ASSOC);

    $jms_total_save_old_deal = $jms_row[0]['jms_no_save_deal'];
    $jms_total_save_old_buy = $jms_row[0]['jms_no_save_buy'];

    // user data record update

	$jms_updated_pass = "UPDATE `user-registration` SET jms_no_save_deal=:jms_no_save_deal,jms_no_save_buy=:jms_no_save_buy,jms_deal_save_allno=:jms_deal_save_allno,jms_buy_save_allno=:jms_buy_save_allno,updated_on=:updated_on WHERE id=:jms_user_id";

	$jms_updated_pass_update = $jms_pdo->prepare($jms_updated_pass);
	$jms_updated_pass_update->bindParam(':jms_user_id', $jms_user_id, PDO::PARAM_INT);

	// subscription add 250 + old save deal evalution 

	$jms_nosave_deal = $jms_access_all_calculator_save + $jms_total_save_old_deal;
    $jms_updated_pass_update->bindParam(':jms_no_save_deal', $jms_nosave_deal, PDO::PARAM_STR);

    // subscription add 250 save deal evalution 

	$jms_deal_save_allno = $jms_access_all_calculator_save;
    $jms_updated_pass_update->bindParam(':jms_deal_save_allno', $jms_deal_save_allno, PDO::PARAM_STR);

    // subscription add 250 + old save buy and hold analysis

    $jms_nosave_buy = $jms_access_all_calculator_save + $jms_total_save_old_buy;
    $jms_updated_pass_update->bindParam(':jms_no_save_buy', $jms_nosave_buy, PDO::PARAM_STR);

    // subscription add 250 save deal evalution 

	$jms_buy_save_allno = $jms_access_all_calculator_save;
    $jms_updated_pass_update->bindParam(':jms_buy_save_allno', $jms_buy_save_allno, PDO::PARAM_STR);

	$jms_updated_pass_update->bindParam(':updated_on', $updated_on, PDO::PARAM_STR);
	$jms_updated_pass_update->execute();

?>