<?php 
    // get data upload logo

    $jms_select_sql_color_data = "SELECT * FROM color_themes";

    $jms_select_data_color_data = $jms_pdo->prepare($jms_select_sql_color_data);
    $jms_select_data_color_data->execute();
    $jms_row_color_data = $jms_select_data_color_data->fetchAll(PDO::FETCH_ASSOC);

    $color = json_decode($jms_row_color_data[0]['color_code']);
?>
<style>
    /* phpcode get*/
    
    :root 
    {
        --white : #ffffff; 
        --black : black;
        --one : <?php echo $color[0];?>;
        --two : <?php echo $color[1];?>;
    }



    .jms-login-container::before,.jms-login-container::after,
    .jms-forgot-pass-container::before,.jms-forgot-pass-container::after,
    .jms-change-forgot-pass-container::before,.jms-change-forgot-pass-container::after,
    .jms-verify-container::before,.jms-verify-container::after,
    .jms-change-pass-container::before,.jms-change-pass-container::after
    {
        background: linear-gradient(45deg, <?php echo $color[0];?> , <?php echo $color[1];?>);
    }
    
    .jms-login-container,.jms-login-container::before,.jms-login-container::after,
    .jms-forgot-pass-container,.jms-forgot-pass-container::before,.jms-forgot-pass-container::after,
    .jms-change-forgot-pass-container,.jms-change-forgot-pass-container::before,.jms-change-forgot-pass-container::after,
    .jms-verify-container,.jms-verify-container::before,.jms-verify-container::after,
    .jms-change-pass-container,.jms-change-pass-container::before,.jms-change-pass-container::after
    {
        border: 1px solid <?php echo $color[0];?>;
    }
    .btn-primary 
    {
        background: linear-gradient(145deg, <?php echo $color[0];?> , <?php echo $color[1];?>) !important;
        border: none !important;
        border-radius: .5rem;
    }
    .jms-border-add
    {
        border: 2px solid var(--one) !important;
    }
    .checkbox-wrapper-18 .round input[type="checkbox"]:checked + label 
    {
        background-color: var(--one);
        border-color: var(--two);
    }
    .progress-container 
    {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: #f0f0f0;
        height: 5px;
        z-index: 9999; 
    }

    .progress-bar 
    {
        height: 100%;
        background-color: var(--one);
        width: 0;
        transition: width 0.3s ease;
    }

    /* dashboard */

    /* index */

    /* box ribbons */

    .ribbon3 
    {
        min-width: 150px;
        height: 35px;
        line-height: 35px;
        padding-left: 15px;
        position: absolute;
        left: -8px;
        top: 20px;
        color: white;
        font-weight: 600;
        background: linear-gradient(90deg, <?php echo $color[0];?> , <?php echo $color[1];?>) !important;
    }
    .ribbon3:before, .ribbon3:after 
    {
      content: "";
      position: absolute;
    }
    .ribbon3:before 
    {
        height: 0;
        width: 0;
        top: -8.5px;
        left: -0.9px;
        border-bottom: 9px solid var(--one);
        border-left: 9px solid transparent;
    }
    .ribbon3:after 
    {
        height: 0;
        width: 0;
        right: -15px;
        border-top: 17px solid transparent;
        border-bottom: 18px solid transparent;
        border-left: 15px solid var(--two);
    }

</style>