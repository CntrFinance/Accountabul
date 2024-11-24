<?php
    session_start();
    $jms_servername = "localhost";  
    $jms_username = "root";     
    $jms_password = "";     
    $jms_dbname = "database_buy_and_hold_calculator_db";   

    try 
    {
        $jms_pdo = new PDO("mysql:host=$jms_servername;dbname=$jms_dbname", $jms_username, $jms_password);
        $jms_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } 
    catch(PDOException $jms_e) 
    {
        die("Connection failed: " . $jms_e->getMessage());
    }

    

?>